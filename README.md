Points Calculator with Stripe Integration

This project is built with Laravel, Inertia.js, and React. It allows users to buy credits through Stripe and perform basic calculations (sum and difference) based on the number of credits they own.
Features

    User Credits: Users can purchase credits using Stripe.
    Calculations: Users can perform two types of calculations:
        Sum: Costs 1 credit per operation.
        Difference: Costs 3 credits per operation.
    Stripe Integration: Secure payment system using Stripe to add credits.
    Frontend: Built with React and Inertia.js for a seamless user experience.
    Backend: Built with Laravel for robust server-side processing.

Requirements

    PHP 8.x
    Laravel 10.x
    MySQL
    Node.js and npm
    Composer
    Stripe API keys

Installation

    Clone the repository:

    git clone https://github.com/yourusername/points-calculator-stripe.git
    cd points-calculator-stripe

Install dependencies:


    composer install
    npm install

Copy .env.example to .env:


    cp .env.example .env

Generate an application key:


    php artisan key:generate

Set up your database in .env and run migrations:

    php artisan migrate

Configure Stripe keys in your .env:

    STRIPE_KEY=your_stripe_key
    STRIPE_SECRET=your_stripe_secret

Build frontend assets:

    npm run dev

Start the server:

bash

    php artisan serve

Usage

    Create an account or log in.
    Purchase credits using Stripe.
    Use credits to perform calculations:
        Sum (costs 1 credit)
        Difference (costs 3 credits)

Testing

To run unit tests, use the following command:


    php artisan test

License

This project is licensed under the MIT License. See the LICENSE file for more information.
