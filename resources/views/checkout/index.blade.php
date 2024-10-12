<html xmins="http://www.w3.org/1999/xhtml"><head>
<script type="text/javascript">
    function closeThisAsap() {
        document.forms["redirectpost"].submit();
    }
</script>
</head>
<body onload="closeThisAsap();">
    <form name="redirectpost" method="POST" action="https://easypay.easypaisa.com.pk/easypay/Index.jsf">
    @csrf
    
        <?php
            echo '<pre>';
            print_r('Please wait, loading...');
            echo '</pre>';
        ?>
        @foreach ($post_data as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form> 
</body> 
</html>