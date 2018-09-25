$(document).ready(function(){  
    if (minMaxPrice.min > 0 && minMaxPrice.max > 0 && minMaxPrice.max != minMaxPrice.min) {

        var inputMin = parseFloat($('input#min_price').val());
        var inputMax = parseFloat($('input#max_price').val()); 
        valueMin = (inputMin > 0 && inputMin >= minMaxPrice.min && inputMin <= minMaxPrice.max) ? inputMin : minMaxPrice.min;
        valueMax = (inputMax > 0 && inputMax >= minMaxPrice.min && inputMax <= minMaxPrice.max) ? inputMax : minMaxPrice.max;
         
        $( "#slider-range" ).slider({
            range: true,
            min: minMaxPrice.min,
            max: minMaxPrice.max,
            values: [ valueMin, valueMax ],
            slide: function( event, ui ) {
                $( "#amount" ).val( "₽" + ui.values[ 0 ] + " - ₽" + ui.values[ 1 ] );
            },
            stop: function(){
                $('input#min_price').val($( "#slider-range" ).slider( "values", 0 ));
                $('input#max_price').val($( "#slider-range" ).slider( "values", 1 ));
                teacherFilter();
            }
        });
        $( "#amount" ).val( "₽" + $( "#slider-range" ).slider( "values", 0 ) +
        " - ₽" + $( "#slider-range" ).slider( "values", 1 ) );
        $('input#min_price').val($( "#slider-range" ).slider( "values", 0 ));
        $('input#max_price').val($( "#slider-range" ).slider( "values", 1 ));
    }

    $('div.filter_block').find('input').change(function(){
        teacherFilter();
    }); 
});

function subjectsFilter(select){
	var value = $(select).val();
    if (value <= 0) return;
    var name  = $(select).find('option[value="'+value+'"]').text(); 
    $(select).find('option[value="'+value+'"]').attr('disabled',true);

    var input = '<input type="hidden" class="teacher_subjects" value="'+value+'">';
    $('.subjects_filter__inputs').append(input); 
    teacherFilter();
}

function deleteFilterSubject(id){
	$('input#teacher_subject_input_' + id).remove();
	$('input#teacher_subjects_' + id).fadeOut(150);
	teacherFilter();
}

function teacherFilter(){
    var teacher_available = $('input#teacher_available').val();
    var per_page  = $('input#per_page').val();
    var page      = $('input#page').val(); 
    var search__input = $('input#search__input').val();
    var min_price = $('input#min_price').val();
    var max_price = $('input#max_price').val();

    var specializations = '';
    if ($('input.specialization_input').length > 0) {

        pluser='';  
        $.each($('input.specialization_input'),function() {
            if ($(this).is(':checked')) { 
                specializations+=pluser+$(this).val();
                pluser=',';
            }
        }); 
    } 

    var subjects = '';
    if ($('input.teacher_subjects').length > 0) {
    pluser='';  
        $.each($('input.teacher_subjects'),function() {
            subjects+=pluser+$(this).val();
           	pluser=',';
        });
    }  

    var lesson_options = '';
    if ($('input.lesson_option_input').length > 0) {
    pluser='';  
        $.each($('input.lesson_option_input'),function() {
            if ($(this).is(':checked')) {
                lesson_options+=pluser+$(this).val();
                pluser=',';
            }
        });
    }

    var sex = '';
    if ($('input.sex').length > 0) {
    pluser='';  
        $.each($('input.sex'),function() {
            if ($(this).is(':checked')) {
                sex+=pluser+$(this).val();
                pluser=',';
            }
        });
    }  

    flt='?flt=1'; 
    if(search__input) flt+='&q='+search__input;
    // if(teacher_available) flt+='&teacher_available='+teacher_available;
    if(subjects) flt+='&subjects='+subjects;
    if(sex) flt+='&sex='+sex;
    if(min_price) flt+='&min_price='+min_price;
    if(max_price) flt+='&max_price='+max_price;
    if(specializations) flt+='&specializations='+specializations;
    if(lesson_options) flt+='&lesson_options='+lesson_options;
    if(per_page) flt+='&per_page='+per_page;
    if(page) flt+='&page=1';

    olink='/teachers';  
    var redirect=olink+flt;    
    window.location=redirect;
}

function teacher_available_filter(item){
    var value = $(item).attr('data-availbale');
    $('input#teacher_available').val(value);

    teacherFilter();
}

function teacher_perpage_filter(item){
    var value = $(item).attr('data-perpage');
    $('input#per_page').val(value); 
    teacherFilter();
}