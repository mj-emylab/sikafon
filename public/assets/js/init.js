$(document).ready(function() {
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        responsiveClass: true,
        center: true,
        nav: true,
        navText: [
            "<i class= 'fa fa-3x fa-angle-left'style='color: var(--bs-danger);'></i>",
            "<i class= 'fa fa-3x fa-angle-right' style='color: var(--bs-danger);'></i>"
        ],
        responsive: {
            0: {
                items: 1,

            },
            600: {
                items: 1,

            },
            1000: {
                items: 4,

            }
        }
    })
});