<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'twentyseventeen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyseventeen' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'twentyseventeen-featured-image', 2000, 1200, true );

	add_image_size( 'twentyseventeen-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'twentyseventeen' ),
		'social' => __( 'Social Links Menu', 'twentyseventeen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', twentyseventeen_fonts_url() ) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'twentyseventeen' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

			// Assign a menu to the "social" location.
			'social' => array(
				'name' => __( 'Social Links Menu', 'twentyseventeen' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	);

	/**
	 * Filters Twenty Seventeen array of starter content.
	 *
	 * @since Twenty Seventeen 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'twentyseventeen_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'twentyseventeen_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( twentyseventeen_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param $content_width integer
	 */
	$GLOBALS['content_width'] = apply_filters( 'twentyseventeen_content_width', $content_width );
}
add_action( 'template_redirect', 'twentyseventeen_content_width', 0 );

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'twentyseventeen' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentyseventeen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'twentyseventeen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'twentyseventeen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'twentyseventeen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyseventeen_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'twentyseventeen_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyseventeen_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'twentyseventeen_pingback_header' );

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"' ; } ?>
    ><?php echo twentyseventeen_custom_colors_css();
    ?>
</style>
<?php }
add_action( 'wp_head', 'twentyseventeen_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function twentyseventeen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'twentyseventeen-style', get_stylesheet_uri() );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'twentyseventeen-style' ), '1.0' );
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'twentyseventeen-style' ), '1.0' );
		wp_style_add_data( 'twentyseventeen-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentyseventeen-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'twentyseventeen-style' ), '1.0' );
	wp_style_add_data( 'twentyseventeen-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentyseventeen-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$twentyseventeen_l10n = array(
		'quote'          => twentyseventeen_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'twentyseventeen-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array(), '1.0', true );
		$twentyseventeen_l10n['expand']         = __( 'Expand child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['collapse']       = __( 'Collapse child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['icon']           = twentyseventeen_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
	}

	wp_enqueue_script( 'twentyseventeen-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_localize_script( 'twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'twentyseventeen_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentyseventeen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'twentyseventeen_front_page_template' );







/*funcion general json*/
function show_fields( $object, $field_name, $request ) {
  return get_post_meta( $object[ 'id' ], $field_name, true );
}
/*funcion general json*/


/*SERVICIOS DE PQR*/
add_action( 'init', 'add_role_pqr' );
function add_role_pqr(){
    remove_role('pqr');
    add_role(
        'pqr',
        'pqr',
        [
            'read'                  => true,
            'edit_post'             => true,
            'upload_files'          => true,
            'publish_posts'         => true,
            // 'delete_posts'          => true,
            'edit_published_posts'  => true,
        ]
        );
}

/* costum fiel*/
add_action('rest_api_init', 'register_custom_fields');
function register_custom_fields()
{
    register_rest_field(
        'pqr',
      	'titulo_de_la_pagina',
        array(
            'get_callback' => 'show_fields'
        )
    );
}

/* costum fiel*/

add_action( 'init', 'pqr_init' );
function pqr_init() {
    $labels = array(
        'name'              => _x( 'PQRs', 'Consulta de solicitudes', 'your-plugin-textdomain' ),
        'singular_name'     => _x( 'PQR', 'post type general name', 'your-plugin-textdomain' ),
        'menu_name'         => _x( 'PQR', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'    => _x( 'pqr', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'           => _x( 'Añadir nuevo', 'viaje', 'your-plugin-textdomain' ),
        'add_new_item'      => __( 'Añadir nuevo', 'your-plugin-textdomain' ),
        'new_item'          => __( 'Nuevo servicio pqr', 'your-plugin-textdomain' ),
        'edit_item'         => __( 'Editar servicio PQR', 'your-plugin-textdomain' ),
        'view_item'         => __( 'Ver Servicio PQR', 'your-plugin-textdomain' ),
        'all_items'         => __( 'Todos los servicios', 'your-plugin-textdomain' ),
        'search_items'      => __( 'Buscar servicios', 'your-plugin-textdomain' ),
        'parent_item_colon' => __( 'servicios padre', 'your-plugin-textdomain' ),
        'not_found'         => __( 'No hemos encontrado servicios.', 'your-plugin-textdomain' ),
        'not_found_in_trash'=> __( 'No hemos encontrado servicios en la papelera', 'your-plugin-textdomain' ),
    );
    $args = array(
        'labels'            => $labels,
        'description'       => __('Description', 'your-plugin-textdomain'),
        'public'            => true,
        'public_queryable'  => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_in_menu'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'pqr' ),
        'capability_type'   => 'post',
        'has_archive'       => true,
        'hierarchical'      => false,
        'menu_position'     => null,
        'menu_icon'         => 'dashicons-admin-multisite',
        'supports'          => array( 'title', 'editor', 'author', 'thumbnail' )
    );
    register_post_type( 'pqr', $args );
}
/*CAMPO PERSONALIZADOS PQR*/
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_titulo-de-la-pagina',
		'title' => 'Título de la página',
		'fields' => array (
			array (
				'key' => 'field_5b2f28c2a5fa5',
				'label' => 'Título de la página',
				'name' => 'titulo_de_la_pagina',
				'type' => 'text',
				'instructions' => 'ingrese el titulo de la página ',
				'required' => 1,
				'default_value' => 'Consulta tus solicitudes	y reclamos',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => 50,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'pqr',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}




/*SERVICIOS DE ¿Cómo se enteró del proyecto?*/

add_action( 'init', 'add_role_tipo_documento' );
 function add_role_tipo_documento(){
    remove_role('tipo_documento');
    add_role(
        'tipo_documento',
        'tipo_documento',
        [
            'read'                  => true,
            'edit_post'             => true,
            'upload_files'          => true,
            'publish_posts'         => true,
            'delete_posts'          => true,
            'edit_published_posts'  => true,
        ]
        );
}



add_action( 'init', 'tipo_documento_init' );
function tipo_documento_init() {
    $labels = array(
        'name'              => _x( 'tipo_documento', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'     => _x( 'tipo_documento', 'post type general name', 'your-plugin-textdomain' ),
        'menu_name'         => _x( 'Mis tipo_documento', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'    => _x( 'tipo_documento', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'           => _x( 'Añadir nuevo', 'tipo_documento', 'your-plugin-textdomain' ),
        'add_new_item'      => __( 'Añadir nuevo tipo_documento', 'your-plugin-textdomain' ),
        'new_item'          => __( 'Nuevo tipo_documento', 'your-plugin-textdomain' ),
        'edit_item'         => __( 'Editar tipo_documento', 'your-plugin-textdomain' ),
        'view_item'         => __( 'Ver tipo_documento', 'your-plugin-textdomain' ),
        'all_items'         => __( 'Todos los tipo_documento', 'your-plugin-textdomain' ),
        'search_items'      => __( 'Buscar tipo_documento', 'your-plugin-textdomain' ),
        'parent_item_colon' => __( 'tipo_documento padre', 'your-plugin-textdomain' ),
        'not_found'         => __( 'No hemos encontrado tipo_documento.', 'your-plugin-textdomain' ),
        'not_found_in_trash'=> __( 'No hemos encontrado tipo_documento en la papelera', 'your-plugin-textdomain' ),
    );

    $args = array(
        'labels'            => $labels,
        'description'       => __('Description', 'your-plugin-textdomain'),
        'public'            => true,
        'public_queryable'  => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'tipo_documento' ),
        'capability_type'   => 'post',
        'has_archive'       => true,
        'hierarchical'      => false,
        'menu_position'     => null,
        'menu_icon'         => 'dashicons-admin-multisite',
        'supports'          => array( 'title', 'editor', 'author', 'thumbnail' )
    );

    register_post_type( 'tipo_documento', $args );
}


add_action('rest_api_init', 'register_custom_fields_tipo_documento');
function register_custom_fields_tipo_documento()
{

    register_rest_field(
        'tipo_documento','id_tipo_documento',
        array(
            'get_callback' => 'show_fields'
        )
    );
}
/*CAMPO PERSONALIZADOS como_se_entero_del_proyecto*/
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_titulo-tipo-documento',
		'title' => 'id_tipo_documento',
		'fields' => array (
			array (
				'key' => 'field_4546731',
				'label' => 'id_tipo_documento',
				'name' => 'id_tipo_documento',
				'type' => 'text',
				'instructions' => 'ingrese el titulo_tipo_documento',
				'required' => 1,
				'default_value' => ' ',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => 50,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'tipo_documento',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
/*SERVICIOS DE tipo_documento*/
/*SERVICIOS DE tipo_documento*/



/*SERVICIOS DE ¿Cómo se enteró del proyecto?*/

add_action( 'init', 'add_role_datocomo_entero' );
 function add_role_datocomo_entero(){
    remove_role('datocomo_entero');
    add_role(
        'datocomo_entero',
        'datocomo_entero',
        [
            'read'                  => true,
            'edit_post'             => true,
            'upload_files'          => true,
            'publish_posts'         => true,
            'delete_posts'          => true,
            'edit_published_posts'  => true,
        ]
        );
}



add_action( 'init', 'datocomo_entero_init' );
function datocomo_entero_init() {
    $labels = array(
        'name'              => _x( 'datocomo_entero', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'     => _x( 'datocomo_entero', 'post type general name', 'your-plugin-textdomain' ),
        'menu_name'         => _x( 'Mis datocomo_entero', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'    => _x( 'datocomo_entero', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'           => _x( 'Añadir nuevo', 'datocomo_entero', 'your-plugin-textdomain' ),
        'add_new_item'      => __( 'Añadir nuevo datocomo_entero', 'your-plugin-textdomain' ),
        'new_item'          => __( 'Nuevo datocomo_entero', 'your-plugin-textdomain' ),
        'edit_item'         => __( 'Editar datocomo_entero', 'your-plugin-textdomain' ),
        'view_item'         => __( 'Ver datocomo_entero', 'your-plugin-textdomain' ),
        'all_items'         => __( 'Todos los datocomo_entero', 'your-plugin-textdomain' ),
        'search_items'      => __( 'Buscar datocomo_entero', 'your-plugin-textdomain' ),
        'parent_item_colon' => __( 'datocomo_entero padre', 'your-plugin-textdomain' ),
        'not_found'         => __( 'No hemos encontrado datocomo_entero.', 'your-plugin-textdomain' ),
        'not_found_in_trash'=> __( 'No hemos encontrado datocomo_entero en la papelera', 'your-plugin-textdomain' ),
    );

    $args = array(
        'labels'            => $labels,
        'description'       => __('Description', 'your-plugin-textdomain'),
        'public'            => true,
        'public_queryable'  => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'datocomo_entero' ),
        'capability_type'   => 'post',
        'has_archive'       => true,
        'hierarchical'      => false,
        'menu_position'     => null,
        'menu_icon'         => 'dashicons-admin-multisite',
        'supports'          => array( 'title', 'editor', 'author', 'thumbnail' )
    );

    register_post_type( 'datocomo_entero', $args );
}


/*SERVICIOS DE como_se_entero_del_proyecto*/
/*SERVICIOS DE como_se_entero_del_proyecto*/



/*SERVICIOS DE proyectos_vivienda*/
/*SERVICIOS DE proyectos_vivienda*/
add_action( 'init', 'add_role_proyectos_vivienda' );
 function add_role_proyectos_vivienda(){
    remove_role('proyectos_vivienda');
    add_role(
        'proyectos_vivienda',
        'proyectos_vivienda',
        [
            'read'                  => true,
            'edit_post'             => true,
            'upload_files'          => true,
            'publish_posts'         => true,
            // 'delete_posts'          => true,
            'edit_published_posts'  => true,
        ]
        );
}



add_action( 'init', 'proyectos_viviendas_init' );
function proyectos_viviendas_init() {
    $labels = array(
        'name'              => _x( 'proyectos_viviendas', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'     => _x( 'proyectos_viviendas', 'post type general name', 'your-plugin-textdomain' ),
        'menu_name'         => _x( 'Mis proyectos_viviendas', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'    => _x( 'proyectos_viviendas', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'           => _x( 'Añadir nuevo', 'proyectos_vivienda', 'your-plugin-textdomain' ),
        'add_new_item'      => __( 'Añadir nuevo proyectos_vivienda', 'your-plugin-textdomain' ),
        'new_item'          => __( 'Nuevo proyectos_vivienda', 'your-plugin-textdomain' ),
        'edit_item'         => __( 'Editar proyectos_vivienda', 'your-plugin-textdomain' ),
        'view_item'         => __( 'Ver proyectos_vivienda', 'your-plugin-textdomain' ),
        'all_items'         => __( 'Todos los proyectos_viviendas', 'your-plugin-textdomain' ),
        'search_items'      => __( 'Buscar proyectos_viviendas', 'your-plugin-textdomain' ),
        'parent_item_colon' => __( 'proyectos_viviendas padre', 'your-plugin-textdomain' ),
        'not_found'         => __( 'No hemos encontrado proyectos_viviendas.', 'your-plugin-textdomain' ),
        'not_found_in_trash'=> __( 'No hemos encontrado proyectos_viviendas en la papelera', 'your-plugin-textdomain' ),
    );

    $args = array(
        'labels'            => $labels,
        'description'       => __('Description', 'your-plugin-textdomain'),
        'public'            => true,
        'public_queryable'  => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'proyectos_vivienda' ),
        'capability_type'   => 'post',
        'has_archive'       => true,
        'hierarchical'      => false,
        'menu_position'     => null,
        'menu_icon'         => 'dashicons-admin-multisite',
        'supports'          => array( 'title', 'editor', 'author', 'thumbnail' )
    );

    register_post_type( 'proyectos_vivienda', $args );
}





add_action('rest_api_init', 'register_custom_fields_proyectos_vivienda');
function register_custom_fields_proyectos_vivienda()
{

    register_rest_field(
        'proyectos_vivienda','proyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );
    register_rest_field(
        'proyectos_vivienda','descripcion',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','direccion',
        array(
            'get_callback' => 'show_fields'
        )
    );
    register_rest_field(
        'proyectos_vivienda','ubicacion',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','telefono',
        array(
            'get_callback' => 'show_fields'
        )
    );
    register_rest_field(
        'proyectos_vivienda','area_construida',
        array(
            'get_callback' => 'show_fields'
        )
    );
    register_rest_field(
        'proyectos_vivienda','vr_separacion',
        array(
            'get_callback' => 'show_fields'
        )
    );
    register_rest_field(
        'proyectos_vivienda','precio_no_afiliado_sin_acabados',
        array(
            'get_callback' => 'show_fields'
        )
    );
    register_rest_field(
        'proyectos_vivienda','precio_no_afiliado_con_acabados',
        array(
            'get_callback' => 'show_fields'
        )
    );
    register_rest_field(
        'proyectos_vivienda','precio_sin_acabados',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','precio_con_acabados',
        array(
            'get_callback' => 'show_fields'
        )
    );
    register_rest_field(
        'proyectos_vivienda','vr_separacion',
        array(
            'get_callback' => 'show_fields'
        )
    );
    register_rest_field(
        'proyectos_vivienda','plazo_cuota_inicial',
        array(
            'get_callback' => 'show_fields'
        )
    );
    register_rest_field(
        'proyectos_vivienda','fecha_escrituras_probable',
        array(
            'get_callback' => 'show_fields'
        )
    );
    register_rest_field(
        'proyectos_vivienda','trimestre_entrega',
        array(
            'get_callback' => 'show_fields'
        )
    );
    register_rest_field(
        'proyectos_vivienda','vr_gastos_escrituracion',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','vr_administracion',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','srcFotos',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','altFotos',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','InventarioProyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','areaPrivadaproyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','valorProyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','habitacionesProyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','disponiblesProyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','banosProyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','galeria_1',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','galeria_2',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','galeria_3',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','galeria_4',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'proyectos_vivienda','galeria_5',
        array(
            'get_callback' => 'show_fields'
        )
    );



		register_rest_field(
				'proyectos_vivienda','exclusivo_para_afiliados',
				array(
						'get_callback' => 'show_fields'
				)
		);


}



/*CAMPO PERSONALIZADOS proyectos_vivienda*/
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_proyectos_vivienda',
		'title' => 'proyectos_vivienda',
		'fields' => array (
			array (
				'key' => 'field_5b4a76013d6bf',
				'label' => 'Proyecto',
				'name' => 'proyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_2509461',
				'label' => 'Descripción - Inventario-Proyecto',
				'name' => 'InventarioProyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_5c0979efd3c1d',
				'label' => 'Exclusivo para afiliados a Colsubsidio',
				'name' => 'exclusivo_para_afiliados',
				'type' => 'select',
				'choices' => array (
					'no' => 'no',
					'si' => 'si',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),

			array (
				'key' => 'field_5b4a79cfab1c6',
				'label' => 'Direccion',
				'name' => 'direccion',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),


			array (
				'key' => 'field_5b4a79d6ab1c7',
				'label' => 'Ubicación',
				'name' => 'ubicacion',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_5b4a79dfab1c8',
				'label' => 'Teléfono',
				'name' => 'telefono',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b4a79b4ab1c5',
				'label' => 'Email Sala de Ventas',
				'name' => 'descripcion',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b4a79e3ab1c9',
				'label' => 'Área Construida',
				'name' => 'area_construida',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_6166647',
				'label' => 'Área Privada',
				'name' => 'areaPrivadaproyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b4a79e8ab1ca',
				'label' => 'Valor separación',
				'name' => 'vr_separacion',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),

			array (
				'key' => 'field_5b4a7a08ab1cd',
				'label' => 'Precio Afiliado sin Acabados',
				'name' => 'precio_sin_acabados',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),

			array (
				'key' => 'field_5b4a7a13ab1ce',
				'label' => 'Precio Afiliado con Acabados',
				'name' => 'precio_con_acabados',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),

			array (
				'key' => 'field_5b4a79fdab1cc',
				'label' => 'Precio No Afiliado con Acabados',
				'name' => 'precio_no_afiliado_con_acabados',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),

			array (
				'key' => 'field_5b4a79f5ab1cb',
				'label' => 'Precio No Afiliado sin Acabados',
				'name' => 'precio_no_afiliado_sin_acabados',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),


			array (
				'key' => 'field_5b4a7a23ab1d0',
				'label' => 'Plazo Cuota Inicial',
				'name' => 'plazo_cuota_inicial',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b4a7a2aab1d1',
				'label' => 'Fecha de escrituras Probable',
				'name' => 'fecha_escrituras_probable',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b4a7a30ab1d2',
				'label' => 'Trimestre de Entrega',
				'name' => 'trimestre_entrega',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),





			array (
				'key' => 'field_5b4a7a36ab1d3',
				'label' => 'vr_gastos_escrituracion',
				'name' => 'vr_gastos_escrituracion',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),

			array (
				'key' => 'field_5b4a7a3dab1d4',
				'label' => 'vr_administracion',
				'name' => 'vr_administracion',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),

			array (
				'key' => 'field_3730937',
				'label' => 'srcFotos',
				'name' => 'srcFotos',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_5867861',
				'label' => 'altFotos',
				'name' => 'altFotos',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),





			array (
				'key' => 'field_3649458',
				'label' => 'valor Proyecto un titulo',
				'name' => 'valorProyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_1928694',
				'label' => 'habitacionesProyecto',
				'name' => 'habitacionesProyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_2921280',
				'label' => 'disponiblesProyecto',
				'name' => 'disponiblesProyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_89641',
				'label' => 'banosProyecto',
				'name' => 'banosProyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),



//ima g


array (
	'key' => 'field_5b69db0b3ae4a',
	'label' => 'galeria 1',
	'name' => 'galeria_1',
	'type' => 'image',
	'instructions' => 'Agregar imágenes 1380 x 842',
	'save_format' => 'url',
	'preview_size' => 'medium',
	'library' => 'all',
),
array (
	'key' => 'field_5b69db5e3ae4b',
	'label' => 'galeria 2',
	'name' => 'galeria_2',
	'type' => 'image',
	'instructions' => 'Agregar imágenes 1380 x 842',
	'save_format' => 'url',
	'preview_size' => 'medium',
	'library' => 'all',
),
array (
	'key' => 'field_5b69db813ae4c',
	'label' => 'galeria 3',
	'name' => 'galeria_3',
	'type' => 'image',
	'instructions' => 'Agregar imágenes 1380 x 842',
	'save_format' => 'url',
	'preview_size' => 'medium',
	'library' => 'all',
),
array (
	'key' => 'field_5b69db943ae4d',
	'label' => 'galeria 4',
	'name' => 'galeria_4',
	'type' => 'image',
	'instructions' => 'Agregar imágenes 1380 x 842',
	'save_format' => 'url',
	'preview_size' => 'medium',
	'library' => 'all',
),
array (
	'key' => 'field_5b69dbce3ae4e',
	'label' => 'galeria 5',
	'name' => 'galeria_5',
	'type' => 'image',
	'instructions' => 'Agregar imágenes 1380 x 842',
	'save_format' => 'url',
	'preview_size' => 'medium',
	'library' => 'all',
),

//ima g







		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'proyectos_vivienda',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

/*SERVICIOS DE proyectos_vivienda*/
/*SERVICIOS DE proyectos_vivienda*/



add_action( 'init', 'add_role_info_texto_vivienda' );
 function add_role_info_texto_vivienda(){
    remove_role('info_texto_vivienda');
    add_role(
        'info_texto_vivienda',
        'info_texto_vivienda',
        [
            'read'                  => true,
            'edit_post'             => true,
            'upload_files'          => true,
            'publish_posts'         => true,
            // 'delete_posts'          => true,
            'edit_published_posts'  => true,
        ]
        );
}



add_action( 'init', 'info_texto_viviendas_init' );
function info_texto_viviendas_init() {
    $labels = array(
        'name'              => _x( 'info_texto_viviendas', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'     => _x( 'info_texto_viviendas', 'post type general name', 'your-plugin-textdomain' ),
        'menu_name'         => _x( 'Mis info_texto_viviendas', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'    => _x( 'info_texto_viviendas', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'           => _x( 'Añadir nuevo', 'info_texto_vivienda', 'your-plugin-textdomain' ),
        'add_new_item'      => __( 'Añadir nuevo info_texto_vivienda', 'your-plugin-textdomain' ),
        'new_item'          => __( 'Nuevo info_texto_vivienda', 'your-plugin-textdomain' ),
        'edit_item'         => __( 'Editar info_texto_vivienda', 'your-plugin-textdomain' ),
        'view_item'         => __( 'Ver info_texto_vivienda', 'your-plugin-textdomain' ),
        'all_items'         => __( 'Todos los info_texto_viviendas', 'your-plugin-textdomain' ),
        'search_items'      => __( 'Buscar info_texto_viviendas', 'your-plugin-textdomain' ),
        'parent_item_colon' => __( 'info_texto_viviendas padre', 'your-plugin-textdomain' ),
        'not_found'         => __( 'No hemos encontrado info_texto_viviendas.', 'your-plugin-textdomain' ),
        'not_found_in_trash'=> __( 'No hemos encontrado info_texto_viviendas en la papelera', 'your-plugin-textdomain' ),
    );

    $args = array(
        'labels'            => $labels,
        'description'       => __('Description', 'your-plugin-textdomain'),
        'public'            => true,
        'public_queryable'  => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'info_texto_vivienda' ),
        'capability_type'   => 'post',
        'has_archive'       => true,
        'hierarchical'      => false,
        'menu_position'     => null,
        'menu_icon'         => 'dashicons-admin-multisite',
        'supports'          => array( 'title', 'editor', 'author', 'thumbnail' )
    );

    register_post_type( 'info_texto_vivienda', $args );
}





add_action('rest_api_init', 'register_custom_fields_info_texto_vivienda');
function register_custom_fields_info_texto_vivienda()
{

    register_rest_field(
        'info_texto_vivienda','tituloTipoDocumento',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloNombres',
        array(
            'get_callback' => 'show_fields'
        )
    );



    register_rest_field(
        'info_texto_vivienda','titulonumeroDocumento',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloEmail',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloafiliadoColsubsidio',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloCelular',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','textoObligatorio',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloAutorizaDatos',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloTratamientoDatos',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','urlTratamientoDatos',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloavisoPrivacidad',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','urlAvisoPrivacidad',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloCotizador',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloPaso1',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloPaso2',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloPaso3',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloPaso4',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloFiltroCiudad',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloFiltroProyectos',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloFiltroTamano',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','titulofiltroDondeEntero',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloInventarioProyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloareaconstruidaProyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloValorProyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','titulodisponiblesProyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloareaPrivadaproyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','titulohabitacionesProyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','titulobanosProyecto',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloIngresosGrupoFamiliar',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloAhorros',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloCesantias',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloDocumentoIdentidad',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','tituloNombresApellidos',
        array(
            'get_callback' => 'show_fields'
        )
    );

    register_rest_field(
        'info_texto_vivienda','asesorvirtual',
        array(
            'get_callback' => 'show_fields'
        )
    );

		register_rest_field(
				'info_texto_vivienda','tasainteres',
				array(
						'get_callback' => 'show_fields'
				)
		);

		register_rest_field(
				'info_texto_vivienda','uvr_anos_5',
				array(
						'get_callback' => 'show_fields'
				)
		);

			register_rest_field(
					'info_texto_vivienda','uvr_anos_10',
					array(
							'get_callback' => 'show_fields'
					)
			);

			register_rest_field(
					'info_texto_vivienda','uvr_anos_15',
					array(
							'get_callback' => 'show_fields'
					)
			);

			register_rest_field(
					'info_texto_vivienda','uvr_anos_20',
					array(
							'get_callback' => 'show_fields'
					)
			);

			register_rest_field(
					'info_texto_vivienda','texto_legales',
					array(
							'get_callback' => 'show_fields'
					)
			);

			register_rest_field(
					'info_texto_vivienda','texto_doc_requeridos',
					array(
							'get_callback' => 'show_fields'
					)
			);

			register_rest_field(
					'info_texto_vivienda','texto_exclusivos_para_afiliados',
					array(
							'get_callback' => 'show_fields'
					)
			);




}




/*CAMPO PERSONALIZADOS info_texto_vivienda*/
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_info_texto_vivienda',
		'title' => 'info_texto_vivienda',
		'fields' => array (

			array (
				'key' => 'field_9767393',
				'label' => 'tituloTipoDocumento',
				'name' => 'tituloTipoDocumento',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_5026907',
				'label' => 'tituloNombres',
				'name' => 'tituloNombres',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_420653',
				'label' => 'titulonumeroDocumento',
				'name' => 'titulonumeroDocumento',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_8904748',
				'label' => 'tituloEmail',
				'name' => 'tituloEmail',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_5000480',
				'label' => 'tituloafiliadoColsubsidio',
				'name' => 'tituloafiliadoColsubsidio',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_8710102',
				'label' => 'tituloCelular',
				'name' => 'tituloCelular',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_1500352',
				'label' => 'textoObligatorio',
				'name' => 'textoObligatorio',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_3515753',
				'label' => 'tituloAutorizaDatos',
				'name' => 'tituloAutorizaDatos',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_1188642',
				'label' => 'tituloTratamientoDatos',
				'name' => 'tituloTratamientoDatos',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_4760204',
				'label' => 'urlTratamientoDatos',
				'name' => 'urlTratamientoDatos',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_1219408',
				'label' => 'tituloavisoPrivacidad',
				'name' => 'tituloavisoPrivacidad',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_7754455',
				'label' => 'urlAvisoPrivacidad',
				'name' => 'urlAvisoPrivacidad',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_9409207',
				'label' => 'tituloCotizador',
				'name' => 'tituloCotizador',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_8111500',
				'label' => 'tituloPaso1',
				'name' => 'tituloPaso1',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_885078',
				'label' => 'tituloPaso2',
				'name' => 'tituloPaso2',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_8404931',
				'label' => 'tituloPaso3',
				'name' => 'tituloPaso3',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_538122',
				'label' => 'tituloPaso4',
				'name' => 'tituloPaso4',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_1270626',
				'label' => 'tituloFiltroCiudad',
				'name' => 'tituloFiltroCiudad',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_4106456',
				'label' => 'tituloFiltroProyectos',
				'name' => 'tituloFiltroProyectos',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_4266894',
				'label' => 'tituloFiltroTamano',
				'name' => 'tituloFiltroTamano',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_720606',
				'label' => 'titulofiltroDondeEntero',
				'name' => 'titulofiltroDondeEntero',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_9154103',
				'label' => 'tituloInventarioProyecto',
				'name' => 'tituloInventarioProyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_3816341',
				'label' => 'tituloareaconstruidaProyecto',
				'name' => 'tituloareaconstruidaProyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_9509373',
				'label' => 'tituloValorProyecto',
				'name' => 'tituloValorProyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_7401689',
				'label' => 'titulodisponiblesProyecto',
				'name' => 'titulodisponiblesProyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_2265708',
				'label' => 'tituloareaPrivadaproyecto',
				'name' => 'tituloareaPrivadaproyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_850246',
				'label' => 'titulohabitacionesProyecto',
				'name' => 'titulohabitacionesProyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_2160184',
				'label' => 'titulobanosProyecto',
				'name' => 'titulobanosProyecto',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_214096',
				'label' => 'tituloIngresosGrupoFamiliar',
				'name' => 'tituloIngresosGrupoFamiliar',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_665795',
				'label' => 'tituloAhorros',
				'name' => 'tituloAhorros',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_256779',
				'label' => 'tituloCesantias',
				'name' => 'tituloCesantias',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_889582',
				'label' => 'tituloDocumentoIdentidad',
				'name' => 'tituloDocumentoIdentidad',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),

			array (
				'key' => 'field_66753',
				'label' => 'tituloNombresApellidos',
				'name' => 'tituloNombresApellidos',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),




			array (
				'key' => 'field_16057',
				'label' => 'asesorvirtual',
				'name' => 'asesorvirtual',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),



			array (
				'key' => 'field_40652',
				'label' => 'tasainteres',
				'name' => 'tasainteres',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),




			array (
				'key' => 'field_27243',
				'label' => 'uvr_anos_5',
				'name' => 'uvr_anos_5',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),


			array (
				'key' => 'field_39598',
				'label' => 'uvr_anos_10',
				'name' => 'uvr_anos_10',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),


				array (
					'key' => 'field_64740',
					'label' => 'uvr_anos_15',
					'name' => 'uvr_anos_15',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),


				array (
					'key' => 'field_90701',
					'label' => 'uvr_anos_20',
					'name' => 'uvr_anos_20',
					'type' => 'text',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),




				array (
					'key' => 'field_6962',
					'label' => 'texto_legales',
					'name' => 'texto_legales',
					'type' => 'textarea',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),



				array (
					'key' => 'field_31640',
					'label' => 'texto_doc_requeridos',
					'name' => 'texto_doc_requeridos',
					'type' => 'textarea',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),



				array (
					'key' => 'field_e65962',
					'label' => 'Mensaje para proyectos exclusivos para afiliados a Colsubsidio',
					'name' => 'texto_exclusivos_para_afiliados',
					'type' => 'textarea',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				)





		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'info_texto_vivienda',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}







/*SERVICIOS DE idioma_vivienda*/
/*SERVICIOS DE idioma_vivienda*/



/*SERVICIOS DE idioma_vivienda*/
/*SERVICIOS DE idioma_vivienda*/





/*SERVICIOS DE galeria_imagnes*/
/*SERVICIOS DE galeria_imagnes*/



add_action( 'init', 'add_role_galeria_imagenes' );
 function add_role_galeria_imagenes(){
    remove_role('galeria_imagenes');
    add_role(
        'galeria_imagenes',
        'galeria_imagenes',
        [
            'read'                  => true,
            'edit_post'             => true,
            'upload_files'          => true,
            'publish_posts'         => true,
            // 'delete_posts'          => true,
            'edit_published_posts'  => true,
        ]
        );
}



add_action( 'init', 'galeria_imageness_init' );
function galeria_imageness_init() {
    $labels = array(
        'name'              => _x( 'galeria_imageness', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'     => _x( 'galeria_imageness', 'post type general name', 'your-plugin-textdomain' ),
        'menu_name'         => _x( 'Mis galeria_imageness', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'    => _x( 'galeria_imageness', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'           => _x( 'Añadir nuevo', 'galeria_imagenes', 'your-plugin-textdomain' ),
        'add_new_item'      => __( 'Añadir nuevo galeria_imagenes', 'your-plugin-textdomain' ),
        'new_item'          => __( 'Nuevo galeria_imagenes', 'your-plugin-textdomain' ),
        'edit_item'         => __( 'Editar galeria_imagenes', 'your-plugin-textdomain' ),
        'view_item'         => __( 'Ver galeria_imagenes', 'your-plugin-textdomain' ),
        'all_items'         => __( 'Todos los galeria_imageness', 'your-plugin-textdomain' ),
        'search_items'      => __( 'Buscar galeria_imageness', 'your-plugin-textdomain' ),
        'parent_item_colon' => __( 'galeria_imageness padre', 'your-plugin-textdomain' ),
        'not_found'         => __( 'No hemos encontrado galeria_imageness.', 'your-plugin-textdomain' ),
        'not_found_in_trash'=> __( 'No hemos encontrado galeria_imageness en la papelera', 'your-plugin-textdomain' ),
    );

    $args = array(
        'labels'            => $labels,
        'description'       => __('Description', 'your-plugin-textdomain'),
        'public'            => true,
        'public_queryable'  => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'galeria_imagenes' ),
        'capability_type'   => 'post',
        'has_archive'       => true,
        'hierarchical'      => false,
        'menu_position'     => null,
        'menu_icon'         => 'dashicons-admin-multisite',
        'supports'          => array( 'title', 'editor', 'author', 'thumbnail' )
    );

    register_post_type( 'galeria_imagenes', $args );
}





add_action('rest_api_init', 'register_custom_fields_galeria_imagenes');
function register_custom_fields_galeria_imagenes()
{

    register_rest_field(
        'galeria_imagenes','campo_imagen',
        array(
            'get_callback' => 'show_fields'
        )
    );

		    register_rest_field(
		        'galeria_imagenes','ubicacion_galeria',
		        array(
		            'get_callback' => 'show_fields'
		        )
		    );

				    register_rest_field(
				        'galeria_imagenes','ocultar',
				        array(
				            'get_callback' => 'show_fields'
				        )
				    );

}

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_galeria_imagenes',
		'title' => 'galeria_imagenes',
		'fields' => array (
			array (
				'key' => 'field_5b69af7e2df39',
				'label' => 'campo_imagen',
				'name' => 'campo_imagen',
				'type' => 'image',
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_5b69b03c2df3a',
				'label' => 'ubicacion_galeria',
				'name' => 'ubicacion_galeria',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b69b0612df3b',
				'label' => 'ocultar',
				'name' => 'ocultar',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'galeria_imagenes',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}


/*SERVICIOS DE galeria_imagnes*/
/*SERVICIOS DE galeria_imagnes*/


/// lg subsidios de lg_get_subsidio_vivienda

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/get_subsidio_vivienda/(?P<id>\d+)', array(
    'methods' => 'POST',
    'callback' => 'lg_get_subsidio_vivienda',
  ) );
} );


function lg_get_subsidio_vivienda( WP_REST_Request $request ) {
		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_body_params();//post y json
		$manage = json_decode($parameters["json"]);
		//print_r($manage);
		//echo $manage->cedula."asdfsdf";

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_personas';

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE cedula = ".$manage->cedula." ", OBJECT );

		return $results;
}

//////////funciones especializadas

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/add_cotizacion_persona/(?P<id>\d+)', array(
    'methods' => 'POST',
    'callback' => 'lg_add_cotizacion_persona',
  ) );
} );


function lg_add_cotizacion_persona( WP_REST_Request $request ) {
	date_default_timezone_set("America/Bogota");
	$parameters = $request->get_body_params();//post y json
	//$manage = json_decode($parameters["json"]);
	//print_r($manage);

	global $wpdb;

	$table_name = $wpdb->prefix . 'cotizaciones_personales';

	$wpdb->insert(
		$table_name,
		array(
			'created' => current_time( 'mysql' ),
			'updated' => current_time( 'mysql' ),
			'json_cotizacion' => $parameters["json"],
		)
	);


	return $wpdb->insert_id;
}

//ejemplo
function my_awesome_func( WP_REST_Request $request ) {
  // You can access parameters via direct array access on the object:
  //$param = $request['some_param'];

  // Or via the helper method:
  //$param = $request->get_param( 'some_param' );

  // You can get the combined, merged set of parameters:
  //$parameters = $request->get_params();

  // The individual sets of parameters are also available, if needed:
  //$parameters = $request->get_url_params();//GET
  //$parameters = $request->get_query_params();
  $parameters = $request->get_body_params();//POST
  //$parameters = $request->get_json_params();
  //$parameters = $request->get_default_params();

	print_r($parameters);

  // Uploads aren't merged in, but can be accessed separately:
  //$parameters = $request->get_file_params();
	return "lala";
}



///////////funciones especializadas







/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

















/// lg subsidios de lg_get_ciudad

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_ciudad/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_ciudad',
  ) );
} );


function lg_get_ciudad( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_ciudad';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE ciudad like '%".$parameters["id"]."%' ", OBJECT );

		return $results;
}




/// lg subsidios de lg_get_localidad

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_localidad/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_ciudad',
  ) );
} );


function lg_get_localidad( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_localidad';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE localidad like '%".$parameters["id"]."%' ", OBJECT );

		return $results;
}





/// lg subsidios de lg_get_categoria

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_categoria/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_categoria',
  ) );
} );


