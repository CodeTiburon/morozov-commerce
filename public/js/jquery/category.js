/**
 * Created by guest on 21.04.15.
 */

// waiting page load
$(document).ready(function() {
    var compactMenu = '<select>';
        compactMenu     += '<option value="flat">';
        compactMenu         += 'Add category to this level';
        compactMenu     += '</option>';
        compactMenu     += '<option value="child">';
        compactMenu         += 'Add category as a child';
        compactMenu     += '</option>';
        compactMenu += '</select>';
    var selectedType = 0;
    var categoryId = 0;

    createRemoveBtn($( "ul.edit-category"));

    // button register handler
    $(document).on('click', '.edit-category span', function(e){
        var $this = $(this);
        categoryId = $this.data('id');
        $('.create-choice').remove();
        $('.edit-category span').removeClass('active');
        $this.addClass('active');
        $this.after('<div class="create-choice">' + compactMenu + '</div>');
    });

    // submenu create choice handler
    $(document).on('click', '.create-choice option', function(){
        selectedType = $(this).val();
        visualChange();
    });

    // ESC handler
    $(document).on('keyup', function(e){
        if(e.which == 27){
            $('.create-choice').fadeOut(400);
        }
    });

    // Free area handler
    $(document).on('click', function(e){
        if(e.target.nodeName !== 'SPAN' && e.target.nodeName !== 'SELECT'){
            $('.create-choice').fadeOut(400);
        }
    });

    // Remove category handler
    $(document).on('click', '.remove-category', function(){
       var categoryId = $(this).prev().data('id');
        var $modal = $("#cat-rmv-modal");
        $modal.modal('show');
        $modal.on('click', '.btn-primary' ,function(){
            removeCategory(categoryId);
            $modal.modal('hide');
        });
    });

    // form send handler
    $('.add-category form').find('input[type=submit]').on('click', function(e){
        e.preventDefault();
        addCategory($('.add-category').find('form'), categoryId, selectedType);
    });

});

    function visualChange(){
        $('.add-category').show(400);
        $('.create-choice').fadeOut(400);
    }

    function createRemoveBtn($node, btnName){
        var btn_name = btnName || 'remove-category'
        $node.find('span').after('<div class="' + btn_name + ' glyphicon glyphicon-remove" title="Remove a category"></div>');
        $('.' + btn_name) .hide().fadeIn(1000);
    }

    function categoryListRefresh(node){
        $.ajax({
            url: document.location.href,
            success: function(html){
                $(node).html($(html).find(node).children().hide().fadeIn(300));
                createRemoveBtn($( "ul.edit-category"));
            }
        });
    }

    function addCategory($form, categoryId, selectedType){
        var action = $form.attr('action');
        var $_token = $form.find('#token').val();
        if(categoryId && selectedType){
            if(!$( "ul.edit-category").length){
                selectedType = 'root';
                categoryId = 0;
            }
            $.ajax({
                url: action,
                headers: { 'X-XSRF-TOKEN' : $_token },
                dataType: 'json',
                type: "POST",
                data: {
                    'category_id' : categoryId,
                    'name' : $form.find('#name').val(),
                    'selected_type' : selectedType
                },
                success: function(json){
                    if(json.errors){
                        addErrorMessages(json, $('.add-category'));
                    } else{
                        categoryListRefresh('ul.edit-category');
                    }
                }
            });
        } else {
            alert('error');
        }
    }

    function removeCategory(id){
        var $_token = $('#token').val();
        $.ajax({
            url: '/admin/categories/remove',
            headers: { 'X-XSRF-TOKEN' : $_token },
            dataType: 'json',
            type: "POST",
            data: {
                'category_id' : id
            },
            success: function(json){
                if(json.errors){
                   alert('error');
                } else {
                    categoryListRefresh('ul.edit-category');
                }
            }
        });
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




