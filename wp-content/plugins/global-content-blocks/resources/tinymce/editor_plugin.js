(function() {
    tinymce.create('tinymce.plugins.gcbplugin', {
        init : function(ed, url) {
            var t = this;
            ed.addCommand('gcb_do', function() {
                    ed.windowManager.open({
                    file:url+"/getgcb.php?a=1",
                    width:400+parseInt(ed.getLang("media.delta_width",0)),
                    height:350+parseInt(ed.getLang("media.delta_height",0)),
                    inline:1
                },{
                    plugin_url:url
                });

			});

            ed.addButton('gcb', {
                title : 'Insert Global Content Block',
                image :url+'/block20.gif',
                onclick : function() {                   
               ed.execCommand("gcb_do");
                }
            });

            ed.onBeforeSetContent.add(function(ed, o) {
				o.content = t._process_gcb(o.content,url);
			});

           ed.onPostProcess.add(function(ed, o) {
				if (o.get)
					o.content = t._get_gcb(o.content);
			});
        },

        _process_gcb : function(co,url) {
			return co.replace(/\[contentblock([^\]]*)\]/g, function(a,b){
                                    var im= b.replace(/id=([0-9]*) img=/,"");
                                    var img="gcb.png";if(im.length) img=im.replace(/^\s+/,"");//ltrim - a white space creeps out in the left; maybe regexe's fault ?
				return '<img src="'+url+'/../i/'+img+'" class="gcbitem mceItem" title="contentblock'+tinymce.DOM.encode(b)+'" />';
			});
		},
	_get_gcb : function(co) {
			function getAttr(s, n) {
				n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
				return n ? tinymce.DOM.decode(n[1]) : '';
			};
			return co.replace(/(<img[^>]+>)/g, function(a,im) {
				var cls = getAttr(im, 'class');

				if ( cls.indexOf('gcbitem') != -1 )
					return '['+tinymce.trim(getAttr(im, 'title'))+']';

				return a;
			});
		},
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Global Content Blocks",
                author : 'Ben Magrill',
                authorurl : 'http://wordpress-plugins.org',
                infourl : 'http://wordpress-plugins.org/global-content-blocks',
                version : "1.1.1"
            };
        }
    });
    tinymce.PluginManager.add('gcbplugin', tinymce.plugins.gcbplugin);
})();