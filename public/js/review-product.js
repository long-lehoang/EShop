var ratedIndex = -1;
var parent = 0;
var img = '';
var img_active =$('.img_active').attr('src');

$(document).ready(function(){
    resetStarColors();
    listComment();
    $('.fa-star-o').on('click',function(){
        ratedIndex = parseInt($(this).data('index'));
    })

    $('.fa-star-o').mouseover(function(){
        resetStarColors();

        var currentIndex = parseInt($(this).data('index'));

        for(var i = 0; i <= currentIndex; i++){
            $('.fa-star-o:eq('+i+')').css('color','yellow');
        }
    });
    $('.fa-star-o').mouseleave(function(){
        resetStarColors();

        if(ratedIndex!=-1)
            for(var i = 0; i <= ratedIndex; i++)
                $('.fa-star-o:eq('+i+')').css('color', 'yellow');
    });

    $('.img').on('click',function(){
        img = $(this).attr('src');
        $(this).attr('src',img_active);
        $('.img_active').attr('src',img);
        img_active =$('.img_active').attr('src');
    });

    $('#submit').on('click',function(){
        addComment();
    });
    
});

function listComment(){
    $.ajax({
        url: "?c=ajax&a=listcomment",
        type: "post",
        dataType: "text",
        data:{
            product_id: parseInt($('#product_id').val())
        },
        success: function(result){
            $('#list-comment').html(result);
        }
    });
}

function addComment(){
    if(!$('#user_name').length){
        alert('Vui lòng đăng nhập');
        return false;
    }
    if(ratedIndex==-1||$('#comment').val()=='')
    {
        alert('Bạn Chưa Đánh Giá Sản Phẩm');
        return false;
    }
    $.ajax({
        url: "?c=ajax&a=addcomment",
        type: "post",
        dataType: "text",
        data:{
            product_id: parseInt($('#product_id').val()),
            comment: $('#comment').val(),
            star: ratedIndex+1,
            parent:parent
        },
        success: function(){
            $('#comment').val('');
            ratedIndex = -1;
            listComment();
        }
    });
}

function resetStarColors(){
    $('.fa-star-o').css('color', 'black');
}