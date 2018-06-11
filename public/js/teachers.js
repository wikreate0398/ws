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
    if (hasRequest == true) {
        alert('Вы уже оставляли заявку для этого учителя');
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

function deleteTeacherSubject(id){
    var span = $('span#teacher_subjects_' + id);
    var name = $(span).find('.subject_tag').text(); 
    var id = $(span).attr('data-id'); 
    $('select.teacher_subjects_select option[value="'+id+'"]').attr('disabled',false);
    $('input#teacher_subjects_input_' + id).remove();
    $('span#teacher_subjects_' + id).remove();

    if ($('.selected__teacher_subjects span').length <= 0) {
        $('.selected__teacher_subjects').hide();

        $('select.teacher_subjects_select option[selected="selected"]').each(
            function() {
                $(this).removeAttr('selected');
            }
        );

        $('select.teacher_subjects_select option:first').attr('selected',true);
    }
}