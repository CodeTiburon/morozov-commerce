/**
 * Created by guest on 21.04.15.
 */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// waiting page load
$(document).ready(function() {


    // form send handler
    $('#menu').find('span').on('click', function(){
        var id = $(this).data('id');
        if (id){
            getProduct($(this).data('id'));
        }
    });


});



    function getProduct(id){
        //var action = $form.attr('action');
       // var $_token = $form.find('#token').val();
        //var images = $form.find('.a-images').val();
        //var formData = $form.serialize();

        $.ajax({
            dataType:  'json',
            url:  '/home',
            data:  'id=' + id,
            //headers: { 'X-XSRF-TOKEN' : $_token },
            type: "POST",
            beforeSend: function(){
                $.gritter.add({
                    title: 'Loading...',
                    text: 'Please wait.'
                });
            },
            success: function(json){
                // using the "interpolate" delimiter to create a compiled template
                var compiled = _.template($('#product-template').html());
                $('.products').empty();
                if(json.products.length > 0){
                    $.each( json.products, function(index, product){
                        $('.products').append(compiled({
                            'id': product['id'],
                            'name': product['name'],
                            'model': product['model'],
                            'image': product['image'],
                            'price': product['price'],
                            'description': product['short_descr']
                        }));
                    });
                } else {
                    $('.products').append('<p class="empty"> There are no products in this category. </p>');
                }
            }
        });
    }



    function redirect($url, title, message){
        title = title || 'Success';
        message = message || 'All data have been changed successfully';
        $.gritter.add({
            title: title,
            text: message
        });
        setTimeout(function(){
            window.location = $url;
        }, 1000);
    }

    function formReset($form){
        $form.trigger('reset');
        $form.find('select').prop('selectedIndex',0);
    }

    function addErrorMessages(data, $node, messageHtml){
        var msgHtml = messageHtml || '<strong>Whoops!</strong> There were some problems with your input.';
        var errorMessages = [];
        for(var msg in data.errors){
            errorMessages.push('<li>' + data.errors[msg] + '</li>');
        }
        errorMessages = errorMessages.join('');
        var $AlertDanger = $('.alert.alert-danger');
        if($AlertDanger.length > 0){
            $AlertDanger.remove();
        }
        $node.append('<div class="alert alert-danger">' + msgHtml + '<br><br><ul>' + errorMessages + '</ul></div>');
    }





