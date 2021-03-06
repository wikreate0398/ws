jQuery(document).ready(function($) {

    $(".fancybox").fancybox();

    // tinymce.init({
    //   selector: 'textarea',  // change this value according to your HTML
    //   auto_focus: 'element1'
    // });

    if ($('.lk_menu').length) {
        $('html,body').animate({
            scrollTop: $('.lk_menu').offset().top
        }, 50);
    }
    
    $('.rating-stars').each(function(){
        var currentRating = $(this).data('current-rating');

        $(this).barrating({
            theme: 'fontawesome-stars-o',
            showSelectedRating: false,
            initialRating: parseFloat(currentRating),
            allowEmpty:true, 
            deselectable:true,
            emptyValue: 0,
            onSelect:function(value, text, event){ 
            } 
        }); 
        var state = ($(this).attr('data-readonly') == 'true') ? true : false; 
        $(this).barrating('readonly', state);  
    }); 

    var numChange = 0;
    $("form.listener__change_form").change(function(e) { 
      if (!$(e.target).hasClass('onload__change')) {numChange++}
       
      if (numChange > 0) {
        $(this).data("changed","true");
      }
      numChange++; 
    });

    $('a').click(function(e){ 
        if ($('.course__form_hc').length > 0) { 
            e.preventDefault();  
            formHasChanged(this, '.course__form_hc'); 
        }

        if ($('.teacher__form_hc').length > 0) { 
            e.preventDefault();   
            formHasChanged(this, '.teacher__form_hc'); 
        }  

        if ($('.univ__form_hc').length > 0) { 
            e.preventDefault();   
            formHasChanged(this, '.univ__form_hc'); 
        }  
    }); 

    function formHasChanged(a, formClass){  
        if ($(formClass).data('changed') == undefined) { 
          window.location = a.href;
        }else{
          if (confirm('Сохранить изменения')) {
            $(formClass).find('input#redirectUri').val(a.href);
            $(formClass).find('button[type="submit"]').trigger('click'); 
          }else{
            window.location = a.href;
          }
        }  
    } 
     
    InputMask(); 

    $("textarea[maxlength]").each(function(){
        $(this).next('.maxlength__label').find('span').text(this.value.length);
    });

    $("textarea[maxlength]").on("propertychange input", function() {
        if (this.value.length > this.maxlength) {
            this.value = this.value.substring(0, this.maxlength);
        }  

        $(this).next('.maxlength__label').find('span').text(this.value.length);
    }); 
    
    initSelect2();
 
    $('#teacher_carousel').owlCarousel({
        loop:false,
        margin:60,
        nav:true,
        dots:false,
        navText: ['<img src="public/images/left-arrow.png">', '<img src="public/images/right-arrow.png">'],
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
    $('#partner_universities').owlCarousel({
        loop:true,
        margin:60,
        nav:true,
        dots:false,
        navText: ['<img src="public/images/left-arrow.png">', '<img src="public/images/right-arrow.png">'],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    });

    $('#page_teacher_universities').owlCarousel({
        loop:true,
        margin:00,
        nav:false,
        dots:true, 
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });

    $('#course_teachers_slider').owlCarousel({
        loop:false,
        margin:00,
        nav:false,
        dots:true, 
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    }); 

    $('#certificates__box').owlCarousel({
        loop:true,
        margin:00,
        nav:false,
        dots:true,
        items:1,
        // navText: ['<img src="/public/images/left-arrow.png">', '<img src="/public/images/right-arrow.png">'],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });

      
    $("input#teacher_status").switchButton({
        on_label: 'Свободен',
        off_label: 'Занят', 
        width: 50,
        height: 20,
        button_width: 25
    });
 
    $( ".datepicker" ).datepicker({
        format: "dd.mm.yyyy",
        changeMonth: true,
        language: 'ru',
        changeYear: true,
        autoHide: true  
    }); 

    $( ".datepicker_birthdate" ).datepicker({
        format: "dd.mm.yyyy",
        changeMonth: true,
        language: 'ru',
        changeYear: true,
        autoHide: true,
        startView:2
    });  

    $('.datepicker__input').attr("readonly", 'readonly'); 

    $(document).on('click', '.delete__item', function(e){
        if (!confirm('Вы действительно хотите удалить?')) {
            e.preventDefault();
        } 
    });

    $(document).on('click', '.confirm__item', function(e){
        var msg = $(this).attr('data-confirm');
        var msg = msg ? msg : 'Подтвердить операцию';
        if (!confirm(msg)) {
            e.preventDefault();
        } 
    }); 

    $(document).on('keypress', '.number_field', function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
    });

    $(document).on('input', '.number_field', function (e) {
     
        var max = parseInt($(this).attr('max'));
        var min = parseInt($(this).attr('min'));
        if ($(this).val() > max)
        {
            $(this).val(max); 
        }
        else if ($(this).val() < min)
        { 
            $(this).val(min);
        }   
    });

    $('.course_discount_price').keyup(function(event) {
        console.log($(this).val());
        if ($(this).val() == '') {
            $('.course_discount_percent').attr('disabled', false);
        }else{
            $('.course_discount_percent').attr('disabled', true);
        } 
    });  

    $('.course_discount_percent').keyup(function(event) {
        if ($(this).val() == '') {
            $('.course_discount_price').attr('disabled', false);
        }else{
            $('.course_discount_price').attr('disabled', true);
        } 
    }); 
 
    $('form#search_form').on('submit', function(e){
        var len = $('input#search__input').val().length;
        if (len < 3) {
            alert('Введите не менее 3 символов');
            e.preventDefault();
        }  
    });

    $('input#search__input').focus(function(){
        $(this).keyup();
    }); 

    $('#search_form').find('input#search__input').keyup(function(event){   
        if ($(this).val().length >= 3 && event.key != undefined) {  
            var url = $(this).closest('#search_form').attr('data-url-autocomplete'); 

            var dataSearch = {search: $(this).val()};

            if ($(this).closest('#search_form').is('form')==false) {
                if($(this).closest('form').length){
                    var dataSearch = $(this).closest('form').serialize(); 
                }
            }

            $.ajax({
                type: "GET",
                url: url,
                data:dataSearch,
                dataType: 'json',
                beforeSend: function(){},
                success: function(jsonData){
                    if (jsonData.content != '') {
                        $('.loaded__search_result').show();
                        $('.loaded__search_result').html(jsonData.content); 
                    }else{
                        $('.loaded__search_result').hide();
                        $('.loaded__search_result').html(''); 
                    } 
                }
            }); 
        }else{
            $('.loaded__search_result').hide();
            $('.loaded__search_result').html(''); 
        }
    }); 

    $(document).on('click', function(e) {  
        if($(e.target).closest('.input-search-area').length <= 0) {
            $('.loaded__search_result').hide();
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
                    var msgArr=[];
                    if (typeof jsonResponse.messages == 'object') { 
                        $.each(jsonResponse.messages, function(key, value){  

                            var inputError = $(form).find('[name="'+key+'"]');
                            $(inputError).addClass("error__input");
                            if ($(inputError).hasClass('select2-hidden-accessible')) {
                                $(inputError).next('.select2-container').find('.select2-selection').addClass("error__input");
                            }

                            // if (key == 'teacher_subjects') { 
                            //     $('select[name="teacher_directions_select"]').addClass('error__input');
                            //     $('select[name="teacher_subjects_select"]').next('.select2-container').find('.select2-selection').addClass("error__input");
                            // }
 
                            // .filter(function() {
                            //     return !this.value;
                            // })

                            $.each(value, function(k,v){
                                if (key != 'multifields') { 

                                    if ($.inArray(v, msgArr) == -1) { 
                                        message += '<p>'+v+'</p>';
                                    }
                                    msgArr.push(v);

                                    console.log(msgArr);
                                }else{
                                    var inputError = $(form).find('[name*="'+v+'"]'); 
                                    $(inputError).filter(function(){
                                        if ($(this).hasClass('required__input') == true && $(this).val() == '') 
                                        { 
                                            return 1;
                                        }  
                                    }).addClass("error__input");  
                                }
                            });
                        }); 
                    }else{
                        message += '<p>' + jsonResponse.messages + '</p>'; 
                    } 
                    $(form).find('#error-respond').fadeIn().html(message + '<span onclick="$(this).closest(\'#error-respond\').fadeOut()" class="close__error_respond"></span>');  

                    setTimeout(function(){
                        $(form).find('#error-respond').fadeOut();  
                    },10000);
                } else {    
                    if (jsonResponse.redirect !== undefined) {   
                        window.location = jsonResponse.redirect; 
                        return;
                    }

                    if (jsonResponse.reload == true) { 
                        window.location.reload(true);
                        return;
                    }  

                    $(form).find('#error-respond').fadeOut();  

                    if (jsonResponse.message) { 
                    showFadeModal('success', jsonResponse.message);
                    }

                     
                    $(form)[0].reset();

                    $('.modal').modal('hide'); 
                } 
            },
            complete: function() {
                $(button).attr('disabled', false); 
                $(button).css({
                    'padding-left': '0',
                    'padding-right': '0'
                });
                $(button).text(button_txt);
                $('.profile__image_form').removeClass('loading__save_image');
                $(form).removeClass('preloader__form');
                $(form).remove('.preloader__form_content');
                $('.has--preload input#redirectUri').val('');
                 
                InputMask();
            }
        });
    } 
    $(document).on('submit', 'form.ajax__submit', function(e){
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
        $(button).attr('disabled', true); 
        $(button).width(button_width);
        $(button).height(button_height);
        $('.profile__image_form').addClass('loading__save_image');

        $(form).addClass('preloader__form');
        var formLoaderContent = '<div class="preloader__form_content" style="display: none;">'+
                                    '<div class="loader-inner ball-pulse"> '+
                                            '<div></div>'+ 
                                            '<div></div>'+ 
                                            '<div></div>'+ 
                                        '</div>'+
                                '</div>';

        if ($(form).hasClass('has--preload')) {
            $('.preloader__form').append(formLoaderContent);
        }
         
        setTimeout(function(){
            serializeForm(form, button, action, button_txt);
        }, 500);
    });
});

function setAutocompleteValue(item){
    var value = $(item).attr('data-value');
    $('#search_form').find('input#search__input').val(value);
    $('.loaded__search_result').hide();
    $('.loaded__search_result').html(''); 
}

function showFadeModal(type, text){ //fade-success, fade-danger 
    setTimeout(function() { 
        $('.fade__modal').addClass('fade-' + type); 
        $('.fade__modal').fadeIn(200); 
        $('.fade__modal').find('h2').html(text);
    }, 300);

    setTimeout(function() {
        $('.fade__modal').fadeOut(300, function(){
            $('.fade__modal').removeClass('fade-' + type);
        }); 
    }, 4000); 
}

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

$(window).on('load', function(){ 
    eqBlocksInit();
});

function eqBlocksInit()
{
    setEqualHeight2($('.external_card h3'), $('.course__catalog'));
    setEqualHeight2($('.external_card h4'), $('.course__catalog'));
    setEqualHeight($('#teacher_carousel .item h3'));

    setEqualHeight2($('.external_univer h3'), $('.universities_catalog'));
    setEqualHeight2($('.external_univer'), $('.universities_catalog'));


    setEqualHeight($('.trainer__box'));
 

    setEqualHeight2($('.course_card .footer__course_card .set__going_date'), $('.course__catalog'));
    setEqualHeight2($('.course_card h2'), $('.course__catalog'));

    setEqualHeight2($('.university__item h3'), $('.universities_catalog'));

    setEqualHeight2($('.item__block .item__name'), $('.teacher__universities'));
    setEqualHeight2($('.item__block .item__footer'), $('.teacher__universities')); 

    setEqualHeight2($('.item__block .item__name'), $('.teachers__conections_container')); 
    setEqualHeight2($('.item__block .item__img'), $('.teachers__conections_container')); 

    setEqualHeight2($('.news__item a.news_name'), $('.news__catalog')); 
    setEqualHeight2($('.news__item p'), $('.news__catalog')); 
    setEqualHeight2($('.news__item'), $('.news__catalog')); 
    
    $('.tab-pane').each(function(){ 
        setEqualHeight2($(this).find('.external_card h3'), $(this));
        setEqualHeight2($(this).find('.external_card h4'), $(this)); 
    }); 
}
 
function setEqualHeight2(columns, parent) {   
    if (!$(columns).length ) { 
        return false;
    }   
    if (parent) {
        var width       = $(parent).width();
        var item_width  = $(columns).closest('.eq_list__item').outerWidth();
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
 
  
function loadRegionCities(select, city){
    var val      = $(select).val(); 
    var cacheStr = String((new Date()).getTime()).replace(/\D/gi, '');

    var citiesArea  = $(select).closest('.regions__area').next();
    var regionsArea = $(select).closest('.regions__area');

    $(citiesArea).load("/user/actions/loadRegionCities?rnd=" + cacheStr,
                             {'id': $(select).val(), 'id_city': city, '_token': CSRF_TOKEN}, 
                             function( response, status, xhr ) { 
        if ( response == "" ) {
            $(citiesArea).hide();
            $(regionsArea).removeClass('col-md-6').addClass('col-md-12');
        }else{
            $(citiesArea).show(); 
            $(regionsArea).removeClass('col-md-12').addClass('col-md-6');
        }
        initSelect2();
    }); 
}

function initSelect2(){ 

    // $('[data-container-class]').each(function() {
    //    var className = $(this).attr('data-container-class');
    //    var container = $('.select2-dropdown');
    //    container.addClass(className);
    //    container.find('.select2-dropdown').removeClass(className);
    // });

    $('.select2').each(function(){
        if ($(this).hasClass('select2-hidden-accessible')) {
            $(this).select2('destroy');
        }
        $(this).select2();
    });  
}

function getRoundedCanvas(sourceCanvas) {
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    var width = sourceCanvas.width;
    var height = sourceCanvas.height;

    canvas.width = width;
    canvas.height = height;

    context.imageSmoothingEnabled = true;
    context.drawImage(sourceCanvas, 0, 0, width, height);
    context.globalCompositeOperation = 'destination-in';
    context.beginPath();
    context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
    context.fill();

    return canvas;
}

function profilePhoto(fileName){

    var file = fileName.files[0];

    var reader = new FileReader(); 

    reader.readAsDataURL(file);

    var fileSize = parseInt(file["size"]) / 1000; 
    var fileExtension = ["image/gif", "image/jpeg", "image/png", "image/jpg"];
    var fileType = fileName["type"];

    if (fileSize > 2048) {
        alert('Максимальный размер изображения 2МБ');
        return;
    } 

    if (jQuery.inArray(fileType, fileExtension) == -1) {
        alert('Файл не неверного формата');
        return;
    }

    reader.onload = function (e) {

        $('.cropper__section, #overlay').fadeIn(150); 

        // $('.edit__profile__photo-icon').show();
        $('.cropper__image_content').html('<img src="" id="image__crop">');
        var image = $('img#image__crop');

        $(image).attr('src', reader.result); 
        $('input#avatar').val(reader.result);

        var image = document.getElementById('image__crop');
        var button = document.getElementById('crop__btn');
         
        var croppable = false;
        var cropper = new Cropper(image, { 
          aspectRatio: 1,
          viewMode: 1,
          ready: function () { 
            croppable = true;
          }
        });

        button.onclick = function () {
          $('.cropper__section, #overlay').fadeOut(150);
          var croppedCanvas;
          var roundedCanvas;
          var roundedImage;

          if (!croppable) {
            return;
          }
 
          cropper = cropper.getCroppedCanvas().toDataURL();

          // // Crop
          // croppedCanvas = cropper.getCroppedCanvas();

          // // Round
          // roundedCanvas = getRoundedCanvas(croppedCanvas);

          // // Show
          // roundedImage     = document.createElement('img');
          // cropper = roundedCanvas.toDataURL();
          $('input#avatar').val(cropper);
          $('.profile__img').css('background-image', 'url('+cropper+')'); 
          $('.save__cropped_image').show();
          $('form.profile__image_form').submit();
        };
    }; 
}

/* Edit profile upload image */
function multipleImages(input, uploaderContainter){
    if (input.files && input.files[0]) {
        $(input.files).each(function(i) { 
            var fileExtension = ["image/gif", "image/jpeg", "image/png", "image/jpg"];
            var fileType = this["type"];
            var fileName = this["name"];
            var fileSize = parseInt(this["size"]) / 1000;
 
            if (jQuery.inArray(fileType, fileExtension) == -1) {
                alert('Ошибка в расширении файла!');
                return;
            }  

            if (fileSize > 2048) {
                alert('Максимальный размер изображения 2МБ');
                return;
            }

            var reader = new FileReader();
            reader.readAsDataURL(this);

            reader.onload = function(e) { 
                
                $(uploaderContainter).show();
                var content = "<div class='col-md-4 load-thumbnail'>"+ 
                              "<div class='uploadedImg' style='background-image:url("+reader.result+")'></div>"+
                              "<div class='actions__upload_img'>"+
                              "<span onclick='deleteUploadImg(this)' class='delete__upload_img'></span> "+
                              "</div>"+
                              "<input type='hidden' name='certificates[]' value='"+reader.result+"'>"+
                              "</div>";
                $('.uploaderContainter .col-md-offset-4').removeClass('col-md-offset-4')             
                $(uploaderContainter).prepend(content);
            } 
        }); 
    } 
}

function deleteUploadImg(item, id){
    if (!confirm('Вы действительно хотите удалить?')) {
        return false;
    }
    $(item).closest('.load-thumbnail').fadeOut(150, function(){
        $(this).closest('.load-thumbnail').remove();
    });
      
    if (id) {
        $.ajax({
            url: '/user/actions/deleteCertificate',
            type: 'POST', 
            data: {'id':id, _token: CSRF_TOKEN}, 
            dataType: 'json',
            beforeSend: function() {},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.status === 401) document.location.reload(true);
            },
            success: function(jsonResponse, textStatus, request) {},
            complete: function() { }
        });
    }
}   
  
function InputMask(){
    $('.price__input').inputmask("decimal",{
        alias: 'numeric',
        radixPoint:".", 
        groupSeparator: " ", 
        digits: 2,
        autoGroup: true,
        allowMinus: false  
    }); 
} 

function teacherStatus(input){
    var status = $(input).prop('checked');

    $.ajax({
        url: '/user/actions/changeStatus',
        type: 'POST', 
        data: {status:status, _token: CSRF_TOKEN}, 
        dataType: 'json',
        beforeSend: function() {},
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (XMLHttpRequest.status === 401) document.location.reload(true);
        },
        success: function(jsonResponse, textStatus, request) {},
        complete: function() {}
    }); 
}

function log(data) {
    console.log(data);
}

// function videoJsInit(){
//     $('.vide__videojs').each(function(){
//         videojs($(this));
//     });
// }