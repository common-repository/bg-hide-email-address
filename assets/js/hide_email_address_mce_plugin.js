(function() {

	tinymce.PluginManager.add( 'bghea_tc_button', function( editor, url ) {
		editor.addButton( 'bghea_tc_button', {
			title: 'Hide From Bots',
			icon: 'icon dashicons-shield',
			onclick: function() {
				editor.insertContent( '[bg-hide-email-address]' + 
					editor.selection.getContent() + '[/bg-hide-email-address]' );
			}
		});
	});

})();
