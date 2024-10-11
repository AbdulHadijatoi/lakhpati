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
    protected $transaction_url_1 = 'https://easypay.easypaisa.com.pk/easypay/Index.jsf';
    protected $transaction_url_2 = 'https://easypay.easypaisa.com.pk/easypay/Confirm.jsf';
    
    protected $storeId = '578817';
    protected $hashKey = 'EVB39B3S9LGTDEK5'; 
    
    public function doCheckout(Request $request) {
        // $data = $request->input();

        // $product_id = $data['product_id'];
        $product = ['name' => 'New product', 'price' => '20.0'];

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
            "postBackURL" => url('paymentConfirm'),
            "orderRefNum" => $orderRefNum,
            "expiryDate" => $expiryDate, //Optional
            "merchantHashedReq" => "", //Optional
            "autoRedirect" => "1", //Optional
            "paymentMethod" => "QR_PAYMENT_METHOD", //Optional
            // OTC_PAYMENT_METHOD
            // MA_PAYMENT_METHOD
            // CC_PAYMENT_METHOD
            // QR_PAYMENT_METHOD
        );

        $post_data['merchantHashedReq'] = $this->getSecureHash($post_data);

        $values = array(
            'TxnRefNo' => $orderRefNum,
            'amount' => $product['price'],
            'description' => 'New product',
            'status' => 'pending'
        );

        // SAVE $VALUES TO DB

        Session::put('post_data', $post_data);

        return view('do_checkout_v');
    }

    public function paymentConfirm(Request $request) { 
        
        $data = array(); 
        $data['auth_token'] = $request->auth_token;
        $data['postBackUrl'] = url('paymentStatus');

        return view('checkout_confirm_v',compact('data'));
    }

    public function paymentStatus(Request $request) { 
        return $request->input();
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


    public function index()
    {
        $hashKey = $this->hashKey; // generated from easypay account
        $storeId = $this->storeId;
        $amount = "30.0";
        $postBackURL = "https://www.test.com/confirm-payment";
        $orderRefNum = "1008";
        $expiryDate = "20190721 112300";
        $autoRedirect = 0;
        $paymentMethod = 'CC_PAYMENT_METHOD';
        $emailAddr = 'abdulhadijatoi@gmail.com';
        $mobileNum = "03362735187";

        // Starting encryption
        $paramMap = [
            'amount' => $amount,
            'autoRedirect' => $autoRedirect,
            'emailAddr' => $emailAddr,
            'expiryDate' => $expiryDate,
            'mobileNum' => $mobileNum,
            'orderRefNum' => $orderRefNum,
            'paymentMethod' => $paymentMethod,
            'postBackURL' => $postBackURL,
            'storeId' => $storeId,
        ];

        // Creating the string to be encoded
        $mapString = '';
        foreach ($paramMap as $key => $val) {
            $mapString .= $key . '=' . $val . '&';
        }
        $mapString = substr($mapString, 0, -1);

        // Encrypting the string
        $mapString = $this->pkcs5Pad($mapString, 16);
        $crypttext = openssl_encrypt($mapString, 'AES-128-ECB', $hashKey, OPENSSL_RAW_DATA);
        $hashRequest = base64_encode($crypttext);

        // Returning the view with the encrypted data
        return view('payment.index', compact('storeId', 'amount', 'postBackURL', 'orderRefNum', 'expiryDate', 'autoRedirect', 'paymentMethod', 'emailAddr', 'mobileNum', 'hashRequest'));
    }

    // Function for padding the string
    private function pkcs5Pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public function confirmPayment(Request $request)
    {
        // Handle the confirmation process here
        return view('payment.confirm', ['auth_token' => $request->input('auth_token')]);
    }
    
}
