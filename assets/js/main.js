var scripts = document.getElementsByTagName( 'script' );
var scriptTag = $(scripts[ scripts.length - 1 ]);

var rng = new RNG(scriptTag.attr('rng-seed'));

Math.random = RNG.prototype.uniform.bind(rng);

function get_random(min, max) {
    return min + (rng.uniform() * (max - min)) ;
}

$('#field-password').bind('focus mouseenter',function(){
    $(this).attr('type','text');
}).bind('blur',function(){
    $(this).attr('type','password');
}).bind('mouseleave', function(){
    if ($(this).is(':focus') == false) {
        $(this).attr('type','password');
    }
});

$('#pw-generate-new').click(function(){
   dogenerate();
});
$('#new-password').on('click', function(){
    dogenerate();
});

$('#password-gen form').on('valid.fndtn.abide valid', function(){
    $('#field-password').val($('#pw-generated').val());
    $('#password-gen').foundation('reveal', 'close');
    var pw_label = $('.password-label');
    pw_label.removeClass('password-label').addClass('password-updated');
    setTimeout(function(){
        pw_label.addClass('password-label').removeClass('password-updated');
    }, 500);
});