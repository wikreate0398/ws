function addSubject(select){
    var value = $(select).val();
    if (value <= 0) return;
    var name  = $(select).find('option[value="'+value+'"]').text(); 
    $(select).find('option[value="'+value+'"]').attr('disabled',true);
    var input = '<input type="hidden" id="teacher_subjects_input_'+value+'" value="'+value+'" name="teacher_subjects[]">';
    $('.selected__teacher_inputs').append(input);
    var tagLabel = '<span data-id="'+value+'" id="teacher_subjects_'+value+'">'+
                   '<div class="subject_tag">'+name+'</div>'+
                   '<div class="delete__subject" onclick="deleteSubject('+value+');"><i class="fa fa-times" aria-hidden="true"></i></div></span>';
    $('.selected__teacher_labels').append(tagLabel);
    $('.selected__teacher_labels').show();
}

function deleteSubject(id){
    var span = $('span#teacher_subjects_' + id);
    var name = $(span).find('.subject_tag').text(); 
    var id = $(span).attr('data-id'); 
    $('select.teacher_subjects_select option[value="'+id+'"]').attr('disabled',false);
    $('input#teacher_subjects_input_' + id).remove();
    $('span#teacher_subjects_' + id).remove();

    if ($('.selected__teacher_labels span').length <= 0) {
        $('.selected__teacher_labels').hide();

        $('select.teacher_subjects_select option[selected="selected"]').each(
            function() {
                $(this).removeAttr('selected');
            }
        );
        $('select.teacher_subjects_select option:first').attr('selected',true);
    }
}