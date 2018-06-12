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

function teacherSubject(select){
    var value = $(select).val();
    if (value <= 0) return;
    var name  = $(select).find('option[value="'+value+'"]').text(); 
    $(select).find('option[value="'+value+'"]').attr('disabled',true);
    var input = '<input type="hidden" id="teacher_subjects_input_'+value+'" value="'+value+'" name="teacher_subjects[]">';
    $('.selected__teacher_inputs').append(input);
    var tagLabel = '<span data-id="'+value+'" id="teacher_subjects_'+value+'">'+
                   '<div class="subject_tag">'+name+'</div>'+
                   '<div class="delete__subject" onclick="deleteTeacherSubject('+value+');"><i class="fa fa-times" aria-hidden="true"></i></div></span>';
    $('.selected__teacher_subjects').append(tagLabel);
    $('.selected__teacher_subjects').show();
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
 