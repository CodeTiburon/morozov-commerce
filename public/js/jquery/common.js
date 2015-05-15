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
            miniCartRefresh($('.minicart'));
            CartRefresh('#cart');
        });
    });

    // remove product
    $(document).on('click', '#remove-product', function(){
        cartProductRemove($(this).data('id'), function(){
            miniCartRefresh($('.minicart'));
            CartRefresh('#cart');
        });
    });

    // clear all
    $(document).on('click', '#clear-cart', function(e){
        e.preventDefault();
        clearCart(function(){
            miniCartRefresh($('.minicart'));
            CartRefresh('#cart');
        });
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
           miniCartRefresh($('.minicart'));
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

function miniCartRefresh($node){
    var count = 0;
    getTotaItems(function(data){
        $node.find('.minicart-count span').text(data.total_items);
        count = data.total_items;
    });
    getTotalSum(function(data){
        $node.find('.minicart-price span').text(data.total_sum);
    });
    if(count === 0){
        $.ajax({
            dataType:  'html',
            url:  '/checkout/cart/show',
            //headers: { 'X-XSRF-TOKEN' : $_token },
            type: "GET",
            success: function(data){
                $('.minicart').html($(data).find('.minicart').children());
            }
        });
    }
}

function CartRefresh(cart){
    //location.reload();
    getTotalSum(function(data){
        $('div.cart-total').find('.price').text(data.total_sum + ' $');
    });
    getTotaItems(function(data){
        count = data.total_items;
        if (count === 0){
            $('div.cart-total').hide(300);
            $('#clear-cart').hide(300);
        } else {
            $('div.cart-total').show(300);
            $('#clear-cart').show(300);
        }
    });

    $.ajax({
        dataType:  'html',
        url:  '/checkout/cart/show',
        //headers: { 'X-XSRF-TOKEN' : $_token },
        type: "GET",
        success: function(data){
            $(cart).html($(data).find(cart).children());
            if (count === 0){
                $(cart).parent().html('<span>There are no products</span>');
            }
        }
    });

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

function clearCart(successCallback){
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
        success: successCallback
    });
}

