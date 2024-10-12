<?php

namespace App\Http\Controllers\API;

use Inertia\Inertia;
use App\Http\Controllers\AppBaseController;
use App\Models\Complaint;
use App\Models\ComplaintDetails;
use App\Models\Contest;
use App\Models\Payment;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class EasypaisaController extends AppBaseController{
    
    protected $storeId = '578817';
    protected $hashKey = 'EVB39B3S9LGTDEK5'; 
    
    public function checkout(Request $request) {
        $request->validate([
            'contest_id' => 'required|exists:contests,id',
        ]);
        
        $user = Auth()->user();
        $contest = Contest::with('contestDetails')->find($request->contest_id);
        
        if(!$contest->contestDetails){
            return response()->json([
                'status' => false,
                'message' => 'Invalid contest!',
            ], 422);
        }

        $product = ['name' => $contest->title, 'price' => $contest->contestDetails->entry_fee];

        $amount = $product['price'];
        $amount = number_format($amount, 1);

        $dateTime = new DateTime();

        $orderRefNum = $dateTime->format('YmdHis');

        $expiryDateTime = $dateTime;
        $expiryDateTime->modify('+' . 1 . ' hours');
        $expiryDate = $expiryDateTime->format('Ymd His');

        $post_data = array(
            "storeId" => '578817',
            "amount" => $amount,
            "postBackURL" => url('api/v1/easypaisa/checkout/confirm'),
            "orderRefNum" => $orderRefNum,
            // "expiryDate" => $expiryDate, // Optional
            "merchantHashedReq" => "", //Optional
            "autoRedirect" => "1", // Optional
            // "paymentMethod" => "MA_PAYMENT_METHOD", // Optional
            // MA_PAYMENT_METHOD
            // QR_PAYMENT_METHOD

            // OTC_PAYMENT_METHOD // disabled/not_working
            // CC_PAYMENT_METHOD // disabled/not_working
        );

        $post_data['merchantHashedReq'] = $this->getSecureHash($post_data);

        $payment = Payment::create([
            // "user_id" => 1,
            "user_id" => $user->id,
            "contest_id" => $contest->id,
            "amount" => $amount,
            "payment_type" => 'easypaisa',
            "payment_status" => 'pending',
            "order_reference" => $orderRefNum,
            "description" => 'payment attempted',
        ]);

        return view('checkout.index', compact('post_data'));
    }

    public function checkoutConfirm(Request $request) { 
        
        $data = array(); 
        $data['auth_token'] = $request->auth_token;
        $data['postBackUrl'] = url('paymentStatus');

        return view('checkout.confirm',compact('data'));
    }

    public function paymentStatus(Request $request) { 

        $request->validate([
            'amount' => 'required',
            'transactionRefNumber' => 'required',
            'orderRefNumber' => 'required',
            'message' => 'nullable'
        ]);

        $amount = $request->amount;
        $transactionRefNumber = $request->transactionRefNumber;
        $orderRefNumber = $request->orderRefNumber;
        $message = $request->message;

        $payment = Payment::where('order_reference',$orderRefNumber)->first();

        if(!$payment){
            return response()->json([
                'status' => false,
                'message' => 'Payment not found!',
            ], 422);
        }

        $payment->response_data = json_encode($request->all());
        $payment->description = $request->message;
        $payment->payment_status = 'failed';

        $payment->save();

        if($message){
            return response()->json([
                'status' => false,
                'message' => $message,
            ], 422);
        }

        $payment->payment_status = 'completed';

        $payment->save();

        return response()->json([
            'status' => true,
            'message' => 'Payment Success!',
        ], 200);
    }

    public function checkStatus(Request $request) { 
        // return $request->input();

        // Your Easypaisa credentials
        $username = 'asifusbstores@gmail.com';
        $password = 'Asif0311...@.';

        // Base64 encode the credentials
        $credentials = base64_encode($username.":".$password);

        // Prepare the request data
        $data = [
            'orderId' => $request->orderRefNumber??'20241012014631',  // Replace with actual order ID
            'storeId' => $this->storeId,        // Replace with actual store ID
            'accountNum' => "152204472" // Replace with actual customer account number from db
        ];

        // Send the POST request
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Credentials' => $credentials
        ])->post('https://easypay.easypaisa.com.pk/easypay-service/rest/v4/inquire-transaction', $data);

        // Check for any errors in the request
        if ($response->successful()) {
            // Handle success response
            $responseData = $response->json();
            return response()->json($responseData);
        } elseif ($response->failed()) {
            // Handle failed request
            return response()->json(['error' => 'Failed to inquire transaction.'], 500);
        }
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
        $crypttext = openssl_encrypt($sorted_string, $cipher, 'EVB39B3S9LGTDEK5', OPENSSL_RAW_DATA);
        $HashedRequest = Base64_encode($crypttext);

        return $HashedRequest;
    }

}
