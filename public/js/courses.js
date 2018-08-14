$(document).ready(function(){
	var course_is_open = $( ".course_is_open" ); 
    var course_date_to = $( ".course_date_to" );
    var course_date_from = $( ".course_date_from" );

    course_is_open.datepicker({
        format: "dd.mm.yyyy", 
        language: 'ru',
        startDate: new Date(),
        autoHide: true
    });
 
    course_date_to.datepicker({
        format: "dd.mm.yyyy", 
        language: 'ru',  
        autoHide: true,
        startDate: new Date(),
    });

    course_date_from.datepicker({
        format: "dd.mm.yyyy", 
        language: 'ru',  
        startDate: new Date(),
        autoHide: true
    });  
   
    course_date_to.on('pick.datepicker', function (e) {   
        var data = (e.date != undefined) ? e.date : this.value; 
        if (!data) return;  
        course_date_from.datepicker('setEndDate', data); 
    });

    course_date_from.on('pick.datepicker', function (e) {
        var data = (e.date != undefined) ? e.date : this.value; 
        if (!data) return;  
        course_is_open.datepicker('setEndDate', data); 
        course_date_to.datepicker('setStartDate', data);   
    });

    course_date_from.trigger('pick.datepicker'); 
    course_date_to.trigger('pick.datepicker');  
});

function courseRequest(button, id_course, auth, canMakeRequest)
{
	if (canMakeRequest == false && auth == true) { 
		return;
	}
	if (auth != true) 
	{
		window.location = loginLink + '?redirectUri=/course/' + id_course + '/makeRequest';
	}
	else
	{
		window.location = '/course/' + id_course + '/makeRequest';
	}
}

function showCourseDuration(input){
    if ($(input).prop('checked') == true) {
        $('.course__duration').show();
    }else{
        $('.course__duration').hide();
    }
}

function deleteCourseUploadImg(item, id){ 
    if (!confirm('Вы действительно хотите удалить?')) {
        return false;
    }
    $(item).closest('.load-thumbnail').fadeOut(150, function(){
        $(this).closest('.load-thumbnail').remove();
    });      
    if (id) {
        $.ajax({
            url: '/user/actions/deleteCourseCertificate',
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

function setPayCourse(input){
    var val = $(input).val();
    if (val == 1) {
        $('.price__course').attr('disabled', true);
    }else{
        $('.price__course').attr('disabled', false);
    } 
}

function deleteSectionBlock(item, id){
    if (!confirm('Вы действительно хотите удалить?')) {
        return false;
    } 

    // if (id > 0) {
    //     $.ajax({
    //         url: '/user/actions/deleteCourseSection',
    //         type: 'POST', 
    //         data: {id_section: id, _token: CSRF_TOKEN}, 
    //         cache: false, 
    //         dataType: 'json',
    //         beforeSend: function() {},
    //         error: function(XMLHttpRequest, textStatus, errorThrown) {
    //             if (XMLHttpRequest.status === 401) document.location.reload(true);
    //         },
    //         success: function(jsonResponse, textStatus, request) {    
    //             if (jsonResponse.msg === true) {
    //                 $(item).closest('.course__section').remove();
    //             } else {   
    //                 alert('Ошибка');
    //             } 
    //         },
    //         complete: function() {}
    //     });
    // }else{
    //     $(item).closest('.course__section').remove();
    // } 
    $(item).closest('.course__section').remove();
}

function deleteLectureBlock(item, id){

    if (!confirm('Вы действительно хотите удалить?')) {
        return false;
    } 

    // if (id > 0) {
    //     $.ajax({
    //         url: '/user/actions/deleteCourseSectionLecture',
    //         type: 'POST', 
    //         data: {id_lecture: id, _token: CSRF_TOKEN}, 
    //         cache: false, 
    //         dataType: 'json',
    //         beforeSend: function() {},
    //         error: function(XMLHttpRequest, textStatus, errorThrown) {
    //             if (XMLHttpRequest.status === 401) document.location.reload(true);
    //         },
    //         success: function(jsonResponse, textStatus, request) {    
    //             if (jsonResponse.msg === true) {
    //                 $(item).closest('.lecture__section').remove();
    //             } else {   
    //                 alert('Ошибка');
    //             } 
    //         },
    //         complete: function() {}
    //     });
    // }else{
    //     $(item).closest('.lecture__section').remove();
    // } 

     $(item).closest('.lecture__section').remove(); 
}    

function loadCourseSubcats(select, subcat){  
 
    var cacheStr = String((new Date()).getTime()).replace(/\D/gi, '');
    $( "#load__subcats").load( "/user/actions/loadCourseSubcats?rnd=" + cacheStr,{'id': $(select).val(), 'id_subcat': subcat, '_token': CSRF_TOKEN}, function( response, status, xhr ) { 
        if ( response == "" ) {
            $('#load__subcats').hide();
            $('#load__subcats').html('');

            $('#course__cats').removeClass('col-md-6').addClass('col-md-12');
            $('#load__subcats').removeClass('col-md-6').addClass('col-md-12');
        }else{
            $('#load__subcats').show();
            

            $('#course__cats').removeClass('col-md-12').addClass('col-md-6');
            $('#load__subcats').removeClass('col-md-12').addClass('col-md-6');
        }
    });
}

function addLecture(){
    var first_block = $('.course__sections .course__section.first_block').find('.lecture__sections .lecture__section.first_block');
    var cloneBlock = $(first_block).clone();
    $(cloneBlock).removeClass('first_block');
    $(cloneBlock).find('.error__input').removeClass('error__input');
     
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
    $(cloneBlock).find('.error__input').removeClass('error__input');
     
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

function activeFinishCourse(btn){
    var showId=$(btn).data('show');
    $('.course_card').closest('.col-md-4').hide(); 
    $(showId).fadeIn(100);
    $('.toggle__course').removeClass('active');
    $(btn).addClass('active'); 
}

function courseFavorite(item, id){
    $.ajax({
        url: '/course/favorite',
        type: 'POST', 
        data: {'id':id, _token: CSRF_TOKEN}, 
        dataType: 'json',
        beforeSend: function() {},
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (XMLHttpRequest.status === 401) document.location.reload(true);
        },
        success: function(jsonResponse, textStatus, request) {
            if (jsonResponse.status == 1) {
                $(item).addClass('is_favorite fa-heart');
                $(item).removeClass('fa-heart-o');
            }else{
                $(item).removeClass('is_favorite fa-heart');
                $(item).addClass('fa-heart-o');
            }
        },
        complete: function() { }
    });
}

function selectFilterTeacher(select, category, url){
    var val      = $(select).val(); 
    var cacheStr = String((new Date()).getTime()).replace(/\D/gi, '');
    $( "#category").load(url + "?rnd=" + cacheStr,
                             {'id': val, 'category': category, '_token': CSRF_TOKEN}, 
                             function( response, status, xhr ) {  
    }); 
} 