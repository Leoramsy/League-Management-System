var transparent = true;
var transparentDemo = true;
var fixedTop = false;

var navbar_initialized = false;
var backgroundOrange = false;
var sidebar_mini_active = false;
var toggle_initialized = false;

var $html = $('html');
var $body = $('body');
var $navbar_minimize_fixed = $('.navbar-minimize-fixed');
var $collapse = $('.collapse');
var $navbar = $('.navbar');
var $tagsinput = $('.tagsinput');
var $selectpicker = $('.selectpicker');
var $navbar_color = $('.navbar[color-on-scroll]');
var $full_screen_map = $('.full-screen-map');
var $datetimepicker = $('.datetimepicker');
var $datepicker = $('.datepicker');
var $timepicker = $('.timepicker');

var seq = 0,
        delays = 80,
        durations = 500;
var seq2 = 0,
        delays2 = 80,
        durations2 = 500;


$("#accordion > li > a").click(function () {
    $(this).closest('li').siblings().find('a').removeClass('active').next('div').slideUp(500);
    $(this).toggleClass("active").next('div').slideToggle(500);
});


(function () {
    var isWindows = navigator.platform.indexOf('Win') > -1 ? true : false;

    if (isWindows) {
        // if we are on windows OS we activate the perfectScrollbar function
        if ($('.main-panel').length != 0) {
            var ps = new PerfectScrollbar('.main-panel', {
                wheelSpeed: 2,
                wheelPropagation: true,
                minScrollbarLength: 20,
                suppressScrollX: true
            });
        }

        if ($('.sidebar .sidebar-wrapper').length != 0) {

            var ps1 = new PerfectScrollbar('.sidebar .sidebar-wrapper');
            $('.table-responsive').each(function () {
                var ps2 = new PerfectScrollbar($(this)[0]);
            });
        }



        $html.addClass('perfect-scrollbar-on');
    } else {
        $html.addClass('perfect-scrollbar-off');
    }
})();

$(document).ready(function () {

    var scroll_start = 0;
    var startchange = $('.row');
    var offset = startchange.offset();
    var scrollElement = navigator.platform.indexOf('Win') > -1 ? $(".ps") : $(window);
    scrollElement.scroll(function () {

        scroll_start = $(this).scrollTop();

        if (scroll_start > 50) {
            $(".navbar-minimize-fixed").css('opacity', '1');
        } else {
            $(".navbar-minimize-fixed").css('opacity', '0');
        }
    });


    $(document).scroll(function () {
        scroll_start = $(this).scrollTop();
        if (scroll_start > offset.top) {
            $(".navbar-minimize-fixed").css('opacity', '1');
        } else {
            $(".navbar-minimize-fixed").css('opacity', '0');
        }
    });

    if ($('.full-screen-map').length == 0 && $('.bd-docs').length == 0) {
        // On click navbar-collapse the menu will be white not transparent
        $('.collapse').on('show.bs.collapse', function () {
            $(this).closest('.navbar').removeClass('navbar-transparent').addClass('bg-white');
        }).on('hide.bs.collapse', function () {
            $(this).closest('.navbar').addClass('navbar-transparent').removeClass('bg-white');
        });
    }

    blackDashboard.initMinimizeSidebar();

    $navbar = $('.navbar[color-on-scroll]');
    scroll_distance = $navbar.attr('color-on-scroll') || 500;

    // Check if we have the class "navbar-color-on-scroll" then add the function to remove the class "navbar-transparent" so it will transform to a plain color.
    if ($('.navbar[color-on-scroll]').length != 0) {
        blackDashboard.checkScrollForTransparentNavbar();
        $(window).on('scroll', blackDashboard.checkScrollForTransparentNavbar)
    }

    $('.form-control').on("focus", function () {
        $(this).parent('.input-group').addClass("input-group-focus");
    }).on("blur", function () {
        $(this).parent(".input-group").removeClass("input-group-focus");
    });

    // Activate bootstrapSwitch
    $('.bootstrap-switch').each(function () {
        $this = $(this);
        data_on_label = $this.data('on-label') || '';
        data_off_label = $this.data('off-label') || '';

        $this.bootstrapSwitch({
            onText: data_on_label,
            offText: data_off_label
        });
    });
});


