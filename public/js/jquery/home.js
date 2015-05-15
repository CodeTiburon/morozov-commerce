    /**
     * Created by guest on 21.04.15.
     */

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // variables
    var categoryid = 0;

    // waiting page load
    $(document).ready(function () {


        // form send handler
        $('#menu').find('span').on('click', function () {
            if ($(this).data('id')) {
                var categoryid = $(this).data('id');
                window.categoryid = categoryid;
                getProductsWithPaginate(categoryid);
            }
        });

        // ajax pagination links
        $(document).on('click', '.pagination a', function (e) {
            getProductsWithPaginate(categoryid, $(this).attr('href').split('page=')[1]);
            e.preventDefault();
        });

        //$(window).on('hashchange', function () {
        //    if (window.location.hash) {
        //        var page = window.location.hash.replace('#', '');
        //        if (page == Number.NaN || page <= 0) {
        //            return false;
        //        } else {
        //           // getProductsWithPaginate(categoryid, page);
        //        }
        //    }
        //});


    });

    function getProductsWithPaginate(categoryid, pageNum) {
        var page = pageNum || 1;
        $.ajax({
            dataType: 'json',
            url: '/home' + '?page=' + page,
            data: 'id=' + categoryid,
            //headers: { 'X-XSRF-TOKEN' : $_token },
            type: "POST"
        }).done(function (json) {
            var compiled = _.template($('#product-template').html());
            $('.products').empty();
            if (json.products.length > 0) {
                $.each(json.products, function (index, product) {
                    $('.products').append(compiled({
                        'id': product['id'],
                        'name': product['name'],
                        'model': product['model'],
                        'image': product['image'],
                        'price': product['price'],
                        'description': product['short_descr']
                    }));
                });
                var $pagination = $('#pagination');
                $pagination.empty();
                $pagination.append(json.plinks);
            } else {
                $('.products').append('<p class="empty"> There are no products in this category. </p>');
            }
            // location.hash = page;
        }).fail(function () {
            alert('Products could not be loaded.');
        });
    }

    function redirect($url, title, message) {
        title = title || 'Success';
        message = message || 'All data have been changed successfully';
        $.gritter.add({
            title: title,
            text: message
        });
        setTimeout(function () {
            window.location = $url;
        }, 1000);
    }

    function formReset($form) {
        $form.trigger('reset');
        $form.find('select').prop('selectedIndex', 0);
    }

    function addErrorMessages(data, $node, messageHtml) {
        var msgHtml = messageHtml || '<strong>Whoops!</strong> There were some problems with your input.';
        var errorMessages = [];
        for (var msg in data.errors) {
            errorMessages.push('<li>' + data.errors[msg] + '</li>');
        }
        errorMessages = errorMessages.join('');
        var $AlertDanger = $('.alert.alert-danger');
        if ($AlertDanger.length > 0) {
            $AlertDanger.remove();
        }
        $node.append('<div class="alert alert-danger">' + msgHtml + '<br><br><ul>' + errorMessages + '</ul></div>');
    }





