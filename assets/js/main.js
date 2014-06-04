$('#field-password').bind('focus mouseenter',function(){
    $(this).attr('type','text');
}).bind('blur mouseleave',function(){
    $(this).attr('type','password');
});