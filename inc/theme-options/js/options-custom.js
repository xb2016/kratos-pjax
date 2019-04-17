jQuery(document).ready(function($) {
    $('.of-color').wpColorPicker();
    $('.of-radio-img-img').click(function(){
        $(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
        $(this).addClass('of-radio-img-selected');
    });
    $('.of-radio-img-label').hide();
    $('.of-radio-img-img').show();
    $('.of-radio-img-radio').hide();
    if ( $('.nav-tab-wrapper').length > 0 ) {
        options_framework_tabs();
    }
    function options_framework_tabs() {
        var $group = $('.group'),
            $navtabs = $('.nav-tab-wrapper a'),
            active_tab = '';
        $group.hide();
        if ( typeof(localStorage) != 'undefined' ) {
            active_tab = localStorage.getItem('active_tab');
        }
        if ( active_tab != '' && $(active_tab).length ) {
            $(active_tab).fadeIn();
            $(active_tab + '-tab').addClass('nav-tab-active');
        } else {
            $('.group:first').fadeIn();
            $('.nav-tab-wrapper a:first').addClass('nav-tab-active');
        }
        $navtabs.click(function(e) {
            e.preventDefault();
            $navtabs.removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active').blur();
            if (typeof(localStorage) != 'undefined' ) {
                localStorage.setItem('active_tab', $(this).attr('href') );
            }
            var selected = $(this).attr('href');
            $group.hide();
            $(selected).fadeIn();
        });
    }
});