function coursesFilter(){
    var pay           = $('input#courses_pay').val(); 
    var per_page      = $('input#per_page').val();
    var page          = $('input#page').val(); 
    var search__input = $('input#search__input').val();

    flt='?flt=1'; 
    if(search__input) flt+='&q='+search__input;
    if(pay) flt+='&pay='+pay; 
    if(per_page) flt+='&per_page='+per_page;
    if(page) flt+='&page=1';

    var baseUrl = $('input#baseUrl').val();
    olink=baseUrl;  
    var redirect=olink+flt;  
    window.location=redirect;
}

function courses_pay_filter(item){
    var value = $(item).attr('data-pay');
    $('input#courses_pay').val(value);

    coursesFilter();
}

function courses_perpage_filter(item){
    var value = $(item).attr('data-perpage');
    $('input#per_page').val(value);

    coursesFilter();
}