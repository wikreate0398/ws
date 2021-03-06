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
 
    $('div.nestable').each(function(i){ 
        var newClass = 'nestable_' + i;
        $(this).addClass(newClass);
        var depth = $(this).attr('data-depth') ? $(this).attr('data-depth') : 1;

        $('.' + newClass).nestable({
            collapsedClass: 'dd-collapsed',
            maxDepth:parseInt(depth),
            axis: 'y',
            noDragClass: 'no-drag',     
            handleClass: 'dd-handle'
        }).nestable('expandAll').on('change', function() {
            Ajax.nestable($(this));
        }); 
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
                        var br='';
                        $.each(value, function(k,v){
                            message += '<p>'+v+'</p>';
                        }); 
                    }); 
                }else{
                    message += '<p>' + jsonResponse.messages + '</p>'; 
                }
                Ajax.notify('danger', message); 
                //$(form).find('#error-respond').fadeIn().html(message);
                // setTimeout(function() {
                //     $(form).find('#form-respond').fadeOut(700);
                // }, 1000);

            } else {   
                if ($(form).attr('data-redirect')) {
                    window.location = $(form).attr('data-redirect'); 
                } else{
                    if (jsonResponse.redirect !== undefined) {   
                        window.location = jsonResponse.redirect; 
                    }

                    if (jsonResponse.reload == true) { 
                        window.location.reload(true);
                    } 

                    if (jsonResponse.message !== undefined) {
                        Ajax.notify('success', jsonResponse.message);
                        $(form)[0].reset(); 
                    }  
                } 
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
    toDelete: function(element, table, id, conf){

        if (conf == true) {
            if (confirm('Вы действительно хотите удалить?') == false) {
                return false;
            }
        }

        jQuery.ajax({  
            url: '/admin/ajax/deleteElement',
            type: 'POST', 
            data: {
                id: id,
                table: table,
                _token: CSRF_TOKEN
            }, 
            headers: {'X-CSRF-TOKEN': CSRF_TOKEN}, 
            dataType: 'json',  
            beforeSend: function() {},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.status === 401) document.location.reload(true);
            },
            success: function(res) {

                if (res.msg === 'error') { 
                    Ajax.notify('error', res.cause); 
                } else { 
                    Ajax.notify('success', res.message);
                    $('.modal, .modal-backdrop').fadeOut(100);
                    if ( $(element).closest('.dd-item').length == true) {
                        $(element).closest('.dd-item').fadeOut(200);
                    } else if($(element).closest('.row.multi__container').length == true){
                        $(element).closest('.row').remove();
                    } else{
                        if ($(element).closest('tbody').find('tr').length <= 1) {
                            $(element).closest('table').fadeOut(200);
                            $(element).closest('table').prev('.cat__name').fadeOut(200); 
                        }else{
                            $(element).closest('tr').fadeOut(200, function(){
                                $(element).closest('tr').remove();
                            });
                        } 
                    } 
                }
            },
            complete: function() {}
        }); 
    },

    deleteImg: function(element, table, id, name){ 
        $.ajax({
            type: "POST",
            url: '/admin/ajax/deleteImg',
            data: {
                'id': id,
                'table': table,
                'name' : !name ? null : name,
                '_token': CSRF_TOKEN
            },
            dataType: 'json',
            success: function(res) {
                if (res.msg === 'error') {
                    Ajax.notify('error', res.cause); 
                } else { 
                    Ajax.notify('success', res.message);

                    var parent = $('.fileupload');  
                    $(element).closest(parent).find('.modal').fadeOut(100);
                    $('.modal-backdrop').fadeOut(100); 
                      
                    $(element).closest(parent).find('.modal').fadeOut(100);
                    if (name == 'swf') {
                        $(element).closest('.fileupload').find('#thumb-img').remove();
                        $('#swf-file').html('<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>');
                    }else{
                        $(element).closest(parent).find('#thumb-img').attr('src', 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image');
                    }
                 
                    $(element).closest(parent).find('.del_btn').hide();
                }
            }
        }); 
    },

    nestable: function(item){

        var arr = $(item).nestable('serialize');
        var table = $(item).attr('data-table'); 
        var action = $(item).attr('data-action')
        var depth = $(item).attr('data-depth') ? $(item).attr('data-depth') : 1;

        jQuery.ajax({  
            url: action,
            type: 'POST', 
            data: {
                'arr': arr,
                'depth': depth,
                'table': table,
                '_token': CSRF_TOKEN
            }, 
            headers: {'X-CSRF-TOKEN': CSRF_TOKEN}, 
            dataType: 'json',  
            beforeSend: function() {},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.status === 401) document.location.reload(true);
            },
            success: function(res) {
                if (res.msg === 'error') { 
                    Ajax.notify('error', res.cause); 
                } else { 
                    Ajax.notify('success', res.message); 
                }
            },
            complete: function() { 
            }
        }); 
    },

    buttonView: function(click, table, id, row) {  
        row       = !row ? 'view' : row; 
        var state = $(this).prop('checked');   
        $.ajax({
            type: "POST",
            url: '/admin/ajax/viewElement',
            data: {
                'id': id,
                'state': state,
                'table': table,
                'row' : row
            },
            headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
            dataType: 'json',
            beforeSend: function() {},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.status === 401) document.location.reload(true);
            },
            success: function(res) {
                if (res.msg === 'error') { 
                    Ajax.notify('error', res.cause); 
                } else { 
                    Ajax.notify('success', res.message); 
                }
            }
        }); 
    },

    notify: function(status, message){
        $('.modal, .modal-backdrop').fadeOut(100);
        $.notify({
         // options 
         // title: 'Bootstrap notify',
         message: message, 
         target: '_blank'
      },{
         // settings
         element: 'body', 
         type: status, 
         placement: {
            from: "top",
            align: "right"
         },
         offset: 20,
         spacing: 10,
         z_index: 1031,
         delay: 2000,
         timer: 1000 ,
         
      });
    },

    loadRegionCities: function(select, city){
        var val      = $(select).val(); 
        var cacheStr = String((new Date()).getTime()).replace(/\D/gi, '');
        $( ".cities__area").load("/admin/location/loadRegionCities?rnd=" + cacheStr,
                                 {'id': $(select).val(), 'id_city': city, '_token': CSRF_TOKEN}, 
                                 function( response, status, xhr ) { 
            if ( response == "" ) {
                $('.cities__area').hide();
                $('.regions__area').removeClass('col-md-6').addClass('col-md-12');
            }else{
                $('.cities__area').show(); 
                $('.regions__area').removeClass('col-md-12').addClass('col-md-6');
            }
            initSelect2();
        }); 
    }
}
 