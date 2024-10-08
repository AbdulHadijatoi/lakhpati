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
            <form action="{{ $transaction_url_2 }}" method="POST" target="_blank">
              <div>
                <input id="auth_token" name="auth_token" type="hidden" value="{{ $auth_token }}" />
                <input id="postBackURL" name="postBackURL" type="hidden" value="{{ $postBackURL }}" />
            </div>

          <div class="flex items-center justify-end mt-4">
            <button class="btn btn-primary" type="submit">
              Confirm
            </button>
          </div>
        </form>
      </div>
    </body>
</html>