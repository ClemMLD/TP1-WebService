<?php

namespace App\Http\Controllers;

use Exception;
use Stripe\Stripe;
use Stripe\Balance;
use App\StripeTrait;
use Illuminate\View\View;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Stripe\Exception\ApiErrorException;

class DashboardController extends Controller
{
    use StripeTrait;
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_KEY'));
    }

    public function index(): View
    {
        $payments = $this->showPayments();
        $solds = $this->getBalance();
        return view('dashboard', ['payments' => $payments, 'soldAvailable' => $solds["available"], "soldPending" => $solds["pending"]]);
    }

    public function showPayments(): array
    {
        $sessions = Session::all(['limit' => 20]);
        $payments = [];

        foreach ($sessions->data as $session) {
            if($session->payment_intent){
                try {
                    $paymentIntent = PaymentIntent::retrieve($session->payment_intent);
                    $paymentMethod = PaymentMethod::retrieve($paymentIntent->payment_method);
                    $details = $this->mapPaymentInfos($session, $paymentIntent, $paymentMethod);
                } catch (ApiErrorException $e) {
                    Log::error('Error fetching Stripe payment intent: ' . $e->getMessage());
                    continue;
                }
                $payments[$session->id] =
                    [
                        'id' => $session->id,
                        'lastname' => $details['lastname'] ?? 'N/A',
                        'firstname' => $details['firstname'] ?? 'N/A',
                        'car' => $details['car'] ?? 'N/A',
                        'city' =>$details['city'] ?? 'N/A',
                        'email' => $details['email'] ?? 'N/A',
                        'amount' => $paymentIntent->amount / 100,
                        'captureValPartial' => $paymentIntent->amount * 0.75,
                        'lastCardNumbers' => $paymentMethod->card->last4 ?? 'N/A',
                        'transactionId' => $session->id,
                        'age' => $details['age'] ?? 'N/A',
                        'status' => $paymentIntent->status,
                    ];
            }

        }

        return $payments;
    }

    public function getBalance(): array
    {
        try {
            $balance = Balance::retrieve();
            $available = $balance->available[0];
            $pending = $balance->pending[0];

            return [
                'available' => $available->amount / 100,
                'pending' => $pending->amount / 100,
                'currency' => $available->currency
            ];
        } catch (\Exception $e) {
            Log::error('Error fetching Stripe balance: ' . $e->getMessage());
            return [
                'available' => 0,
                'pending' => 0,
                'currency' => 'usd'
            ];
        }
    }

    public function captureFull(string $sessionId): RedirectResponse
    {
        try {
            $session = Session::retrieve($sessionId);
            $paymentIntent = PaymentIntent::retrieve($session->payment_intent);
            $paymentIntent->capture();
            return redirect('/dashboard')->with('success', 'Full payment captured successfully.');
        } catch (ApiErrorException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function capturePartial(string $sessionId, Request $request): RedirectResponse
    {

        try {
            $session = Session::retrieve($sessionId);
            $paymentIntent = PaymentIntent::retrieve($session->payment_intent);
            $amountToCapture = (int)$request->input('capturePartial');
            $paymentIntent->capture(['amount_to_capture' => $amountToCapture]);
            return redirect('/dashboard')->with('success', 'Partial payment captured successfully.');
        } catch (ApiErrorException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function refundPayment(string $sessionId): RedirectResponse
    {
        try {
            $session = Session::retrieve($sessionId);
            $paymentIntent = PaymentIntent::retrieve($session->payment_intent);
            $paymentIntent->cancel();
            return redirect('/dashboard')->with('success', 'Payment authorization canceled successfully.');
        } catch (ApiErrorException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function succeededPayment()
    {

    }
}
