$(document).ready(function(){
	$('form.ajax__submit').submit(function(e){
        e.preventDefault();
 
        var form   = $(this);
        var button = $(form).find('button[type="submit"]');
        var action = $(form).attr('action');
        $(button).attr('disabled', true);

        var button_width = $(button).width();

        var button_height = $(button).height(); 
        var button_txt    = $(button).text();
        var loader        = '<div class="loader-inner ball-pulse">' +
            '<div></div>' +
            '<div></div>' +
            '<div></div>' +
            '</div>';
        $(button).html(loader);
        $(button).width(button_width);
        $(button).height(button_height);

        setTimeout(function(){
            serializeForm(form, button, action, button_txt);
        }, 500);
    });

    $('#nestable').nestable({
        collapsedClass: 'dd-collapsed',
        maxDepth:1,
        axis: 'y'//x,y,all
    }).nestable('expandAll').on('change', function() {
        Ajax.nestable($(this));
    }); 
});

function serializeForm(form, button, action, button_txt){
	
    $.ajax({
        url: action,
        type: 'POST',
        async: true,
        data: new FormData(form[0]),
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        beforeSend: function() {},
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (XMLHttpRequest.status === 401) document.location.reload(true);
        },
        success: function(jsonResponse, textStatus, request) {   
            $(form).find('.error__input').removeClass('error__input');
            if (jsonResponse.msg === false) {
                var message = ''; 
                if (typeof jsonResponse.messages == 'object') { 
                    $.each(jsonResponse.messages, function(key, value){ 
                        $(form).find('[name="'+key+'"]').filter(function() {
                            return !this.value;
                        }).addClass("error__input") 

                        $.each(value, function(k,v){
                            message += '<p>'+v+'</p>';
                        }); 
                    }); 
                }else{
                    message += '<p>' + jsonResponse.messages + '</p>'; 
                }

                $(form).find('#error-respond').fadeIn().html(message);
                // setTimeout(function() {
                //     $(form).find('#form-respond').fadeOut(700);
                // }, 1000);

            } else {    
                if (jsonResponse.redirect != '') { 
                    window.location = jsonResponse.redirect;
                }

                if (jsonResponse.reload == true) { 
                    window.location.reload(true);
                } 
                 
                // $(form).find('#error-respond').hide();

                // setTimeout(function() {
                //     showSuccessMsg();
                //     $('.success').find('h2').html(res.msg);
                // }, 300);

                // setTimeout(function() {
                //     $('.success').fadeOut(300);
                // }, 4000); 
                // $(form)[0].reset(); 
            } 
        },
        complete: function() {
            $(button).attr('disabled', false);
            $(button).css({
                'padding-left': '0',
                'padding-right': '0'
            });
            $(button).text(button_txt);
        }
    });
}

var Ajax = {
    toDelete: function(){
        alert('s');
    },

    nestable: function(item){

        var arr = $(item).nestable('serialize');
        var table = $(item).attr('data-table'); 
        var action = $(item).attr('data-action')

        jQuery.ajax({
            type: 'POST',
            url: action,
            dataType: 'json',
            data: {
                arr: arr,
                table: table
            },
            beforeSend: function() {},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.status === 401) document.location.reload(true);
            },
            success: function(res) {
                if (res.msg === 'error') {
                    //alert(res.cause); 
                    $('#fade-respond').removeClass().addClass('alert-danger');
                    $('#fade-respond').fadeIn(500).html(res.cause).setTimeout(1000).hide();
                } else {
                    //alert(res.msg);       
                    $('#fade-respond').fadeIn(500).html(res.msg);
                    $('#fade-respond').removeClass().addClass('success-respond');
                    setTimeout(function() {
                        $('#fade-respond').fadeOut(700);
                    }, 1000);
                }
            },
            complete: function() {

            }
        }); 
    }
}