$(document).on('click', '.navbar-toggle', function () {
    var $toggle = $(this);

    if (blackDashboard.misc.navbar_menu_visible == 1) {
        $html.removeClass('nav-open');
        blackDashboard.misc.navbar_menu_visible = 0;
        setTimeout(function () {
            $toggle.removeClass('toggled');
            $('.bodyClick').remove();
        }, 550);

    } else {
        setTimeout(function () {
            $toggle.addClass('toggled');
        }, 580);

        var div = '<div class="bodyClick"></div>';
        $(div).appendTo('body').click(function () {
            $html.removeClass('nav-open');
            blackDashboard.misc.navbar_menu_visible = 0;
            setTimeout(function () {
                $toggle.removeClass('toggled');
                $('.bodyClick').remove();
            }, 550);
        });

        $html.addClass('nav-open');
        blackDashboard.misc.navbar_menu_visible = 1;
    }
});


$(window).resize(function () {
    // reset the seq for charts drawing animations
    seq = seq2 = 0;

    if ($full_screen_map.length == 0 && $('.bd-docs').length == 0) {
        var isExpanded = $navbar.find('[data-toggle="collapse"]').attr("aria-expanded");
        if ($navbar.hasClass('bg-white') && $(window).width() > 991) {
            $navbar.removeClass('bg-white').addClass('navbar-transparent');
        } else if ($navbar.hasClass('navbar-transparent') && $(window).width() < 991 && isExpanded != "false") {
            $navbar.addClass('bg-white').removeClass('navbar-transparent');
        }
    }
});

blackDashboard = {
    misc: {
        navbar_menu_visible: 0
    },

    initMinimizeSidebar: function () {
        0 != $(".sidebar-mini").length && (sidebar_mini_active = !0),
                $(".minimize-sidebar").click(function () {
            1 == sidebar_mini_active ? ($body.removeClass("sidebar-mini"), sidebar_mini_active = !1, blackDashboard.showSidebarMessage("Sidebar mini deactivated...")) :
                    ($body.addClass("sidebar-mini"), sidebar_mini_active = !0, blackDashboard.showSidebarMessage("Sidebar mini activated..."));

            var a = setInterval(function () {
                window.dispatchEvent(new Event("resize"))
            }, 180);
            setTimeout(function () {
                clearInterval(a)
            }, 1e3);

            if (sidebar_mini_active) {
                // find all notification_items and hide
                $('.notification_span').hide();
                $('.version-info').hide();
            } else {
                $('.notification_span').show();
                $('.version-info').show();
            }
        })
    },

    showSidebarMessage: function (message) {
        try {
            $.notify({
                icon: "far fa-bell",
                message: message
            }, {
                type: "primary",
                timer: 1000,
                placement: {
                    from: 'top',
                    align: 'right'
                }
            });
        } catch (e) {
            console.log('Notify library is missing, please make sure you have the notifications library added.');
        }

    }

};

function hexToRGB(hex, alpha) {
    var r = parseInt(hex.slice(1, 3), 16),
            g = parseInt(hex.slice(3, 5), 16),
            b = parseInt(hex.slice(5, 7), 16);

    if (alpha) {
        return "rgba(" + r + ", " + g + ", " + b + ", " + alpha + ")";
    } else {
        return "rgb(" + r + ", " + g + ", " + b + ")";
    }
}


function flash_message(message, type, important = false) {
    var timer = (important ? 300000 : 1000);
    try {
        $.notify({
            icon: "far fa-bell",
            message: message
        }, {
            type: type,
            timer: timer,
            placement: {
                from: 'top',
                align: 'right'
            }
        });
    } catch (e) {
        console.log('Notify library is missing, please make sure you have the notifications library added.');
}

}