<html>
    <head>
        <script type = "text/javascript"> 
            function closeThisAsap(){
                document.forms["redirectpost"].submit();
            }
        </script>
    </head> 
    <body onload="closeThisAsap();">
        <h1> Please wait fyou will be redirected soon to <br> EasyPay payment page</h1>
        <form name="redirectpost" method="POST" action="https://easypay.easypaisa.com.pk/easypay/Confirm.jsf">
            @csrf
            @foreach ($data as $key => $value)
                <input type="text" name="{{ $key }}" value="{{ $value }}">
            @endforeach
        </form>
    </body>
</html>