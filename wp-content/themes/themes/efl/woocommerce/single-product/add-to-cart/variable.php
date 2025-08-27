<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$attribute_keys = array_keys( $attributes );
$is_price_empty = true;// empty($first['price_html']);

if(is_array($available_variations)) {
	foreach($available_variations as $variation) {
		if(!empty($variation['price_html']))
			$is_price_empty = false;
	}
} else {
	$is_price_empty = false;
}

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart <?php echo $is_price_empty ? 'hide-variation-price' : '' ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
						<td class="label"><label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label></td>
						<td class="value">
							<?php
								$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) ) : $product->get_variation_default_attribute( $attribute_name );
								wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
								echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) : '';
							?>
						</td>
					</tr>
				<?php endforeach;?>
				<tr class="customcolor">
					<td>
						<?php 
						   	$pastel = get_field('base_pastel');
						   	$tint = get_field('base_tint');
						   	$deep = get_field('base_deep');
						   	$accent = get_field('base_accent');
						   	$pres = get_field('combination_press');
						   	$format_template = get_field('sku_format');
						   	$ter_base = get_field('ter_base');
						   	$ter_base_sat = get_field('ter_base_sat');
						   	$format_template2 = get_field('sku_format_sat');
						   	$format_template3 = get_field('sku_format_sembri');
						   	$format_template4 = get_field('sku_format_bri');
						   	$term_sebri = get_field('sembri');
						   	$termbri = get_field('ter_bri');

						?>
						<label class="hide-in" for="pa_presentacion"><strong>Color Personalizado :</strong></label>
						<div style="position: relative;min-height: 65px;display: flex;justify-content: space-between;align-items: center;" class="hide-in">
							<button type="submit" class="btn btn-primary js-color" data-toggle="modal" data-target="#exampleModal"  data-pastel="<?php echo $pastel; ?>" data-tint="<?php echo $tint; ?>" data-deep="<?php echo $deep; ?>" data-accent="<?php echo $accent; ?>" data-pres="<?php echo $pres; ?>" data-format="<?php echo $format_template; ?>" data-term="<?php echo $ter_base; ?>" data-termsat="<?php echo $ter_base_sat; ?>" data-format2="<?php echo $format_template2; ?>" data-format3="<?php echo $format_template3; ?>" data-format4="<?php echo $format_template4; ?>" data-sembri="<?php echo $term_sebri; ?>" data-termbri ="<?php echo $termbri; ?>"></button>
							<?php echo do_shortcode('[alg_display_product_input_fields]'); ?>
							<i class="js-color-icon color-icon fa fa-tint" aria-hidden="true"></i>
						</div>
					</td>
				</tr>
			</tbody>
		</table>

		<?php if($is_price_empty): ?>
		<div class="woocommerce-variation-price">
			<span class="price">
				<?php echo $product->get_price_html(); ?>
			</span>
		</div>
		<?php endif ?>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap">
			<?php
				/**
				 * woocommerce_before_single_variation Hook.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<main class="cd-main-content">
				   <!-- palette -->
				   <div class="container" style="margin-top: 5px; margin-bottom: 5px;">
				      <div class="col-xs-12 bg-gray-3 border-gray-2">
				         <div class="col-xs-12 Pad0" style="margin-bottom: 5px;">
				            <h4 style="margin-top: -35px; font-size: 17px;" class="let-sp-1f-w-500 text-darkgray text-left"><?php _e('Selección de color personalizada','lanco') ?></h4>
				           <!--  <hr class="col-xs-12 Pad0" style="margin-top: 0px; margin-bottom: 0px; border-top: 1px solid rgba(216, 216, 216, 1);"> -->
				         </div>
				         
				      </div>
				   </div>
				   <div class="col-xs-12 Pad0 tab-content" style="">
				      <div id="colores-all" class="tab-pane fade in active col-xs-12 Pad0" style="">
				         <div class="col-xs-12 Pad0 bg-gray-3" style="overflow: hidden;">
				            <div class="container" style="margin-top: 25px; margin-bottom: 30px;">
				            	<div class="step1">
				            		<span>1</span><p>Seleccione el tono o busque su color por código</p>
				            	</div>
				               <div class="col-xs-12">
				                  <div id="owl-palette" class="owl-carousel-palette owl-theme">
				                  </div>
				               </div>
				            </div>
				         </div>
				         <div class="col-xs-12 js-blockcolor" style="margin-bottom:20px;">
				         	<div class="search-colrs container" style="display: flex;flex-direction: row;justify-content: flex-start;align-items: center;">
				         		<input type="text" name="" id="js-search-colors" placeholder="Buscar por código" style="margin-bottom: 20px;margin-right: 10px;">
				         		<input type="text" name="" id="js-search-colors-code" placeholder="Buscar por nombre" style="margin-bottom: 20px;">
				         	</div>
				         	<div class="container">
				         		<div class="col-xs-12 step1">
				            		<span>2</span><p>Seleccione su color</p>
				            	</div>
				            	<div class="results"></div>
				         	</div>
				            <div id="colores_all_container" class="container mTop50 bg-white mBot50">
				            </div>
				            <div class="allColors container">
				            	<button type="button" name="" class="btn btn-primary" id="gobackallcolor">Volver a todos los colores</button>
				            </div>
				         </div>
				      </div>
				      <div id="colores-cold" class="tab-pane col-xs-12 Pad0" style="">
				         <div class="col-xs-12 Pad0 bg-gray-3" style="">
				            <div class="container" style="margin-top: 25px; margin-bottom: 30px;">
				               <div class="col-xs-12">
				                  <div id="owl-palette-cold" class="owl-carousel-palette owl-theme">
				                  </div>
				               </div>
				            </div>
				         </div>
				         <div class="col-xs-12" style=" ">
				            <div id="colores_cold_container" class="container mTop50 bg-white mBot50">
				            </div>
				         </div>
				      </div>
				      <div id="colores-warm" class="tab-pane col-xs-12 Pad0" style="">
				         <div class="col-xs-12 Pad0 bg-gray-3" style="">
				            <div class="container" style="margin-top: 25px; margin-bottom: 30px;">
				               <div class="col-xs-12">
				                  <div id="owl-palette-warm" class="owl-carousel-palette owl-theme">
				                  </div>
				               </div>
				            </div>
				         </div>
				         <div class="col-xs-12" style=" ">
				            <div id="colores_warm_container" class="container mTop50 bg-white mBot50">
				            </div>
				         </div>
				      </div>
				      <div id="subir-imagen" class="tab-pane col-xs-12 Pad0" style="">
				         <div class="col-xs-12 Pad0 bg-gray-3" style="">
				            <div class="container" style="margin-top: 25px; margin-bottom: 30px;">
				               <div class="col-xs-12 bg-white Pad0">
				                  <div class="tab-content">
				                     <div class="col-xs-12 col-sm-6 col-md-6 mTop10">
				                        <div class="imageSection col-xs-12 Pad0 mBot10 bg-gray-2">
				                           <div class="imageWrap">
				                              <img id="palette-image" class="img img-responsive" alt="" src="" data-colorcount="">
				                           </div>
				                        </div>
				                        <form style="" class="text-white">
				                           <div class="box" style="position: relative;">
				                              <div class="input-wrapper row">
				                                 <div style="position: relative;">
				                                    <input style="    display: inline-block;
				                                        max-width: 155px;margin-left: 17px;    position: absolute;
				    left: 0;
				    bottom: 0px;
				    opacity: 0;" type="file" accept="image/*" name="palette-file[]" id="palette-file" class="inputfile inputfile-1" data-multiple-caption="{count} Selected image"/>
				                                        <div>
				                                          <input style="    color: white;
				    margin-left: 15px;" type="button" class="btn-upload" name="" value="<?php _e('Upload image','lanco') ?>">
				                                        </div>

				                                 </div>

				                              </div>
				                              <label class="" for="palette-file" style="width: 100%;line-height: 40px;position: absolute;top: 0;opacity: 0;">
				                              <span class="myriad-pro"><?php _e('Upload image','lanco') ?></span>
				                              <i class="fa fa-upload text-white pull-right" style="line-height: 35px; margin-top: 2px; padding-left: 8px; font-size: 25px"></i>
				                              </label>
				                           </div>
				                        </form>
				                     </div>
				                     <div class="col-xs-12 col-sm-6 col-md-6 mTop10 Pad0">
				                        <div class="pallete-colors">
				                           <!--<div class="function dominantColor">
				                              <p>Dominant Color</p>
				                              <div class="col-xs-12 mBot10 Pad0">
				                                  <div class="Pad0 col-xs-12 palette-container">
				                                      <div class="Pad0 palette-row swatches" id="swatches-dominant">

				                                      </div>
				                                  </div>
				                              </div>
				                              </div>-->
				                           <div class="function medianCutPalette clearfix">
				                              <div class="col-xs-12 mBot10 Pad0">
				                                 <div class="Pad3 col-xs-12 col-sm-12 col-md-6 palette-cont">
				                                    <p class="text-center"><?php _e('Image color palette','lanco') ?></p>
				                                    <div id='placeholder'></div>
				                                    <div class="palette-flower flower-1">
				                                       <div class="palette-flower-1">
				                                          <div class="palette-flower-r-1 radius-2">
				                                             <div id="flw1" class="vertical-align text-center" style="transition: all 0.3s cubic-bezier(0.55, 0.06, 0.68, 0.19) 0s;-webkit-box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1);-moz-box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1); box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1), 1px 1px 1px 1px rgba(0, 0, 0, 0.1);border-radius: inherit; width:100%; height: 100%; background: #fff;">
				                                                <p class="text-center M0 text-darkgray-2 f-w-500 upper Pad1 col-xs-12" style="font-size: 8px;"><?php _e('Subir una imagen para ver los colores','lanco') ?></p>
				                                             </div>
				                                          </div>
				                                          <div class="palette-flower-r-2 radius-1">
				                                             <div id="flw2" class="vertical-align text-center" style="transition: all 0.3s cubic-bezier(0.55, 0.06, 0.68, 0.19) 0s;-webkit-box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1);-moz-box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1); box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1), 1px 1px 1px 1px rgba(0, 0, 0, 0.1);border-radius: inherit; width:100%; height: 100%; background: #fff;">
				                                                <p class="text-center M0 text-darkgray-2 f-w-500 upper Pad1 col-xs-12" style="font-size: 8px;"><?php _e('Subir una imagen para ver los colores','lanco') ?></p>
				                                             </div>
				                                          </div>
				                                       </div>
				                                       <div class="palette-flower-2">
				                                          <div class="palette-flower-r-3 radius-1">
				                                             <div id="flw3" class="vertical-align text-center" style="transition: all 0.3s cubic-bezier(0.55, 0.06, 0.68, 0.19) 0s;-webkit-box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1);-moz-box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1); box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1), 1px 1px 1px 1px rgba(0, 0, 0, 0.1);border-radius: inherit; width:100%; height: 100%; background: #fff;">
				                                                <p class="text-center M0 text-darkgray-2 f-w-500 upper Pad1 col-xs-12" style="font-size: 8px;"><?php _e('Subir una imagen para ver los colores','lanco') ?></p>
				                                             </div>
				                                          </div>
				                                       </div>
				                                    </div>
				                                 </div>
				                                 <div class="Pad3 col-xs-12 col-sm-12 col-md-6 palette-cont">
				                                    <p class="text-center"><?php _e('Similar ENCO colors','lanco') ?></p>
				                                    <div class="palette-flower flower-2">
				                                       <div class="palette-flower-1">
				                                          <div class="palette-flower-r-1 radius-2">
				                                             <div id="flw4" data-toggle="tooltip" title="" class="vertical-align text-center" style="transition: all 0.3s cubic-bezier(0.55, 0.06, 0.68, 0.19) 0s;-webkit-box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1);-moz-box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1); box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1), 1px 1px 1px 1px rgba(0, 0, 0, 0.1);border-radius: inherit; width:100%; height: 100%; background: #fff;">
				                                                <p class="text-center M0 text-darkgray-2 f-w-500 upper Pad1 col-xs-12" style="font-size: 8px;"><?php _e('Subir una imagen para ver los colores','lanco') ?></p>
				                                                <div class="color-title-wrapper js-color-name">
				                                                   <p style="line-height: 1;" class="color-name js-name"></p>
				                                                   <p style="line-height: 1;" class="color-code js-code"></p>
				                                                </div>
				                                             </div>
				                                          </div>
				                                          <div class="palette-flower-r-2 radius-1">
				                                             <div id="flw5" data-toggle="tooltip" title="" class="vertical-align text-center" style="transition: all 0.3s cubic-bezier(0.55, 0.06, 0.68, 0.19) 0s;-webkit-box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1);-moz-box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1); box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1), 1px 1px 1px 1px rgba(0, 0, 0, 0.1);border-radius: inherit; width:100%; height: 100%; background: #fff;">
				                                                <p class="text-center M0 text-darkgray-2 f-w-500 upper Pad1 col-xs-12" style="font-size: 8px;"><?php _e('Subir una imagen para ver los colores','lanco') ?></p>
				                                                <div class="color-title-wrapper-small js-color-name">
				                                                   <p  style="line-height: 1;" class="color-name js-name-1"></p>
				                                                   <p  style="line-height: 1;" class="color-code js-code-1"></p>
				                                                </div>
				                                             </div>
				                                          </div>
				                                       </div>
				                                       <div class="palette-flower-2">
				                                          <div class="palette-flower-r-3 radius-1">
				                                             <div id="flw6" data-toggle="tooltip" title="" class="vertical-align text-center" style="transition: all 0.3s cubic-bezier(0.55, 0.06, 0.68, 0.19) 0s;-webkit-box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1);-moz-box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1); box-shadow: 1px 1px 1px 1px rgba(0, 0, 0, 0.1), 1px 1px 1px 1px rgba(0, 0, 0, 0.1);border-radius: inherit; width:100%; height: 100%; background: #fff;">
				                                                <p class="text-center M0 text-darkgray-2 f-w-500 upper Pad1 col-xs-12" style="font-size: 8px;"><?php _e('Subir una imagen para ver los colores','lanco') ?></p>
				                                                <div class="color-title-wrapper-small js-color-name">
				                                                   <p  style="line-height: 1;" class="color-name js-name-2"></p>
				                                                   <p  style="line-height: 1;" class="color-code js-code-2"></p>
				                                                </div>
				                                             </div>
				                                          </div>
				                                       </div>
				                                    </div>
				                                    <div class="mTop10 Pad0 palette-row swatches" id="swatches-palette">
				                                    </div>
				                                 </div>
				                                 <input type="button" class="js-refresh" value="Refrescar paleta" style="margin-left: 16px;">
				                              </div>
				                           </div>
				                        </div>
				                     </div>
				                  </div>
				               </div>
				            </div>
				         </div>
				      </div>
				   </div>
				   <!-- palette -->
				</main>
				<!-- cd-main-content -->
				<!-- modal favoritos -->
				<div class="modal fade bs-example-modal-sm" id="mdl-favoritos-add" tabindex="-1" role="dialog" aria-labelledby="mdl_favoritos_add">
				   <div class="modal-dialog modal-sm" role="document" id="modal-little">
				      <div class="modal-content bg-gray-3">
				         <div class="modal-header">
				            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				            <h4 class="modal-title" id="mdl_favoritos_add"><?php _e('Seleccionar este color','lanco') ?></h4>
				         </div>
				         <div class="modal-body" style="padding: 15px!Important;">
				            <p class="text-darkgray"><?php _e('¿Estás seguro de elegir este color?','lanco') ?></p>
				            <div class="palette-favorite-2" style="margin:0 auto;">
				            	<p class="insp-color">
				            		
				            	</p>
				               <div class="bg-container add-favorite-bg" style="background: #000;">
				               </div>
				               <div class="bg-row bg-white">
				                  <p class="M0 text-darkgray f-w-500 upper Pad5 add-favorite-txt" style="font-size: 10px;"></p>
				               </div>
				            </div>
				         </div>
				         <div class="modal-footer">
				            <button type="button" class="btn link-sky f-w-600 bg-white text-red js-modalno" style="border:none;"><?php _e('No','lanco') ?></button>
				            <button type="button" class="btn link-sky f-w-600 bg-red text-white" id="add-favorite" style="border:none; margin-right: 20px;"><?php _e('Sí','lanco') ?></button>
				         </div>
				      </div>
				   </div>
				</div>
				<div class="modal fade bs-example-modal-sm" id="mdl-favoritos-remove" tabindex="-1" role="dialog" aria-labelledby="mdl_favoritos"data-whatever="@fab" >
				   <div class="modal-dialog modal-sm" role="document">
				      <div class="modal-content bg-gray-3">
				         <div class="modal-header">
				            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				            <h4 class="modal-title text-darkgray-2" id="mdl_favoritos"><?php _e('Delete from favorites','lanco') ?></h4>
				         </div>
				         <div class="modal-body">
				            <p class="text-darkgray"><?php _e('Do you want to delete ?','lanco') ?></p>
				            <div class="palette-favorite-2" style="margin:0 auto;">
				               <div class="bg-container remove-favorite-bg" style="background: #000;">
				               </div>
				               <div class="bg-row bg-white">
				                  <p class="M0 text-darkgray f-w-500 upper Pad5 remove-favorite-txt" style="font-size: 10px;"></p>
				               </div>
				            </div>
				         </div>
				         <div class="modal-footer">
				            <button type="button" class="btn link-sky f-w-600 bg-white text-red" data-dismiss="modal" style="border:none;"><?php _e('No','lanco') ?></button>
				            <button type="button" class="btn link-sky f-w-600 bg-red text-white" id="delete-favorite" style="border:none;"><?php _e('Sí','lanco') ?></button>
				         </div>
				      </div>
				   </div>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary js-close-m" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" style="margin-right: 20px;">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>
<?php
do_action( 'woocommerce_after_add_to_cart_form' );
