jQuery(function($) {
    
    $( "#sortable_fields" ).sortable({
        placeholder: "ui-state-highlight"
    });

    $('.form-settings-submit #submit').click(function() {
        $('.form-settings-submit .settings-loader').css('display', 'inline-block');
    })
})