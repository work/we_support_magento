<?php
require_once('../../../../../wp-load.php');
global $wpdb;

if(!isset($_POST["name"]) || !isset($_POST["content"])) {die("invalid call!");}

$name = $_POST["name"];
$description = mysql_real_escape_string(htmlspecialchars($_POST['description']));
$type = mysql_real_escape_string(htmlspecialchars($_POST['type']));
$value = mysql_real_escape_string(htmlspecialchars($_POST['content']));

if(!strlen($name) || !strlen($value)) {die("invalid call!");}

$available_types = array(
            "other"=>array("vname"=>"General","img"=>"gcb.png","help"=>"Content block"),
            "adsense"=>array("vname"=>"Adsense","img"=>"adsense.png","help"=>"Adsense code"),
            "code"=>array("vname"=>"Code","img"=>"code.png","help"=>"Programming code"),
            "form"=>array("vname"=>"Form","img"=>"form.png","help"=>"General form"),
            "html"=>array("vname"=>"HTML","img"=>"html.png","help"=>"Raw HTML code"),
            "iframe"=>array("vname"=>"Iframe","img"=>"iframe.png","help"=>"Iframe code"),
            "optin"=>array("vname"=>"Opt-In Form","img"=>"optin.png","help"=>"Opt-In form code"),
            "php"=>array("vname"=>"PHP Code","img"=>"php.png","help"=>"PHP code (without <?php, <?, ?> tags)"),
        );



$wpdb->query("insert into ".$wpdb->prefix . "gcb (name,description,value,type) VALUES ('".$name."','".$description."','".$value."','".$type."')");

$inserted_id = mysql_insert_id();

$return = array(
"id"=>$inserted_id,
"name"=>$name,
"img"=>$available_types[$type]["img"]
);

echo json_encode($return);die();
?>