<?php

namespace App\Http\Controllers;

use App\StripeTrait;
use Illuminate\Http\Request;
use SendinBlue\Client\ApiException;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\SendSmtpEmail;
use SendinBlue\Client\Api\TransactionalEmailsApi;

class MailController extends Controller {

    use StripeTrait;

    public function sendMail(Request $request,$sessionId): void
    {
        $customerDetails =  $this->getPaymentCustomerInfo($sessionId);

        $data = [
            "lastname" => data_get($customerDetails, 'lastname'),
            "firstname" => data_get($customerDetails, 'firstname'),
            "age" => data_get($customerDetails, 'age'),
            "city" => data_get($customerDetails,'city'),
            "email"=>data_get($customerDetails,'email'),
            "car" => data_get($customerDetails, 'car'),
            "amount" => data_get($customerDetails, 'amount'),
            "lastCardNumbers" => data_get($customerDetails, 'lastCardNumbers'),
            "transactionId" => data_get($customerDetails, 'transactionId'),
        ];

        $config = Configuration::getDefaultConfiguration()->setApiKey("api-key", env('BREVO_API_KEY'));
        $api_instance = new TransactionalEmailsApi(null, $config);
        $emailCampaigns = new SendSmtpEmail([
            'name' => 'Campaign sent via the API',
            'subject' => 'My subject',
            'sender' => [
                'name' => 'Clément Maldonado',
                'email' => 'valerian.charrier@gmail.com'
            ],
            'htmlContent' => view('email_content', ['data'=>$data])->render(),
            'to' => [
                [
                    'email' => $data['email'],
                    'name' => $data['lastname'] . ' ' . $data['firstname'],
                ]
            ],
        ]);
        try {
            $result = $api_instance->sendTransacEmail($emailCampaigns);
            dd($result);
        } catch (ApiException $e) {
            echo 'Exception when calling EmailCampaignsApi->createEmailCampaign: ', $e->getMessage(), PHP_EOL;
        }
    }
}