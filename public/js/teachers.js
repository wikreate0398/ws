function teacherBookmark(item, id){
    $.ajax({
        url: '/teachers/setBoockmark',
        type: 'POST', 
        data: {'id':id, _token: CSRF_TOKEN}, 
        dataType: 'json',
        beforeSend: function() {},
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (XMLHttpRequest.status === 401) document.location.reload(true);
        },
        success: function(jsonResponse, textStatus, request) {
            if (jsonResponse.status == 1) {
                $(item).addClass('add_bkmrk');
            }else{
                $(item).removeClass('add_bkmrk');
            }
        },
        complete: function() { }
    });
} 

function teacherRequest(button, id_teacher, auth, hasRequest)
{
    if (hasRequest == true && auth == true) { 
        return;
    }
    if (auth != true) 
    {
        window.location = loginLink + '?redirectUri=/teacher/' + id_teacher + '/makeRequest';
    }
    else
    {
        window.location = '/teacher/' + id_teacher + '/makeRequest';
    }
}

function openDirectionSubjects(span) {
    $(span).closest('li').find('ul').slideToggle();
}

function selectSubject(span) {
    $(span).toggleClass('selected--subject');  
    var name = $(span).text(); 
    var id   = $(span).attr('subject-id'); 
    var directionId   = $(span).attr('direction-id'); 

    if ($(span).hasClass('selected--subject')) { 
        var parent = '.teacher_subjects_inner'; 
        var input = '<input type="hidden" id="teacher_subjects_input_'+id+'" value="'+id+'" name="teacher_subjects['+directionId+'][]">';
        $('.selected__teacher_inputs').append(input);
        var tagLabel = '<span id="teacher_label_'+id+'">'+
                       '<div class="subject_tag">'+name+'</div>'+
                       '<div class="delete__subject" onclick="deleteTeacherSubject('+id+');"><i class="fa fa-times" aria-hidden="true"></i></div></span>';
        $('.selected--subjects-list').append(tagLabel);
        $('.select--subjects-label').hide();
        $('.selected--subjects-list').show();
    }else{ 
        deleteTeacherSubject(id); 
    } 
}

$(document).ready(function(){
    $('.selected--subjects-list').on('click', function(event){    
        if (!$(event.target).hasClass('subject_tag') && !$(event.target).closest('.delete__subject').length) {
            $('.dropdown-category').toggleClass('open--dropdown');
            $('.selected--subjects-list').toggleClass('active--drowdown');
        }  
    }); 

    $(document).click(function(event){ 
        if (!$(event.target).hasClass('category--subjects') 
            && !$(event.target).closest('.category--subjects').length 
            && !$(event.target).hasClass('fa')) {
            $('.dropdown-category').removeClass('open--dropdown');
        $('.selected--subjects-list').removeClass('active--drowdown');
        } 
    }); 
}); 

function deleteTeacherSubject(id) {
    $('#teacher_subjects_input_' + id).remove();
    $('#teacher_label_' + id).remove(); 
    $('span[subject-id="'+id+'"]').removeClass('selected--subject');

    if ($('.selected--subjects-list span').length == 0) {
        $('.select--subjects-label').show();
    }
}