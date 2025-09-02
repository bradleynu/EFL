<?php
/**
 * Template Name: Full Width
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Lanco_Store
 */

get_header(); 

the_post();

?>
<?php if(get_field('slider') != ""): ?>

	<section id="hero">
		<?php echo do_shortcode( '[rev_slider alias="'.get_field('slider').'"]' ); ?>
	</section>

<?php endif ?>
<section id="content">
	<?php if(get_field('slider') == ""): ?>
	<div class="content top-shadow">
	<?php endif ?>
	<?php if(get_field('content_gray')): ?>
	<div class="content-gray">
	<?php endif ?>
	<div class="container vertical-padding lanco-products">
		<div class="row">
			<div class="col-sm-12">

				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">

						<?php					

							get_template_part( 'template-parts/content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						?>

						<?php if(is_front_page() && is_active_sidebar( 'home' )): ?>
						
						<div class="row">

							<?php dynamic_sidebar( 'home' ); ?>
						
						</div>

						<?php endif ?>

					</main><!-- #main -->
				</div><!-- #primary -->
			</div>
		</div>
	</div>
	<?php if(get_field('content_gray')): ?>
	</div>
	<?php endif ?>
	<?php if(get_field('slider') == ""): ?>
	</div>
	<?php endif ?>
</section>
<?php
get_footer();
