<?php
return [
    'easypay' => [
        'STORE ID' => '578817',
        'HASHKEY' => 'EVB39B3S9LGTDEK5',
        //Post back url
        'POST_BACK_URI1' => 'http://127.0.0.1:8000/checkout-confirm',
        'POST_BACK_URL2' => 'http://127.0.0.1:8000/paymentStatus',
        //Live
        'TRANSACTION_POST_URI1' => 'https://easypay.easypaisa.compk/easypay/Index.jsf',
        'TRANSACTION_POST_URL2' => 'https://easypay.easypaisa.com.pk/easypay/Confirm.jsf',
    ]
];