function lg_get_categoria( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_categoria';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE categoria like '%".$parameters["id"]."%' ", OBJECT );

		return $results;
}







/// lg subsidios de lg_get_subcategoria

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_subcategoria/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_subcategoria',
  ) );
} );


function lg_get_subcategoria( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_subcategoria';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE subcategoria like '%".$parameters["id"]."%' ", OBJECT );

		return $results;
}




/// lg subsidios de lg_get_comercio_by_razonzocial

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_comercio_by_razonzocial/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_comercio_by_razonzocial',
  ) );
} );



function lg_get_comercio_by_razonzocial( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_comercio';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE razonzocial like '%".$parameters["id"]."%' ", OBJECT );

		return $results;
}




/// lg subsidios de lg_get_punto_by_nombredelcomercio

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_punto_by_nombredelcomercio/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_punto_by_nombredelcomercio',
  ) );
} );



function lg_get_punto_by_nombredelcomercio( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_punto';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE nombredelcomercio like '%".$parameters["id"]."%' ", OBJECT );

		return $results;
}




/// lg subsidios de lg_get_punto_by_direccion

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_punto_by_direccion/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_punto_by_direccion',
  ) );
} );



function lg_get_punto_by_direccion( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_punto';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE direccionpuntos like '%".$parameters["id"]."%' ", OBJECT );

		return $results;
}




