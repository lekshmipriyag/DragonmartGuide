(function() {

    tinymce.create('tinymce.plugins.ShortcodeMce', {
        init : function(ed, url){
            tinymce.plugins.ShortcodeMce.theurl = url;
        },
        createControl : function(btn, e) {
            if ( btn == "netbase_shortcodes_button" ) {
                var a = this;
                var btn = e.createSplitButton('button', {
                    title: "Netbase Shortcodes",
                    image: tinymce.plugins.ShortcodeMce.theurl +"/shortcodes.png",
                    icons: false
                });
                btn.onRenderMenu.add(function (c, b) {
                    a.render( b, "Featured Products", "netbase_featured_products" );
                    a.render( b, "Products", "netbase_products" );
                    a.render( b, "Product Category", "netbase_product_category" );
                    a.render( b, "Product Attribute", "netbase_product_attribute" );
                    a.render( b, "Product", "netbase_product" );
                    a.render( b, "Product Categories", "netbase_product_categories" );
                    a.render( b, "Widget Woocommerce Products", "netbase_widget_woo_products" );                   
                });

                return btn;
            }
            return null;
        },
        render : function(ed, title, id) {
            ed.add({
                title: title,
                onclick: function () {
                    netbase_shortcode_open(title, id);
                    return false;
                }
            })
        }

    });
    tinymce.PluginManager.add("shortcodes", tinymce.plugins.ShortcodeMce);

})();