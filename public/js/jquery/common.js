/**
 * Created by guest on 13.05.15.
 */

$(document).ready(function(){

    // add to cart
    $(document).on('click', '.add-to-cart', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        addToCart(id);
    });

    // change quantity
    $(document).on('click', '#quantity-update', function(){
        qtyUpdate($('.quantity-number'), $('#quantity').val(), function(){
            cartRefresh($('.minicart'));
            location.reload();
        });
    });

    // remove product
    $(document).on('click', '#remove-product', function(){
        cartProductRemove($(this).data('id'), function(){
            cartRefresh($('.minicart'));
            location.reload();
        });
    });

    // clear all
    $(document).on('click', '#clear-cart', function(){
        clearCart();
        cartRefresh($('.minicart'));
    });

});

function addToCart(id){
    $.ajax({
        dataType:  'json',
        url:  '/checkout/cart/add',
        data:  'id=' + id,
        //headers: { 'X-XSRF-TOKEN' : $_token },
        type: "POST",
        beforeSend: function(){
        /*    $.gritter.add({
                title: 'Loading...',
                text: 'Please wait.'
            });*/
        },
        success: function(json){
           cartRefresh($('.minicart'));
        }
    });
}

function qtyUpdate($form, quantity, successCallback){
    qty = quantity || $form.find('#quantity').val();
    $form.ajaxForm({
        dataType:  'json',
        //headers: { 'X-XSRF-TOKEN' : $_token },
        type: "POST",
        success: successCallback
    });
}

function cartProductRemove(id, successCallback){
    $.ajax({
        dataType:  'json',
        url:  '/checkout/cart/clear-product',
        //headers: { 'X-XSRF-TOKEN' : $_token },
        type: "POST",
        data:  'product_id=' + id,
        beforeSend: function(){
            /*            $.gritter.add({
             title: 'Loading...',
             text: 'Please wait.'
             });*/
        },
        success: successCallback
    });
}

function cartRefresh($node){
    var count = 0;
    getTotaItems(function(data){
        $node.find('.minicart-count span').text(data.total_items);
        count = data.total_items;
    });
    getTotalSum(function(data){
        $node.find('.minicart-price span').text(data.total_sum);
    });
    if(count === 0){
        $('.minicart').load('home .minicart > *');
    }
}

function getTotaItems(successCallback){
    $.ajax({
        dataType:  'json',
        url:  '/checkout/cart/total-items',
        //headers: { 'X-XSRF-TOKEN' : $_token },
        type: "POST",
        beforeSend: function(){
    /*            $.gritter.add({
             title: 'Loading...',
             text: 'Please wait.'
             });*/
        },
        success: successCallback
    });
}

function getTotalSum(successCallback){
    $.ajax({
        dataType:  'json',
        url:  '/checkout/cart/total-sum',
        //headers: { 'X-XSRF-TOKEN' : $_token },
        type: "POST",
        beforeSend: function(){
            /*            $.gritter.add({
             title: 'Loading...',
             text: 'Please wait.'
             });*/
        },
        success: successCallback
    });
}

function clearCart(){
    $.ajax({
        url:  '/checkout/cart/clear',
        //headers: { 'X-XSRF-TOKEN' : $_token },
        type: "POST",
        beforeSend: function(){
            /*            $.gritter.add({
             title: 'Loading...',
             text: 'Please wait.'
             });*/
        },
        success: function(data){
            console.log('data', data);
        }
    });
}

