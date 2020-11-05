<?php
    session_start();
    require_once('../config/functions.php');	
    if(!isLoggedIn()) { die(); }
    $type = $_GET['type'];
	$kwota = $_GET['kwota'];
?>

<?php 
if($type == 'standard') { ?>
        <form id="payment" action="https://ssl.dotpay.pl/" method="POST">
        <input type="hidden" name="id" value="261217"/>
        <input type="hidden" name="currency" value="PLN"/>
        <input type="hidden" name="description" value="Wpłata do wirtualnego portfela / LiveServer.pl (API)"/>
        <input type="hidden" name="type" value="0"/>
        <input type="hidden" name="URL" value="https://gpp-samp.pl/index.php?page=sklep&type=przelew"/>
        <input type="hidden" name="api_version" value="dev"/>
        <input type="hidden" name="control" value="API-11999"/>
        <input type="hidden" name="amount" value="<?php echo $kwota; ?>"/>
</form>
<?php } 
if($type == 'paypal') { 
    ?>
        <form name="paypalForm" action="https://liveserver.pl/pay.php?method=paypal" method="post" target="_blank">
            <input type="hidden" name="lvs_client_id" value="11999"/> 
            <input type="hidden" name="api"/>
            <input type="hidden" name="lvs_o_amount" value="<?php echo $kwota; ?>"/> 
            <input type="hidden" id="payment" name="lvs_o_submit" value="Wyślij"/>
        </form>
    <?php
} 
?>

<?php if($type=='standard') { ?>
        <script> 
        window.onload=function(){ 
            document.getElementById('payment').submit(); 
        } 
        </script>
<?php } 
if($type=='paypal') { 
?>
        <script>
        document.forms["paypalForm"].submit();
        </script>
<?php
        header( "Refresh:5; url=/index.php?page=sklep&type=paypal", true, 303);
}
?>