<?php

namespace App;
use Stripe\StripeClient;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Checkout\Session;
use Nowakowskir\JWT\TokenEncoded;
use Stripe\Exception\ApiErrorException;

trait StripeTrait
{
    protected StripeClient $stripe;

    public function makeCheckout(string $token): Session
    {
        $this->stripe = new StripeClient(env('STRIPE_KEY'));
        header('Content-Type: application/json');

        $YOUR_DOMAIN = 'https://1fa0-2a01-e0a-afe-f430-f4f2-1f4f-d51c-ec71.ngrok-free.app';

        return $this->stripe->checkout->sessions->create([
            'submit_type' => 'pay',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => 300,
                    'product_data' => [
                        'name' => 'Nom du produit vendu',
                        // 'images' => [$picture],
                    ],
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'token' => $token
            ],
            'mode' => 'payment',
            'payment_intent_data' => [
                'capture_method' => 'manual',
                'setup_future_usage' => 'off_session',
                'metadata' => [
                    'token' => $token,
                ],
            ],
            'success_url' => $YOUR_DOMAIN . '/payment_success?transaction_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/payment_failed'
        ]);
    }

    public function getPaymentInfos(string $transactionId)
    {
        $this->stripe = new StripeClient(env('STRIPE_KEY'));
        try {
            return $this->stripe->paymentIntents->retrieve($transactionId);
        } catch (ApiErrorException $e) {
            dd($e);
        }
    }

    public function mapPaymentInfos(Session $session, PaymentIntent $payment, PaymentMethod $paymentMethod = null): array
    {
        $this->stripe = new StripeClient(env('STRIPE_KEY'));
        if(!$paymentMethod){
            $paymentMethodId = $payment->payment_method;
            $paymentMethod = $this->stripe->paymentMethods->retrieve($paymentMethodId);
        }
        $token = $session->metadata->token;
        $tokenEncoded = new TokenEncoded($token);
        $payload = $tokenEncoded->decode()->getPayload();

        return [
            'lastname' => data_get($payload, 'lastname'),
            'firstname' => data_get($payload, 'firstname'),
            'car' => data_get($payload, 'vehicle'),
            'age' => data_get($payload, 'age'),
            'city' => data_get($payload, 'city'),
            'email' => $session->customer_details->email,
            'amount' => $payment->amount / 100 ,
            'lastCardNumbers' => '...' . $paymentMethod->card->last4,
            'transactionId' => $payment->id,
        ];
    }


    public function getPaymentCustomerInfo($sessionId)
    {
        $this->stripe = new StripeClient(env('STRIPE_KEY'));
        try {
            $session = $this->stripe->checkout->sessions->retrieve($sessionId);
        } catch (ApiErrorException $e) {
            dd('Error retrieving session: ' . $e->getMessage());
        }

        $paymentIntentId = $session->payment_intent;

        if ($paymentIntentId) {
            try {
                $paymentInfos = $this->getPaymentInfos($paymentIntentId);
            } catch (ApiErrorException $e) {
                dd('Error retrieving payment intent: ' . $e->getMessage());
            }
            return $this->mapPaymentInfos($session, $paymentInfos);
        } else {
            dd('No payment intent found in session');
        }
    }

}
