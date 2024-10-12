<form id="easypay-form" action="https://easypay.easypaisa.com.pk/easypay/Confirm.jsf" method="POST">
    @csrf
    <input name="auth_token" value="{{ $data['auth_token'] }}" type="hidden"/>
    <input name="postBackURL" value="{{ url('api/v1/easypaisa/payment-status') }}" type="hidden"/>
</form>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('easypay-form').submit();
    });
</script>