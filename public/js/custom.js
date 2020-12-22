import * as $ from './helper.js'

(function() {

    window.addEventListener('DOMContentLoaded', () =>
    {
        const menuBtn = $.select('.app-navbar #menu-toggle');

        $.toggleMenuIconOnWindowSize(window.innerWidth, menuBtn)
        window.addEventListener('resize', () =>
        {
            if (window.innerWidth <= 768)
            {
                $.addClass(menuBtn, 'fa-bars');
                $.removeClass(menuBtn, 'fa-times');
            }
            else
            {
                $.removeClass(menuBtn, 'fa-bars');
                $.addClass(menuBtn, 'fa-times');
            }
        });

        if ($.select('#menu-toggle'))
        {
            $.select('#menu-toggle').addEventListener('click', (e) =>
            {
                e.preventDefault();

                $.toggleClass($.select('#wrapper'), 'toggled');
                $.toggleMenuIcon(menuBtn);
            });
        }
    });

}())

