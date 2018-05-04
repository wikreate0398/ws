jQuery(document).ready(function($) {
    $('#teacher_carousel').owlCarousel({
        loop:false,
        margin:60,
        nav:false,
        dots:true,
        navText: ['<i class="fa fa-angle-double-left" aria-hidden="true"></i>', '<i class="fa fa-angle-double-right" aria-hidden="true"></i>'],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });
    $('#partner_universities').owlCarousel({
        loop:false,
        margin:60,
        nav:false,
        dots:true,
        navText: ['<i class="fa fa-angle-double-left" aria-hidden="true"></i>', '<i class="fa fa-angle-double-right" aria-hidden="true"></i>'],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    });


    $( ".datepicker" ).datepicker({
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true,
        yearRange: '1945:'+(new Date).getFullYear()
    });

    $('.delete__item').click(function(e){
        if (!confirm('Вы действительно хотите удалить?')) {
            e.preventDefault();
        } 
    }); 

    $('.number_field').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
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

    $('form.ajax__submit').on('submit', function(e){
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
});

function institutionCheck(input){
    if ($(input).prop('checked') == true) {
        $('.parent_institution').show();
    }else{
        $('.parent_institution').hide();
    }
}

function addBlock(blockClass) {
    var first_block = $('.' + blockClass + '.first_block');
    var cloneBlock = $(first_block).clone();
    $(cloneBlock).removeClass('first_block');
    $(cloneBlock).removeClass('error__input');
     
    $(cloneBlock).append('<div class="close__item" onclick="deleteBlock(this);">X</div>');
    $(cloneBlock).find('input').val('');
    $(cloneBlock).find('textarea').val(''); 
    $(cloneBlock).find('select option').prop('selected', false);
    $(cloneBlock).find('select option:first').prop('selected', true);
    $(cloneBlock).find('input.id__block').remove();

    $(cloneBlock).find('select').each(function(){
        $(this).attr('name', $(this).attr('name').replace('edit_', ''))
    });

    $(cloneBlock).find('input').each(function(){
        $(this).attr('name', $(this).attr('name').replace('edit_', ''))
    });

    $(cloneBlock).find('textarea').each(function(){
        $(this).attr('name', $(this).attr('name').replace('edit_', ''))
    }); 
  
    $(cloneBlock).insertAfter('.' + blockClass + ':last');
}

function deleteBlock(item, id, action){
    $(item).closest('.row').remove();

    // if (id != '') {
    //     $.ajax({
    //         url: '/user/deleteUserBlockHistory',
    //         type: 'POST', 
    //         data: {'id':id}, 
    //         dataType: 'json',
    //         beforeSend: function() {},
    //         error: function(XMLHttpRequest, textStatus, errorThrown) {
    //             if (XMLHttpRequest.status === 401) document.location.reload(true);
    //         },
    //         success: function(jsonResponse, textStatus, request) {   
    //             $(form).find('.error__input').removeClass('error__input');
    //             if (jsonResponse.msg === false) {
                    
    //             } else {   
                     
    //             } 
    //         },
    //         complete: function() { }
    //     });
    // }
}


jQuery(document).ready(function($) {

    var classBlocks = ['.work_experience_container', '.teach_activity_container'];

    $.each(classBlocks, function(k,v){
        var disabledCheckbox  = $(v).closest('.panel').find('input.disable_block'); 
        var disabled          = true;
        if ($(disabledCheckbox).prop('checked') == true) {
            disabled = false;
        } 

        $(v).find('input,select,textarea').not(disabledCheckbox).attr('disabled', disabled); 
        $(v).closest('.panel').find('button.add__more').attr('disabled', disabled); 
    }); 

}); 
function disableBlock(checkbox){ 
    if ($(checkbox).prop('checked') == true) {
        $(checkbox).closest('.panel').find('input,select,textarea').not(checkbox).attr('disabled', false); 
        $(checkbox).closest('.panel').find('button.add__more').attr('disabled', false); 
    }else{
        $(checkbox).closest('.panel').find('input,select,textarea').not(checkbox).attr('disabled', true); 
        $(checkbox).closest('.panel').find('button.add__more').attr('disabled', true); 
    } 
}
 
function setEqualHeight2(columns, parent) {   
    if (!$(columns).length ) { 
        return false;
    }   
    if (parent) {
        var width       = $(parent).width();
        var item_width  = $(columns).closest('.js_list__item').outerWidth();
        var itemInRow = parseInt(width/item_width, 10); 
    }else{
        var itemInRow = 3; 
    }

    cloudHeight    = 0; 
    var totalItems = $(columns).length 
    if (totalItems < itemInRow) itemInRow = totalItems;

    $(columns).each(function(index){
        index=index+1;
        currentHeight = $(this).outerHeight(); 
        if(currentHeight > cloudHeight) {
            cloudHeight = currentHeight;
        } 
        rest = 0;
        if (totalItems%itemInRow!=0) rest = totalItems%itemInRow;    
        if (index%itemInRow==0) {    
            for (var i = index - 1; i >= index-itemInRow; i--) {
                $(columns).eq(i).height(cloudHeight);
            }  
            if ((totalItems-index-1) == rest) {   
                for (var i = totalItems; i >=  totalItems-rest; i--) { 
                    $(columns).eq(i).height(cloudHeight);
                } 
            }
            cloudHeight=0;
        } 
    });
    return; 
}

function setEqualHeight(columns) {
    var tallestcolumn = 0;
    columns.each(
        function() {
            currentHeight = $(this).height();
            if (currentHeight > tallestcolumn) {
                tallestcolumn = currentHeight;
            }
        }
    );
    columns.height(tallestcolumn );
}

$(window).on('load', function() { 
    setEqualHeight($('#partner_universities .item h3'));   
}); 

function addLecture(){
    var first_block = $('.course__sections .course__section.first_block').find('.lecture__sections .lecture__section.first_block');
    var cloneBlock = $(first_block).clone();
    $(cloneBlock).removeClass('first_block');
    $(cloneBlock).removeClass('error__input');
     
    $(cloneBlock).append('<div class="close__item" onclick="deleteLectureBlock(this);">X</div>');
    $(cloneBlock).find('input').val('');
    $(cloneBlock).find('textarea').val(''); 
    $(cloneBlock).find('select option').prop('selected', false);
    $(cloneBlock).find('select option:first').prop('selected', true);
    $(cloneBlock).find('input.id__block').remove();

    var sectionId = $('.course__sections .course__section').length;
    if (sectionId >= 1) {
        sectionId--;
    }

    $(cloneBlock).find('select').each(function(){
        $(this).attr('name', $(this).attr('name').replace('edit_', '')); 
    });

    $(cloneBlock).find('input').each(function(){
        $(this).attr('name', $(this).attr('name').replace('edit_', '')); 
    });

    $(cloneBlock).find('textarea').each(function(){
        $(this).attr('name', $(this).attr('name').replace('edit_', '')); 
    });  
  
    $(cloneBlock).insertAfter('.lecture__sections .lecture__section:last'); 

    attrLectureInputName();
}

function attrLectureInputName(){
    
    $('.course__sections .course__section').each(function(sectionId){
 
        $(this).find('select').each(function(){ 
            $(this).attr('name', $(this).attr('name').replace('[0]', '['+sectionId+']'));
        });

        $(this).find('input').each(function(){ 
            $(this).attr('name', $(this).attr('name').replace('[0]', '['+sectionId+']'));
        });

        $(this).find('textarea').each(function(){ 
            $(this).attr('name', $(this).attr('name').replace('[0]', '['+sectionId+']'));
        }); 
    });
}

function addCourseSection()
{ 
    var first_block = $('.course__sections .course__section.first_block');
    var cloneBlock = $(first_block).clone();
    $(cloneBlock).removeClass('first_block');
    //$(cloneBlock).find('.lecture__sections').find('.first_block').removeClass('first_block');
    $(cloneBlock).removeClass('error__input');
     
    $(cloneBlock).append('<div class="close__item" onclick="deleteSectionBlock(this);">X</div>');
    $(cloneBlock).find('input').val('');
    $(cloneBlock).find('textarea').val(''); 
    $(cloneBlock).find('select option').prop('selected', false);
    $(cloneBlock).find('select option:first').prop('selected', true);
    $(cloneBlock).find('input.id__block').remove();

    $(cloneBlock).find('select').each(function(){
        $(this).attr('name', $(this).attr('name').replace('edit_', ''))
    });

    $(cloneBlock).find('input').each(function(){
        $(this).attr('name', $(this).attr('name').replace('edit_', ''))
    });

    $(cloneBlock).find('textarea').each(function(){
        $(this).attr('name', $(this).attr('name').replace('edit_', ''))
    }); 

    $(cloneBlock).find('.lecture__section').not('.first_block').remove();
  
    $(cloneBlock).insertAfter('.course__sections .course__section:last'); 

    attrLectureInputName();
}

function deleteSectionBlock(item, id){
    if (!confirm('Вы действительно хотите удалить?')) {
        return false;
    } 

    if (id > 0) {
        $.ajax({
            url: '/user/profile/deleteCourseSection',
            type: 'POST', 
            data: {id_section: id, _token: CSRF_TOKEN}, 
            cache: false, 
            dataType: 'json',
            beforeSend: function() {},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.status === 401) document.location.reload(true);
            },
            success: function(jsonResponse, textStatus, request) {    
                if (jsonResponse.msg === true) {
                    $(item).closest('.course__section').remove();
                } else {   
                    alert('Ошибка');
                } 
            },
            complete: function() {}
        });
    }else{
        $(item).closest('.course__section').remove();
    } 
}

