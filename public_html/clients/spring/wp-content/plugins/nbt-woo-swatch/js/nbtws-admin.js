jQuery(document).ready(function($) {
$(function() {
$('#nbtws_woocommerce_global_activation').live('change',function(){
    if ($(this).prop('checked')) {
             $(this).closest("tr").next().show(200);
        }
        else {
             $(this).closest("tr").next().hide(200);
        }
});
});
});