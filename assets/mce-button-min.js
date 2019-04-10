tinymce.PluginManager.add("my_mce_button",function(t,n){t.addButton("my_mce_button",{text:"Ramka",icon:!1,onclick:function(){selected=tinyMCE.activeEditor.selection.getContent(),selected?
//If text is selected when button is clicked
//Wrap shortcode around it.
content="[wazna_ramka]"+selected+"[/wazna_ramka]":content="[wazna_ramka][/wazna_ramka]",t.insertContent(content)}})});