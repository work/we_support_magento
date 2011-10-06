<?php
if(!isset($_POST["id"]) || intval($_POST["id"])<=0)
    die();
$gcb_id= intval($_POST["id"]);
require_once('../../../../../wp-load.php');
global $wpdb;
$val = $wpdb->get_row("select value from ".$wpdb->prefix."gcb where id=".$gcb_id);
if($val!==null) {
    echo stripslashes(htmlspecialchars_decode($val->value));
}
die();
?>
