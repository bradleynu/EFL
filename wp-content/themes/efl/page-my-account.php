<?php /* Template Name: My Account */ ?>

<?php get_header(); the_post(); ?>

<section id="content">
	<?php if(is_user_logged_in()) : ?>
		<div class="woocomerce-top-my-account">
			<div class="main-title top-shadow">
				<div class="container">
					<?php 
						$user_meta = get_user_meta(wp_get_current_user()->ID);
						if(!empty($user_meta['first_name'][0]) /*&& !empty($user_meta['last_name'][0])*/) {
							$display_name = $user_meta['first_name'][0] ;//. ' ' . $user_meta['last_name'][0];
						} else {
							$display_name = wp_get_current_user()->display_name;
						}
					?>
					<div class="row">
						<div class="col-sm-1 col-md-1 text-center">
							<div class="top-my-account-avatar">
								<img src="<?php echo get_avatar_url(wp_get_current_user()->ID); ?>" alt="">
							</div>
						</div>
						<div class="col-sm-8 col-md-8">
							<h2 class="top-my-account-title"><?php echo pll_e('Bienvenido a tu cuenta', 'woocommerce')?><?php echo ' ', $display_name; ?></h2>
						</div>
						<div class="col-sm-3 col-md-3 m15">
							<div class="row">
								<div class="col-sm-6 col-md-6 text-center top-my-account-controls">
									<span class="top-my-account-orders">
										<strong><?php echo wc_get_customer_order_count(wp_get_current_user()->ID); ?></strong>
									</span>
									<a class="top-my-account-link gray-link" href="/my-account/orders/" class="col-sm-6 col-md-6 text-center">
									<?php echo pll_e('Pedidos', 'woocommerce')?>
									</a>
								</div>
								<div class="col-sm-6 col-md-6 text-center top-my-account-controls">
									<i class="top-my-account-icon"></i>
									<a class="top-my-account-link gray-link" href="<?php echo wp_logout_url('/my-account/'); ?>" class="col-sm-6 col-md-6 text-center">
										<?php echo pll_e('Cerrar la sesión', 'woocommerce')?>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif ?>

	<div class="content top-shadow">
		<div class="container vertical-padding">
			<div class="main-title">
				<h2><?php the_title(); ?></h2>
				<hr>
			</div>
			<?php the_content(); ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
