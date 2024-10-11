<!DOCTYPE html>
<html>
<head>
    <title>Easy Pay</title>
</head>
<body>
    <form action="https://easypaystg.easypaisa.com.pk/easypay/Index.jsf" method="POST" id="easyPayStartForm">
        <input name="storeId" value="{{ $storeId }}" hidden="true"/>
        <input name="amount" value="{{ $amount }}" hidden="true"/>
        <input name="postBackURL" value="{{ $postBackURL }}" hidden="true"/>
        <input name="orderRefNum" value="{{ $orderRefNum }}" hidden="true"/>
        <input type="text" name="expiryDate" value="{{ $expiryDate }}">
        <input type="hidden" name="autoRedirect" value="{{ $autoRedirect }}">
        <input type="hidden" name="paymentMethod" value="{{ $paymentMethod }}">
        <input type="hidden" name="emailAddr" value="{{ $emailAddr }}">
        <input type="hidden" name="mobileNum" value="{{ $mobileNum }}">
        <input type="hidden" name="merchantHashedReq" value="{{ $hashRequest }}">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
