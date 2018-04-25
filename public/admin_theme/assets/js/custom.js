$(document).ready(function(){
    startMaskNewInput();

    $('.fancybox-button').fancybox();
    $('.fancybox').fancybox();

    $('.number').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
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