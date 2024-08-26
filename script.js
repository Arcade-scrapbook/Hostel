var searchVisible = 0;
var transparent = true;

var transparentDemo = true;
var fixedTop = false;

var navbar_initialized = false;

$(document).ready(function () {
    window_width = $(window).width();

    // Activate the tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Activate the switches with icons
    if ($('.switch').length !== 0) {
        $('.switch')['bootstrapSwitch']();
    }
    // Activate regular switches
    if ($("[data-toggle='switch']").length !== 0) {
        $("[data-toggle='switch']").bootstrapSwitch();
    }

    if ($(".tagsinput").length !== 0) {
        $(".tagsinput").tagsInput();
    }
    if (window_width >= 768) {
        big_image = $('.page-header[data-parallax="true"]');

        if (big_image.length !== 0) {
            $(window).on('scroll', pk.checkScrollForPresentationPage);
        }
    }

    if ($("#datetimepicker").length !== 0) {
        $('#datetimepicker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            },
            debug: true
        });
    }

    // Navbar color change on scroll
    if ($('.navbar[color-on-scroll]').length !== 0) {
        $(window).on('scroll', pk.checkScrollForTransparentNavbar);
    }

    $('.btn-tooltip').tooltip();
    $('.label-tooltip').tooltip();

    // Carousel
    $('.carousel').carousel({
        interval: 4000
    });

    $('.form-control').on("focus", function () {
        $(this).parent('.input-group').addClass("input-group-focus");
    }).on("blur", function () {
        $(this).parent(".input-group").removeClass("input-group-focus");
    });

    // Init popovers
    pk.initPopovers();

    // Init Collapse Areas
    pk.initCollapseArea();

    // Init Sliders
    pk.initSliders();

});

$(document).on('click', '.navbar-toggler', function () {
    $toggle = $(this);
    if (pk.misc.navbar_menu_visible == 1) {
        $('html').removeClass('nav-open');
        pk.misc.navbar_menu_visible = 0;
        setTimeout(function () {
            $toggle.removeClass('toggled');
            $('#bodyClick').remove();
        }, 550);
    } else {
        setTimeout(function () {
            $toggle.addClass('toggled');
        }, 580);

        div = '<div id="bodyClick"></div>';
        $(div).appendTo("body").click(function () {
            $('html').removeClass('nav-open');
            pk.misc.navbar_menu_visible = 0;
            $('#bodyClick').remove();
            setTimeout(function () {
                $toggle.removeClass('toggled');
            }, 550);
        });

        $('html').addClass('nav-open');
        pk.misc.navbar_menu_visible = 1;
    }
});
