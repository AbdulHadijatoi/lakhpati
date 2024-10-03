<?php

namespace App\Http\Controllers\API;

use Inertia\Inertia;
use App\Http\Controllers\AppBaseController;
use App\Models\Complaint;
use App\Models\ComplaintDetails;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class EasypaisaController extends AppBaseController{
    
    // Sandbox Url's
    protected $transaction_url_1 = 'https://easypaystg.easypaisa.com.pk/easypay/Index.jsf';
    protected $transaction_url_2 = 'https://easypaystg.easypaisa.com.pk/easypay/Confirm.jsf';
    
    protected $storeId = '578817';
    protected $hashKey = 'EVB39B3S9LGTDEK5';

    public function doCheckout(Request $request) {
        // Define the URLs for confirmation and status check
        $checkoutConfirm = url('checkout-confirm');
        $paymentStatus = url('payment-status');
    
        // Example product data (this would typically come from the request or database)
        $product = ['name' => 'New product', 'price' => '20.0'];
    
        // Format amount
        $amount = $product['price'];
        $amount = number_format($amount, 1);
    
        // Generate order reference number and expiry date
        $dateTime = new DateTime();
        $orderRefNum = $dateTime->format('YmdHis');
    
        // Set expiry date (1 hour from current time)
        $expiryDateTime = (clone $dateTime)->modify('+1 hours');
        $expiryDate = $expiryDateTime->format('Ymd His');
    
        // Prepare the post data for Easypaisa API (for Index.jsf)
        $post_data = array(
            "storeId" => $this->storeId,
            "amount" => $amount,
            "postBackURL" => $checkoutConfirm,
            "orderRefNum" => $orderRefNum,
            "expiryDate" => $expiryDate, // Optional
            "merchantHashedReq" => "", // To be generated
            "autoRedirect" => "1", // Optional
            "paymentMethod" => "QR_PAYMENT_METHOD", // Payment Method
        );
    
        // Generate secure hash
        $post_data['merchantHashedReq'] = $this->getSecureHash($post_data);
    
        // Save transaction to DB (optional, can be done later)
        $values = [
            'TxnRefNo' => $orderRefNum,
            'amount' => $product['price'],
            'description' => 'New product',
            'status' => 'pending'
        ];
        // Here you could save $values to your transactions table
        // Transaction::create($values);
    
        try {
            // Initialize Guzzle HTTP Client
            $client = new \GuzzleHttp\Client();
    
            // Send POST request to Easypaisa (Index.jsf)
            $response = $client->post('https://easypay.easypaisa.com.pk/easypay/Index.jsf', [
                'form_params' => $post_data
            ]);
    
            // Get the response body
            $responseBody = $response->getBody()->getContents();
    
            // Assuming you need to extract some data (e.g., auth token) from the first response
            $responseData = json_decode($responseBody, true);
            if (isset($responseData['auth_token'])) {
                $authToken = $responseData['auth_token'];
            } else {
                throw new \Exception("Failed to retrieve auth_token.");
            }
    
            // Now make a second request to Confirm.jsf with the auth_token
            $confirm_data = [
                "auth_token" => $authToken,
                "orderRefNum" => $orderRefNum,
            ];
    
            // Send POST request to Easypaisa (Confirm.jsf)
            $confirmResponse = $client->post('https://easypay.easypaisa.com.pk/easypay/Confirm.jsf', [
                'form_params' => $confirm_data
            ]);
    
            // Get the confirm response body
            $confirmResponseBody = $confirmResponse->getBody()->getContents();
    
            // Return the result of both responses (success)
            return response()->json([
                'status' => 'success',
                'message' => 'Checkout initiated',
                'data' => [
                    'index_response' => $responseBody,
                    'confirm_response' => $confirmResponseBody
                ],
            ]);
    
        } catch (\Exception $e) {
            // Catch and log any errors
            return response()->json([
                'status' => 'error',
                'message' => 'Checkout failed',
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    

    public function checkoutConfirm(Request $request) { 
        $response = $request->input();
        $post_data = array(); 
        $post_data['auth_token'] = $response['auth_token'];
        $post_data['postBackUrl'] = Config::get('constants.easypay.POST_BACK_URL2');
        echo '<pre>';
        print_r($post_data);
        echo '</pre>';

        return view('checkout_confirm_v',['post_data' => $post_data]);
    }

    public function paymentStatus(Request $request) { 

        $response = $request->input(); 
        echo '<pre>'; 
        print_r($response); 
        echo '</pre>';
    }

    private function getSecureHash($data_array){
        $sortedArray = $data_array;
        ksort($sortedArray);
        $sorted_string = '';
        $i = 1;

        foreach($sortedArray as $key => $value){
            if(!empty($value))
            {
                if($i == 1)
                {
                    $sorted_string = $key. '=' .$value;
                }
                else
                {
                    $sorted_string = $sorted_string . '&' . $key. '=' .$value;
                }
            }
            $i++;
        }	
        
        $cipher = "aes-128-ecb";
        $crypttext = openssl_encrypt($sorted_string, $cipher, Config::get('constants.easypay.HASHKEY'), OPENSSL_RAW_DATA);
        $HashedRequest = Base64_encode($crypttext);

        return $HashedRequest;
    }
    
}
