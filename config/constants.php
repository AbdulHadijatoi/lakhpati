<?php
return [
    'easypay' => [
        'STORE_ID' => '578817',
        'HASHKEY' => 'EVB39B3S9LGTDEK5',
        //Post back url
        'POST_BACK_URL1' => url('checkout-confirm'),
        'POST_BACK_URL2' => url('paymentStatus'),
        //Live
        'TRANSACTION_POST_URL1' => 'https://easypay.easypaisa.com.pk/easypay/Index.jsf',
        'TRANSACTION_POST_URL2' => 'https://easypay.easypaisa.com.pk/easypay/Confirm.jsf',
    ]
];