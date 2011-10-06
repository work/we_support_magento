<?php
if(!isset($_GET["gcb"])) (die("Please select some values"));
require_once('../../../../wp-load.php');
global $wpdb;


$ids = explode(";",$_GET["gcb"]);
$final_text = array();

foreach($ids as $id) {
    if(intval($id)>0) {
        $entry = $wpdb->get_row("select * from ".$wpdb->prefix."gcb where id=".intval(mysql_real_escape_string($id)));
        $final_text[] =
        base64_encode($entry->name)."<;>".
        base64_encode($entry->description)."<;>".
        base64_encode($entry->value)."<;>".
        base64_encode($entry->type);        
    }
}

$final = implode("\r\n",$final_text);



		header("Content-Type: text/plain");
		header("Content-disposition: attachment; filename=export_gcb_".date("d_m_y_H_i").".gcb;");
		header("Content-Length: ".strlen($final));

		header('Content-Transfer-Encoding: Binary');
		header('Accept-Ranges: bytes');

		header('ETag: "'.md5($final).'"');
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");

		echo $final;

  die();
?>