/// lg subsidios de lg_get_punto_by_telefono

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_punto_by_telefono/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_punto_by_telefono',
  ) );
} );



function lg_get_punto_by_telefono( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_punto';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE telefono like '%".$parameters["id"]."%' ", OBJECT );

		return $results;
}






/// lg subsidios de lg_get_punto_by_idcomercio

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_punto_by_idcomercio/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_punto_by_idcomercio',
  ) );
} );



function lg_get_punto_by_idcomercio( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_punto';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE idcomercio = '".$parameters["id"]."' ", OBJECT );

		return $results;
}











/// lg subsidios de lg_get_punto_by_idcategoria

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_punto_by_idcategoria/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_punto_by_idcategoria',
  ) );
} );



function lg_get_punto_by_idcategoria( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_punto';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE idcategoria = '".$parameters["id"]."' ", OBJECT );

		return $results;
}



















/// lg subsidios de lg_get_punto_by_idsubcategoria

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_punto_by_idsubcategoria/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_punto_by_idsubcategoria',
  ) );
} );



function lg_get_punto_by_idsubcategoria( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_punto';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE idsubcategoria = '".$parameters["id"]."' ", OBJECT );

		return $results;
}















/// lg subsidios de lg_get_punto_by_idlocalidad

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_punto_by_idlocalidad/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_punto_by_idlocalidad',
  ) );
} );



