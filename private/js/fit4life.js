// wait until the page and jQuery have loaded before running the code below
jQuery(document).ready(function($){
                       
    // stop our admin menus from collapsing
    if( $('body[class*=" fit4life_"]').length || $('body[class*=" post-type-fit4life_"]').length ) {
    
        $fit4life_menu_li = $('#toplevel_page_fit4life_dashboard_admin_page');
    
        $fit4life_menu_li
        .removeClass('wp-not-current-submenu')
        .addClass('wp-has-current-submenu')
        .addClass('wp-menu-open');
    
        $('a:first',$fit4life_menu_li)
        .removeClass('wp-not-current-submenu')
        .addClass('wp-has-current-submenu')
        .addClass('wp-menu-open');
    
    }
                       
});
