<?php
if(!isset($_GET["gcb"])) (die("Please select some values"));
require_once('../../../../wp-admin/admin.php');
require_once('gcb_arraytoxml.php');
global $wpdb;


$ids = explode(";",$_GET["gcb"]);
$final_text = array();

$xml_array = array();

foreach($ids as $id) {
    if(intval($id)>0) {
        $entry = $wpdb->get_row("select name,description,value,type from ".$wpdb->prefix."gcb where id=".intval(mysql_real_escape_string($id)),ARRAY_A);
        $xml_array[] = $entry;        
    }
}

$xml = array();

$xml[] = "﻿<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

foreach($xml_array as $x) {
$xml[] = "<gcbentry>";
  $xml[] = "<name>".$x["name"]."</name>";
  
   $xml[] = "<description>".$x["description"]."</description>";
  
  $xml[] = "<type>".$x["type"]."</type>";
  
  $xml[] = "<value><![CDATA[".htmlspecialchars_decode(stripslashes($x["value"]))."]]></value>";
  
$xml[] = "</gcbentry>";
}

$f = implode("\n",$xml);


//$array2xml = new ArrayToXML();

//$f = $array2xml->toXml($xml_array,"gcbdata");

//echo $xml;
header("Content-Type: text/xml");
header('Accept-Ranges: bytes');
echo $f;
die();


		header("Content-Type: text/xml");
		header("Content-disposition: attachment; filename=export_gcb_".date("d_m_y_H_i").".xml;");
		//header("Content-Length: ".strlen($f));

		//header('Content-Transfer-Encoding: Binary');
		//header('Accept-Ranges: bytes');

		//header('ETag: "'.md5($f).'"');
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");

		echo $f;

  die();
?>