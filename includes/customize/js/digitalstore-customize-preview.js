/* Customizer scripts by Matt Varone */
(function( wp, $ ){
    
    var api = wp.customize;
    
    api( 'digitalstore_theme_options[footer_text]', function( value ) {
        value.method = 'postMessage';
        value.bind( function( to ) {
            var iframe = $('#customize-preview>iframe');
            iframe.contents().find('#credits p').html(to);
        });
    });

})( wp, jQuery );