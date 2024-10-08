<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            <form action="{{ $transaction_url_1 }}" method="POST" target="_blank">
              <div>
                <input id="amount" name="amount" type="hidden" value="{{ $amount }}" />
                <input id="storeId" name="storeId" type="hidden" value="{{ $storeId }}" />
                <input id="postBackURL" name="postBackURL" type="hidden" value="{{ $postBackURL }}" />
                <input id="orderRefNum" name="orderRefNum" type="hidden" value="{{ $orderRefNum }}" />
                <input id="expiryDate" name="expiryDate" type="hidden" value="{{ $expiryDate }}" />
                <input id="merchantHashedReq" name="merchantHashedReq" type="hidden" value="{{ $merchantHashedReq }}" />
                <input id="autoRedirect" name="autoRedirect" type="hidden" value="{{ $autoRedirect }}" />
                <input id="paymentMethod" name="paymentMethod" type="hidden" value="{{ $paymentMethod }}" />
                <input id="mobileNum" name="mobileNum" type="hidden" value="{{ $mobileNum }}" />
                <input id="payImg" name="pay" type="image" src="{{ asset('easypaisa.webp') }}" border="0" />
            </div>

          <div class="flex items-center justify-end mt-4">
            <button class="btn btn-primary" type="submit">
              Pay
            </button>
          </div>
        </form>
      </div>
    </body>
</html>