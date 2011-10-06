<?php
require_once('../../../../../wp-load.php');
global $wpdb;
$list = $wpdb->get_results("select * from ".$wpdb->prefix . "gcb");


//define the available types,and their image
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

?>
<html>
    <head>
        <title>Global Content Blocks</title>
        <script type="text/javascript" src="<?php echo get_option('siteurl')."/wp-includes/js/jquery/jquery.js"?>"></script>
         <script type="text/javascript" src="<?php echo get_option('siteurl')."/wp-includes/js/tinymce/tiny_mce_popup.js?ver=327-1235"?>"></script>
        <script type="text/javascript">
            function do_s() {
              var opt = document.getElementById("gcb_sel").options[document.getElementById("gcb_sel").selectedIndex];
              var continue_send = true;
            if(opt.value != "0")
            {
            var actual = document.getElementById("gcb_actual").checked;
            if(!actual) {
            var img = opt.id;
            var html = "<img src='<?php echo get_option('siteurl'); ?>/wp-content/plugins/global-content-blocks/resources/i/"+img+"' class='gcbitem mceItem' title='contentblock id=" + opt.value + " img="+img+"' />";
            }
            else
                {
                    var html = "";
                    continue_send = false;
                    jQuery.post(
                                "<?php echo get_option('siteurl'); ?>/wp-content/plugins/global-content-blocks/resources/tinymce/gcbvalue.php",
                                {id:opt.value},
                                function(data){
                                    var win = window.dialogArguments || opener || parent || top;
                                            win.send_to_editor(data);
                                            tinyMCEPopup.close()
                                            return false;
                                }
                            );
                               
                }
        }
        else
        {
            var html = "";
            alert("Please select something!");
            return false;
        }
        if(continue_send) {
        var win = window.dialogArguments || opener || parent || top;
        win.send_to_editor(html);
        tinyMCEPopup.close();
        return false;
        }
        }
        jQuery(document).ready(function(ex){         
          jQuery("#gcb_create_link").click(function(){
            jQuery("#insert_wrapper").slideUp(200);
            jQuery("#add_wrapper").slideDown(200);
            return false;
          });
          jQuery("#gcb_insert_link").click(function(ex){            
            jQuery("#add_wrapper").slideUp(200);
            jQuery("#insert_wrapper").slideDown(200);
            return false;
          });          
          jQuery("#gcb_frame_type").change(function(){
        var sel = jQuery(this).children("option:selected");
        jQuery("span#frame_type_help").text(sel.attr("help"));
          });
         
         jQuery("#gcb_frame_add_do").click(function(){
          if(!check_add_form()){
            alert("Please fill in all mandatory  values!\n(note: mandatory fields are marked with a star sign;eg: *)");
            return;
          }
          
          jQuery.post(
                                "<?php echo get_option('siteurl'); ?>/wp-content/plugins/global-content-blocks/resources/tinymce/gcb_ajax_add.php",
                                {name:jQuery("#gcb_frame_name").val(),
                                type:jQuery("#gcb_frame_type").val(),
                                description:jQuery("#gcb_frame_description").val(),
                                content:jQuery("#gcb_frame_content").val()
                                },
                                function(data){
                                   var new_option = "<option id='"+data.img+"' value='"+data.id+"'>"+data.name+"</option>";
                                   jQuery("#gcb_sel").append(new_option);                                   
                                  document.getElementById("gcb_sel").selectedIndex = parseInt(jQuery("#gcb_sel option").length) -1;
                                  jQuery("#add_wrapper").slideUp(200);
                                  jQuery("#insert_wrapper").slideDown(200);
                                }, 
                                "json"
                            );
          
         });
          
        });
        
        function check_add_form(){
          var f1 = jQuery("#gcb_frame_name").val().length;
          var f2 = jQuery("#gcb_frame_content").val().length;
          if(!f1 || !f2){
          return false;
          }
          return true;
        }
    </script>
        <style>
            body {font-family: sans-serif;font-size:10pt;}
            #add_wrapper {display:none;}
            #gcb_add_new_form_wrap_ajax label,
            #gcb_add_new_form_wrap_ajax input,
            #gcb_add_new_form_wrap_ajax select,
            #gcb_add_new_form_wrap_ajax textarea {clear:both;float:left;}
            #gcb_add_new_form_wrap_ajax p {margin:2px 0;border-top:1px solid #ccc;float:left;width:100%;}
            #gcb_add_new_form_wrap_ajax input {line-height:10pt;height:25px;width:300px;}
            #gcb_add_new_form_wrap_ajax select {line-height:10pt;height:25px;}
            #gcb_add_new_form_wrap_ajax label {font-weight:bold;}
           #frame_type_help {float:right;padding-right:10px;}
        </style>
    </head>
    <body>



<div id="insert_wrapper">
<h4>Insert Global Content Block</h4>
<i>Select the content block to insert</i>
<br />
<select id="gcb_sel" name="gcb_sel" style="width:300px;">
    <option value="0">--Select a content block--</option>
    <?php foreach($list as $l): ?>
        <option id="<?php echo $available_types[$l->type]["img"]?>" value="<?php echo $l->id;?>"><?php echo $l->name; ?></option>
    <?php endforeach; ?>
</select>
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr valign="top">
    <td width="1%">
<input type="checkbox" name="gcb_actual" id="gcb_actual"/></td>
    <td width="99%"><label for="gcb_actual"><font size="2">Insert full content (not the shortcode)</font><br />
      <i><font size="1">(not recommended for php code)</font></i></label></td>
  </tr>
</table>
<br /><br />
<button id="gcb_insert" onclick="do_s()">Insert Content Block</button>
<br /><br />
or
<a id="gcb_create_link" href="#">Create New Content Block</a> 
</div>
<div id="add_wrapper">
<h4>Create New Content Block</h4>
<a id="gcb_insert_link" href="#">Cancel creating new block</a> 
<br /><br />
<div id="gcb_add_new_form_wrap_ajax">
  <p>
    <label for="gcb_frame_name">Name (short title) *</label>
    <input type="text" id="gcb_frame_name" name="gcb_frame_name" />
  </p> 
  
  <p>
    <label for="gcb_frame_type">Block type</label>
    <select name="gcb_frame_type" id="gcb_frame_type">
    <?php foreach($available_types as $ak=>$av): ?>
        <option value="<?php echo $ak?>" help="<?php echo $av["help"]?>"><?php echo $av["vname"]?></option>
    <?php endforeach; ?>
    </select>
    <span id="frame_type_help"><?php echo $available_types["other"]["help"];?></span>
  </p>
  
  <p>
    <label for="gcb_frame_description">Description (optional)</label>
    <textarea cols="60" rows="2" name="gcb_frame_description" id="gcb_frame_description"></textarea>
  </p> 
  
  <p>
    <label for="gcb_frame_content">Content*</label>
    <textarea cols="60" rows="4" name="gcb_frame_content" id="gcb_frame_content"></textarea>
  </p>
  
  <p>
    <button id="gcb_frame_add_do">Add content block</button>
  </p>
  
</div>
</div>
    </body>
</html>