<!DOCTYPE html>
<html>
<head>
    <title>EasyPay Confirm</title>
</head>
<body>
    <div align="center">
        <img src="images/wait.gif">
    </div>
    <form action="https://easypaystg.easypaisa.com.pk/easypay/Confirm.jsf" method="POST" id="easyPayAuthForm">
        <input name="auth_token" value="{{ $auth_token }}" hidden="true"/>
        <input name="postBackURL" value="https://www.test.com/confirmPayment.php" hidden="true"/>
        <input type="submit" value="Confirm" name="pay"/>
    </form>
    <script>
        (function() {
            document.getElementById("easyPayAuthForm").submit();
        })();
    </script>
</body>
</html>
