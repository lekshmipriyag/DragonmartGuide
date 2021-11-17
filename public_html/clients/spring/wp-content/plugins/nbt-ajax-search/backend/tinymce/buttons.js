(function() {
    if (typeof(wpnetbase_asl_mce_button_menu)!="undefined") {
      tinymce.PluginManager.add('wpnetbase_asl_mce_button', function( editor, url ) {
          eval("var asl_menus = [" + wpnetbase_asl_mce_button_menu + "]");
          eval("var asl_res_menus = [" + wpnetbase_asl_res_mce_button_menu + "]");
          editor.addButton( 'wpnetbase_asl_mce_button', {
              text: 'ASP',
              icon: false,
              type: 'menubutton',
              menu: [
                  {
                      text: 'Search box',
                      menu: asl_menus
                  },
                  {
                      text: 'Result box',
                      menu: asl_res_menus
                  }
              ]
          });
      });
    }
})();