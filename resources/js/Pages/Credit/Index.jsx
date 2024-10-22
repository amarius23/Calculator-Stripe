import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import {Head} from "@inertiajs/react";
import CreditPricingCards from "@/Components/CreditPricingCards.jsx";

export default function Index({auth, packages, features, success, error}) {
    const availableCredits = auth.user.available_credits;

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
                Your Credits
            </h2>}
        >
            <Head title="Your Credits"/>
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {success && <div className="rounded-lg bg-emerald-500 text-gray-100 p-3 mb-4">
                        {success}
                    </div>}
                    {error && <div className="rounded-lg bg-red-500 text-gray-100 p-3 mb-4">
                        {error}
                    </div>}
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg relative">
                        <div className="flex flex-col gap-3 items-center p-4">
                            <img src="https://t3.ftcdn.net/jpg/01/94/67/20/360_F_194672016_pf5HYgLlm6XlSwuL7JE4Pqvdq0RFqK7V.jpg"
                                 className="w-[30px]" alt=""/>
                            <h3 className="text-white text-2xl">
                                You have {availableCredits} credits
                            </h3>
                        </div>
                    </div>
                    <CreditPricingCards packages={packages.data} features={features.data}/>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
