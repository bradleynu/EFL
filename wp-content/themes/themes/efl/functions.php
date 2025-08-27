<?php
/**
 * Lanco Store functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Lanco_Store
 */
$efl_theme_version = 'efs-312';

if (!function_exists('lanco_setup')):
  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function lanco_setup()
  {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Lanco Store, use a find and replace
     * to change 'lanco' to the name of your theme in all the template files.
     */
    load_theme_textdomain('lanco', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');
    add_theme_support('post-formats', array('aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio'));
    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(array(
      'menu-1' => esc_html__('Primary', 'lanco'),
      'footer' => esc_html__('Footer', 'lanco'),
      'header-pies' => __( 'Header Pies' ),
		  'footer-pies' => __( 'Footer Pies' )
    ));

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ));

    // Set up the WordPress core custom background feature.
    add_theme_support('custom-background', apply_filters('lanco_custom_background_args', array(
      'default-color' => 'ffffff',
      'default-image' => '',
    )));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Add theme support for woocommercest
    add_theme_support('woocommerce');
  }
endif;
add_action('after_setup_theme', 'lanco_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function lanco_content_width()
{
  $GLOBALS['content_width'] = apply_filters('lanco_content_width', 640);
}
add_action('after_setup_theme', 'lanco_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function lanco_widgets_init()
{
  register_sidebar(array(
    'name' => esc_html__('Sidebar', 'lanco'),
    'id' => 'sidebar-1',
    'description' => esc_html__('Add widgets here.', 'lanco'),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h2 class="widget-title">',
    'after_title' => '</h2>',
  ));

  register_sidebar(array(
    'name' => esc_html__('Banner Top', 'lanco'),
    'id' => 'banner-top',
    'description' => esc_html__('Agregar una imagen para el banner principal', 'lanco'),
    'before_widget' => '<section id="banner-top"><div class="banner">',
    'after_widget' => '</div></section>',
    'before_title' => '<h2 style="display:none">',
    'after_title' => '</h2>',
  ));

  register_sidebar(array(
    'name' => esc_html__('Footer', 'lanco'),
    'id' => 'footer-1',
    'description' => esc_html__('Agregar los menus del footer', 'lanco'),
    'before_widget' => '<div class="col-sm-3 col-xs-6">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));

  register_sidebar(array(
    'name' => esc_html__('Home', 'lanco'),
    'id' => 'home',
    'description' => esc_html__('Agregar los menus del footer', 'lanco'),
    'before_widget' => '<div class="col-sm-6"><div class="ad">',
    'after_widget' => '</div></div>',
    'before_title' => '<h3 style="display:none">',
    'after_title' => '</h3>',
  ));

}
add_action('widgets_init', 'lanco_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function lanco_scripts()
{
  global $efl_theme_version;

  wp_enqueue_style('lanco-style', get_stylesheet_uri(), false, $efl_theme_version);
  wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/owl.carousel.css', array(), $efl_theme_version);
  wp_enqueue_style('owl-carousel-theme', get_template_directory_uri() . '/assets/owl.theme.default.css', array(), $efl_theme_version);


  //wp_enqueue_script('lanco-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);
  //wp_enqueue_script('lanco-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

  wp_enqueue_script('owl-carouseljs', get_template_directory_uri() . '/assets/owl.carousel.min.js', ('jquery-lib'), $efl_theme_version, true);

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_style('lanco-libraries', get_template_directory_uri() . '/assets/dist/css/libs.min.css', array(), $efl_theme_version);
  wp_enqueue_style('lanco-main', get_template_directory_uri() . '/assets/dist/css/style.css', array('lanco-libraries'), $efl_theme_version);

  wp_enqueue_script('lanco-libraries', get_template_directory_uri() . '/assets/dist/js/libs.min.js', array(), $efl_theme_version, true);
  wp_enqueue_script('lanco-app', get_template_directory_uri() . '/assets/dist/js/app.js', array('lanco-libraries'), $efl_theme_version, true);


}
add_action('wp_enqueue_scripts', 'lanco_scripts');

add_action('show_admin_bar', '__return_false');

/**
 * Seaech
 */
function shop_order_user_role_posts_where($query)
{
  if (!$query->is_main_query() || !isset($_GET['_user_role'])) {
    return;
  }
  $ids = get_users(array('role' => sanitize_text_field($_GET['_user_role']), 'fields' => 'ID'));
  $ids = array_map('absint', $ids);
  $query->set('meta_query', array(
    array(
      'key' => '_customer_user',
      'compare' => 'IN',
      'value' => $ids,
    )
  ));
  if (empty($ids)) {
    $query->set('posts_per_page', 0);
  }
}
function lanco_products_search($query)
{
  if ($query->is_search()) {
    // category terms search.
    if (isset($_GET['category']) && !empty($_GET['category'])) {
      $query->set('tax_query', array(
        array(
          'taxonomy' => 'product_cat',
          'field' => 'slug',
          'terms' => array($_GET['category'])
        )
      ));
    }
  }
  return $query;
}
add_action('pre_get_posts', 'lanco_products_search', 1000);

function lanco_footer()
{
  ?>
  <script type="text/javascript">
    var find = 'House number and street name';
    var repl = 'Número de casa y nombre de la calle';
    if (typeof wc_address_i18n_params !== 'undefined')
      wc_address_i18n_params.locale = wc_address_i18n_params.locale.replace(find, repl).replace(find, repl);
  </script>
  <?php
}
// add_action( 'restrict_manage_posts', 'shop_order_user_role_filter' );
add_filter('pre_get_posts', 'shop_order_user_role_posts_where');
add_action('wp_footer', 'lanco_footer', 1000);

// function lanco_remove_billing_postcode_checkout( $fields ) {
// 	$fields['billing']['billing_postcode']['default'] = '11111';
// 	$fields['shipping']['shipping_postcode']['default'] = '11111';
// 	return $fields;
// }

// add_filter( 'woocommerce_checkout_fields' , 'lanco_remove_billing_postcode_checkout' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * WooCommerce Hooks
 */

require get_template_directory() . '/inc/wc-functions.php';
// function lanco_register_product_view() {
//     $product = get_queried_object();
//     echo '<div class="js-count-product-view" data-product="'.$product->ID.'"></div>';
// }
// add_action('woocommerce_after_single_product', 'lanco_register_product_view');

// function lanco_cart_account_menu_items($items){
//     unset($items['edit-account']);
//     unset($items['customer-logout']);
//     unset($items['downloads']);
//     unset($items['dashboard']);
//     unset($items['account-wishlists']);
//     $items = array('edit-account' => 'Cuenta') + $items;

//     return $items;
// }

// add_filter( 'woocommerce_account_menu_items', 'lanco_cart_account_menu_items', 99999 );

// function set_custom_isvars( $wp_query ) {
//     if($wp_query->query_vars['pagename'] == 'my-account' && isset($wp_query->query_vars['page']) ){
//         wp_redirect('/my-account/edit-account/');
//         exit;
//     }
// }
// add_action('parse_query', 'set_custom_isvars');

// add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
// function logout_without_confirm($action, $result){
//   /**
//   * Allow logout without confirmation
//   */
//   if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
//       $redirect_to = isset($_REQUEST['redirect_to']) ?
//       $_REQUEST['redirect_to'] : '';
//       $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));;
//       header("Location: $location");
//       die();
//     }
// }

// add_filter('woocommerce_variable_price_html', 'lanco_variation_price', 10, 2);
// function lanco_variation_price( $price, $product ) {

//     $prices = $product->get_variation_prices( true );

//     foreach($product->get_available_variations() as $pav){
//         $def=true;
//         foreach($product->get_variation_default_attributes() as $defkey=>$defval){
//             if($pav['attributes']['attribute_'.$defkey]!=$defval){
//                 $def=false;
//             }
//         }
//         if($def){
//             if($pav['display_regular_price'] !== $pav['display_price']){
//                 $normalprice = wc_price($pav['display_regular_price']);
//                 $saleprice = wc_price($pav['display_price']);
//                 $price = '<del>' . $normalprice . '</del><ins>' . $saleprice . '</ins>';
//                 return $price;
//             } else {
//                 $price = $pav['display_price'];
//             }
//         }
//     }

//     return woocommerce_price($price); 
// }
/**
 * WooCommerce Hooks
 */
require get_template_directory() . '/inc/main-menu-walker.php';

/**
 * Shortcodes
 */
require get_template_directory() . '/inc/shortcodes.php';

add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);

function my_wp_nav_menu_objects($items, $args)
{
  foreach ($items as &$item) {
    $image = get_field('image', $item);
    if ($image) {
      $item->title .= ' <img src="' . $image . '">';
    }
  }
  return $items;
}
if (function_exists('acf_add_options_page')) {

  acf_add_options_page(array(
    'page_title' => 'Mobile App Share',
    'menu_title' => 'Mobile App Share',
    'menu_slug' => 'theme-options',
    'capability' => 'edit_posts'
  ));

  acf_add_options_sub_page(array(
    'page_title' => "Mobile App Share",
    'parent_slug' => 'theme-options',
    'menu_title' => "global-options",
    'menu_slug' => 'global-options',
  ));
}

function add_content_after_addtocart()
{

  $amazon_product_link = get_field('amazon_product_link');
  $amazon_text = get_field('amazon_product_cta');
  if ($amazon_product_link != "") {
    echo sprintf(__('<a style="background: #e47911;color: white;margin-top: 5px;height: 46px;display: flex;align-items: center;justify-content: center;" class="alt btn btn-outline single_add_to_cart_button"  href="%s" target="_blank">%s</a>'), $amazon_product_link, $amazon_text);
  }
}

add_action('woocommerce_after_add_to_cart_button', 'add_content_after_addtocart');

add_filter('woocommerce_states', 'custom_woocommerce_states');

function custom_woocommerce_states($states)
{
  $states['PR'] = array(
    'PRAdjuntas' => 'Adjuntas',
    'PRAguada' => 'Aguada',
    'PRAguadilla' => 'Aguadilla',
    'PRAguas Buenas' => 'Aguas Buenas',
    'PRAibonito' => 'Aibonito',
    'PRArecibo' => 'Arecibo',
    'PRArroyo' => 'Arroyo',
    'PRAñasco' => 'Añasco',
    'PRBarceloneta' => 'Barceloneta',
    'PRBarranquitas' => 'Barranquitas',
    'PRBayamón' => 'Bayamón',
    'PRCabo Rojo' => 'Cabo Rojo',
    'PRCaguas' => 'Caguas',
    'PRCamuy' => 'Camuy',
    'PRCanóvanas' => 'Canóvanas',
    'PRCarolina' => 'Carolina',
    'PRCataño' => 'Cataño',
    'PRCayey' => 'Cayey',
    'PRCeiba' => 'Ceiba',
    'PRCiales' => 'Ciales',
    'PRCidra' => 'Cidra',
    'PRCoamo' => 'Coamo',
    'PRComerío' => 'Comerío',
    'PRCorozal' => 'Corozal',
    'PRCulebra' => 'Culebra',
    'PRDorado' => 'Dorado',
    'PRFajardo' => 'Fajardo',
    'PRFlorida' => 'Florida',
    'PRGuayama' => 'Guayama',
    'PRGuayanilla' => 'Guayanilla',
    'PRGuaynabo' => 'Guaynabo',
    'PRGurabo' => 'Gurabo',
    'PRGuánica' => 'Guánica',
    'PRHatillo' => 'Hatillo',
    'PRHormigueros' => 'Hormigueros',
    'PRHumacao' => 'Humacao',
    'PRIsabela' => 'Isabela',
    'PRJayuya' => 'Jayuya',
    'PRJuana Díaz' => 'Juana Díaz',
    'PRJuncos' => 'Juncos',
    'PRLajas' => 'Lajas',
    'PRLares' => 'Lares',
    'PRLas Marías' => 'Las Marías',
    'PRLas Piedras' => 'Las Piedras',
    'PRLoiza' => 'Loiza',
    'PRLuquillo' => 'Luquillo',
    'PRManatí' => 'Manatí',
    'PRMaricao' => 'Maricao',
    'PRMaunabo' => 'Maunabo',
    'PRMayagüez' => 'Mayagüez',
    'PRMoca' => 'Moca',
    'PRMorovis' => 'Morovis',
    'PRNaguabo' => 'Naguabo',
    'PRNaranjito' => 'Naranjito',
    'PROrocovis' => 'Orocovis',
    'PRPatillas' => 'Patillas',
    'PRPeñuelas' => 'Peñuelas',
    'PRPonce' => 'Ponce',
    'PRQuebradillas' => 'Quebradillas',
    'PRRincón' => 'Rincón',
    'PRRio Grande' => 'Rio Grande',
    'PRSabana Grande' => 'Sabana Grande',
    'PRSalinas' => 'Salinas',
    'PRSan Germán' => 'San Germán',
    'PRSan Juan' => 'San Juan',
    'PRSan Lorenzo' => 'San Lorenzo',
    'PRSan Sebastián' => 'San Sebastián',
    'PRSanta Isabel' => 'Santa Isabel',
    'PRToa Alta' => 'Toa Alta',
    'PRToa Baja' => 'Toa Baja',
    'PRTrujillo Alto' => 'Trujillo Alto',
    'PRUtuado' => 'Utuado',
    'PRVega Alta' => 'Vega Alta',
    'PRVega Baja' => 'Vega Baja',
    'PRVieques' => 'Vieques',
    'PRVillalba' => 'Villalba',
    'PRYabucoa' => 'Yabucoa',
    'PRYauco' => 'Yauco'
  );

  return $states;
}


add_filter('wc_city_select_cities', 'my_cities');

function my_cities($cities)
{
  $file = 'usacit.json';

  // Ruta donde se guardará el archivo
  $path = get_template_directory() . '/' . $file;

  // Verifica si el archivo existe
  if (file_exists($path)) {
    // Lee el contenido del archivo y lo convierte en un array
    $cities = json_decode(file_get_contents($path), true);
  } else {
    $cities = array();
    $states = array("AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "FL", "GA", "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME", "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", "NJ", "NM", "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA", "WV", "WI", "WY");
    foreach ($states as $state) {

      // URL para hacer la solicitud de API
      //$url = "http://api.geonames.org/searchJSON?country=US&adminCode1=" . $state . "&maxRows=1000&featureCode=ADM3&orderby=name&username=fhidalgo";
		    $url = "http://api.geonames.org/searchJSON?country=US&adminCode1=" . $state . "&maxRows=1000&orderby=name&username=fhidalgo";


      // Inicializar cURL
      $ch = curl_init();

      // Configurar opciones de cURL
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Mozilla/5.0'));

      // Ejecutar la solicitud de cURL y obtener los datos
      $data = curl_exec($ch);

      // Convertir los datos JSON en un array de PHP
      $result = json_decode($data, true);

      // Iterar sobre cada resultado y agregar la ciudad al array correspondiente del estado
      foreach ($result['geonames'] as $city) {
        $cityname = $city['name'];
        $cities['US'][$state][] = $cityname;
      }

      // Cerrar la conexión de cURL
      curl_close($ch);
    }


    $datacity = json_encode($cities);

    // Crear el archivo JSON y escribir los datos en él
    $file = 'usacit.json';
    file_put_contents(get_template_directory() . '/' . $file, json_encode($cities));
  }


  $cities['PR'] = array(
    'PRAdjuntas' =>
      array(
        0 => 'Adjuntas',
        1 => 'Capáez',
        2 => 'Garzas',
        3 => 'Guayabo Dulce',
        4 => 'Guayo',
        5 => 'Guilarte',
        6 => 'Juan González',
        7 => 'Limaní',
        8 => 'Pellejas',
        9 => 'Portillo',
        10 => 'Portugués',
        11 => 'Saltillo',
        12 => 'Tanamá',
        13 => 'Vegas Abajo',
        14 => 'Vegas Arriba',
        15 => 'Yahuecas',
        16 => 'Yayales',
      ),
    'PRAguada' =>
      array(
        0 => 'Aguada',
        1 => 'Asomante',
        2 => 'Atalaya',
        3 => 'Carrizal',
        4 => 'Cerro Gordo',
        5 => 'Cruces',
        6 => 'Espinar',
        7 => 'Guanábano',
        8 => 'Guaniquilla',
        9 => 'Guayabo',
        10 => 'Jagüey',
        11 => 'Lagunas',
        12 => 'Mal Paso',
        13 => 'Mamey',
        14 => 'Marías',
        15 => 'Naranjo',
        16 => 'Piedras Blancas',
        17 => 'Río Grande',
      ),
    'PRAguadilla' =>
      array(
        0 => 'Aguacate',
        1 => 'Aguadilla',
        2 => 'Arenales',
        3 => 'Borinquen',
        4 => 'Caimital Alto',
        5 => 'Caimital Bajo',
        6 => 'Camaceyes',
        7 => 'Ceiba Alta',
        8 => 'Ceiba Baja',
        9 => 'Corrales',
        10 => 'Guerrero',
        11 => 'Maleza Alta',
        12 => 'Maleza Baja',
        13 => 'Montaña',
        14 => 'Palmar',
        15 => 'Victoria',
      ),
    'PRAguas Buenas' =>
      array(
        0 => 'Aguas Buenas',
        1 => 'Bairoa',
        2 => 'Bayamoncito',
        3 => 'Cagüitas',
        4 => 'Jagüeyes',
        5 => 'Juan Asencio',
        6 => 'Mula',
        7 => 'Mulita',
        8 => 'Sonadora',
        9 => 'Sumidero',
      ),
    'PRAibonito' =>
      array(
        0 => 'Aibonito',
        1 => 'Algarrobo',
        2 => 'Asomante',
        3 => 'Caonillas',
        4 => 'Cuyón',
        5 => 'Llanos',
        6 => 'Pasto',
        7 => 'Plata',
        8 => 'Robles',
      ),
    'PRAñasco' =>
      array(
        0 => 'Añasco Abajo',
        1 => 'Añasco Arriba',
        2 => 'Añasco',
        3 => 'Caguabo',
        4 => 'Caracol',
        5 => 'Carreras',
        6 => 'Casey Abajo',
        7 => 'Casey Arriba',
        8 => 'Cerro Gordo',
        9 => 'Cidra',
        10 => 'Corcovada',
        11 => 'Dagüey',
        12 => 'Espino',
        13 => 'Hatillo',
        14 => 'Humatas',
        15 => 'Marías',
        16 => 'Miraflores',
        17 => 'Ovejas',
        18 => 'Piñales',
        19 => 'Playa',
        20 => 'Quebrada Larga',
        21 => 'Río Arriba',
        22 => 'Río Cañas',
      ),
    'PRArecibo' =>
      array(
        0 => 'Arecibo',
        1 => 'Arenalejos',
        2 => 'Arrozal',
        3 => 'Cambalache',
        4 => 'Carreras',
        5 => 'Domingo Ruíz',
        6 => 'Dominguito',
        7 => 'Esperanza',
        8 => 'Factor',
        9 => 'Garrochales',
        10 => 'Hato Abajo',
        11 => 'Hato Arriba',
        12 => 'Hato Viejo',
        13 => 'Islote',
        14 => 'Miraflores',
        15 => 'Río Arriba',
        16 => 'Sabana Hoyos',
        17 => 'Santana',
        18 => 'Tanamá',
      ),
    'PRArroyo' =>
      array(
        0 => 'Ancones',
        1 => 'Arroyo',
        2 => 'Guásimas',
        3 => 'Palmas',
        4 => 'Pitahaya',
        5 => 'Yaurel',
      ),
    'PRBarceloneta' =>
      array(
        0 => 'Barceloneta',
        1 => 'Florida Afuera',
        2 => 'Garrochales',
        3 => 'Palmas Altas',
      ),
    'PRBarranquitas' =>
      array(
        0 => 'Barrancas',
        1 => 'Barranquitas',
        2 => 'Cañabón',
        3 => 'Helechal',
        4 => 'Honduras',
        5 => 'Palo Hincado',
        6 => 'Quebrada Grande',
        7 => 'Quebradillas',
      ),
    'PRBayamón' =>
      array(
        0 => 'Bayamón',
        1 => 'Buena Vista',
        2 => 'Cerro Gordo',
        3 => 'Dajaos',
        4 => 'Guaraguao Abajo',
        5 => 'Guaraguao Arriba',
        6 => 'Hato Tejas',
        7 => 'Juan Sánchez',
        8 => 'Minillas',
        9 => 'Nuevo',
        10 => 'Pájaros',
        11 => 'Santa Olaya',
      ),
    'PRCabo Rojo' =>
      array(
        0 => 'Bajura',
        1 => 'Boquerón',
        2 => 'Cabo Rojo',
        3 => 'Guanajibo',
        4 => 'Llanos Costa',
        5 => 'Llanos Tuna',
        6 => 'Miradero',
        7 => 'Monte Grande',
        8 => 'Pedernales',
      ),
    'PRCaguas' =>
      array(
        0 => 'Bairoa',
        1 => 'Beatriz',
        2 => 'Borinquen',
        3 => 'Caguas',
        4 => 'Cañabón',
        5 => 'Cañaboncito',
        6 => 'Río Cañas',
        7 => 'San Antonio',
        8 => 'San Salvador',
        9 => 'Tomás de Castro',
        10 => 'Turabo',
      ),
    'PRCamuy' =>
      array(
        0 => 'Abra Honda',
        1 => 'Camuy Arriba',
        2 => 'Camuy',
        3 => 'Cibao',
        4 => 'Ciénagas',
        5 => 'Membrillo',
        6 => 'Piedra Gorda',
        7 => 'Puente',
        8 => 'Puertos',
        9 => 'Quebrada',
        10 => 'Santiago',
        11 => 'Yeguada',
        12 => 'Zanja',
      ),
    'PRCanóvanas' =>
      array(
        0 => 'Canóvanas',
        1 => 'Canóvanas',
        2 => 'Cubuy',
        3 => 'Hato Puerco',
        4 => 'Lomas',
        5 => 'Torrecilla Alta',
      ),
    'PRCarolina' =>
      array(
        0 => 'Barrazas',
        1 => 'Buena Vista',
        2 => 'Cacao',
        3 => 'Cangrejo Arriba',
        4 => 'Canovanillas',
        5 => 'Carolina',
        6 => 'Carruzos',
        7 => 'Cedro',
        8 => 'Martín González',
        9 => 'Sabana Abajo',
        10 => 'San Antón',
        11 => 'Santa Cruz',
        12 => 'Trujillo Bajo',
      ),
    'PRCataño' =>
      array(
        0 => 'Cataño',
        1 => 'Palmas',
      ),
    'PRCayey' =>
      array(
        0 => 'Beatriz',
        1 => 'Cayey',
        2 => 'Cedro',
        3 => 'Cercadillo',
        4 => 'Culebras Alto',
        5 => 'Culebras Bajo',
        6 => 'Farallón',
        7 => 'Guavate',
        8 => 'Jájome Alto',
        9 => 'Jájome Bajo',
        10 => 'Lapa',
        11 => 'Matón Abajo',
        12 => 'Matón Arriba',
        13 => 'Monte Llano',
        14 => 'Pasto Viejo',
        15 => 'Pedro Ávila',
        16 => 'Piedras',
        17 => 'Quebrada Arriba',
        18 => 'Rincón',
        19 => 'Sumido',
        20 => 'Toíta',
        21 => 'Vegas',
      ),
    'PRCeiba' =>
      array(
        0 => 'Ceiba',
        1 => 'Chupacallos',
        2 => 'Daguao',
        3 => 'Guayacán',
        4 => 'Machos',
        5 => 'Quebrada Seca',
        6 => 'Río Abajo',
        7 => 'Saco',
      ),
    'PRCiales' =>
      array(
        0 => 'Ciales',
        1 => 'Cialitos',
        2 => 'Cordillera',
        3 => 'Frontón',
        4 => 'Hato Viejo',
        5 => 'Jaguas',
        6 => 'Pesas',
        7 => 'Pozas',
        8 => 'Toro Negro',
      ),
    'PRCidra' =>
      array(
        0 => 'Arenas',
        1 => 'Bayamón',
        2 => 'Beatriz',
        3 => 'Ceiba',
        4 => 'Certenejas',
        5 => 'Cidra',
        6 => 'Honduras',
        7 => 'Monte Llano',
        8 => 'Rabanal',
        9 => 'Rincón',
        10 => 'Río Abajo',
        11 => 'Salto',
        12 => 'Sud',
        13 => 'Toíta',
      ),
    'PRCoamo' =>
      array(
        0 => 'Coamo Arriba',
        1 => 'Coamo',
        2 => 'Cuyón',
        3 => 'Hayales',
        4 => 'Los Llanos',
        5 => 'Palmarejo',
        6 => 'Pasto',
        7 => 'Pedro García',
        8 => 'Pulguillas',
        9 => 'San Ildefonso',
        10 => 'Santa Catalina',
      ),
    'PRComerío' =>
      array(
        0 => 'Cedrito',
        1 => 'Cejas',
        2 => 'Comerío',
        3 => 'Doña Elena',
        4 => 'Naranjo',
        5 => 'Palomas',
        6 => 'Piñas',
        7 => 'Río Hondo',
        8 => 'Vega Redonda',
      ),
    'PRCorozal' =>
      array(
        0 => 'Abras',
        1 => 'Cibuco',
        2 => 'Corozal',
        3 => 'Cuchillas',
        4 => 'Dos Bocas',
        5 => 'Magueyes',
        6 => 'Maná',
        7 => 'Negros',
        8 => 'Padilla',
        9 => 'Palmarejo',
        10 => 'Palmarito',
        11 => 'Palos Blancos',
        12 => 'Pueblo',
      ),
    'PRCulebra' =>
      array(
        0 => 'Culebra',
        1 => 'Flamenco',
        2 => 'Fraile',
        3 => 'Playa Sardinas I',
        4 => 'Playa Sardinas II',
        5 => 'San Isidro',
      ),
    'PRDorado' =>
      array(
        0 => 'Dorado',
        1 => 'Espinosa',
        2 => 'Higuillar',
        3 => 'Maguayo',
        4 => 'Mameyal',
        5 => 'Río Lajas',
      ),
    'PRFajardo' =>
      array(
        0 => 'Cabezas',
        1 => 'Demajagua',
        2 => 'Fajardo',
        3 => 'Florencio',
        4 => 'Naranjo',
        5 => 'Quebrada Fajardo',
        6 => 'Quebrada Vueltas',
        7 => 'Río Arriba',
        8 => 'Sardinera',
      ),
    'PRFlorida' =>
      array(
        0 => 'Florida Adentro',
      ),
    'PRGuánica' =>
      array(
        0 => 'Arena',
        1 => 'Caño',
        2 => 'Carenero',
        3 => 'Ciénaga',
        4 => 'Ensenada',
        5 => 'Guánica',
        6 => 'Montalva',
        7 => 'Susúa Baja',
      ),
    'PRGuayama' =>
      array(
        0 => 'Algarrobo',
        1 => 'Caimital',
        2 => 'Carite',
        3 => 'Carmen',
        4 => 'Guamaní',
        5 => 'Guayama',
        6 => 'Jobos',
        7 => 'Machete',
        8 => 'Palmas',
        9 => 'Pozo Hondo',
      ),
    'PRGuayanilla' =>
      array(
        0 => 'Barrero',
        1 => 'Boca',
        2 => 'Cedro',
        3 => 'Consejo',
        4 => 'Guayanilla',
        5 => 'Indios',
        6 => 'Jagua Pasto',
        7 => 'Jaguas',
        8 => 'Llano',
        9 => 'Macaná',
        10 => 'Magas',
        11 => 'Pasto',
        12 => 'Playa',
        13 => 'Quebrada Honda',
        14 => 'Quebradas',
        15 => 'Rufina',
        16 => 'Sierra Baja',
      ),
    'PRGuaynabo' =>
      array(
        0 => 'Camarones',
        1 => 'Frailes',
        2 => 'Guaraguao',
        3 => 'Guaynabo',
        4 => 'Hato Nuevo',
        5 => 'Mamey',
        6 => 'Pueblo Viejo',
        7 => 'Río',
        8 => 'Santa Rosa',
        9 => 'Sonadora',
      ),
    'PRGurabo' =>
      array(
        0 => 'Celada',
        1 => 'Gurabo',
        2 => 'Hato Nuevo',
        3 => 'Jaguar',
        4 => 'Jaguas',
        5 => 'Mamey',
        6 => 'Masa',
        7 => 'Navarro',
        8 => 'Quebrada Infierno',
        9 => 'Rincón',
      ),
    'PRHatillo' =>
      array(
        0 => 'Aibonito',
        1 => 'Bayaney',
        2 => 'Buena Vista',
        3 => 'Campo Alegre',
        4 => 'Capáez',
        5 => 'Carrizales',
        6 => 'Corcovado',
        7 => 'Hatillo',
        8 => 'Hatillo',
        9 => 'Naranjito',
      ),
    'PRHormigueros' =>
      array(
        0 => 'Benavente',
        1 => 'Guanajibo',
        2 => 'Hormigueros',
        3 => 'Hormigueros',
        4 => 'Jagüitas',
        5 => 'Lavadero',
      ),
    'PRHumacao' =>
      array(
        0 => 'Antón Ruíz',
        1 => 'Buena Vista',
        2 => 'Candelero Abajo',
        3 => 'Candelero Arriba',
        4 => 'Cataño',
        5 => 'Collores',
        6 => 'Humacao',
        7 => 'Mabú',
        8 => 'Mambiche',
        9 => 'Mariana',
        10 => 'Punta Santiago',
        11 => 'Río Abajo',
        12 => 'Tejas',
      ),
    'PRIsabela' =>
      array(
        0 => 'Arenales Altos',
        1 => 'Arenales Bajos',
        2 => 'Bajura',
        3 => 'Bejucos',
        4 => 'Coto',
        5 => 'Galateo Alto',
        6 => 'Galateo Bajo',
        7 => 'Guayabos',
        8 => 'Guerrero',
        9 => 'Isabela',
        10 => 'Jobos',
        11 => 'Llanadas',
        12 => 'Mora',
        13 => 'Planas',
      ),
    'PRJayuya' =>
      array(
        0 => 'Coabey',
        1 => 'Collores',
        2 => 'Jauca',
        3 => 'Jayuya Abajo',
        4 => 'Jayuya',
        5 => 'Mameyes Arriba',
        6 => 'Pica',
        7 => 'Río Grande',
        8 => 'Saliente',
        9 => 'Veguitas',
        10 => 'Zamas',
      ),
    'PRJuana Díaz' =>
      array(
        0 => 'Amuelas',
        1 => 'Callabo',
        2 => 'Capitanejo',
        3 => 'Cintrona',
        4 => 'Collores',
        5 => 'Emajagual',
        6 => 'Guayabal',
        7 => 'Jacaguas',
        8 => 'Juana Díaz',
        9 => 'Lomas',
        10 => 'Río Cañas Abajo',
        11 => 'Río Cañas Arriba',
        12 => 'Sabana Llana',
        13 => 'Tijeras',
      ),
    'PRJuncos' =>
      array(
        0 => 'Caimito',
        1 => 'Ceiba Norte',
        2 => 'Ceiba Sur',
        3 => 'Gurabo Abajo',
        4 => 'Gurabo Arriba',
        5 => 'Juncos',
        6 => 'Lirios',
        7 => 'Mamey',
        8 => 'Valenciano Abajo',
        9 => 'Valenciano Arriba',
      ),
    'PRLajas' =>
      array(
        0 => 'Candelaria',
        1 => 'Costa',
        2 => 'Lajas Arriba',
        3 => 'Lajas',
        4 => 'Lajas',
        5 => 'Llanos',
        6 => 'Palmarejo',
        7 => 'Parguera',
        8 => 'París',
        9 => 'Plata',
        10 => 'Sabana Yeguas',
        11 => 'Santa Rosa',
      ),
    'PRLares' =>
      array(
        0 => 'Bartolo',
        1 => 'Buenos Aires',
        2 => 'Callejones',
        3 => 'Espino',
        4 => 'La Torre',
        5 => 'Lares',
        6 => 'Lares',
        7 => 'Mirasol',
        8 => 'Pezuela',
        9 => 'Piletas',
        10 => 'Pueblo',
        11 => 'Río Prieto',
      ),
    'PRLas Marías' =>
      array(
        0 => 'Alto Sano',
        1 => 'Anones',
        2 => 'Bucarabones',
        3 => 'Buena Vista',
        4 => 'Cerrote',
        5 => 'Chamorro',
        6 => 'Espino',
        7 => 'Furnias',
        8 => 'Las Marías',
        9 => 'Maravilla Este',
        10 => 'Maravilla Norte',
        11 => 'Maravilla Sur',
        12 => 'Naranjales',
        13 => 'Palma Escrita',
        14 => 'Purísima Concepción',
        15 => 'Río Cañas',
      ),
    'PRLas Piedras' =>
      array(
        0 => 'Boquerón',
        1 => 'Ceiba',
        2 => 'Collores',
        3 => 'El Río',
        4 => 'Las Piedras',
        5 => 'Montones',
        6 => 'Quebrada Arenas',
        7 => 'Tejas',
      ),
    'PRLoíza' =>
      array(
        0 => 'Canóvanas',
        1 => 'Loíza',
        2 => 'Medianía Alta',
        3 => 'Medianía Baja',
        4 => 'Torrecilla Alta',
        5 => 'Torrecilla Baja',
      ),
    'PRLuquillo' =>
      array(
        0 => 'Juan Martín',
        1 => 'Luquillo',
        2 => 'Mameyes I',
        3 => 'Mata de Plátano',
        4 => 'Pitahaya',
        5 => 'Sabana',
      ),
    'PRManatí' =>
      array(
        0 => 'Bajura Adentro',
        1 => 'Bajura Afuera',
        2 => 'Coto Norte',
        3 => 'Coto Sur',
        4 => 'Manatí',
        5 => 'Río Arriba Poniente',
        6 => 'Río Arriba Saliente',
        7 => 'Tierras Nuevas Poniente',
        8 => 'Tierras Nuevas Saliente',
      ),
    'PRMaricao' =>
      array(
        0 => 'Bucarabones',
        1 => 'Indiera Alta',
        2 => 'Indiera Baja',
        3 => 'Indiera Fría',
        4 => 'Maricao Afuera',
        5 => 'Maricao',
        6 => 'Montoso',
      ),
    'PRMaunabo' =>
      array(
        0 => 'Calzada',
        1 => 'Emajagua',
        2 => 'Lizas',
        3 => 'Matuyas Alto',
        4 => 'Matuyas Bajo',
        5 => 'Maunabo',
        6 => 'Palo Seco',
        7 => 'Quebrada Arenas',
        8 => 'Talante',
        9 => 'Tumbao',
      ),
    'PRMayagüez' =>
      array(
        0 => 'Algarrobos',
        1 => 'Bateyes',
        2 => 'Guanajibo',
        3 => 'Isla de Mona e Islote Monito',
        4 => 'Juan Alonso',
        5 => 'Leguísamo',
        6 => 'Limón',
        7 => 'Malezas',
        8 => 'Mayagüez Arriba',
        9 => 'Mayagüez',
        10 => 'Miradero',
        11 => 'Montoso',
        12 => 'Naranjales',
        13 => 'Quebrada Grande',
        14 => 'Quemado',
        15 => 'Río Cañas Abajo',
        16 => 'Río Cañas Arriba',
        17 => 'Río Hondo',
        18 => 'Rosario',
        19 => 'Sábalos',
        20 => 'Sabanetas',
      ),
    'PRMoca' =>
      array(
        0 => 'Aceitunas',
        1 => 'Capá',
        2 => 'Centro',
        3 => 'Cerro Gordo',
        4 => 'Cruz',
        5 => 'Cuchillas',
        6 => 'Marías',
        7 => 'Moca',
        8 => 'Naranjo',
        9 => 'Plata',
        10 => 'Pueblo',
        11 => 'Rocha',
        12 => 'Voladoras',
      ),
    'PRMorovis' =>
      array(
        0 => 'Barahona',
        1 => 'Cuchillas',
        2 => 'Fránquez',
        3 => 'Monte Llano',
        4 => 'Morovis',
        5 => 'Morovis Norte',
        6 => 'Morovis Sud',
        7 => 'Pasto',
        8 => 'Perchas',
        9 => 'Río Grande',
        10 => 'San Lorenzo',
        11 => 'Torrecillas',
        12 => 'Unibón',
        13 => 'Vaga',
      ),
    'PRMunicipio' =>
      array(
        0 => 'Pueblo',
      ),
    'PRNaguabo' =>
      array(
        0 => 'Daguao',
        1 => 'Duque',
        2 => 'Húcares',
        3 => 'Maizales',
        4 => 'Mariana',
        5 => 'Naguabo',
        6 => 'Peña Pobre',
        7 => 'Río',
        8 => 'Río Blanco',
        9 => 'Santiago y Lima',
      ),
    'PRNaranjito' =>
      array(
        0 => 'Achiote',
        1 => 'Anones',
        2 => 'Cedro Abajo',
        3 => 'Cedro Arriba',
        4 => 'Guadiana',
        5 => 'Lomas',
        6 => 'Naranjito',
        7 => 'Nuevo',
      ),
    'PROrocovis' =>
      array(
        0 => 'Ala de la Piedra',
        1 => 'Barros',
        2 => 'Bauta Abajo',
        3 => 'Bauta Arriba',
        4 => 'Bermejales',
        5 => 'Botijas',
        6 => 'Cacaos',
        7 => 'Collores',
        8 => 'Damián Abajo',
        9 => 'Damián Arriba',
        10 => 'Gato',
        11 => 'Mata de Cañas',
        12 => 'Orocovis',
        13 => 'Orocovis',
        14 => 'Pellejas',
        15 => 'Sabana',
        16 => 'Saltos',
      ),
    'PRPatillas' =>
      array(
        0 => 'Apeadero',
        1 => 'Bajo',
        2 => 'Cacao Alto',
        3 => 'Cacao Bajo',
        4 => 'Egozcue',
        5 => 'Guardarraya',
        6 => 'Jacaboa',
        7 => 'Jagual',
        8 => 'Mamey',
        9 => 'Marín',
        10 => 'Mulas',
        11 => 'Muñoz Rivera',
        12 => 'Patillas',
        13 => 'Pollos',
        14 => 'Quebrada Arriba',
        15 => 'Ríos',
      ),
    'PRPeñuelas' =>
      array(
        0 => 'Barreal',
        1 => 'Coto',
        2 => 'Cuebas',
        3 => 'Encarnación',
        4 => 'Jaguas',
        5 => 'Macaná',
        6 => 'Peñuelas',
        7 => 'Quebrada Ceiba',
        8 => 'Rucio',
        9 => 'Santo Domingo',
        10 => 'Tallaboa Alta',
        11 => 'Tallaboa Poniente',
        12 => 'Tallaboa Saliente',
      ),
    'PRPonce' =>
      array(
        0 => 'Anón',
        1 => 'Bucaná',
        2 => 'Canas',
        3 => 'Canas Urbano',
        4 => 'Capitanejo',
        5 => 'Cerrillos',
        6 => 'Coto Laurel',
        7 => 'Cuarto',
        8 => 'Guaraguao',
        9 => 'Machuelo Abajo',
        10 => 'Machuelo Arriba',
        11 => 'Magueyes',
        12 => 'Magueyes Urbano',
        13 => 'Maragüez',
        14 => 'Marueño',
        15 => 'Monte Llano',
        16 => 'Playa',
        17 => 'Portugués',
        18 => 'Portugués Urbano',
        19 => 'Primero',
        20 => 'Quebrada Limón',
        21 => 'Quinto',
        22 => 'Real',
        23 => 'Sabanetas',
        24 => 'San Antón',
        25 => 'San Patricio',
        26 => 'Segundo',
        27 => 'Sexto',
        28 => 'Tercero',
        29 => 'Tibes',
        30 => 'Vayas',
      ),
    'PRQuebradillas' =>
      array(
        0 => 'Cacao',
        1 => 'Charcas',
        2 => 'Cocos',
        3 => 'Guajataca',
        4 => 'Quebradillas',
        5 => 'San Antonio',
        6 => 'San José',
        7 => 'Terranova',
      ),
    'PRRincón' =>
      array(
        0 => 'Atalaya',
        1 => 'Barrero',
        2 => 'Calvache',
        3 => 'Cruces',
        4 => 'Ensenada',
        5 => 'Jagüey',
        6 => 'Pueblo',
        7 => 'Puntas',
        8 => 'Rincón',
        9 => 'Río Grande',
      ),
    'PRRío Grande' =>
      array(
        0 => 'Ciénaga Alta',
        1 => 'Ciénaga Baja',
        2 => 'Guzmán Abajo',
        3 => 'Guzmán Arriba',
        4 => 'Herreras',
        5 => 'Jiménez',
        6 => 'Mameyes II',
        7 => 'Río Grande',
        8 => 'Zarzal',
      ),
    'PRSabana Grande' =>
      array(
        0 => 'Machuchal',
        1 => 'Rayo',
        2 => 'Rincón',
        3 => 'Sabana Grande',
        4 => 'Santana',
        5 => 'Susúa',
        6 => 'Tabonuco',
        7 => 'Torre',
      ),
    'PRSalinas' =>
      array(
        0 => 'Aguirre',
        1 => 'Lapa',
        2 => 'Palmas',
        3 => 'Quebrada Yeguas',
        4 => 'Río Jueyes',
        5 => 'Salinas',
      ),
    'PRSan Germán' =>
      array(
        0 => 'Ancones',
        1 => 'Caín Alto',
        2 => 'Caín Bajo',
        3 => 'Cotuí',
        4 => 'Duey Alto',
        5 => 'Duey Bajo',
        6 => 'Guamá',
        7 => 'Hoconuco Alto',
        8 => 'Hoconuco Bajo',
        9 => 'Maresúa',
        10 => 'Minillas',
        11 => 'Retiro',
        12 => 'Rosario Alto',
        13 => 'Rosario Bajo',
        14 => 'Rosario Peñón',
        15 => 'Sabana Eneas',
        16 => 'Sabana Grande Abajo',
        17 => 'San Germán',
        18 => 'Tuna',
      ),
    'PRSan Juan' =>
      array(
        0 => 'Caimito',
        1 => 'Cupey',
        2 => 'El Cinco',
        3 => 'Gobernador Piñero',
        4 => 'Hato Rey Central',
        5 => 'Hato Rey Norte',
        6 => 'Hato Rey Sur',
        7 => 'Monacillo',
        8 => 'Monacillo Urbano',
        9 => 'Oriente',
        10 => 'Quebrada Arenas',
        11 => 'Río Piedras Pueblo',
        12 => 'Sabana Llana Norte',
        13 => 'Sabana Llana Sur',
        14 => 'San Juan Antiguo',
        15 => 'Santurce',
        16 => 'Tortugo',
        17 => 'Universidad',
      ),
    'PRSan Lorenzo' =>
      array(
        0 => 'Cayaguas',
        1 => 'Cerro Gordo',
        2 => 'Espino',
        3 => 'Florida',
        4 => 'Hato',
        5 => 'Jagual',
        6 => 'Quebrada Arenas',
        7 => 'Quebrada',
        8 => 'Quebrada Honda',
        9 => 'Quemados',
        10 => 'San Lorenzo',
      ),
    'PRSan Sebastián' =>
      array(
        0 => 'Aibonito',
        1 => 'Alto Sano',
        2 => 'Bahomamey',
        3 => 'Calabazas',
        4 => 'Cibao',
        5 => 'Cidral',
        6 => 'Culebrinas',
        7 => 'Eneas',
        8 => 'Guacio',
        9 => 'Guajataca',
        10 => 'Guatemala',
        11 => 'Hato Arriba',
        12 => 'Hoya Mala',
        13 => 'Juncal',
        14 => 'Magos',
        15 => 'Mirabales',
        16 => 'Perchas 1',
        17 => 'Perchas 2',
        18 => 'Piedras Blancas',
        19 => 'Pozas',
        20 => 'Robles',
        21 => 'Salto',
        22 => 'San Sebastián',
        23 => 'Sonador',
      ),
    'PRSanta Isabel' =>
      array(
        0 => 'Boca Velázquez',
        1 => 'Descalabrado',
        2 => 'Felicia 1',
        3 => 'Felicia 2',
        4 => 'Jauca 1',
        5 => 'Jauca 2',
        6 => 'Playa',
        7 => 'Santa Isabel',
      ),
    'PRToa Alta' =>
      array(
        0 => 'Contorno',
        1 => 'Galateo',
        2 => 'Mucarabones',
        3 => 'Ortíz',
        4 => 'Piñas',
        5 => 'Quebrada Arenas',
        6 => 'Quebrada Cruz',
        7 => 'Río Lajas',
        8 => 'Toa Alta',
      ),
    'PRToa Baja' =>
      array(
        0 => 'Candelaria',
        1 => 'Media Luna',
        2 => 'Palo Seco',
        3 => 'Sabana Seca',
        4 => 'Toa Baja',
      ),
    'PRTrujillo Alto' =>
      array(
        0 => 'Carraízo',
        1 => 'Cuevas',
        2 => 'Dos Bocas',
        3 => 'La Gloria',
        4 => 'Quebrada Grande',
        5 => 'Quebrada Negrito',
        6 => 'St. Just',
        7 => 'Trujillo Alto',
      ),
    'PRUtuado' =>
      array(
        0 => 'Ángeles',
        1 => 'Arenas',
        2 => 'Caguana',
        3 => 'Caníaco',
        4 => 'Caonillas Abajo',
        5 => 'Caonillas Arriba',
        6 => 'Consejo',
        7 => 'Don Alonso',
        8 => 'Guaonico',
        9 => 'Las Palmas',
        10 => 'Limón',
        11 => 'Mameyes Abajo',
        12 => 'Paso Palma',
        13 => 'Río Abajo',
        14 => 'Roncador',
        15 => 'Sabana Grande',
        16 => 'Salto Abajo',
        17 => 'Salto Arriba',
        18 => 'Santa Isabel',
        19 => 'Santa Rosa',
        20 => 'Tetuán',
        21 => 'Utuado',
        22 => 'Viví Abajo',
        23 => 'Viví Arriba',
      ),
    'PRVega Alta' =>
      array(
        0 => 'Bajura',
        1 => 'Candelaria',
        2 => 'Cienegueta',
        3 => 'Espinosa',
        4 => 'Maricao',
        5 => 'Mavilla',
        6 => 'Sabana',
        7 => 'Vega Alta',
      ),
    'PRVega Baja' =>
      array(
        0 => 'Algarrobo',
        1 => 'Almirante Norte',
        2 => 'Almirante Sur',
        3 => 'Cabo Caribe',
        4 => 'Ceiba',
        5 => 'Cibuco',
        6 => 'Puerto Nuevo',
        7 => 'Pugnado Adentro',
        8 => 'Pugnado Afuera',
        9 => 'Quebrada Arenas',
        10 => 'Río Abajo',
        11 => 'Río Arriba',
        12 => 'Vega Baja',
        13 => 'Yeguada',
      ),
    'PRVieques' =>
      array(
        0 => 'Florida',
        1 => 'Isabel II',
        2 => 'Llave',
        3 => 'Mosquito',
        4 => 'Puerto Diablo',
        5 => 'Puerto Ferro',
        6 => 'Puerto Real',
        7 => 'Punta Arenas',
      ),
    'PRVillalba' =>
      array(
        0 => 'Caonillas Abajo',
        1 => 'Caonillas Arriba',
        2 => 'Hato Puerco Abajo',
        3 => 'Hato Puerco Arriba',
        4 => 'Vacas',
        5 => 'Villalba Abajo',
        6 => 'Villalba Arriba',
        7 => 'Villalba',
      ),
    'PRYabucoa' =>
      array(
        0 => 'Aguacate',
        1 => 'Calabazas',
        2 => 'Camino Nuevo',
        3 => 'Guayabota',
        4 => 'Jácanas',
        5 => 'Juan Martín',
        6 => 'Limones',
        7 => 'Playa',
        8 => 'Tejas',
        9 => 'Yabucoa',
      ),
    'PRYauco' =>
      array(
        0 => 'Aguas Blancas',
        1 => 'Algarrobo',
        2 => 'Almácigo Alto',
        3 => 'Almácigo Bajo',
        4 => 'Barina',
        5 => 'Caimito',
        6 => 'Collores',
        7 => 'Diego Hernández',
        8 => 'Duey',
        9 => 'Frailes',
        10 => 'Jácana',
        11 => 'Naranjo',
        12 => 'Quebradas',
        13 => 'Ranchera',
        14 => 'Río Prieto',
        15 => 'Rubias',
        16 => 'Sierra Alta',
        17 => 'Susúa Alta',
        18 => 'Susúa Baja',
        19 => 'Vegas',
      )
  );
  return $cities;
}


add_filter('woocommerce_default_address_fields', 'cambiar_labels_campos_direccion');
function cambiar_labels_campos_direccion($fields)
{
  $idioma_actual = pll_current_language();

  switch ($idioma_actual) {
    case 'es_ES':
      $fields['state']['label'] = pll__('Estado/Provincia', 'woocommerce');
      $fields['city']['label'] = pll__('Ciudad', 'woocommerce');
      break;
    case 'en_US':
      $fields['state']['label'] = pll__('State/Province', 'woocommerce');
      $fields['city']['label'] = pll__('City', 'woocommerce');
      break;
    // Agregar más casos según los idiomas que tengas configurados en Polylang
  }

  return $fields;
}




/**
 * @snippet       Hide one shipping rate when Free Shipping is available
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 6
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

add_filter('woocommerce_package_rates', 'bbloomer_unset_shipping_when_free_is_available_in_zone', 9999, 2);

function bbloomer_unset_shipping_when_free_is_available_in_zone($rates, $package)
{
  // Only unset rates if free_shipping is available
  if (isset($rates['free_shipping:1'])) {
    unset($rates['flat_rate:3']);
  }
  return $rates;
}


function redireccion_despues_de_un_tiempo()
{
  if (is_page('comprarya')) {
    echo 'Serás redirigido en 5 segundos...';

    // espera 10 segundos antes de redirigir
    header('Refresh: 5; url=https://amzn.to/2SThfo8');
    exit;
  }
}
add_action('template_redirect', 'redireccion_despues_de_un_tiempo');



// Ocultar el campo "Enviar a una dirección diferente" del formulario de finalizar compra
add_filter('woocommerce_checkout_fields', 'ocultar_ship_to_different_address');
function ocultar_ship_to_different_address($fields)
{
  unset($fields['ship_to_different_address']);
  return $fields;
}


function disable_comments_on_new_posts()
{
  // Deshabilitar comentarios y pingbacks en nuevas publicaciones
  update_option('default_comment_status', 'closed');
  update_option('default_ping_status', 'closed');
}
add_action('publish_post', 'disable_comments_on_new_posts');
add_action('publish_page', 'disable_comments_on_new_posts');

function disable_comments_on_all_posts()
{
  // Obtener todas las publicaciones
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
  );
  $posts = get_posts($args);

  foreach ($posts as $post) {
    // Deshabilitar comentarios y pingbacks en la publicación
    update_post_meta($post->ID, '_wp_comments_status', 'closed');
    update_post_meta($post->ID, '_ping_status', 'closed');
  }
}
add_action('init', 'disable_comments_on_all_posts');

function deshabilitar_recaptcha_en_paginas_sin_formulario()
{
  // Obtén el Page ID actual
  $page_id = get_the_ID();

  // Define los Page IDs donde deseas deshabilitar el script de reCAPTCHA
  $page_ids_sin_formulario = array(43260, 43106); // Reemplaza con los IDs de tus páginas sin formularios

  // Verifica si el Page ID actual está en la lista de IDs sin formularios
  if (!in_array($page_id, $page_ids_sin_formulario)) {
    // Si no estamos en una página sin formulario, deshabilita el script de reCAPTCHA
    wp_dequeue_script('wpcf7-recaptcha');
  }
}

add_action('wp_enqueue_scripts', 'deshabilitar_recaptcha_en_paginas_sin_formulario', 99);







add_filter('woocommerce_billing_fields', 'hacer_state_requerido');

function hacer_state_requerido($fields)
{
  // Hacer el campo 'state' requerido

  $fields['billing_state']['required'] = true;
  return $fields;
}

add_action('init', function () {
  if (function_exists('pll_register_string')) {
    pll_register_string('efl', 'Inicio');
    pll_register_string('efl', 'Lista de deseos');
    pll_register_string('efl', 'Perfil');
    pll_register_string('efl', 'Carrito');
    pll_register_string('efl', 'Buscar');
    pll_register_string('efl', 'Categorias');
    pll_register_string('efl', 'Productos Destacados');
    pll_register_string('efl', 'Ordenar por');
    pll_register_string('efl', 'Ver producto');
    pll_register_string('efl', 'Agregar a carrito');
    pll_register_string('efl', 'Comprar con un click');
    pll_register_string('efl', 'Recomendaciones');
    pll_register_string('efl', 'He leído y acepto los términos y condiciones');
    pll_register_string('efl', 'Si tenés un código promocional o un cupón, por favor canjealo aquí:');
    pll_register_string('efl', 'Costo de envío:');
    pll_register_string('efl', 'Realizar Compra:');
    pll_register_string('efl', 'Carrito de compra');
    pll_register_string('efl', 'Precio');
    pll_register_string('efl', 'Cantidad');
    pll_register_string('woocommerce', 'Aplicar Cupón');
    pll_register_string('woocommerce', 'Guardar');
    pll_register_string('woocommerce', '¿Tenés un cupón?');
    pll_register_string('woocommerce', 'Bienvenido a tu cuenta');
    pll_register_string('woocommerce', 'Pedidos');
    pll_register_string('woocommerce', 'Cerrar la sesión');
	pll_register_string('woocommerce', 'Otra cuidad');
  }
});

// ✅ NUEVO CÓDIGO - SOLO ESTO:
add_filter('pll_rel_hreflang_attributes', function ($hreflangs) {
    // Definir inglés como x-default
    if (isset($hreflangs['en'])) {
        $hreflangs['x-default'] = $hreflangs['en'];
    }
    
    return $hreflangs;
});


add_filter('slim_seo_robots_index', function ($value) {
  return is_author() ? false : $value;
});




// Función que genera el schema del doctor
if (!function_exists('generate_doctor_flikier_schema')) {
    function generate_doctor_flikier_schema($options = array()) {
        $defaults = array(
            'doctor_id'     => 4395,
            'doctor_name'   => 'Dr. Samuel F. Flikier',
            'position'      => 'Especialista en Otorrinolaringología y Cirugía de Cabeza y Cuello',
            'doctor_number' => 'CMC 2723',
            'image'         => '',
            'url'           => site_url('/dr-samuel-f-flikier/'),
            'bio'           => ''
        );

        $options = wp_parse_args($options, $defaults);

        $schema = array(
            '@context'       => 'https://schema.org',
            '@type'          => 'Person',
            'name'           => $options['doctor_name'],
            'honorificPrefix'=> 'Dr.',
            'url'            => $options['url'],
            'givenName'      => 'Samuel',
            'familyName'     => 'Flikier',
            'additionalName' => 'Felix Frajnd',
            'jobTitle'       => $options['position'],
            'identifier'     => array(
                '@type'      => 'PropertyValue',
                'propertyID'=> 'Colegio de Médicos y Cirujanos de Costa Rica',
                'value'     => $options['doctor_number']
            ),
            'knowsLanguage'  => array('es', 'en'),
            'worksFor'       => array(
                '@type'   => 'Hospital',
                'name'    => 'Hospital Metropolitano',
                'address' => array(
                    '@type'            => 'PostalAddress',
                    'streetAddress'    => '300 metros al sur del costado oeste del Parque La Merced, Calle 14, Avenida 8, Edificio Torre Médica B, Piso 2, Consultorio 13',
                    'addressLocality'  => 'San José',
                    'addressCountry'   => 'CR'
                )
            ),
            'alumniOf'       => array(
                array('@type' => 'EducationalOrganization', 'name' => 'Universidad de Costa Rica', 'description' => 'Médico y Cirujano, 1984'),
                array('@type' => 'EducationalOrganization', 'name' => 'Universidad de Costa Rica', 'description' => 'Especialidad en Otorrinolaringología, 1986-1990'),
                array('@type' => 'EducationalOrganization', 'name' => 'Hospital San Juan de Dios'),
                array('@type' => 'EducationalOrganization', 'name' => 'Hospital México'),
                array('@type' => 'EducationalOrganization', 'name' => 'Hospital Nacional de Niños')
            ),
            'memberOf'       => array(
                array('@type' => 'Organization', 'name' => 'Asociación Costarricense de Otorrinolaringología y Cirugía de Cabeza y Cuello'),
                array('@type' => 'Organization', 'name' => 'Academia Americana de Otorrinolaringología y Cirugía de Cabeza y Cuello')
            ),
            'workExample'    => array(
                array(
                    '@type'         => 'ScholarlyArticle',
                    'name'          => 'Tratamiento quirúrgico del vértigo 1985-1989 en el Hospital México',
                    'publisher'     => array('@type' => 'Organization', 'name' => 'Revista Neuroeje'),
                    'pageStart'     => '59',
                    'pageEnd'       => '62',
                    'datePublished' => '1989'
                ),
                array(
                    '@type'         => 'ScholarlyArticle',
                    'name'          => 'Cirugía del Vértigo: Conceptos anatómicos y clínicos',
                    'publisher'     => array('@type' => 'Organization', 'name' => 'Revista Neuroeje'),
                    'pageStart'     => '63',
                    'pageEnd'       => '71',
                    'datePublished' => '1989'
                )
            ),
            'sameAs'         => array(
                'https://www.linkedin.com/in/samuel-felix-flikier-6a407827/?originalSubdomain=cr',
                'https://www.drsamuelflikier.com'
            ),
            'contactPoint'   => array(
                '@type'       => 'ContactPoint',
                'telephone'   => '+506-2521-9650',
                'email'       => 'docflikier@gmail.com',
                'contactType' => 'office'
            ),
            'knowsAbout'     => array(
                'Otorrinolaringología',
                'Cirugía de Cabeza y Cuello',
                'Diagnóstico de enfermedades del oído, nariz y garganta',
                'Cirugía de senos paranasales',
                'Rinoseptoplastía',
                'Tratamiento de apnea del sueño',
                'Cirugía de cornetes',
                'Manejo de trastornos del sueño',
                'Tratamiento de sinusitis crónica'
            ),
            'description'    => !empty($options['bio']) ? $options['bio'] : 'El Dr. Samuel F. Flikier es médico y cirujano con más de 40 años de experiencia en la Caja Costarricense del Seguro Social y más de 36 años de práctica privada.'
        );

        return $schema;
    }
}

// Función que imprime el schema como JSON-LD
if (!function_exists('print_doctor_schema')) {
    function print_doctor_schema($schema, $remove_duplicates = true) {
        static $schema_printed = false;
        if ($schema_printed) return;
        $schema_printed = true;

        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>';

        if ($remove_duplicates) {
            add_action('wp_footer', 'remove_duplicate_jsonld_scripts', 100);
        }
    }
}

// Script para eliminar schemas duplicados
function remove_duplicate_jsonld_scripts() {
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const scripts = document.querySelectorAll("script[type='application/ld+json']");
            let found = false;
            scripts.forEach((script) => {
                if (!found && script.innerHTML.includes('"@type":"Person"')) {
                    found = true;
                } else if (script.innerHTML.includes('"@type":"Person"')) {
                    script.remove();
                }
            });
        });
    </script>
    <?php
}

// Agrega el schema en el footer si la página es del doctor
if (!function_exists('add_doctor_flikier_schema')) {
    function add_doctor_flikier_schema() {
        if (!is_singular()) return;

        global $post;
        $doctor_id = 4395;

        if (!isset($post->post_author) || $post->post_author != $doctor_id) return;

        $options = array(
            'doctor_id' => $doctor_id,
            'url'       => get_permalink(),
        );

        $schema = generate_doctor_flikier_schema($options);

        $schema['isPartOf'] = array(
            '@type' => 'WebPage',
            '@id'   => get_permalink()
        );

        print_doctor_schema($schema);
    }

    add_action('wp_footer', 'add_doctor_flikier_schema', 20);
}



// Añadir script de reCAPTCHA
function agregar_recaptcha_script() {
    wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'agregar_recaptcha_script');

// Validar reCAPTCHA en CF7
add_filter('wpcf7_validate', 'validar_recaptcha_manual', 10, 2);
function validar_recaptcha_manual($result, $tag) {
    // Log para debugging
    error_log('Iniciando validación reCAPTCHA');
    
    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        error_log('No hay respuesta de reCAPTCHA');
        $result->invalidate($tag, 'Por favor, completa el reCAPTCHA');
        return $result;
    }
    
    $secret_key = '6LfZpjgrAAAAAP20G9oRSguRzq6X4J5Cn2rDnv9Q';
    $recaptcha_response = $_POST['g-recaptcha-response'];
    
    $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$recaptcha_response}");
    $body = wp_remote_retrieve_body($response);
    $responseData = json_decode($body, true);
    
    error_log('Respuesta de Google: ' . print_r($responseData, true));
    
    if (!$responseData['success']) {
        error_log('reCAPTCHA falló');
        $result->invalidate($tag, 'Verificación reCAPTCHA fallida');
    } else {
        error_log('reCAPTCHA validado correctamente');
    }
    
    return $result;
}

// Desactiva temporalmente otros filtros de spam
add_filter('wpcf7_spam', '__return_false', 10, 1);









// Función para aplicar noindex y canonical a páginas /products/
function noindex_products_and_canonical() {
    $current_url = $_SERVER['REQUEST_URI'];
    
    // Aplicar noindex a páginas /products/
    if (strpos($current_url, '/products/') !== false) {
        echo '<meta name="robots" content="noindex,follow" />' . "\n";
        
        // Detectar idioma y establecer canonical al shop correspondiente
        if (strpos($current_url, '/es/') !== false) {
            $canonical_url = 'https://efficientlabs.com/es/shop/';
        } elseif (strpos($current_url, '/en/') !== false) {
            $canonical_url = 'https://efficientlabs.com/en/shop/';
        } else {
            // Por defecto inglés si no se detecta idioma
            $canonical_url = 'https://efficientlabs.com/en/shop/';
        }
        
        echo '<link rel="canonical" href="' . esc_url($canonical_url) . '" />' . "\n";
    }
}
add_action('wp_head', 'noindex_products_and_canonical');

// Eliminar canonical de Yoast para páginas /products/
function remove_yoast_canonical_for_products($canonical) {
    if (strpos($_SERVER['REQUEST_URI'], '/products/') !== false) {
        return false;
    }
    return $canonical;
}
add_filter('wpseo_canonical', 'remove_yoast_canonical_for_products');










// TRACKING EVENTS PARA EFFICIENT LABS
// Agregar al final de functions.php

function efficient_labs_tracking_scripts() {
    if (!is_admin()) {
        ?>
        <script>
        (function() {
            'use strict';
            
            function initTracking() {
                console.log('🚀 Efficient Labs Tracking Initialized');
                trackAmazonClicks();
                trackCTAClicks();
                trackFormSubmissions();
                trackScrollDepth();
                
                // Log de elementos encontrados
                setTimeout(function() {
                    console.log('📊 Elements found:');
                    console.log('  Amazon product buttons:', document.querySelectorAll('.aawp-button--buy[href*="amazon"]').length);
                    console.log('  Amazon store buttons:', document.querySelectorAll('.btn-group-buy.amazon a').length);
                    console.log('  Store locator buttons:', document.querySelectorAll('.btn-group-buy.pts-venta a').length);
                    console.log('  Buy online buttons:', document.querySelectorAll('.btn-group-buy.carrito a').length);
                    console.log('  Forms:', document.querySelectorAll('form').length);
                }, 100);
            }
            
            // AMAZON CLICKS
            function trackAmazonClicks() {
                // Productos individuales AAWP
                document.querySelectorAll('.aawp-button--buy[href*="amazon"]').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const container = btn.closest('.aawp-product');
                        const productName = container?.getAttribute('data-aawp-product-title') || 
                                          container?.querySelector('.aawp-product__title')?.textContent?.trim() || 
                                          'Unknown Product';
                        const price = container?.querySelector('.aawp-product__price--current')?.textContent?.trim() || 'No price';
                        const asin = container?.getAttribute('data-aawp-product-asin') || 'No ASIN';
                        
                        console.log('🛒 Amazon Product Click:', productName, '|', price, '| ASIN:', asin);
                        
                        gtag('event', 'amazon_click', {
                            'product_name': productName.substring(0, 100),
                            'product_price': price,
                            'product_asin': asin,
                            'button_type': 'product_buy_button',
                            'click_url': btn.href,
                            'source_page': window.location.pathname
                        });
                    });
                });
                
                // Botón general Amazon
                document.querySelectorAll('.btn-group-buy.amazon a[href*="amazon"]').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        console.log('🏪 Amazon Store Click:', btn.textContent.trim());
                        
                        gtag('event', 'amazon_click', {
                            'product_name': 'General Store Visit',
                            'button_type': 'general_store_button',
                            'button_text': btn.textContent.trim(),
                            'click_url': btn.href,
                            'source_page': window.location.pathname
                        });
                    });
                });
            }
            
            // CTA CLICKS
            function trackCTAClicks() {
                // Points of Sale
                document.querySelectorAll('.btn-group-buy.pts-venta a').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        console.log('📍 Store Locator Click:', btn.textContent.trim());
                        
                        gtag('event', 'cta_click', {
                            'button_text': btn.textContent.trim(),
                            'cta_type': 'store_locator',
                            'destination_url': btn.href
                        });
                    });
                });
                
                // Buy Online
                document.querySelectorAll('.btn-group-buy.carrito a').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        console.log('🛒 Buy Online Click:', btn.textContent.trim());
                        
                        gtag('event', 'cta_click', {
                            'button_text': btn.textContent.trim(),
                            'cta_type': 'buy_online',
                            'destination_url': btn.href
                        });
                    });
                });
                
                // Product images/titles
                document.querySelectorAll('.aawp-product__image--link, .aawp-product__title').forEach(function(link) {
                    link.addEventListener('click', function() {
                        const container = link.closest('.aawp-product');
                        const productName = container?.getAttribute('data-aawp-product-title') || 'Unknown Product';
                        
                        console.log('🖼️ Product Details Click:', productName.substring(0, 50));
                        
                        gtag('event', 'cta_click', {
                            'cta_type': 'product_details',
                            'product_name': productName.substring(0, 100),
                            'destination_url': link.href
                        });
                    });
                });
            }
            
            // FORM SUBMISSIONS
            function trackFormSubmissions() {
                document.querySelectorAll('form').forEach(function(form, index) {
                    form.addEventListener('submit', function() {
                        const formText = form.textContent.toLowerCase();
                        const formClass = form.className.toLowerCase();
                        const formId = form.id.toLowerCase();
                        
                        let formType = 'general';
                        if (formText.includes('contact') || formClass.includes('contact') || formId.includes('contact')) {
                            formType = 'contact';
                        } else if (formText.includes('newsletter') || formClass.includes('newsletter')) {
                            formType = 'newsletter';
                        } else if (formText.includes('distribuidor') || formClass.includes('distribuidor')) {
                            formType = 'distributor';
                        }
                        
                        console.log('📝 Form Submit:', formType, '| ID:', form.id || `form-${index}`);
                        
                        gtag('event', 'form_submit', {
                            'form_id': form.id || `form-${index}`,
                            'form_type': formType,
                            'page_location': window.location.href
                        });
                    });
                });
            }
            
            // SCROLL DEPTH
            function trackScrollDepth() {
                const scrollPercentages = [25, 50, 75, 90];
                const trackedPercentages = [];
                const pageStartTime = Date.now();
                
                window.addEventListener('scroll', function() {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                    const scrollPercent = Math.round((scrollTop / docHeight) * 100);
                    
                    scrollPercentages.forEach(function(percentage) {
                        if (scrollPercent >= percentage && !trackedPercentages.includes(percentage)) {
                            trackedPercentages.push(percentage);
                            
                            console.log('📜 Scroll Depth:', percentage + '%');
                            
                            gtag('event', 'scroll_progress', {
                                'scroll_depth': percentage,
                                'time_on_page': Math.round((Date.now() - pageStartTime) / 1000)
                            });
                        }
                    });
                });
            }
            
            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initTracking);
            } else {
                initTracking();
            }
        })();
        </script>
        <?php
    }
}
add_action('wp_footer', 'efficient_labs_tracking_scripts');

// MARCAR EVENTOS COMO CONVERSIONES EN GA4
// Nota: Esto debe hacerse manualmente en GA4 Admin > Events
function efficient_labs_tracking_info() {
    if (current_user_can('manage_options')) {
        echo '<!-- 
        EVENTOS CONFIGURADOS:
        - amazon_click (product_buy_button, general_store_button)
        - cta_click (store_locator, buy_online, product_details)  
        - form_submit (contact, newsletter, distributor, general)
        - scroll_progress (25%, 50%, 75%, 90%)
        
        CONFIGURAR EN GA4:
        1. Admin > Events
        2. Marcar como conversiones: amazon_click, form_submit, cta_click
        3. Crear audiencias personalizadas
        -->';
    }
}
add_action('wp_head', 'efficient_labs_tracking_info');

// FUNCIÓN PARA DEBUGGING (OPCIONAL)
function efficient_labs_debug_tracking() {
    if (current_user_can('manage_options') && isset($_GET['debug_tracking'])) {
        ?>
        <script>
        setTimeout(function() {
            console.log('🔍 EFFICIENT LABS DEBUG MODE');
            console.log('=================================');
            console.log('Amazon product buttons found:', document.querySelectorAll('.aawp-button--buy[href*="amazon"]').length);
            console.log('Amazon store buttons found:', document.querySelectorAll('.btn-group-buy.amazon a').length);
            console.log('Store locator buttons found:', document.querySelectorAll('.btn-group-buy.pts-venta a').length);
            console.log('Buy online buttons found:', document.querySelectorAll('.btn-group-buy.carrito a').length);
            console.log('Product images/titles found:', document.querySelectorAll('.aawp-product__image--link, .aawp-product__title').length);
            console.log('Forms found:', document.querySelectorAll('form').length);
            console.log('=================================');
            console.log('Add ?debug_tracking=1 to URL to see this debug info');
        }, 500);
        </script>
        <?php
    }
}
add_action('wp_footer', 'efficient_labs_debug_tracking');











// REEMPLAZAR el código anterior con este:

function efficient_labs_gtm_head() {
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-N3998W56');</script>
    <!-- End Google Tag Manager -->
    <?php
}
add_action('wp_head', 'efficient_labs_gtm_head');

// SOLUCIÓN ALTERNATIVA para el body (cuando wp_body_open no funciona)
function efficient_labs_gtm_body_fallback() {
    ?>
    <script>
    // Insertar GTM noscript cuando la página cargue
    document.addEventListener('DOMContentLoaded', function() {
        if (!document.querySelector('iframe[src*="googletagmanager.com/ns.html"]')) {
            var noscriptFrame = document.createElement('noscript');
            noscriptFrame.innerHTML = '<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N3998W56" height="0" width="0" style="display:none;visibility:hidden"></iframe>';
            document.body.insertBefore(noscriptFrame, document.body.firstChild);
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'efficient_labs_gtm_body_fallback');

// OPCIÓN ALTERNATIVA: Via output buffering (más agresiva)
function efficient_labs_gtm_body_ob() {
    ob_start('efficient_labs_add_gtm_to_body');
}

function efficient_labs_add_gtm_to_body($html) {
    $gtm_noscript = '<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N3998W56"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->';
    
    // Insertar después de <body>
    $html = preg_replace('/(<body[^>]*>)/i', '$1' . $gtm_noscript, $html);
    return $html;
}