function lg_get_punto_by_idlocalidad( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_punto';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE idlocalidad = '".$parameters["id"]."' ", OBJECT );

		return $results;
}














/// lg subsidios de lg_get_punto_by_idciudad

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_punto_by_idciudad/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_punto_by_idciudad',
  ) );
} );



function lg_get_punto_by_idciudad( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_punto';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE idciudad = '".$parameters["id"]."' ", OBJECT );

		return $results;
}












/// lg subsidios de lg_get_by_id_ciudad

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_by_id_ciudad/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_by_id_ciudad',
  ) );
} );


function lg_get_by_id_ciudad( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_ciudad';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE idciudad = '".$parameters["id"]."' ", OBJECT );

		return $results;
}




/// lg subsidios de lg_get_by_id_localidad

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_by_id_localidad/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_by_id_ciudad',
  ) );
} );


function lg_get_by_id_localidad( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_localidad';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE idlocalidad = '".$parameters["id"]."' ", OBJECT );

		return $results;
}





/// lg subsidios de lg_get_by_id_categoria

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_by_id_categoria/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_by_id_categoria',
  ) );
} );


function lg_get_by_id_categoria( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_categoria';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE idcategoria = '".$parameters["id"]."' ", OBJECT );

		return $results;
}







/// lg subsidios de lg_get_by_id_subcategoria

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_by_id_subcategoria/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_by_id_subcategoria',
  ) );
} );


