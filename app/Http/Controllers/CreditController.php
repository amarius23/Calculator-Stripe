<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Http\Resources\PackageResource;
use App\Models\Feature;
use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\StripeClient;

class CreditController extends Controller
{
    public function index(){
        $packages = Package::all();
        $features = Feature::where('active', true)->get();
        return inertia('Credit/Index', [
            'packages' => PackageResource::collection($packages),
            'features' => FeatureResource::collection($features),
            'success' => session('success'),
            'error' => session('error')
        ]);
    }

    public function buyCredits(Package $package)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $package->name.' - '.$package->credits.' credits',
                        ],
                        'unit_amount' => $package->price * 100,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('credit.success',[],true),
            'cancel_url' => route('credit.cancel',[],true),
        ]);

        Transaction::create([
            'status' => 'pending',
            'price' => $package->price,
            'credits' => $package->credits,
            'session_id' => $checkout_session->id,
            'user_id' => Auth::id(),
            'package_id' => $package->id,
        ]);

        return redirect($checkout_session->url);
    }

    public function success(){
        return to_route('credit.index')
            ->with('success', 'You have successfully bought new credits.');
    }

    public function cancel(){
        return to_route('credit.index')
            ->with('error', 'There was an error in payment process. Please try again.');
    }

    public function webhook(){
        $endpoint_secret = env('STRIPE_WEBHOOK_KEY');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        }catch (\UnexpectedValueException|SignatureVerificationException $e){
            Log::info($e->getMessage());
            return response($e->getMessage(),400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object; // contains a \Stripe\PaymentIntent

                $transaction = Transaction::where('session_id', $session->id)->with('user')->first();
                if ($transaction && $transaction->status == 'pending'){
                    $transaction->status = 'paid';
                    $transaction->save();
                    $transaction->user->available_credits += $transaction->credits;
                    $transaction->user->save();
                }
                break;
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return  response('',200);

    }
}
