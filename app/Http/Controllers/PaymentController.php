<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public function redirectToGateway(Request $request)
    {
        try{
            // Validate the required fields
    $request->validate([
        'email' => 'required|email',
        'amount' => 'required|numeric',
    ]);

    // Merge necessary data into the Paystack request
    $paystackData = [
        'email' => $request->email, // Customer email
        'amount' => $request->amount * 100, // Paystack expects amount in kobo (multiply by 100 for NGN)
        'reference' => Paystack::genTranxRef(), // Generate a unique transaction reference
        'metadata' => [
            'custom_fields' => [
                [
                    'display_name' => 'Order ID',
                    'variable_name' => 'order_id',
                    'value' => $request->orderID ?? null, // Optional custom fields
                ],
                [
                    'display_name' => 'Quantity',
                    'variable_name' => 'quantity',
                    'value' => $request->quantity ?? null,
                ],
            ],
        ],
    ];
            return Paystack::getAuthorizationUrl($paystackData)->redirectNow();
        }catch(\Exception $e) {
            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }        
    }

    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}
