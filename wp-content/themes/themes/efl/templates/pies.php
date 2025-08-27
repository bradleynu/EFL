<?php 
/* 
 * Template Name: pies 
 */

get_header(); 

// Obtener campos ACF
$contact_form = get_field('contact_form');
$banner = get_field('banner');
$video_banner = get_field('video_banner');
$title = get_field('title');
?>

<!-- Cabecera del sitio -->
<header id="masthead" class="site-header animate__animated animate__delay-500ms">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-center">
                <!-- Columna izquierda vacía -->
            </div>
            <div class="col-md-4 text-center">
                <img src="https://efficientlabs.com/wp-content/themes/efl/assets/dist/images/Logo_EFL.png" alt="Logo Efficient Labs" class="img-fluid"> 
            </div>
            <div class="col-md-4 text-center">
                <?php
                wp_nav_menu([
                    'theme_location'  => 'header-pies',
                    'container_class' => 'h-100',
                    'container_id'    => 'main-menu-wrapper',
                    'menu_class'      => 'navbar-nav mainnav'
                ]);
                ?>
            </div>
        </div>
    </div>
</header>

<!-- Enlace a archivo CSS personalizado -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/dist/css/pies.css">

<!-- Estilos CSS inline -->
<style>
    /* Estilos generales */
    body {
        margin-top: 0px;
    }
    
    header#header, 
    footer, 
    .logo-floted, 
    .xoo-wsc-markup {
        display: none !important;
    }
    
    /* Estilos para video a pantalla completa */
    .fullpage-video {
        position: relative;
        width: 100%;
        height: 80vh;
        overflow: hidden;
    }
    
    .video-background {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 80vh;
        object-fit: cover;
        z-index: -1;
        object-position: bottom;
    }
    
    /* Botón de control de audio */
    .audio-btn {
        position: absolute;
        bottom: 8px;
        right: 20px;
        padding: 10px 20px;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        cursor: pointer;
        z-index: 10;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .audio-btn:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }
    
    /* Estilos para el formulario */
    .codedropz-upload-inner, 
    .codedropz-upload-inner .codedropz-btn-wrap a.cd-upload-btn, 
    .dnd-upload-counter {
        color: #fff;
    }
    
    /* Estilos para el menú de pie de página */
    #menu-footer-pies {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0px;
        padding: 0px;
        list-style: none;
    }
    
    #menu-footer-pies a {
        color: white;
        font-size: 1.9rem !important;
        line-height: 1.3;
        font-weight: 500;
    }
    
    /* Media queries para dispositivos móviles */
    @media (min-width: 320px) and (max-width: 480px) {
        .fullpage-video {
            height: 32vh !important;
        }
        .video-background {
            height: 32vh !important;
        }
    }
</style>

<!-- Sección de video/banner -->
<section id="tuto-video" class="fullpage-video">
    <?php if ($video_banner): ?>
        <video id="bannerVideo" autoplay muted loop playsinline class="video-background">
            <source src="<?php echo $video_banner; ?>" type="video/mp4">
            Tu navegador no soporta videos HTML5.
        </video>
        <button id="audioControl" class="audio-btn" onclick="toggleAudio()">
            <?php pll_e('Activar Sonido'); ?>
        </button>
    <?php elseif ($banner): ?>
        <img src="<?php echo $banner; ?>" alt="Banner" class="img-fluid">
    <?php endif; ?>
</section>

<!-- Sección de formulario principal -->
<section id="main-form">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2><?php echo $title; ?></h2>
               
            </div>
        </div>
         <?php echo do_shortcode($contact_form); ?>
    </div>
</section>

<!-- Pie de página -->
<section id="footer">
    <div class="container">
        <div class="row" style="display: flex;justify-content: center;align-items: center;flex-direction: column;margin-bottom: 40px;">
            <div class="col-md-6 text-center">
                <?php
                wp_nav_menu([
                    'theme_location'  => 'footer-pies',
                    'container_class' => 'h-100',
                    'container_id'    => 'main-menu-wrapper',
                    'menu_class'      => 'navbar-nav mainnav'
                ]);
                ?>
            </div>
            <div class="col-md-6 text-center">
                <div style="margin-right: 10px;">
                    <a target="_blank" href="https://www.facebook.com/efficientlabs" 
                       style="font-size: 32px; color: white; position: relative; margin-right: 10px;">
                        <i class="fa fa-facebook-official" aria-hidden="true"></i>
                    </a>
                    <a target="_blank" href="https://www.instagram.com/efficient_labs/" 
                       style="font-size: 32px; color: white; position: relative; margin-right: 10px;">
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </a>
                    <a target="_blank" href="https://www.youtube.com/channel/UCmA1mylg7S3TyN81ROhhHFw" 
                       style="font-size: 32px; color: white; position: relative;">
                        <i class="fa fa-youtube-play" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Scripts JavaScript -->
