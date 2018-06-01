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
                universityFilter();
            }
        });
        $( "#amount" ).val( "₽" + $( "#slider-range" ).slider( "values", 0 ) +
        " - ₽" + $( "#slider-range" ).slider( "values", 1 ) );
        $('input#min_price').val($( "#slider-range" ).slider( "values", 0 ));
        $('input#max_price').val($( "#slider-range" ).slider( "values", 1 ));
    }

    $('div.filter_block').find('input').change(function(){
        universityFilter();
    }); 
});
 
function universityFilter(){
    var university_status = $('input#university_status').val();
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

    var has_military_department = '';
    if ($('input.has_military_department').length > 0) {
    pluser='';  
        $.each($('input.has_military_department'),function() {
            if ($(this).is(':checked')) {
                has_military_department+=pluser+$(this).val();
                pluser=',';
            }
        });
    }  

    var has_hostel = '';
    if ($('input.has_hostel').length > 0) {
    pluser='';  
        $.each($('input.has_hostel'),function() {
            if ($(this).is(':checked')) {
                has_hostel+=pluser+$(this).val();
                pluser=',';
            }
        });
    }  

    var distance_learning = '';
    if ($('input.distance_learning').length > 0) {
    pluser='';  
        $.each($('input.distance_learning'),function() {
            if ($(this).is(':checked')) {
                distance_learning+=pluser+$(this).val();
                pluser=',';
            }
        });
    }  

    flt='?flt=1'; 
    if(search__input) flt+='&q='+search__input;
    if(university_status) flt+='&university_status='+university_status; 
    if(has_military_department) flt+='&has_military_department='+has_military_department;
    if(has_hostel) flt+='&has_hostel='+has_hostel;
    if(distance_learning) flt+='&distance_learning='+distance_learning;
    if(min_price) flt+='&min_price='+min_price;
    if(max_price) flt+='&max_price='+max_price;
    if(specializations) flt+='&specializations='+specializations;
     
    if(per_page) flt+='&per_page='+per_page;
    if(page) flt+='&page=1';

    olink='/universities';  
    var redirect=olink+flt;    
    window.location=redirect;
}

function university_status_filter(item){
    var value = $(item).attr('data-status');
    $('input#university_status').val(value); 
    universityFilter();
}

function university_perpage_filter(item){
    var value = $(item).attr('data-perpage');
    $('input#per_page').val(value); 
    universityFilter();
}