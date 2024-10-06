<form action="https://easypay.easypaisa.com.pk/easypay/Confirm.jsf " method="POST" target="_blank">
    <input type="text" name="auth_token" value="{{ $auth_token }}"/>
    <input type="text" name="postBackURL" value="{{ url('paymentStatus') }}"/>
    <input value="confirm" type="submit" name="pay"/>
</form>