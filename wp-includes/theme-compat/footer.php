<?php
/**
 * The template for displaying the footer
 *
 * @package EFL_Theme
 */
?>

    </div><footer id="colophon" class="site-footer">
        <div class="site-info">
            <p>
                <?php
                printf(
                    /* translators: 1: Site name */
                    esc_html__( '© %1$s %2$s. Todos los derechos reservados.', 'efl' ),
                    date_i18n('Y'),
                    get_bloginfo('name')
                );
                ?>
            </p>
        </div></footer></div><script id="hamburger-menu-script">
/* ===== JS PARA EL MENÚ DE HAMBURGUESA ===== */
document.addEventListener('DOMContentLoaded', function() {
    // Busca el botón de la hamburguesa en la página
    const burgerButton = document.querySelector('.hm-burger');
    // Busca el menú de navegación que queremos mostrar/ocultar
    const mobileNav = document.querySelector('.hm-header__nav');

    // Si ambos existen en la página...
    if (burgerButton && mobileNav) {
        // ...espera a que alguien haga clic en la hamburguesa
        burgerButton.addEventListener('click', function() {
            // Cuando hagan clic, alterna la clase 'is-active' en el botón
            burgerButton.classList.toggle('is-active');
            // Y también alterna la misma clase en el menú de navegación
            mobileNav.classList.toggle('is-active');
        });
    }
});
</script>

<?php wp_footer(); ?>

</body>
</html>