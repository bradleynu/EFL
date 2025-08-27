<?php $categories = get_categories( array(
	'taxonomy' => 'product_cat',
	'parent' => 0
) ); ?>
<div class="sidebar">
	<div class="widget widget-categories">
		<h3><?php echo pll_e( 'Categorias', 'elf'); ?></h3>
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			<?php foreach($categories as $cat): ?>
			<div class="panel panel-default">
				<?php $subcats = get_categories( array(
					'taxonomy' => 'product_cat',
					'parent' => $cat->term_id
				) ); ?>
				<?php if(count($subcats)): ?>
				<div class="panel-heading" id="heading-<?php echo esc_attr($cat->term_id) ?>" role="tab">
					<div class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo esc_attr($cat->term_id) ?>" aria-expanded="true" aria-controls="collapse-<?php echo esc_attr($cat->term_id) ?>"><?php echo esc_html( $cat->name ); ?></a></div>
				</div>
				<div class="panel-collapse collapse <?php echo lanco_active_parent_cat($cat, $subcats, 'in') ?>" id="collapse-<?php echo esc_attr($cat->term_id) ?>" role="tabpanel" aria-labelledby="heading-<?php echo esc_attr($cat->term_id) ?>">
					<div class="panel-body">
						<ul class="list-unstyled reset">
								<?php foreach($subcats as $subcat):

									$subSubCats = get_categories( array(
										'taxonomy' => 'product_cat',
										'parent' => $subcat->term_id
									));
									if (count($subSubCats) == 0 ): ?>
										<li>
											<a href="<?php echo get_category_link( $subcat->term_id ); ?>"><?php echo esc_html($subcat->name) ?></a>
										</li>
									<?php else: ?>
										<li>
											<div class="panel-group" id="accordion-intern" role="tablist" aria-multiselectable="true">

												  <div class="panel panel-default">
												    <div class="panel-heading" role="tab" id="heading-<?php echo esc_attr($subcat->term_id) ?>">
												      <h4 class="panel-title nomargin">
												        <a role="button" data-toggle="collapse" data-parent="#accordion-intern" href="#collapse-<?php echo esc_attr($subcat->term_id) ?>" aria-expanded="true" aria-controls="collapse-<?php echo esc_attr($subcat->term_id) ?>">
												          <?php echo esc_html($subcat->name) ?>
												        </a>
												      </h4>
												    </div>
												    <div id="collapse-<?php echo esc_attr($subcat->term_id) ?>" class="panel-collapse collapse  <?php echo lanco_active_parent_cat($subcat, $subSubCats, 'in') ?>" id="collapse-<?php echo esc_attr($cat->term_id) ?>" role="tabpanel" aria-labelledby="heading-<?php echo esc_attr($subcat->term_id) ?>">
												      <div class="panel-body">
															<ul class="list-unstyled reset">
																<?php foreach($subSubCats as $subsubcat): ?>
																	<li>
																		<a href="<?php echo get_category_link( $subsubcat->term_id ); ?>"><?php echo esc_html($subsubcat->name) ?></a>
																	</li>
																<?php endforeach ?>
															</ul>
												      </div>
												    </div>
												  </div>

											</div>
										</li>
									<?php endif; ?>
								<?php endforeach ?>
						</ul>
					</div>
				</div>
				<?php else: ?>
				<div class="panel-heading" id="heading-<?php echo esc_attr($cat->term_id) ?>" role="tab">
					<div class="panel-title"><a role="button" href="<?php echo get_category_link( $cat->term_id ); ?>"><?php echo esc_html( $cat->name ); ?></a></div>
				</div>
				<?php endif ?>
			</div>
			<?php endforeach ?>
		</div>
	</div>
</div>