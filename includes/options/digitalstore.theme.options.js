/* Theme Options JS */
var farbtastic;
(function($){
    var pickColor = function(a) {
        farbtastic.setColor(a);
        $('#accent-color').val(a);
        $('#accent-color-example').css('background-color', a);
    };

    $(document).ready( function() {
        $('#default-color').wrapInner('<a href="#" />');

        farbtastic = $.farbtastic('#colorPickerDiv', pickColor);

        pickColor( $('#accent-color').val() );

        $('.pickcolor').click( function(e) {
            $('#colorPickerDiv').show();
            e.preventDefault();
        });

        $('#accent-color').keyup( function() {
            var a = $('#accent-color').val(),
                b = a;

            a = a.replace(/[^a-fA-F0-9]/, '');
            if ( '#' + a !== b )
                $('#accent-color').val(a);
            if ( a.length === 3 || a.length === 6 )
                pickColor( '#' + a );
        });

        $(document).mousedown( function() {
            $('#colorPickerDiv').hide();
        });

        $('#default-color a').click( function(e) {
            pickColor( '#' + this.innerHTML.replace(/[^a-fA-F0-9]/, '') );
            e.preventDefault();
        });

        $('#theme-skin').change( function() {
            var currentDefault = $('#default-color a'),
                newDefault = $('option:selected', this).data('default-color');
                        
            if ( $('#accent-color').val() == currentDefault.text() )
                pickColor( newDefault );

            currentDefault.text( newDefault );
        });
 
    });
})(jQuery);