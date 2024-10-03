<html>
    <head>
        <script type = "text/javascript"> 
            function closeTthisAasap(){
                //document.forms["redirectpost"].submit();
            }
        </script>
    </head> 
    <body onload="closethisasap();">
        <h1> Please wait fyou will be redirected soon to <br> EasyPay payment page</h1>
        <form name = "redirectpost" method="POST" action="{{Config::get('constatns.easypay.TRANSACTION_POST_URL2')}}">

        @foreach ($post_data as $key = $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        </form>
    </body>
</html>