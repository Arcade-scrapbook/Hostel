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

pk = {
    misc: {
        navbar_menu_visible: 0
    },

    checkScrollForPresentationPage: debounce(function () {
        oVal = ($(window).scrollTop() / 3);
        big_image.css({
            'transform': 'translate3d(0,' + oVal + 'px,0)',
            '-webkit-transform': 'translate3d(0,' + oVal + 'px,0)',
            '-ms-transform': 'translate3d(0,' + oVal + 'px,0)',
            '-o-transform': 'translate3d(0,' + oVal + 'px,0)'
        });
    }, 4),

    checkScrollForTransparentNavbar: debounce(function () {
        if ($(document).scrollTop() > $(".navbar").attr("color-on-scroll")) {
            if (transparent) {
                transparent = false;
                $('.navbar[color-on-scroll]').removeClass('navbar-transparent');
            }
        } else {
            if (!transparent) {
                transparent = true;
                $('.navbar[color-on-scroll]').addClass('navbar-transparent');
            }
        }
    }, 17),

    initPopovers: function () {
        if ($('[data-toggle="popover"]').length !== 0) {
            $('body').append('<div class="popover-filter"></div>');

            // Activate Popovers
            $('[data-toggle="popover"]').popover().on('show.bs.popover', function () {
                $('.popover-filter').click(function () {
                    $(this).removeClass('in');
                    $('[data-toggle="popover"]').popover('hide');
                });
                $('.popover-filter').addClass('in');
            }).on('hide.bs.popover', function () {
                $('.popover-filter').removeClass('in');
            });
        }
    },
    initCollapseArea: function () {
        $('[data-toggle="pk-collapse"]').each(function () {
            var thisdiv = $(this).attr("data-target");
            $(thisdiv).addClass("pk-collapse");
        });

        $('[data-toggle="pk-collapse"]').hover(function () {
            var thisdiv = $(this).attr("data-target");
            if (!$(this).hasClass('state-open')) {
                $(this).addClass('state-hover');
                $(thisdiv).css({
                    'height': '30px'
                });
            }

        },
            function () {
                var thisdiv = $(this).attr("data-target");
                $(this).removeClass('state-hover');

                if (!$(this).hasClass('state-open')) {
                    $(thisdiv).css({
                        'height': '0px'
                    });
                }
            }).click(function (event) {
                event.preventDefault();

                var thisdiv = $(this).attr("data-target");
                var height = $(thisdiv).children('.panel-body').height();

                if ($(this).hasClass('state-open')) {
                    $(thisdiv).css({
                        'height': '0px',
                    });
                    $(this).removeClass('state-open');
                } else {
                    $(thisdiv).css({
                        'height': height + 30,
                    });
                    $(this).addClass('state-open');
                }
            });
    },
