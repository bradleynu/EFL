<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Lanco_Store
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/dist/images/favicon.png?v=1.1">
<?php wp_head(); ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-177820351-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-177820351-1');
</script>
<meta name="facebook-domain-verification" content="oyiux9z93nkwe40whmxpi4jl54n3uk" />
<meta name="google-site-verification" content="1cn6d9x2FoMe536leFZ9KZnSrPg4ciT8ZmK3bXMoqfo" />

<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1191205752262538');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1191205752262538&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->


</head>
<body <?php body_class(); ?>>
<header id="header">
	<section class="first-header">
		<div class="container">
			<div class="row">
				
			<div class="col-md-3 flex-middle hide-mobile">
				<a href="<?php echo site_url() ?>"><img class="little-logo" src="<?php echo get_template_directory_uri(); ?>/assets/dist/images/Logo_EFL.png" alt=""></a>
			</div>
			<div class="col-md-9" style="display: flex;justify-content: flex-end;">
			<!-- <h1 id="logo"><a href="<?php echo site_url(); ?>">Lanco</a></h1>
			<form class="form-inline hidden-xs" action="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
				<div class="form-group">
					<input class="form-control" name="s" placeholder="<?php echo esc_html__( 'Estoy buscando...', 'lanco' ); ?>" value="<?php echo is_search() ? esc_html( get_search_query() ) : '' ?>">
				</div>
				<div class="form-group select-field">

					<select class="form-control" name="category">
						<option value=""><?php echo esc_html__( 'Todas las categorías', 'lanco' ); ?></option>
						<?php foreach(lanco_get_wc_categories() as $cat): ?>
						<option <?php echo is_search() && ($cat->slug == $_GET['category']) ? 'selected' : '' ?> value="<?php echo esc_attr( $cat->slug ) ?>"><?php echo esc_html( $cat->name ) ?></option>
						<?php endforeach ?>
					</select>

					<span class="caret"></span>

				</div>
				<button class="btn btn-primary"><i class="fa fa-search"></i></button>
				<input type="hidden" name="post_type" value="product" />
			</form> -->

			<ul class="top-menu list-inline">
				<li><a href="<?php echo site_url() ?>"><!--  <i class="fa fa-home"></i> --><span><?php echo pll_e( 'Inicio', 'efl'); ?></span></a></li>
				<<!-- li><a href="<?php echo get_permalink( WC_Wishlists_Pages::get_page_id( 'my-lists' ) ) ?>"> <i class="fa fa-heart-o red"></i><span><?php echo pll_e( 'Lista de deseos', 'efl'); ?></span></a></li> -->
				<li><a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>"> <!-- <i class="fa fa-user-o"></i> --><span><?php echo pll_e( 'Perfil', 'efl' ); ?></span></a></li>
				<li><a href="/my-lists/"><?php echo pll_e( 'Lista de deseos', 'efl'); ?></a></li>
				<li><a href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>">
					<?php if(WC()->cart->get_cart_contents_count() > 0): ?>
					<span class="bubble"><?php echo WC()->cart->get_cart_contents_count() ?></span>
					<?php endif ?>
					<span><?php echo pll_e( 'Carrito', 'efl'); ?></span> <i class="fa fa-shopping-cart"></i></a></li>
					<li class="mobile-ham" style="display: none;"><a href="#"><span><i class="fa fa-bars" aria-hidden="true"></i></span></a></li>
			</ul>
			<form class="form-inline hidden-xs hidden-sm" action="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
				<div class="form-group">
					<input style="color: white;max-width: 150px;" class="form-control" name="s" placeholder="<?php echo pll_e( 'Buscar', 'efl' ); ?>" value="<?php echo is_search() ? esc_html( get_search_query() ) : '' ?>">
				</div>
		<!-- 		<div class="form-group select-field">

					<select class="form-control" name="category">
						<option value=""><?php echo esc_html__( 'Categorías', 'lanco' ); ?></option>
						<?php foreach(lanco_get_wc_categories() as $cat): ?>
						<option <?php echo is_search() && ($cat->slug == $_GET['category']) ? 'selected' : '' ?> value="<?php echo esc_attr( $cat->slug ) ?>"><?php echo esc_html( $cat->name ) ?></option>
						<?php endforeach ?>
					</select>

					<span class="caret"></span>

				</div> -->
				<button class="btn btn-primary"><i class="fa fa-search"></i></button>
				<input type="hidden" name="post_type" value="product" />
			</form>
		</div>
	</div>
	</div>
	</section>
	<nav class="menu">
		<div class="container h-100">
			<form class="form-inline visible-xs visible-sm" action="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
				<div class="form-group">
					<input class="form-control" name="s" placeholder="<?php echo esc_html__( 'Estoy buscando...', 'lanco' ); ?>" value="<?php echo is_search() ? esc_html( get_search_query() ) : '' ?>">
				</div>
		<!-- 		<div class="form-group select-field">

					<select class="form-control" name="category">
						<option value=""><?php echo esc_html__( 'Categorías', 'lanco' ); ?></option>
						<?php foreach(lanco_get_wc_categories() as $cat): ?>
						<option <?php echo is_search() && ($cat->slug == $_GET['category']) ? 'selected' : '' ?> value="<?php echo esc_attr( $cat->slug ) ?>"><?php echo esc_html( $cat->name ) ?></option>
						<?php endforeach ?>
					</select>

					<span class="caret"></span>

				</div> -->
				<button class="btn btn-primary"><i class="fa fa-search"></i></button>
				<input type="hidden" name="post_type" value="product" />
			</form>
		</div>
		<?php wp_nav_menu( array(
			'theme_location' => 'menu-1',
			'container_class' => 'container',
			'menu_class' => 'main-menu list-inline',
			'walker' => new Lanco_Main_Menu_Walker
		) ); ?>
	</nav>
	<?php
		// Obtén la ID del post de la página actual
		$current_post_id = get_queried_object_id();

		// Obtén el idioma actual
		$current_language = pll_current_language();

		// Define las fechas de cierre de la tienda
		$fecha_inicio_cierre = strtotime('2024-12-18');
		$fecha_fin_cierre = strtotime('2025-01-06');

		// Verifica si la tienda está cerrada
		if (time() >= $fecha_inicio_cierre && time() <= $fecha_fin_cierre) {
			// Mostrar mensaje en diferentes idiomas
			switch ($current_language) {
				case 'es':
					$mensaje = 'La tienda está cerrada desde el 20 de diciembre de 2024 hasta el 6 de enero de 2024.';
					break;

				case 'en':
					$mensaje = 'The store is closed from December 20 2024 to January 6 2025.';
					break;

					// Agrega más casos según los idiomas que necesites

				default:
					$mensaje = 'La tienda está cerrada desde el 20 de diciembre de 2024 hasta el 6 de enero de 2025.';
					break;
			}

			// Muestra el mensaje
			echo '<div class="aviso-cierre-tienda" style="
    background: green;
    text-align: center;
    color: white;
    padding: 4px;
	font-size: 11px;
">' . esc_html($mensaje) . '</div>';
		}
	?>
</header>