function deleteLectureBlock(item, id){

    if (!confirm('Вы действительно хотите удалить?')) {
        return false;
    } 

    if (id > 0) {
        $.ajax({
            url: '/user/profile/deleteCourseSectionLecture',
            type: 'POST', 
            data: {id_lecture: id, _token: CSRF_TOKEN}, 
            cache: false, 
            dataType: 'json',
            beforeSend: function() {},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.status === 401) document.location.reload(true);
            },
            success: function(jsonResponse, textStatus, request) {    
                if (jsonResponse.msg === true) {
                    $(item).closest('.lecture__section').remove();
                } else {   
                    alert('Ошибка');
                } 
            },
            complete: function() {}
        });
    }else{
        $(item).closest('.lecture__section').remove();
    }  
}    

function loadCourseSubcats(select, subcat){  
 
    var cacheStr = String((new Date()).getTime()).replace(/\D/gi, '');
    $( "#load__subcats").load( "/user/profile/loadCourseSubcats?rnd=" + cacheStr,{'id': $(select).val(), 'id_subcat': subcat, '_token': CSRF_TOKEN}, function( response, status, xhr ) { 
        if ( response == "" ) {
            $('#load__subcats').hide();
            $('#load__subcats').html('');
        }else{
            $('#load__subcats').show();
        }
    });
}

function setPayCourse(input){
    var val = $(input).val();
    if (val == 1) {
        $('.price__course').attr('disabled', true);
    }else{
        $('.price__course').attr('disabled', false);
    } 
}