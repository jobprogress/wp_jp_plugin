jQuery(function($) {
    
    $('.sortable-field-item').each(function() {
        var baseIndex = $(this).find('input.field-position-input').val();
        $(this).attr('field-index', baseIndex);
        $(this).css('order', baseIndex);
    })
    $( "#sortable_fields" ).sortable({
        start: function(event, ui) {
            $(this).css('display', 'unset');
        },
        stop: function(e, ui) {
            $(this).children('.sortable-field-item').each(function() {
                var index = $(this).index();
                // var index = $(this).attr('field-index');
                $(this).attr('field-index', index);
                $(this).find('input.field-position-input').val(index);
                $(this).css({
                    '-ms-flex-order' : index,
                    'order': index
                });
            })
            // $.map($(this).find('.sortable-field-item'), function(el) {
            //     $(el).find('input.field-position-input').val($(el).index());
            //     $(el).css({
            //         '-ms-flex-order' : $(el).index(),
            //         'order': $(el).index()
            //     });
            //     console.log($(el).attr('field-index') + ' = ' + $(el).index());
            // });
        },
        placeholder: "ui-state-highlight"
    });
})