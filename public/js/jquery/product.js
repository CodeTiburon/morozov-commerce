/**
 * Created by guest on 21.04.15.
 */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// "myAwesomeDropzone" is the camelized version of the HTML element's ID
//Dropzone.options.myAwesomeDropzone = {
//    paramName: "images", // The name that will be used to transfer the file
//    maxFilesize: 2, // MB
//    accept: function(file, done) {
//        if (file.name == "justinbieber.jpg") {
//            done("Naha, you don't.");
//        }
//        else { done(); }
//    }
//};

$('.set-as-main').hide();

/*$('.gridly').gridly({
    base: 60, // px
    gutter: 20, // px
    columns: 12
});*/
$( ".gridly" ).sortable({
    items: "> div"
});

// waiting page load
$(document).ready(function() {
    'use strict';
   // alert($('meta[name="csrf-token"]').attr('content'));

    // form send handler
    $('.add-product form').find('input[type=submit]').on('click', function(){
        addProduct($('.add-product').find('form'));
    });

    // form send handler
    $('.edit-product form').find('input[type=submit]').on('click', function(){
        editProduct($('.edit-product').find('form'));
    });

    // form send handler
    $('#product-remove').on('click', function(){
        var $modal = $("#product-rmv-modal");
        var $this = $(this);
        $modal.modal('show');
        $modal.on('click', '.btn-primary' ,function(){
            removeProduct($this.data('product_id'));
            $modal.modal('hide');
        });
    });

    // show set as main button
    $(document).on('mouseenter', '.thumbnails .thumb img', function(){
        $(this).parent().prev().show(400);
    });

    // hide set as main button
    $(document).on('mouseleave', '.thumbnails .thumb', function(){
        $(this).find('img').parent().prev().stop().hide(400);
    });

    // set as main photo handler
    $(document).on('click', '.thumbnails .set-as-main', function(){
        var $this = $(this);
        var $primaryImg = $('.main-image');
        // interchange images
        var selectedImg = {
            'src' :  $this.next().find('img').attr('src'),
            'alt' :  $this.next().find('img').attr('alt'),
            'id' : $this.data('id')
        };
        var primaryImg = {
            'src' :  $primaryImg.find('img').attr('src'),
            'alt' :  $primaryImg.find('img').attr('alt'),
            'id' : $primaryImg.find('img').data('id')
        };

        $this.next().attr('href', primaryImg.src);
        $this.next().find('img').attr('src', primaryImg.src);
        $this.next().find('img').attr('alt', primaryImg.alt);
        $this.attr('data-id', primaryImg.id);

        $primaryImg.find('img').attr('src', selectedImg.src).hide().fadeIn(400);
        $primaryImg.find('img').attr('alt', selectedImg.alt);
        $primaryImg.find('img').data('id', selectedImg.id);

        initZoom();
        $primaryImg.find('a').attr('href', selectedImg.src);


        $('#primary-image-id').val(parseInt($(this).data('id')));
    });

    // change select view
    $('.categorySelect').selectivity({
        multiple: true,
        placeholder: 'Type to search a category'
    });

    // fancybox with thumbs

    initFancyBox();

    initZoom();

/*    image.bind("click", function(e) {
        var ez = image.data('elevateZoom');
        image.fancybox(ez.getGalleryList());
        return false;
    });*/


});



    function addProduct($form){
        //var action = $form.attr('action');
        var $_token = $form.find('#token').val();
        //var images = $form.find('.a-images').val();
        //var formData = $form.serialize();

        $form.ajaxForm({
            dataType:  'json',
            headers: { 'X-XSRF-TOKEN' : $_token },
            type: "POST",
            beforeSend: function(){
                $.gritter.add({
                    title: 'Loading...',
                    text: 'Please wait.'
                });
            },
            success: function(json){
                if(json.errors){
                    addErrorMessages(json, $('.add-product'));
                } else{
                    $.gritter.add({
                        title: 'Success',
                        text: 'Product has been added successfully'
                    });
                    formReset($form);
                }
            }
        });
    }

    function editProduct($form){
        var action = $form.attr('action');
        var p_id =  $form.find('#product-id');
        var $_token = $form.find('#token').val();
        //var images = $form.find('.a-images').val();
        //var formData = $form.serialize();
        var imagesOrder = [];
        $.each( $('.thumbnails').find('.thumb'), function(index, value){
            imagesOrder[index] = $(this).find('button').data('id');
        });

        $form.ajaxForm({
            dataType:  'json',
            //headers: { 'X-XSRF-TOKEN' : $_token },
            data: {
                'images_order[]' : imagesOrder
            },
            type: "POST",
            success: function(json){
                if(json.errors){
                    addErrorMessages(json, $('.edit-product'));
                } else{
                    redirect(json.redirect_url);
                }
            }
        });
    }

    function removeProduct(id){
        var $_token = $('#token').val();
        $.ajax({
            url: '/admin/products/remove',
            headers: { 'X-XSRF-TOKEN' : $_token },
            dataType: 'json',
            type: "POST",
            data: {
                'product_id' : id
            },
            success: function(json){
                if(json.errors){
                    alert('error');
                } else {
                    redirect(json.redirect_url);
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

    function initZoom(){
        if($('.zoomContainer').length){
            $('.zoomContainer').remove();
        }
        $('.main-image .fancybox-thumb').find('img').elevateZoom({
            scrollZoom : true
        });
    }

    function initFancyBox(){
        $(".fancybox-thumb").fancybox();
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





