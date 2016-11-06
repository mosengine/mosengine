//
////console.log('111');
$( "body" ).delegate( ".tsb_fav", "click", function() {

    var data_send ={'id_product':0,_csrf:''};
    data_send.id_product = $(this).attr('data-id');
    data_send._csrf = $('#formCart input[name=_csrf]').val();
    var element = $(this);
    if(!$(this).hasClass('disable')) {
        $.ajax({
                type: 'POST',
                url: '/product/like',
                data: data_send,
                success: function (result) {
                    element.html(result);
                }

            }
        );
    }
});


$('.rating').on('rating.change', function(event, value, caption) {

    var data_send = {id_product:'',value:'','_csrf':''};
    data_send.id_product = $('.rating').attr('data_id');
    data_send.value = value;
    data_send._csrf = $('#formCart input[name=_csrf]').val();

    $.ajax({
            type: 'POST',
            url: '/product/star',
            data: data_send,
            success: function (result) {
            }

        }
    );
});

/** Обработчик лайков*/
$('.active-for-like-good').on('click', function(){
    var data_send = {action:'', id_product:'', id_review:''};
    data_send.action = $(this).data('value');
    data_send.id_product = $(this).data('id_product');
    data_send.id_review = $(this).data('id_review');

    var good_block_obj = $(this);

    $.ajax({
            type: 'POST',
            url: '/ajax/reviews-like-dislike',
            data: data_send,
            success: function (result) {
                var counter = good_block_obj.find(".counter");
                var message = $(".message-like-dislike-"+result.id_review);
                if(result.status == "ok"){
                    counter.empty();
                    counter.text(result.count_like);
                    message.empty();
                    message.text(result.message);
                } else if(result.status == "error"){
                    message.empty();
                    message.text(result.message);
                }
            }
        }
    );

    //console.log(data_send);
});

/** Обработчик дизлайков*/
$('.active-for-like-bad').on('click', function(){
    var data_send = {action:"", id_product:"", id_review:""};
    data_send.action = $(this).data('value');
    data_send.id_product = $(this).data('id_product');
    data_send.id_review = $(this).data('id_review');

    var bad_block_obj = $(this);

    $.ajax({
            type: 'POST',
            url: '/ajax/reviews-like-dislike',
            data: data_send,
            success: function (result) {
                var counter = bad_block_obj.find(".counter");
                var message = $(".message-like-dislike-"+result.id_review);
                if(result.status == "ok"){
                    counter.empty();
                    counter.text(result.count_dislike);
                    message.empty();
                    message.text(result.message);
                } else if(result.status == "error"){
                    message.empty();
                    message.text(result.message);
                }

            }
        }
    );
    //console.log(data_send);
});

/** Обработчик попапа, если пользователь не зарегистрирован.*/
$('.for-register-message').on('click', function(){
    $('.js-open-reg').show();

    var bg = $('<div/>',{
        'class': 'overlay-reg'
    }).appendTo('.wr-reg').fadeIn();

});

$('.close_pop, .overlay-popup').click(function(){
    $('.js-open-reg').hide();
    $('.overlay-reg').hide();
});