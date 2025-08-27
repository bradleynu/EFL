<?php /* Template Name: Help */ ?>
<?php get_header() ?>
<?php the_post() ?>
<section id="content">

	<div class="main-title top-shadow text-center">
		<?php $user = wp_get_current_user() ? wp_get_current_user()->display_name : '' ?>
		<h2><?php echo str_replace('%user', $user, get_the_title()); ?></h2>
	</div>

	<?php $boxes = get_field('boxes') ?>
	<!--
	<?php if(count($boxes) > 0): ?>
	<div class="content-gray top-shadow">
		<div class="container vertical-padding">
			<div class="row">
				<?php foreach($boxes as $box): ?>
					<div class="col-sm-4">
						<div class="box row">
							<div class="col-xs-3"><img class="icon" src="<?php echo $box['icon'] ?>"></div>
							<div class="box-text col-xs-9">
								<h4 class="sub-title"><?php echo $box['title'] ?></h4>
								<p><?php echo $box['description'] ?></p>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<?php endif ?>
	-->

	<div class="content-gray top-shadow">
		<div class="container vertical-padding">
			<div class="row">
				<div class="col-sm-4">
					<div class="box row">
						<div class="col-xs-3"><img class="icon" src="/wp-content/uploads/2017/03/box-icon-1.png"></div>
						<div class="box-text col-xs-9">
							<h4 class="sub-title">Configuración de la cuenta</h4>
							<p><a class="gray-link" href="/my-account/edit-account/">Detalle de la cuenta</a></p>
							<p><a class="gray-link" href="/my-lists/">Lista de deseos</a></p>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="box row">
						<div class="col-xs-3"><img class="icon" src="/wp-content/uploads/2017/03/box-icon-2.png"></div>
						<div class="box-text col-xs-9">
							<h4 class="sub-title">Pagos y envío</h4>
							<p><a class="gray-link" href="/my-account/edit-address/">Direcciones</a></p>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="box row">
						<div class="col-xs-3"><img class="icon" src="/wp-content/uploads/2017/03/box-icon-3.png"></div>
						<div class="box-text col-xs-9">
							<h4 class="sub-title">Tus órdenes</h4>
							<p><a class="gray-link" href="/my-account/orders/">Pedidos</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php $secciones = get_field('secciones') ?>

	<?php if(count($secciones) > 0): ?>
	<div class="content">
		<div class="container vertical-padding-min">
			<div class="main-title">

				<h2><?php echo esc_html__( 'Temas de ayuda', 'lanco' ); ?></h2>

			</div>
			<div class="row help">
				<div class="col-sm-3">
					<ul class="nav nav-pills nav-stacked" role="tablist">

						<?php foreach($secciones as $k => $seccion): ?>
							<li class="<?php echo $k === 0 ? esc_attr('active') : '' ?>" role="presentation"><a href="#tab-help-<?php echo esc_attr( $k ); ?>" aria-controls="tab-help-<?php echo esc_attr( $k ); ?>" role="tab" data-toggle="tab"><?php echo $seccion['title'] ?></a></li>
						<?php endforeach ?>

					</ul>
				</div>
				<div class="col-sm-9">
					<div class="tab-content">

						<?php foreach($secciones as $k => $seccion): ?>
						<div class="tab-pane <?php echo $k === 0 ? esc_attr('active fade in') : '' ?>" id="tab-help-<?php echo esc_attr( $k ); ?>" role="tabpanel">
							<div class="panel-group" id="accordion-help-<?php echo esc_attr( $k ); ?>" role="tablist" aria-multiselectable="true">

								<?php foreach($seccion['preguntas'] as $j => $pregunta): ?>
								<div class="panel panel-default">
									<div class="panel-heading" id="heading-help-<?php echo esc_attr( $k ); ?>-q<?php echo esc_attr( $j ); ?>" role="tab">
										<h4 class="panel-title">
											<a class="<?php echo $j !== 0 ? esc_attr( 'collapsed' ) : '' ; ?>"
											   role="button" data-toggle="collapse"
											   data-parent="#accordion-help-<?php echo esc_attr( $k ); ?>"
											   href="#panel-help-<?php echo esc_attr( $k ); ?>-a<?php echo esc_attr( $j ); ?>"
											   aria-expanded="true"
											   aria-controls="panel-help-<?php echo esc_attr( $k ); ?>-a<?php echo esc_attr( $j ); ?>">
												<?php echo $pregunta['pregunta'] ?>
											</a>
										</h4>
									</div>

									<div class="panel-collapse collapse <?php echo $j === 0 ? esc_attr( 'in' ) : '' ; ?>"
										 id="panel-help-<?php echo esc_attr( $k ); ?>-a<?php echo esc_attr( $j ); ?>"
										 role="tabpanel" aria-labelledby="heading-help-<?php echo esc_attr( $k ); ?>-q<?php echo esc_attr( $j ); ?>">
										<div class="panel-body">
											<p><?php echo $pregunta['respuesta'] ?></p>
										</div>
									</div>
								</div>
								<?php endforeach ?>

							</div>
						</div>
						<?php endforeach ?>

					</div>
				</div>
			</div>
		</div>
  	</div>
	<?php endif ?>
</section>
<?php get_footer() ?>