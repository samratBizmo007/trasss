<form action="<?php echo $action; ?>" method="post" name="payuForm" id="payuForm" style="display: block">
    <input type="hidden" name="key" value="<?php echo MERCHANT_KEY ?>" />
    <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
    <input type="hidden" name="hash_abc" value="<?php echo $hash_string ?>"/>
    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
    <input name="amount" type="number" value="<?php echo $totalCost; ?>" />
    <input type="text" name="firstname" id="firstname" value="<?php echo $firstName; ?>" />
    <input type="email" name="email" id="email" value="<?php echo $email; ?>" />
    <input type="text" name="phone" value="<?php echo $mobile; ?>" />
    
    <!-- <input type="hidden" name="membership_package" id="membership_package" value="<?php echo $membership_package; ?>"> -->
    <textarea name="productinfo"><?php echo $productinfo; ?></textarea>
    <input type="text" name="surl" value="<?php echo SUCCESS_URL; ?>" />
    <input type="text" name="furl" value="<?php echo FAIL_URL?>"/>
    <input type="text" name="service_provider" value="payu_paisa"/>
    <input type="text" name="lastname" id="lastname" value="<?php echo $lastName ?>" />
</form>
<script type="text/javascript">
    var payuForm = document.forms.payuForm;
    payuForm.submit();
</script>