function lg_get_by_id_subcategoria( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_subcategoria';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE idsubcategoria = '".$parameters["id"]."' ", OBJECT );

		return $results;
}




/// lg subsidios de lg_get_by_id_comercio

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_by_id_comercio/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_by_id_comercio',
  ) );
} );



function lg_get_by_id_comercio( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_comercio';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE idcomercio = '".$parameters["id"]."' ", OBJECT );

		return $results;
}





/// lg subsidios de lg_get_by_id_punto

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_by_id_punto/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_by_id_punto',
  ) );
} );



function lg_get_by_id_punto( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_punto';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE idpunto = '".$parameters["id"]."' ", OBJECT );

		return $results;
}





/// lg subsidios de lg_get_localidad_by_idciudad

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_localidad_by_idciudad/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_localidad_by_idciudad',
  ) );
} );


function lg_get_localidad_by_idciudad( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_localidad';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE idciudad = '".$parameters["id"]."' ", OBJECT );

		return $results;
}







/// lg subsidios de lg_get_subcategoria_by_idcategoria

add_action( 'rest_api_init', function () {
  register_rest_route( 'legger/v1', '/lg_get_subcategoria_by_idcategoria/(?P<id>\w+)', array(
    'methods' => 'GET',
    'callback' => 'lg_get_subcategoria_by_idcategoria',
  ) );
} );


function lg_get_subcategoria_by_idcategoria( WP_REST_Request $request ) {

		date_default_timezone_set("America/Bogota");
		$parameters = $request->get_url_params();

		global $wpdb;

		$table_name = $wpdb->prefix . 'lg_subcategoria';
		if($parameters["id"]=="0")$parameters["id"]="";

		$results = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE idcategoria = '".$parameters["id"]."' ", OBJECT );

		return $results;
}
