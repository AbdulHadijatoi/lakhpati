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
        // $data = $request->input();

        // $product_id = $data['product_id'];
        $product = ['name' => 'New product', 'price' => '20.0'];

        $amount = $product['price'];
        $amount = substr($amount, 0, -1);

        $dateTime = new DateTime();

        $orderRefNum = $dateTime->format('YmdHis');

        $expiryDateTime = $dateTime;
        $expiryDateTime->modify('+' . 1 . ' hours');
        $expiryDate = $expiryDateTime->format('Ymd His');

        $post_data = array(
            "storeld" => Config::get ('constants.easypay.STORE_ID'),
            "amount" => $amount,
            "postBackURL" => Config::get ('constants.easypay.POST_BACK_URL1'),
            "orderRefNum" => $orderRefNum,
            "expiryDate" => $expiryDate, //Optional
            "merchantHashedReg" => "", //Optional
            "autoRedirect" => "1", //Optional
            "paymentMethod" => "OTC_PAYMENT_METHOD", //Optional
            // OTC_PAYMENT_METHOD
            // MA_PAYMENT_METHOD
            // CC_PAYMENT_METHOD
        );

        $post_data['merchantHashedReg'] = $this->getSecureHash($post_data);

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
        
        // AES/ECB/PKCS5Padding algorithm
        $cipher = "aes-128-ecb";
        $crypttext = openssl_encrypt($sorted_string, $cipher, Config::get('constants.easypay.HASHKEY'), OPENSSL_RAW_DATA);
        $HashedRequest = Base64_encode($crypttext);
        //NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN

        return $HashedRequest;
    }
    
}
