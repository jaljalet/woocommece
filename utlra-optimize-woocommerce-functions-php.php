<?php
/**
 * ULTRA-OPTIMIZED & SECURE FUNCTIONS.PHP FOR BUSINESS WEBSITE
 * Чистый код без плагинов-мусорщиков
 */

// === 1. ОПТИМИЗАЦИЯ СКОРОСТИ И ОЧИСТКА ===
add_action('init', function() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('wp_resource_hints', function($urls, $relation_type) {
        if ('dns-prefetch' === $relation_type) {
            $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/');
            $urls = array_diff($urls, array($emoji_svg_url));
        }
        return $urls;
    }, 100, 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'feed_links', 2);
});

add_action('wp_enqueue_scripts', function() {
    if (!is_user_logged_in()) { wp_dequeue_style('dashicons'); }
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('global-styles');
}, 100);


// === 2. БЕЗОПАСНОСТЬ (SECURITY HARDENING) ===
add_filter('xmlrpc_enabled', '__return_false');

add_filter('rest_endpoints', function($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) { unset($endpoints['/wp/v2/users']); }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) { unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']); }
    return $endpoints;
});

add_action('template_redirect', function() {
    if (is_author()) {
        global $wp_query; $wp_query->set_404(); status_header(404); locate_template('404.php', true, true); exit;
    }
});

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');

add_filter('login_errors', function() { return 'Ошибка: Неверные данные для входа.'; });


// === 3. ПОЛНОЕ ОТКЛЮЧЕНИЕ КОММЕНТАРИЕВ ===
add_action('admin_init', function () {
    global $pagenow; if ($pagenow === 'edit-comments.php') { wp_redirect(admin_url()); exit; }
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments'); remove_post_type_support($post_type, 'trackbacks');
        }
    }
});
add_filter('comments_open', '__return_false', 20);
add_filter('pings_open', '__return_false', 20);
add_filter('comments_array', '__return_empty_array', 10, 2);
add_action('admin_menu', function () { remove_menu_page('edit-comments.php'); });
add_action('wp_before_admin_bar_render', function () { global $wp_admin_bar; $wp_admin_bar->remove_menu('comments'); });
add_action('wp_enqueue_scripts', function () { wp_dequeue_script('comment-reply'); }, 100);

/**
 * БЛОК 5: СКРЫТИЕ ВЕРСИЙ СКРИПТОВ И СТИЛЕЙ ОТ СКАНЕРОВ
 */
function remove_wp_version_strings($src) {
    global $wp_version;
    // Если в ссылке есть версия WordPress или плагина, отрезаем её
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
// Применяем фильтр для стилей и скриптов на фронтенде
if (!is_admin()) {
    add_filter('script_loader_src', 'remove_wp_version_strings', 15);
    add_filter('style_loader_src', 'remove_wp_version_strings', 15);
}

// Блокировка перебора пользователей через ?author=ID и страниц авторов
add_action('template_redirect', function() {
    if (is_author() || isset($_REQUEST['author'])) {
        global $wp_query; $wp_query->set_404(); status_header(404); locate_template('404.php', true, true); exit;
    }
});

/***************************************************************************************************** */
<?php
/**
 * ULTRA-OPTIMIZED & SECURE FUNCTIONS.PHP FOR WOOCOMMERCE SHOP
 * Скорость, защита REST API и разгрузка страниц от Woo-скриптов
 */

// === 1. ОПТИМИЗАЦИЯ СКОРОСТИ И ОЧИСТКА ===
add_action('init', function() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('wp_resource_hints', function($urls, $relation_type) {
        if ('dns-prefetch' === $relation_type) {
            $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/');
            $urls = array_diff($urls, array($emoji_svg_url));
        }
        return $urls;
    }, 100, 2);
});

add_action('wp_enqueue_scripts', function() {
    if (!is_user_logged_in()) { wp_dequeue_style('dashicons'); }
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('global-styles');
}, 100);


// === 2. ЖЕСТКАЯ РАЗГРУЗКА СТРАНИЦ ОТ WOOCOMMERCE SCRIPTS ===
add_action('wp_enqueue_scripts', function() {
    if (!class_exists('WooCommerce')) return;
    
    // Скрипты Woo грузятся ТОЛЬКО на страницах магазина/корзины/аккаунта
    if (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) { return; }

    wp_dequeue_style('woocommerce-layout');
    wp_dequeue_style('woocommerce-smallscreen');
    wp_dequeue_style('woocommerce-general');
    wp_dequeue_style('generic-woocommerce-styles');
    wp_dequeue_script('wc-add-to-cart');
    wp_dequeue_script('woocommerce');
    wp_dequeue_script('wc-cart-fragments'); // Отключаем микро-запросы корзины на обычных страницах
}, 99);

add_action('get_header', function() {
    if (class_exists('WooCommerce')) { remove_action('wp_head', array($GLOBALS['woocommerce'], 'generator')); }
});


// === 3. БЕЗОПАСНОСТЬ (REST API & SCANNING PROTECTION) ===
add_filter('xmlrpc_enabled', '__return_false');

add_filter('rest_endpoints', function($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) { unset($endpoints['/wp/v2/users']); }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) { unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']); }
    return $endpoints;
});

add_action('template_redirect', function() {
    if (is_author()) {
        global $wp_query; $wp_query->set_404(); status_header(404); locate_template('404.php', true, true); exit;
    }
});

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');

add_filter('login_errors', function() { return 'Ошибка: Неверные данные для входа.'; });


/**
 * БЛОК 5: СКРЫТИЕ ВЕРСИЙ СКРИПТОВ И СТИЛЕЙ ОТ СКАНЕРОВ
 */
function remove_wp_version_strings($src) {
    global $wp_version;
    // Если в ссылке есть версия WordPress или плагина, отрезаем её
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
// Применяем фильтр для стилей и скриптов на фронтенде
if (!is_admin()) {
    add_filter('script_loader_src', 'remove_wp_version_strings', 15);
    add_filter('style_loader_src', 'remove_wp_version_strings', 15);
}

// Блокировка перебора пользователей через ?author=ID и страниц авторов
add_action('template_redirect', function() {
    if (is_author() || isset($_REQUEST['author'])) {
        global $wp_query; $wp_query->set_404(); status_header(404); locate_template('404.php', true, true); exit;
    }
});
