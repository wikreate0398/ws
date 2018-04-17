$(document).ready(function(){
    startMaskNewInput();

    $('.fancybox-button').fancybox();
    $('.fancybox').fancybox();

    $('.number').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $('.c-picker').datepicker({
        rtl: Metronic.isRTL(),
        orientation: "left",
        autoclose: true,
        format: "mm.yyyy",
        startView: "months", 
        minViewMode: "months",
        language: 'ru-RU' 
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