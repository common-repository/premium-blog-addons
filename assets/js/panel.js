jQuery(document).ready(function ($) {
    var value = $("#pbwToolSharing").val();
    //alert(value);
    $("#pbwToolSharing").click(function () {
        $("#socilSubControls").toggle();
    });

});
function toggle_position_fields() {
    var position = jQuery("#pbwToolsSharingPosition").val();
    if (position == 1) {
        jQuery("#floatingPositionControls").show();
        jQuery("#contentPositionControls").hide();
    }
    if (position == 2) {
        jQuery("#floatingPositionControls").hide();
        jQuery("#contentPositionControls").show();
    }
}




