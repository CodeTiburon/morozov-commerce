/**
 * Created by guest on 21.04.15.
 */

// waiting page load
$(document).ready(function() {

    // button register handler
    $(document).on('click', '#register-form button[type=submit]', function(){
        $('#register-form').ajaxForm({
            dataType:  'json',
            success: processJson
        });
    });

    // button login handler
    $(document).on('click', '#login-form button[type=submit]', function(){
        $('#login-form').ajaxForm({
            dataType:  'json',
            success: processJson
        });
    });
});

function processJson(data) {
    console.log(data);
    if(data.success){
        window.location = data.redirect_url;
    } else {
        addErrorMessages(data);
    }
}

function addErrorMessages(data){
    var errorMessages = [];
    for(var msg in data.errors){
        errorMessages.push('<li>' + data.errors[msg] + '</li>');
    }
    errorMessages = errorMessages.join('');
    var $AlertDanger = $('.alert.alert-danger');
    if($AlertDanger.length > 0){
        $AlertDanger.remove();
    }
    $('.panel-body').append('<div class="alert alert-danger"><strong>Whoops!</strong> There were some problems with your input.<br><br><ul>' + errorMessages + '</ul></div>');
}
