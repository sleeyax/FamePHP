/*
 * FamePHP
 *
 * Facebook Messenger bot framework
 *
 * @copyright Copyright (c) 2018 - 2019
 * @author Sleeyax (https://github.com/sleeyax)
 * @link https://github.com/sleeyax/FamePHP
 * @license https://github.com/sleeyax/FamePHP/blob/master/LICENSE
 */

var timeout    = 500;
var closetimer = 0;
var ddmenuitem = 0;

function menu_open() {
    menu_canceltimer();
    menu_close();
    ddmenuitem = $(this).find('ul').css('visibility', 'visible');
}

function menu_close() {
    if (ddmenuitem) ddmenuitem.css('visibility', 'hidden');
}

function menu_timer() {
    closetimer = window.setTimeout(menu_close, timeout);
}

function menu_canceltimer() {
    if (closetimer) {
        window.clearTimeout(closetimer);
        closetimer = null;
    }
}

$(document).ready(function() {
    $('#file-nav > li').bind('mouseover', menu_open);
    $('#file-nav > li').bind('mouseout', menu_timer);
});

document.onclick = menu_close;
