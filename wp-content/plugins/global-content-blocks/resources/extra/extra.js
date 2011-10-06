jQuery(document).ready(function() {

    jQuery("#gcb_toggle").click(function(){
        if(jQuery(this).attr("checked")) {
            jQuery(".gcb_del_cb").each(function(){
                jQuery(this).attr("checked",true);
        });
        }
        else
            {
                jQuery(".gcb_del_cb").each(function(){
                jQuery(this).attr("checked",false);
        });
            }
    });

    var cb = jQuery("#unin");
    if(cb.length) {
        cb.click(function(){
           if(confirm("Are you sure? \nYou will permanently lose your content blocks when the plugin is deactivated.")) {
           cb.unbind("click");
           return true;
           }
           else
               {
                   return false;
               }
        });
    }



    jQuery("#gcb_type").change(function(){
        var sel = jQuery(this).children("option:selected");
        jQuery("span#type_help").text(sel.attr("help"));
        jQuery("img#type_img").attr("src","../wp-content/plugins/global-content-blocks/resources/i/"+sel.attr("img"));
    });

    jQuery(".gcb_export").each(function(){
        jQuery(this).click(function(evt){
        evt.preventDefault();
        var blocks_to_export = [];
        jQuery(".gcb_del_cb").each(function(){
			var checked = jQuery(this).attr("checked");
            if((typeof checked !== 'undefined') && (checked !== false)) blocks_to_export.push(jQuery(this).val());
        });

        if(blocks_to_export.length)
            {               
                location.href="../wp-content/plugins/global-content-blocks/gcb/gcb_export.php?gcb="+blocks_to_export.join(";");
            }
            else
                {
                    alert("Select at least one block to export!");
                }
    });
    });

});
