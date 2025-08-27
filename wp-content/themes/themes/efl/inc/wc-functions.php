<?php

add_action('template_redirect','efl_remove_product_actions',10);
function efl_remove_product_actions() {
    // Single Product
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    // remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    // remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    // add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 30 );

    // global $wp_filter;
    // var_dump($wp_filter);



    // Cart Sidebar order
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
    add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 20 );
}

function efl_cart_account_menu_items($items){
    unset($items['edit-account']);
    unset($items['customer-logout']);
    unset($items['downloads']);
    unset($items['dashboard']);
    unset($items['account-wishlists']);
    $items = array('edit-account' => 'Cuenta') + $items;

    return $items;
}

add_filter( 'woocommerce_account_menu_items', 'efl_cart_account_menu_items', 99999 );

function set_custom_isvars( $wp_query ) {
    if($wp_query->query_vars['pagename'] == 'my-account' && isset($wp_query->query_vars['page']) ){
        wp_redirect('/my-account/edit-account/');
        exit;
    }
}
add_action('parse_query', 'set_custom_isvars');

add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
function logout_without_confirm($action, $result){
  /**
  * Allow logout without confirmation
  */
  if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
      $redirect_to = isset($_REQUEST['redirect_to']) ?
      $_REQUEST['redirect_to'] : '';
      $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));;
      header("Location: $location");
      die();
    }
}

//add_action('woocommerce_after_order_notes', 'efl_checkout_field');
//add_action('woocommerce_checkout_update_user_meta', 'efl_checkout_field_update_user_meta');
//add_action('woocommerce_checkout_update_order_meta', 'efl_checkout_field_update_order_meta');
//add_filter('woocommerce_email_order_meta_keys', 'efl_checkout_field_order_meta_keys');
//add_action('woocommerce_order_details_after_order_table', 'efl_field_display_cust_order_meta', 10, 1 );

function efl_checkout_field( $checkout ) {

    echo '<div id="efl_checkout_field"><br class="hidden-xs"><br><h3>'.__('Otros detalles').'</h3>';

    woocommerce_form_field( 'billing_receive_user', array(
        'type'          => 'text',
        'class'         => array('my-field-class orm-row-wide'),
        'label'         => __('Si otra persona recibirá la orden, por favor indíquelo aquí:'),
        'placeholder'   => __('Nombre de la persona'),
        ), $checkout->get_value( 'billing_receive_user' ));

    woocommerce_form_field( 'billing_receive_user_id', array(
        'type'          => 'text',
        'class'         => array('my-field-class orm-row-wide'),
        'label'         => __('Cédula:'),
        ), $checkout->get_value( 'billing_receive_user_id' ));

    echo '<p> <label for="pickup_same"> <input id="pickup_same" type="checkbox" class="js-pickup-same"> Misma Persona que compra </label> </p>';

    echo '<p class="form-row my-field-class orm-row-wide"><span class="disclaimer">* Recordá que solo se entregará el pedido a la persona que se autorice en este espacio o al dueño de la cuenta.</span></p>';

    echo '</div>';
}

function efl_checkout_field_update_user_meta( $user_id ) {
    if ($user_id && $_POST['billing_receive_user']) update_user_meta( $user_id, 'billing_receive_user', esc_attr($_POST['billing_receive_user']) );
    if ($user_id && $_POST['billing_receive_user_id']) update_user_meta( $user_id, 'billing_receive_user_id', esc_attr($_POST['billing_receive_user_id']) );
}
function efl_checkout_field_update_order_meta( $order_id ) {
    if ($_POST['billing_receive_user']) update_post_meta( $order_id, 'billing_receive_user', esc_attr($_POST['billing_receive_user']));
    if ($_POST['billing_receive_user_id']) update_post_meta( $order_id, 'billing_receive_user_id', esc_attr($_POST['billing_receive_user_id']));
}
function efl_checkout_field_order_meta_keys( $keys ) {
    $keys[] = 'billing_receive_user';
    $keys[] = 'billing_receive_user_id';
    return $keys;
}

function efl_field_display_cust_order_meta($order){
    if(get_post_meta( $order->id, 'billing_receive_user', true ) == '')
        return;

    echo '<section class="woocommerce-order-details">
            <br>
            <legend class="woocommerce-order-details__title">Otros detalles del pedido</legend>
            <table class="woocommerce-table woocommerce-table--customer-details shop_table customer_details">
                <tr>
                <td><b>'.__('Persona que recibe la orden').':</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' . get_post_meta( $order->id, 'billing_receive_user', true ) . ' Cédula: ' . get_post_meta( $order->id, 'billing_receive_user_id', true ) . '</td>
                </tr>
            </table>
        </section>';

}


add_action( 'woocommerce_admin_order_data_after_billing_address', 'efl_checkout_field_display_admin_order_meta', 10, 1 );

function efl_checkout_field_display_admin_order_meta($order){
   $billing_receive_user = get_post_meta( $order->id, 'billing_receive_user', true );
   $billing_receive_user_id = get_post_meta( $order->id, 'billing_receive_user_id', true );
   if($billing_receive_user !== ""){
    echo '<p><strong>'.__('Persona que recibe la orden').':</strong> <br/>' . $billing_receive_user . ' Ced: ' . $billing_receive_user_id . '</p>';
   }
}

