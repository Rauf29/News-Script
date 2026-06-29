jQuery(document).ready(function () {

    jQuery('div[data="photo-view"]').hide();
    jQuery('.tab_bar_block_stories li').on('click', function () {
        if (jQuery(this).attr('class') == 'active') {

        } else {
            jQuery('.tab_bar_block_stories li').removeClass('active');
            jQuery(this).addClass('active');

            if (jQuery(this).attr('data-id') == 'video') {
                jQuery(this).parents('.tab_block_stories').find('.tab_block_view_stories > div')
                    .hide();
                jQuery(this).parents('.tab_block_stories').find(
                    '.tab_block_view_stories > div[data="video-view"]').show();
            } else {
                jQuery(this).parents('.tab_block_stories').find('.tab_block_view_stories > div')
                    .hide();
                jQuery(this).parents('.tab_block_stories').find(
                    '.tab_block_view_stories > div[data="photo-view"]').show();

                jQuery('#photoStories ul.slides li').css({
                    'width': '220px'
                });
                // jQuery('.flexslider').resize();
                /*jQuery('#photoStories').flexslider({
                    animation: "slide",
                    controlNav: false,
                    animationLoop: false,
                    slideshow: false,
                    itemWidth: 220,
                    slideshowSpeed: 3000,
                    move: 1,
                    itemMargin: 15
                });*/
            }
        }
    });



    if (jQuery('#videoFlex').length) {
        jQuery('#videoFlex').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 300,
            slideshowSpeed: 3000,
            move: 1,
            itemMargin: 15
        });
    }

    if (jQuery('#videostories').length) {
        jQuery('#videostories').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 220,
            slideshowSpeed: 3000,
            move: 1,
            itemMargin: 7
        });
    }

    if (jQuery('#photoStories').length) {
        jQuery('#photoStories').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 220,
            move: 1,
            itemMargin: 7
        });
    }

    if (jQuery('#podcastFlex').length) {
        jQuery('#podcastFlex').flexslider({
            animation: "slide",
            controlNav: true,
            animationLoop: false,
            slideshow: false,
            itemWidth: 400,
            move: 1,
            itemMargin: 6
        });
    }

    if (jQuery('#static_opinion').length) {
        jQuery('#static_opinion').flexslider({
            animation: "slide",
            controlNav: true,
            directionNav: false,
            move: 1
        });
    }

    if (jQuery('#home-lead-album').length) {
        jQuery('#home-lead-album').flexslider({
            animation: "slide",
            controlNav: "thumbnails",
            directionNav: true,
            animationLoop: false,
            slideshow: false,
            move: 1
        });
    }


    var dropdown_search_open = false,
        click_srch_allow = true;
    jQuery('#dropdownSearch').on('click', function () {
        // console.log(click_srch_allow)
        if (click_srch_allow) {
            click_srch_allow = false
            if (dropdown_search_open) {
                jQuery('.open_icon', this).show()
                jQuery('.close_icon', this).hide();
                jQuery('.dropdownSearch').slideUp();
                dropdown_search_open = false
            } else {
                jQuery('.open_icon', this).hide()
                jQuery('.close_icon', this).show();
                jQuery('.dropdownSearch').slideDown()
                dropdown_search_open = true
            }

            var srchClickInterval = setInterval(function () {
                click_srch_allow = true;
                clearInterval(srchClickInterval)
            }, 500);
        }
    });

    jQuery('select[name="bd_division"]').on('change', function () {
        var sel_div = jQuery(this).val();
        jQuery('select[name="bd_district"] option').css('display', 'none');
        jQuery('select[name="bd_district"]').val('');
        jQuery('select[name="bd_thana"]').val('');

        jQuery('select[name="bd_district"] .dist-' + sel_div).css('display', 'block');
    });

    jQuery('select[name="bd_district"]').on('change', function () {
        var sel_div = jQuery(this).val();
        jQuery('select[name="bd_thana"] option').css('display', 'none');
        jQuery('select[name="bd_thana"]').val('');

        jQuery('select[name="bd_thana"] .thana-' + sel_div).css('display', 'block');
    });

    jQuery('.dist_news_srch').on('click', function () {
        var div_data = '',
            dist_data = '';
        if (jQuery('select[name="bd_division"] option:selected').attr('data-val'))
            div_data = jQuery('select[name="bd_division"] option:selected').attr('data-val');

        if (jQuery('select[name="bd_district"] option:selected').attr('data-val'))
            dist_data = jQuery('select[name="bd_district"] option:selected').attr('data-val');

        var thana_data = jQuery('select[name="bd_thana"]').val();

        if (div_data == '') {
            alert('please select the division first');
            jQuery('select[name="bd_division"]').focus();
            return false;
        }

        URL = div_data;
        if (dist_data != '') URL = dist_data;
        if (thana_data != '') URL = thana_data;
        window.location.href = URL;

        return false;
    });


    jQuery('#back-top').click(function () {
        jQuery('body,html').animate({
            scrollTop: 0
        }, 'fast');
        return false;
    });


    // Show Search Box
    jQuery('.search_icon').click(function () {
        jQuery('div.search_box').show();
    });
    jQuery('.cross_btn').click(function () {
        jQuery('div.search_box').hide();
    });


    // Menu Toggle Click
    var dropdown_menu_open = false,
        click_allow = true;
    jQuery('.dropdownAllMenuBut').on('click', function () {
        if (click_allow) {
            click_allow = false
            if (dropdown_menu_open) {
                jQuery('.open_icon',this).show()
                jQuery('.close_icon',this).hide();
                jQuery('.dropdownAllMenu').slideUp();
                dropdown_menu_open = false
            } else {
                jQuery('.open_icon',this).hide()
                jQuery('.close_icon',this).show();
                jQuery('.dropdownAllMenu').slideDown()
                dropdown_menu_open = true
            }

            var menuClickInterval = setInterval(function () {
                click_allow = true;
                clearInterval(menuClickInterval)
            }, 500);
        }
    })

    jQuery('.dropdownAllMenuClose').on('click', function () {
        jQuery('.dropdownAllMenu').slideUp();
        jQuery('.open_icon').show();
        jQuery('.close_icon').hide();
        dropdown_menu_open = false;
    })

    jQuery(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdownAllMenuIcon, .dropdownAllMenu').length && dropdown_menu_open) {
            jQuery('.dropdownAllMenu').slideUp();
            jQuery('.open_icon').show();
            jQuery('.close_icon').hide();
            dropdown_menu_open = false;
        }
    })


    jQuery('#dropdownNotification').hover(function () {
        jQuery(this).find('span.badge').hide();
    });



    // Notification dropdown click toggle
    jQuery('#dropdownNotification').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $container = jQuery(this).closest('.dropdown_menu_hover');
        var $dropdown = $container.find(".dropdown_menu");

        if ($dropdown.is(':visible')) {
            $dropdown.fadeOut();
            $container.parent('div').find('nav').css({'opacity': '1'});
            jQuery('body').find('#dynamicArrow').remove();
        } else {
            jQuery('.dropdown_menu_hover').find(".dropdown_menu").not($dropdown).fadeOut();
            $container.parent('div').find('nav').css({'opacity': '0'});
            $dropdown.fadeIn();

            var w = (parseInt($container.find('a:first-child').width()) - (parseInt($container.find('a:first-child').css('padding-left').replace('px', '')) + parseInt($container.find('a:first-child').css('padding-right').replace('px', '')))) / 2 + parseInt($container.offset().left);
            var ww = parseInt($dropdown.offset().left);
            w = w - ww;

            jQuery('body').find('#dynamicArrow').remove();
            var css = '.dropdown-menu:before{ left:' + w + 'px !important; right:' + (w + 10) + 'px !important;}.dropdown-menu:after{ left:' + (w + 1) + 'px !important; right:' + (w + 11) + 'px !important}';
            jQuery('body').append('<div id="dynamicArrow"><style>' + css + '</style></div>');
        }
    });

    // Notification close button
    jQuery('.dropdownNotificationClose').on('click', function (e) {
        e.stopPropagation();
        jQuery('.dropdownNotification').fadeOut();
        jQuery('.dropdown_menu_hover').parent('div').find('nav').css({'opacity': '1'});
        jQuery('body').find('#dynamicArrow').remove();
    });

    // Close notification on click outside
    jQuery(document).on('click', function(e) {
        if (!jQuery(e.target).closest('.dropdownNotification, #dropdownNotification, .dropdownNotificationClose').length) {
            jQuery('.dropdownNotification').fadeOut();
            jQuery('.dropdown_menu_hover').parent('div').find('nav').css({'opacity': '1'});
            jQuery('body').find('#dynamicArrow').remove();
        }
    });


    // latest popuar toggle
    jQuery('.tab_bar_block_new li').on('click', function () {

        if (!jQuery(this).hasClass('active')) {
            var tabIndex = jQuery(this).attr('tabIndex');
            jQuery(this).parents('.tab_block_one').find('.tab_bar_block_new li').removeClass('active');
            jQuery(this).addClass('active');
            jQuery(this).parents('.tab_block_one').find('.list_display_block1').hide();
            jQuery(this).parents('.tab_block_one').find('#' + tabIndex).fadeIn();
        }

    });

    // mobile menu Toggle
    jQuery('.mobile_menu_toggle_container i.menu_open').on('click', function () {
        jQuery('.mobile_menu_toggle_container i.menu_close').show();
        jQuery('.mobile_menu_toggle_container i.menu_open').hide();
        jQuery('#mySidenav').show();
        jQuery('header.non-sticky').css("position", "sticky");
    });
    
    function closeMobileMenu() {
        jQuery('.mobile_menu_toggle_container i.menu_close').hide();
        jQuery('.mobile_menu_toggle_container i.menu_open').show();
        jQuery('#mySidenav').hide();
        jQuery('header.non-sticky').css("position", "relative");
    }
    jQuery('.mobile_menu_toggle_container i.menu_close').on('click', closeMobileMenu);
    jQuery('#mobileMenuClose').on('click', closeMobileMenu);


    jQuery("#fontPlus").click(function () {
        var $el = jQuery('.dtl_content_section');
        if (!$el.length) return;
        var size = $el.data('fontSize') || 16;
        if (size >= 30) return;
        size += 2;
        $el.data('fontSize', size);
        $el.find('*').css({ 'font-size': size + 'px', 'line-height': (size * 1.8) + 'px' });
    });

    jQuery("#fontmines").click(function () {
        var $el = jQuery('.dtl_content_section');
        if (!$el.length) return;
        var size = $el.data('fontSize') || 16;
        if (size <= 10) return;
        size -= 2;
        $el.data('fontSize', size);
        $el.find('*').css({ 'font-size': size + 'px', 'line-height': (size * 1.8) + 'px' });
    });



});


jQuery(function () {
    jQuery('.album_all_img a').lightbox({
        'resizeDuration': 200,
        'albumLabel':true,
    });
});

// print
function printDiv() {
    window.print();
}

function myFunction(x) {
    if (!x.matches) {
        jQuery("#back-top").hide();
        jQuery(window).scroll(function () {
            if (jQuery(window).scrollTop() > 90) {
                jQuery('#back-top').fadeIn();
                //jQuery('header.non-sticky').hide();
                jQuery('header.sticky').show();
            } else {
                jQuery('#back-top').fadeOut();
                jQuery('header.sticky').hide();
                //jQuery('header.non-sticky').show();
            }
        });
    }
}

var x = window.matchMedia("(max-width: 990px)")
myFunction(x)
x.addListener(myFunction)

