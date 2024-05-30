<?php

namespace App\Http\Controllers;

use App\StripeTrait;
use Nowakowskir\JWT\JWT;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Nowakowskir\JWT\TokenDecoded;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Application;


class JwtController extends Controller
{
    use StripeTrait;
    public function generateStripeCheckout(Request $request): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $jwtSecretKey = env('JWT_SECRET_KEY');
        $tokenDecoded = new TokenDecoded(
            [
                'lastname' => $request->input('lastname'),
                'firstname' => $request->input('firstname'),
                'age'=> $request->input('age'),
                'city' => $request->input('city'),
                'vehicle' => $request->input('vehicle'),
                'token ' => env('JWT_TOKEN'),
            ], [
                'alg' => 'HS256',
                'typ' => 'JWT'
            ]
        );
        $tokenEncoded = $tokenDecoded->encode($jwtSecretKey, JWT::ALGORITHM_HS256);
        $token = $tokenEncoded->toString();
        
        $session = $this->makeCheckout($token);
        return redirect($session->url,303);
    }

    public function paymentSuccess(Request $request): View
    {
        $sessionId = $request->input('transaction_id');
        if ($sessionId) {
            $customerDetails = $this->getPaymentCustomerInfo($sessionId);
            if (! empty( $customerDetails)){
                return view('payment_success', ['customerDetails' => $customerDetails, 'session' => $sessionId]);
            }
        }
        return view('payment_failed');
    }

    public function paymentFailed(Request $request): string
    {
        return view('payment_failed');
    }

}