<script>

(function($) {

    
    $(document).ready(function() {
        $('.date-info').on('click', function() {
            $(this).fadeOut();
        });
    });
    
    

})(jQuery);


    // Función para activar/desactivar el sonido del video
    function toggleAudio() {
        var video = document.getElementById('bannerVideo');
        var audioControl = document.getElementById('audioControl');
        
        if (video.muted) {
            video.muted = false;
            audioControl.textContent = '<?php echo pll__('Desactivar Sonido'); ?>';
        } else {
            video.muted = true;
            audioControl.textContent = '<?php echo pll__('Activar Sonido'); ?>';
        }
    }
    
    // Script para detectar el idioma y cambiar el componente de carga
    document.addEventListener('DOMContentLoaded', function() {
        // Función para detectar si la página está en español basándose en el botón de envío
        function isSpanish() {
            const submitButton = document.querySelector('.wpcf7-submit');
            // Si el botón existe y su valor es "Enviar", entonces la página está en español
            return submitButton && submitButton.value === "Enviar";
        }
        
        // Verificar si estamos en español
        const spanish = isSpanish();
        if (!spanish) {
            // Si no estamos en español, no hacemos nada más
            return;
        }
        
        // Textos en español
        const spanishTexts = {
            dragDrop: 'Arrastra y suelta archivos aquí',
            or: 'o',
            browse: 'Examinar archivos',
            counter: ' de 5'
        };
        
        // Función para cambiar los textos del componente a español
        function translateToSpanish() {
            // Seleccionar los elementos a cambiar
            const uploadHandler = document.querySelector('.codedropz-upload-handler');
            if (!uploadHandler) return; // No hacer nada si el componente no existe
            
            const dragDropText = uploadHandler.querySelector('.codedropz-upload-inner h3');
            const orText = uploadHandler.querySelector('.codedropz-upload-inner span');
            const browseBtn = uploadHandler.querySelector('.cd-upload-btn');
            const counterText = uploadHandler.querySelector('.dnd-upload-counter');
            
            // Cambiar los textos a español (solo si no se han cambiado ya)
            if (dragDropText && dragDropText.textContent !== spanishTexts.dragDrop) {
                dragDropText.textContent = spanishTexts.dragDrop;
            }
            if (orText && orText.textContent !== spanishTexts.or) {
                orText.textContent = spanishTexts.or;
            }
            if (browseBtn && browseBtn.textContent !== spanishTexts.browse) {
                browseBtn.textContent = spanishTexts.browse;
            }
            
            // Para el contador, necesitamos preservar el número
            if (counterText && !counterText.dataset.translated) {
                const counterNumber = counterText.querySelector('span')?.textContent || '0';
                counterText.innerHTML = `<span>${counterNumber}</span>${spanishTexts.counter}`;
                counterText.dataset.translated = 'true'; // Marcar como traducido
            }
        }
        
        // Intentar traducir inmediatamente
        translateToSpanish();
        
        // Configurar un temporizador para verificar el componente cada segundo durante 10 segundos
        let checkCount = 0;
        const maxChecks = 10;
        const checkInterval = setInterval(function() {
            translateToSpanish();
            checkCount++;
            if (checkCount >= maxChecks) {
                clearInterval(checkInterval);
            }
        }, 1000);
        
        // También verificar cuando el formulario termine de cargar (eventos de Contact Form 7)
        document.addEventListener('wpcf7invalid', translateToSpanish);
        document.addEventListener('wpcf7mailsent', translateToSpanish);
        document.addEventListener('wpcf7mailfailed', translateToSpanish);
        document.addEventListener('wpcf7submit', translateToSpanish);
    });
</script>

<?php get_footer(); ?>