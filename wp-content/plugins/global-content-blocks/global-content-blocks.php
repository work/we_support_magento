<?php
/*
Plugin Name: Global Content Blocks
Plugin URI: http://wordpress-plugins.org/global-content-blocks
Description: Create your own shortcodes to add HTML, PHP, forms, opt-ins, iframes, Adsense, code snippets, reusable objects, etc, to posts and pages. Ideal for adding reusable objects to your content or to preserve formatting of code that normally gets stripped out or reformatted by the editor
Version: 1.3
Author: Ben Magrill
Author URI: http://wordpress-plugins.org
*/

define('GCB_VERSION','1.1.2');
$current_version = get_option("gcb_db_version");



gcb_check_update();

require_once 'gcb/gcb.class.php';

/*
 * Installs the plugin!
 */
function gcb_install() {
    global $wpdb;
   $table_name = $wpdb->prefix . "gcb";
     if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
         $sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  name varchar(36) NOT NULL,
	  description text NOT NULL,
	  value text NOT NULL,
          type varchar(100) NOT NULL DEFAULT 'other',
	  UNIQUE KEY id (id)
	);";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
     add_option("gcb_db_version", GCB_VERSION);
     }
}

function gcb_uninstall() {
    if(get_option("gcb_complete_uninstall","no")=="yes") {
    global $wpdb;
      $table_name = $wpdb->prefix . "gcb";
     if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
         $sql = "DROP TABLE ".$table_name;
         $wpdb->query($sql);
         delete_option("gcb_db_version");
         delete_option("gcb_complete_uninstall");
     }
    }
}

function gcb_check_update() {
    $current_version = get_option("gcb_db_version");
    if(version_compare($current_version, GCB_VERSION)<0) {
        //we need to perform an update on the database        
        
        switch($current_version) {
            case "1.0":
            case "1.0.1":
                gcb_add_db_column("type", "VARCHAR(100) NOT NULL DEFAULT 'other'");              
                break;
        }
         //update the option
         update_option("gcb_db_version",GCB_VERSION);
    }
}