add_action( 'woocommerce_admin_order_data_after_order_details', 'efl_editable_order_meta_general' );

function efl_editable_order_meta_general( $order ){
    $delivery_date = get_post_meta( $order->id, 'delivery_date', true );
    ?>
        <br class="clear" />
        <p class="form-field form-field-wide"><label for="delivery_date">Fecha de entrega:</label>
        <input style="width: 100% !important;" value="<?php echo $delivery_date; ?>" type="text" class="date-picker" name="delivery_date" id="delivery_date" maxlength="10"  pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" />
        </p>
    <?php
}

add_action( 'woocommerce_process_shop_order_meta', 'efl_save_general_details' );

function efl_save_general_details( $ord_id ){
    update_post_meta( $ord_id, 'delivery_date', wc_clean( $_POST[ 'delivery_date' ] ) );
}

add_action( 'init', 'efl_register_order_status' );
add_filter( 'wc_order_statuses', 'efl_order_statuses' );

function efl_register_order_status() {
    register_post_status( 'wc-alistando', array(
        'label'                     => 'Alistando',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Alistando <span class="count">(%s)</span>', 'Alistando <span class="count">(%s)</span>' )
    ));
    register_post_status( 'wc-para-entrega', array(
        'label'                     => 'Listo para entrega',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Listo para entrega <span class="count">(%s)</span>', 'Listo para entrega <span class="count">(%s)</span>' )
    ));
    register_post_status( 'wc-en-camino', array(
        'label'                     => 'En camino',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'En camino <span class="count">(%s)</span>', 'En camino <span class="count">(%s)</span>' )
    ));
}

function efl_order_statuses($statuses){
    $statuses['wc-alistando']  = _x( 'Alistando', 'Order status', 'woocommerce' );
    $statuses['wc-para-entrega']  = _x( 'Listo para entrega', 'Order status', 'woocommerce' );
    $statuses['wc-en-camino']  = _x( 'En camino', 'Order status', 'woocommerce' );

    return $statuses;
}

function efl_remove_wc_order_statuses( $statuses ){
    return [
        "wc-processing" => "Procesándose",
        "wc-en-camino" => "En tránsito",
        "wc-completed" => "Completado",
    ];
}
add_filter( 'wc_order_statuses', 'efl_remove_wc_order_statuses' );

function efl_shop_manager_restrictions() {
    $user = wp_get_current_user();
    if( !in_array('shop_manager', (array) $user->roles) )
        return;
    ?>
    <script type="text/javascript">
        (function( $ ) {
            
            $(function() {
                $('.toplevel_page_woocommerce .wp-submenu li').each(function(idx) {
                    if(idx > 1) $(this).hide();
                });
            });

        })(window.jQuery);
    </script>
    <?php
}




// Agrega este código en el archivo functions.php de tu tema o en tu plugin personalizado

add_filter('woocommerce_checkout_fields', 'quitar_campo_apellido');

function quitar_campo_apellido($fields) {
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_phone2']);
    unset($fields['order']['order_comments']);
    return $fields;
}

// Agrega este código en el archivo functions.php de tu tema o en tu plugin personalizado

add_filter('woocommerce_checkout_fields', 'modificar_label_nombre');

function modificar_label_nombre($fields) {
    $fields['billing']['billing_first_name']['label'] = 'Full Name';

    return $fields;
}




// Agrega este código en el archivo functions.php de tu tema o en tu plugin personalizado

add_filter('woocommerce_checkout_fields', 'personalizar_labels_campos', 10, 1);

function personalizar_labels_campos($fields) {
    // Obtener el idioma actual
    $idioma_actual = pll_current_language();

    // Personalizar labels dependiendo del idioma para billing_first_name
    $fields['billing']['billing_first_name']['label'] = ($idioma_actual == 'es') ? 'Nombre Completo' : 'Full Name';

    // Personalizar labels dependiendo del idioma para billing_phone
    $fields['billing']['billing_phone']['label'] = ($idioma_actual == 'es') ? 'Teléfono' : 'Phone';

    // Personalizar labels dependiendo del idioma para billing_email
    $fields['billing']['billing_email']['label'] = ($idioma_actual == 'es') ? 'Correo Electrónico' : 'Email';

    // Personalizar labels dependiendo del idioma para billing_country
    $fields['billing']['billing_country']['label'] = ($idioma_actual == 'es') ? 'País' : 'Country';

    // Personalizar labels dependiendo del idioma para billing_state
    $fields['billing']['billing_state']['label'] = ($idioma_actual == 'es') ? 'Estado/Provincia' : 'State';

    // Personalizar labels dependiendo del idioma para billing_city
    $fields['billing']['billing_city']['label'] = ($idioma_actual == 'es') ? 'Ciudad' : 'City';

    // Personalizar labels dependiendo del idioma para billing_postcode
    $fields['billing']['billing_postcode']['label'] = ($idioma_actual == 'es') ? 'Código Postal' : 'Postal Code';

    // Personalizar labels dependiendo del idioma para billing_address_1
    $fields['billing']['billing_address_1']['label'] = ($idioma_actual == 'es') ? 'Dirección' : 'Address';

    return $fields;
}