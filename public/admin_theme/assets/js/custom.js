$(document).ready(function(){
    startMaskNewInput();

    $('.fancybox-button').fancybox();
    $('.fancybox').fancybox();
    initSelect2();
    $('.number').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $("textarea[maxlength]").each(function(){
        $(this).next('.maxlength__label').find('span').text(this.value.length);
    });

    $("textarea[maxlength]").on("propertychange input", function() {
        if (this.value.length > this.maxlength) {
            this.value = this.value.substring(0, this.maxlength);
        }  

        $("textarea[maxlength]").next('.maxlength__label').find('span').text(this.value.length);
    });

    $( ".datepicker" ).datepicker({
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true,
        yearRange: '1945:'+(new Date).getFullYear()
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('input.select_type').change(function(){
        var val              = $(this).val(); 
        var charBlock        = $('#char-display'); 
        if (val=='checkbox') { 
            $(charBlock).show();  
        $('.unit__edit').hide();
        }else if(val=='default'){  
            $(charBlock).hide(); 
            $('.unit__edit').show();
        }
    }); 

    var i = 1;
    $('#tags_1:hidden, #tags_1:visible').each(function() {
        $(this).attr('id', 'tags_1_' + i);
        $('#tags_1_' + i).tagsInput({
           width: 'auto',
           defaultText:'',
           minChars:0,
           'onAddTag': function () { 
           },
       });  
       i = i + 1;
    });
});

function initSelect2(){
    //// $('.select2').select2('destroy');
    $('.select2').each(function(){
        if ($(this).hasClass('select2-hidden-accessible')) {
            $(this).select2('destroy');
        }
        $(this).select2();
    });  
}

function startMaskNewInput(){
    $('.rp').each(function(i){
       $(this).attr('id', 'mask_'+i);
       $("#mask_"+i).inputmask("decimal",{
        alias: 'numeric',
        radixPoint:".", 
            groupSeparator: " ", 
            digits: 2,
            autoGroup: true,
            allowMinus: false 

        });
    });
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

function deleteBlock(item){
    $(item).closest('.row').remove();
}

function institutionCheck(input){
    if ($(input).prop('checked') == true) {
        $('.parent_institution').show();
    }else{
        $('.parent_institution').hide();
    }
}

/* Teacher Subjects */

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
                var content = "<div class='col-md-3 load-thumbnail'>"+ 
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

function deleteUploadImg(item, id, id_user){
    if (!confirm('Вы действительно хотите удалить?')) {
        return false;
    }
    $(item).closest('.load-thumbnail').fadeOut(150, function(){
        $(this).closest('.load-thumbnail').remove();
    });
      
    if (id) {
        $.ajax({
            url: '/admin/users/teachers/deleteCertificate',
            type: 'POST', 
            data: {'id':id, 'id_user':id_user, _token: CSRF_TOKEN}, 
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