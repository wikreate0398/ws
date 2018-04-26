jQuery(document).ready(function($) {
    $('#teacher_carousel').owlCarousel({
        loop:true,
        margin:60,
        nav:false,
        dots:true,
        navText: ['<i class="fa fa-angle-double-left" aria-hidden="true"></i>', '<i class="fa fa-angle-double-right" aria-hidden="true"></i>'],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });
    $('#partner_universities').owlCarousel({
        loop:true,
        margin:60,
        nav:false,
        dots:true,
        navText: ['<i class="fa fa-angle-double-left" aria-hidden="true"></i>', '<i class="fa fa-angle-double-right" aria-hidden="true"></i>'],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    });
});