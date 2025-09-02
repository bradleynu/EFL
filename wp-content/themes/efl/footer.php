<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Lanco_Store
 */

?>

<?php get_template_part( 'template-parts/popup', 'coupon' ); ?>

<footer  id="footer">
	<a class="back-top" href="#"><?php echo esc_html__( 'Volver al principio', 'lanco' ); ?></a>
	<div class="footer">
		<div class="container">
			<div class="bottom clearfix">
			<!-- 	<a id="logo-bottom" href="<?php echo site_url() ?>">Lanco</a> -->
				<?php wp_nav_menu( array(
					'theme_location' => 'footer',
					'container' => false,
					'menu_class' => 'list-inline footer-menu pull-left'
				) ); ?>
				<div class="pull-right" style="display: flex;align-items: center;">
					<div style="margin-right: 10px;">
						<a target="_blank" href="https://www.facebook.com/efficientlabs" style="
    font-size: 24px;
    color: white;
    position: relative;
    top: 2px;
    margin-right: 10px;
"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
						<a target="_blank" href="https://www.instagram.com/efficient_labs/" style="
    font-size: 24px;
    color: white;
    position: relative;
    top: 2px;
	margin-right: 10px;
"><i class="fa fa-instagram" aria-hidden="true"></i></a>
	<a target="_blank" href="https://www.youtube.com/channel/UCmA1mylg7S3TyN81ROhhHFw" style="
    font-size: 24px;
    color: white;
    position: relative;
    top: 2px;
"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
					</div>
					<p class="copy"><?php printf( esc_html__( 'Copyright &copy; %s EfficientLabs.', 'lanco' ) , date('Y') ) ?></p>
				</div>
			</div>
		</div>
	</div>
	<!-- <div id="boxes">
		<div style="top: 50%; left: 50%; display: none;" id="dialog" class="window"> 
			<div id="san">
				<a href="#" class="close agree"><i style="float:right; margin-right: -25px; margin-top: -32px;" class="fa fa-times-circle" aria-hidden="true"></i></a>
				<p>¡Hola! Te contamos que nuestras tiendas físicas estarán cerradas durante la Semana Santa pero nuestra tienda en línea se mantiene abierta por lo que podés realizar tu pedido y el mismo se estará entregando a partir del lunes 13 de abril. ¡Gracias por preferirnos y elegir Lanco! </p>
				<p>*Todas las órdenes que ingresen del viernes 03 de abril a las 5:00 p.m. hasta el domingo 12 de abril se estarán entregando a partir del lunes 13 de abril.</p>
				<button class="close">Aceptar</button>
			</div>
		</div>
		<div style="width: 2478px; font-size: 32pt; color:white; height: 1202px; display: none; opacity: 0.4;" id="mask"></div>
	</div>
	<div class="advice">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-7 text"><p>*Todas las órdenes que ingresen del viernes 03 de abril a las 5:00 p.m. hasta el domingo 12 de abril se estarán entregando a partir del lunes 13 de abril.</p></div>
				<div class="col-xs-12 col-md-5 btn"><button class="js-btn-close">Aceptar</button></div>
			</div>
		</div>
	</div> -->
</footer>
<div class="logo-floted">
	<img src="https://efficientlabs.com/wp-content/uploads/2025/08/mbe-certification-1.png" alt="" class="img-fluid">
</div>
<?php //wp_footer(); ?>
</body>
</html>