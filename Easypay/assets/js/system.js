jQuery(document).ready( function( $ ){
    
    $( '[data-toggle="tooltip"]' ).tooltip();
    
    // mask.js
    
    $(".bandeira-cartao").click(function(){
        if( $(this).attr("data-active") == "off" ){
            $("[data-active='on']").attr("data-active", "off");
            $("[data-active='off']").css({
                'border' : 'solid #EEE'
            });
            
            $(this).attr("data-active", "on");
            $(this).css({
                'border' : 'solid #4F827D'
            });
        }
    });
    
});