function gcb_add_db_column($name,$options) {
    global $wpdb;
    $table_name = $wpdb->prefix . "gcb";
    //check if column exists
    $row = $wpdb->get_row("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$table_name."' AND COLUMN_NAME = '".$name."'");

    if($row===null) {       
       $wpdb->query("ALTER TABLE ".$table_name." ADD ".$name." ".$options);
    }
}

function gcb_add_submenu() {
    $gcb_page = add_options_page( "Global Content Blocks", "Global Content Blocks", "publish_pages", "global-content-blocks", "gcb_submenu");
    add_action( "admin_print_scripts-$gcb_page", 'gcb_loadjs_admin_head',5 );
}

function gcb_loadjs_admin_head() {
    wp_enqueue_script('gcb_uni_script', get_option('siteurl').'/wp-content/plugins/global-content-blocks/resources/extra/extra.js');
}

function gcb_submenu() {
       global $wpdb;
        $msg = "";
    if(isset($_POST["gcb_delete"])) {
        if(isset($_POST["gcb_del"]) && is_array($_POST["gcb_del"])) {
            foreach($_POST["gcb_del"] as $bd) {
                 $wpdb->query("delete from ".$wpdb->prefix."gcb where id=".intval($bd)." limit 1");
            }
            $msg = "Deleted!";
        }
    }

    if(isset($_POST["gcb_unin"])) {
        if(isset($_POST["ch_unin"])) {
           update_option("gcb_complete_uninstall","yes");
        }
        else
        {
            update_option("gcb_complete_uninstall","no");
        }
    }

    if(isset($_POST["gcb_import"])) {
        //importing files
       $msg = gcb_import();
    }

    if(isset($_POST["gcb_save"])) {
        $name = $_POST["gcb_name"];
        $description = mysql_real_escape_string(htmlspecialchars($_POST['gcb_description']));
        $type = mysql_real_escape_string(htmlspecialchars($_POST['gcb_type']));
        $value = mysql_real_escape_string(htmlspecialchars($_POST['gcb_value']));
       
        

        if(strlen($name) && strlen($value)) {
        if(isset($_POST["update_it"])) {
           $wpdb->query("update ".$wpdb->prefix."gcb set name='".$name."',
                         description='".$description."',
                         value='".$value."',
                         type='".$type."' 
                        where id=".intval($_POST["update_it"]." limit 1"));
           $msg = "Entry updated!";
        }
        else
        {
            $wpdb->query("insert into ".$wpdb->prefix . "gcb (name,description,value,type) VALUES ('".$name."','".$description."','".$value."','".$type."')");
            $msg = "Entry inserted!";
        }
        }
        else
        {
             $msg = "Name and Content are mandatory!";
        }
    }
    
    echo gcb::main_page($msg);
}


function gcb_import() {
    global $wpdb;
    $text = file_get_contents($_FILES["gcb_import_file"]["tmp_name"]);
	/*
    echo "text:\n".$text;
    $xml = simplexml_load_string($text);
    print_r($xml);
    die();
	*/
    $entries1 = explode("\r\n",$text);
    $entries = array();
    foreach($entries1 as $e1) {
        $row = explode("<;>",$e1);
        $entries[] = array(
            "name"=>  mysql_real_escape_string(base64_decode($row[0])),
            "description"=>  mysql_real_escape_string(base64_decode($row[1])),
            "value"=> mysql_real_escape_string(base64_decode($row[2])),
            "type"=>  mysql_real_escape_string(base64_decode($row[3])),
        );
    }

    foreach($entries as $e) {
        $wpdb->query("insert into ".$wpdb->prefix . "gcb (name,description,value,type) VALUES ('".$e["name"]."','".$e["description"]."','".$e["value"]."','".$e["type"]."')");
    }
    return "Imported ".count($entries)." blocks";
}

function gcb_shortcode_replacer($atts, $content=null, $code="") {
    $a = shortcode_atts( array('id' => 0), $atts );
    if($a["id"]==0) return "";
     global $wpdb;
     //does this one exist ?
     $ex = $wpdb->get_var("SELECT COUNT(*) from `".$wpdb->prefix."gcb` WHERE `id` = ".$a["id"].";");
     if($ex==1) {
    $record = $wpdb->get_row("SELECT value,type FROM `".$wpdb->prefix."gcb` WHERE `id` = ".$a["id"].";");

    if($record->type!="php") {
     return htmlspecialchars_decode(stripslashes($record->value));
    }
    else
    {
        //execute the php code        
        ob_start();
        $result = eval(" ".htmlspecialchars_decode(stripslashes($record->value)));
        $output = ob_get_contents();
	ob_end_clean();
        return $output . $result;
    }
     }
     else
     {   return "";    }
}


if (!function_exists("gcb_settingslink")) {
	function gcb_settingslink( $links, $file ){
		static $this_plugin;
		if ( ! $this_plugin ) {
			$this_plugin = plugin_basename(__FILE__);
		}	
		if ( $file == $this_plugin ){
			$settings_link = '<a href="options-general.php?page=global-content-blocks">' . __('Settings') . '</a>';
			array_unshift( $links, $settings_link );
		}
		return $links;
	}
}


/**
 * Hooks
 */
register_activation_hook(__FILE__,'gcb_install');
register_deactivation_hook(__FILE__,'gcb_uninstall');
add_action('admin_menu', 'gcb_add_submenu',5);
add_shortcode('contentblock', 'gcb_shortcode_replacer');



        // Load the custom TinyMCE plugin
function gcb_mce_external_plugins( $plugins ) {
		$plugin_array['gcbplugin'] =get_option('siteurl')."/wp-content/plugins/global-content-blocks/resources/tinymce/editor_plugin.js";
                return $plugin_array;
	}

function gcb_mce_buttons( $buttons ) {
                array_push( $buttons,"|","gcb");
		return $buttons;
}

function gcb_addbuttons() {
// Don't bother doing this stuff if the current user lacks permissions
if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
            return;

// Register editor button hooks
if ( get_user_option('rich_editing') == 'true') {     
add_filter( 'mce_external_plugins','gcb_mce_external_plugins',3);
add_filter( 'mce_buttons', 'gcb_mce_buttons',3);
     }
}

function gcb_my_refresh_mce($ver) {
  $ver += 3;
  return $ver;
}
// init process for button control
add_action('init', 'gcb_addbuttons',3);
add_filter( 'tiny_mce_version', 'gcb_my_refresh_mce',3);
add_filter( 'plugin_action_links', 'gcb_settingslink', 10, 2 );
