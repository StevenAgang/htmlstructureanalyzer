$(document).ready(function(){
    $(document).on('submit','form',function(){
       $('.empty').remove();
        if($.trim($('input[type=text]').val()) === ''){
            $('input[type=text]').after('<p class="empty"> This field is required </p>');
            $('.empty').css('color','red');
            $('.empty').css('font-weight','400');
            return false;
        }else{
            if(!$('input[type=text]').val().includes('http')){
                $('input[type=text]').after('<p class="empty"> Please input valid url</p>');
                $('.empty').css('color','red');
                $('.empty').css('font-weight','400');
                return false;
            }else{
                $('#modal').css('display','flex');
                $.get($(this).attr('action'),$(this).serialize(),function(res){
                    if(res.status === true){
                        $('#tags').html(res.tags);
                        $('#response pre').text('');
                        $('#response pre').append(res.string);
                    }else{
                        $('#response pre').text('');
                        $('#response pre').append(res.error);
                    }
                    $('#modal').css('display','none');
                });
                return false;
            }
        }
    });
    $('form input[type=checkbox]').on('change',function(){
        if($(this).prop('checked')){
            $('form').after('<p class="caution"> Note: This tool does not verify SSL certificates. Use caution when inputting URLs.</p>');
            $('.caution').css('color','red');
            $('.caution').css('font-size','1rem');
            $('.caution').css('font-weight','400');
        }else{
            $('.caution').remove();
        }   
    }); 
    $('button').on('click',function(){
        if($('.pop').length){
            element_remove();
            return;
        }
        var parent = $('body');
        parent.append('<section class="pop"></section>');
        var child = $('.pop');
        child.append('<p></p>');
        var clip = $('section pre');
        if($.trim(clip.text()) != ''){
            $('.pop p').text('Text Copied');
            $('.pop').css('display','initial');
            navigator.clipboard.writeText(clip.text());
            setTimeout(animation_perma,2000);
            setTimeout(sidepop,4000);
            setTimeout(element_remove,6000);
        }else{
            $('.pop p').text('Cant copy empty snippet');
            $('.pop p').css('color','red');
            setTimeout(animation_perma,2000);
            setTimeout(sidepop,4000);
            setTimeout(element_remove,5000);
        }
    });
    $(window).on('click',function(e){
        if(e.target === $('#modal')[0]){
            $('#modal').css('display','none');
        }
    });
});
function sidepop(){
        $('.pop').css('animation-name',"popup");
        $('.pop').css('animation-duration','800ms');
        $('.pop').css('animation-timing-function','ease-in-out');
        $('.pop').css('animation-iteration-count','1');
        $('.pop').css('animation-fill-mode','forwards');
}
function element_remove(){
    $('.pop').remove();
}
function animation_perma(forward){
    $('.pop').css('width','15rem');
    $('.pop').css('display','initial');
    $('.pop').css('padding','1rem');
}