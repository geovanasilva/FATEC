/*
    All global JS file must be here.
*/

jQuery(document).ready(function( $ ){

    // Variáveis para mexer a página
    var vel = 300;
    $( 'nav a' ).click(function(  ){
        var namePosition = $(this).attr('data-id');
        var position = $( namePosition).offset().top;
        
        console.log( position );
        
        $('html, body').animate({
          scrollTop : position
        }, vel);
    });
    
});