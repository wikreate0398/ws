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
        }  
    }); 

    $(document).click(function(event){ 
        if (!$(event.target).hasClass('category--subjects') 
            && !$(event.target).closest('.category--subjects').length 
            && !$(event.target).hasClass('fa')) {
            $('.dropdown-category').removeClass('open--dropdown');
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
 
// function teacherSubject(select){
//     var value = $(select).val();
//     if (value <= 0) return;
//     var name  = $(select).find('option[value="'+value+'"]').text(); 
//     $(select).find('option[value="'+value+'"]').attr('disabled',true);
//     var input = '<input type="hidden" id="teacher_subjects_input_'+value+'" value="'+value+'" name="teacher_subjects[]">';
//     $('.selected__teacher_inputs').append(input);
//     var tagLabel = '<span data-id="'+value+'" id="teacher_subjects_'+value+'">'+
//                    '<div class="subject_tag">'+name+'</div>'+
//                    '<div class="delete__subject" onclick="deleteTeacherSubject('+value+');"><i class="fa fa-times" aria-hidden="true"></i></div></span>';
//     $('.selected__teacher_subjects').append(tagLabel);
//     $('.selected__teacher_subjects').show();
// }

// function teacherDirections(select){
//     var value = $(select).val();
//     if (value <= 0) return; 

//     var name  = $(select).find('option[value="'+value+'"]').text(); 
//     var parent = '.teacher_direction_inner';
//     $(select).find('option[value="'+value+'"]').attr('disabled',true);
//     var input = '<input type="hidden" id="teacher_subjects_input_'+value+'" value="'+value+'" name="teacher_directions[]">';
//     $(parent).find('.selected__teacher_inputs').append(input);
//     var tagLabel = '<span data-id="'+value+'" id="teacher_label_'+value+'">'+
//                    '<div class="subject_tag">'+name+'</div>'+
//                    '<div class="delete__subject" onclick="deleteTeacherDirection('+value+', \''+parent+'\');"><i class="fa fa-times" aria-hidden="true"></i></div></span>';
//     $(parent).find('.selected__teacher_labels').append(tagLabel);
//     $(parent).find('.selected__teacher_labels').show();

//     if(categories[value]['childs']){
//         $('.subjects__form-group').show();
//         var select = $('.teacher_subjects_inner select');
//         $.each(categories[value]['childs'], function(key, item){
//             $(select).append('<option data-parent="' + value + '" value="' + item['id'] + '">' + item['name'] + '</option>');
//         });
//         initSelect2();
//     }
// }

// function teacherSubjects(select){
//     var value = $(select).val();
//     if (value <= 0) return; 

//     var name      = $(select).find('option[value="'+value+'"]').text(); 
//     var parent_id = $(select).find('option[value="'+value+'"]').attr('data-parent'); 
    
//     var parent = '.teacher_subjects_inner';
//     $(select).find('option[value="'+value+'"]').attr('disabled',true);
//     var input = '<input type="hidden" data-parent="'+parent_id+'" id="teacher_subjects_input_'+value+'" value="'+value+'" name="teacher_subjects['+parent_id+'][]">';
//     $(parent).find('.selected__teacher_inputs').append(input);
//     var tagLabel = '<span data-id="'+value+'" data-parent="'+parent_id+'" id="teacher_label_'+value+'">'+
//                    '<div class="subject_tag">'+name+'</div>'+
//                    '<div class="delete__subject" onclick="deleteTeacherSubject('+value+', \''+parent+'\');"><i class="fa fa-times" aria-hidden="true"></i></div></span>';
//     $(parent).find('.selected__teacher_labels').append(tagLabel);
//     $(parent).find('.selected__teacher_labels').show();
// }

// function deleteTeacherDirection(id, parent){
//     var span = $('span#teacher_label_' + id);
//     var name = $(span).find('.subject_tag').text(); 
//     var id = $(span).attr('data-id'); 
//     $(parent).find('select option[value="'+id+'"]').attr('disabled',false);
//     $('input#teacher_subjects_input_' + id).remove();
//     $('span#teacher_label_' + id).remove();

//     if ($(parent).find('.selected__teacher_labels span').length <= 0) {
//         $(parent).find('.selected__teacher_labels').hide(); 
//         $(parent).find('select option[selected="selected"]').each(
//             function() {
//                 $(this).removeAttr('selected');
//             }
//         ); 
//         $(parent).find('select option:first').attr('selected',true);
//         $('.subjects__form-group').hide();
//     } 
//     $('.teacher_subjects_inner').find('[data-parent="'+id+'"]').remove(); 
// }

// function deleteTeacherSubject(id, parent){
//     var span = $('span#teacher_label_' + id);
//     var name = $(span).find('.subject_tag').text(); 
//     var id = $(span).attr('data-id'); 
//     $(parent).find('select option[value="'+id+'"]').attr('disabled',false);
//     $('input#teacher_subjects_input_' + id).remove();
//     $('span#teacher_label_' + id).remove();

//     if ($(parent).find('.selected__teacher_labels span').length <= 0) {
//         $(parent).find('.selected__teacher_labels').hide(); 
//         $(parent).find('select option[selected="selected"]').each(
//             function() {
//                 $(this).removeAttr('selected');
//             }
//         ); 
//         $(parent).find('select option:first').attr('selected',true); 
//     }  
// }