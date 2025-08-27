<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Lanco_Store
 */
get_header(); ?>
<style>
/* ==========================================================================
   SINGLE POST STYLES
   ========================================================================== */

/* Hero Section - Imagen de fondo */
.post-hero-section {
    margin-bottom: 2rem;
}
	h2 {
		    font-weight: bold;
    font-size: 25px;
    color: #565656;
	}
	ul {
		margin-left: 0px;
	}
	section, ul li {
		    font-size: 15px;
    color: #616161;
    line-height: 26px;
    font-weight: 300;
	}
.post-hero-bg {
    position: relative;
    height: 400px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: 10px;
    overflow: hidden;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%);
    display: flex;
    align-items: flex-end;
    padding: 2rem;
}

/* Hero Section - Video */
.post-video-bg {
    position: relative;
    height: 400px;
    border-radius: 10px;
    overflow: hidden;
}

.video-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.video-container iframe {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

/* Overlay que no bloquea el video - solo bordes */
.video-overlay-frame {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
    pointer-events: none; /* Permite clicks através del overlay */
}

.overlay-top {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(180deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 60%, transparent 100%);
    display: flex;
    align-items: flex-start;
    padding: 2rem 2rem 0 2rem;
    pointer-events: auto; /* Permite interacción con el título */
}

.overlay-bottom {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 30%;
    background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 60%, transparent 100%);
    display: flex;
    align-items: flex-end;
    padding: 0 2rem 2rem 2rem;
    pointer-events: auto; /* Permite interacción con los metadatos */
}

/* Botón de play personalizado (opcional) */
.custom-play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 3;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

.custom-play-button:hover {
    background: rgba(255, 255, 255, 1);
    transform: translate(-50%, -50%) scale(1.1);
}

.custom-play-button i {
    font-size: 2rem;
    color: #007cba;
    margin-left: 4px; /* Ajuste visual para centrar el icono de play */
}

/* Efecto hover en el video para mostrar controles */
.post-video-bg:hover .overlay-top,
.post-video-bg:hover .overlay-bottom {
    opacity: 0.9;
}

.post-video-bg:hover .video-container iframe {
    transform: scale(1.02);
    transition: transform 0.3s ease;
}

/* Hero Section - Sin imagen/video */
.post-hero-simple {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    padding: 3rem 2rem;
    margin-bottom: 2rem;
}

.post-hero-simple .hero-content {
    text-align: center;
}

/* Contenido del hero */
.hero-content {
    color: white;
    width: 100%;
}

.post-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.2;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    color: #fff;
}

.post-meta {
    font-size: 0.9rem;
    opacity: 0.9;
}

.post-meta span {
    margin-right: 0.5rem;
    color: #fff;
}

.post-meta i {
    margin-right: 0.3rem;
}

.meta-sep {
    opacity: 0.7;
}

/* Contenido del post */
.post-content-wrapper {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.post-content {
    padding: 2rem;
}

/* Tags del post */
.post-tags {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.post-tags a {
    display: inline-block;
    background: #f8f9fa;
    color: #6c757d;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.85rem;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}

.post-tags a:hover {
    background: #007cba;
    color: white;
}

/* Contenido principal */
.entry-content {
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 2rem;
}

.entry-content p {
    margin-bottom: 1.5rem;
}

.entry-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

/* Paginación */
.page-links {
    margin: 2rem 0;
    text-align: center;
}

.page-links span {
    display: inline-block;
    padding: 0.5rem 1rem;
    margin: 0 0.2rem;
    background: #f8f9fa;
    border-radius: 5px;
    text-decoration: none;
}

.page-links a span {
    background: #007cba;
    color: white;
}

/* Sección del autor */
.author-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    margin: 2rem 0;
}

/* Navegación entre posts */
.post-navigation {
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
    padding: 1.5rem 0;
    margin: 2rem 0;
}

.nav-links {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-previous,
.nav-next {
    flex: 1;
}

.nav-next {
    text-align: right;
}

.nav-links a {
    color: #007cba;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.nav-links a:hover {
    color: #005a87;
}

/* Posts relacionados */
.related-posts {
    margin: 2rem 0;
}

.related-posts h3 {
    margin-bottom: 1.5rem;
    color: #333;
    border-bottom: 2px solid #007cba;
    padding-bottom: 0.5rem;
}

.related-post-item {
    text-align: center;
    margin-bottom: 1rem;
}

.related-post-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 0.5rem;
}

.related-post-item h4 {
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.related-post-item a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.related-post-item a:hover {
    color: #007cba;
}

/* Sección de comentarios */
.comments-section {
    border-top: 1px solid #eee;
    padding-top: 2rem;
    margin-top: 2rem;
}

/* Sidebar */
.sidebar {
    padding-left: 2rem;
}

.widget {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.widget-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #333;
    border-bottom: 2px solid #007cba;
    padding-bottom: 0.5rem;
}

.widget ul {
    list-style: none;
    padding: 0;
}

.widget ul li {
    margin-bottom: 0.8rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #f0f0f0;
}

.widget ul li:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.widget ul li a {
    color: #666;
    text-decoration: none;
    transition: color 0.3s ease;
}

.widget ul li a:hover {
    color: #007cba;
}

/* Responsive */
@media (max-width: 768px) {
    .post-title {
        font-size: 2rem;
    }
    
    .hero-overlay,
    .overlay-top,
    .overlay-bottom {
        padding: 1rem;
    }
    
    .overlay-top {
        height: 40%;
    }
    
    .overlay-bottom {
        height: 25%;
    }
    
    .post-content {
        padding: 1.5rem;
    }
    
    .sidebar {
        padding-left: 0;
        margin-top: 2rem;
    }
    
    .post-hero-bg,
    .post-video-bg {
        height: 250px;
    }
    
    .custom-play-button {
        width: 60px;
        height: 60px;
    }
    
    .custom-play-button i {
        font-size: 1.5rem;
    }
    
    .nav-links {
        flex-direction: column;
        gap: 1rem;
    }
    
    .nav-next {
        text-align: left;
    }
}

@media (max-width: 576px) {
    .post-title {
        font-size: 1.5rem;
    }
    
    .entry-content {
        font-size: 1rem;
    }
    
    .post-hero-bg,
    .post-video-bg {
        height: 200px;
    }
    
    .overlay-top,
    .overlay-bottom {
        padding: 0.8rem;
    }
    
    .custom-play-button {
        width: 50px;
        height: 50px;
    }
    
    .custom-play-button i {
        font-size: 1.2rem;
    }
    
    .post-meta {
        font-size: 0.8rem;
    }
}
</style>

<?php
// Obtener idioma actual
$current_lang = '';
if (function_exists('pll_current_language')) {
    $current_lang = pll_current_language();
} elseif (function_exists('qtranxf_getLanguage')) {
    $current_lang = qtranxf_getLanguage();
} elseif (function_exists('icl_get_current_language')) {
    $current_lang = icl_get_current_language();
}
?>

<div class="container">
    <div class="row">
        <!-- Contenido principal del post -->
        <div class="col-md-8">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                <?php
                while ( have_posts() ) : the_post();
                    // Obtener URL del video de YouTube
                    $videurl_1 = get_field("p_video");
                    $videurl = '';
                    if (!empty($videurl_1)) {
                        parse_str( parse_url( $videurl_1, PHP_URL_QUERY ), $my_array_of_vars );
                        $videurl = isset($my_array_of_vars['v']) ? $my_array_of_vars['v'] : '';
                    }
                    ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        
                        <!-- Hero Section con imagen/video de fondo -->
                        <div class="post-hero-section">
                            <?php if (has_post_thumbnail( $post->ID )): ?>
                                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                <div class="post-hero-bg" style="background-image: url('<?php echo $image[0]; ?>')">
                                    <div class="hero-overlay">
                                        <div class="hero-content">
                                            <h1 class="post-title"><?php the_title(); ?></h1>
                                            <div class="post-meta">
                                                <span class="entry-date">
                                                    <i class="fa fa-calendar"></i>
                                                    <?php the_time( 'M d, Y' ); ?>
                                                </span>
                                                <span class="meta-sep"> • </span>
                                                <span class="comment-count">
                                                    <i class="fa fa-comments"></i>
                                                    <?php comments_popup_link(__('0 comentarios', 'lanco'), __('1 comentario', 'lanco'), __('% comentarios', 'lanco')); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif (!empty($videurl)): ?>
                                <div class="post-video-bg" id="videoHeroSection">
                                    <div class="video-container">
                                        <iframe 
                                            id="youtubePlayer"
                                            src="https://www.youtube.com/embed/<?php echo $videurl; ?>?autoplay=0&mute=0&controls=1&showinfo=0&rel=0&enablejsapi=1" 
                                            frameborder="0" 
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen
                                            title="<?php the_title(); ?>">
                                        </iframe>
                                    </div>
                                    <!-- Overlay solo en los bordes, no sobre el video -->
                                    <div class="video-overlay-frame">
                                        <!-- Top overlay -->
                                        <div class="overlay-top">
                                            <div class="hero-content">
                                                <h1 class="post-title"><?php the_title(); ?></h1>
                                            </div>
                                        </div>
                                        <!-- Bottom overlay -->
                                        <div class="overlay-bottom">
                                            <div class="post-meta">
                                                <span class="entry-date">
                                                    <i class="fa fa-calendar"></i>
                                                    <?php the_time( 'M d, Y' ); ?>
                                                </span>
                                                <span class="meta-sep"> • </span>
                                                <span class="comment-count">
                                                    <i class="fa fa-comments"></i>
                                                    <?php comments_popup_link(__('0 comentarios', 'lanco'), __('1 comentario', 'lanco'), __('% comentarios', 'lanco')); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Botón de play personalizado (opcional) -->
                                    <div class="custom-play-button" id="customPlayBtn" style="display: none;">
                                        <i class="fa fa-play"></i>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- Fallback si no hay imagen ni video -->
                                <div class="post-hero-simple">
                                    <div class="hero-content">
                                        <h1 class="post-title"><?php the_title(); ?></h1>
                                        <div class="post-meta">
                                            <span class="entry-date">
                                                <i class="fa fa-calendar"></i>
                                                <?php the_time( 'M d, Y' ); ?>
                                            </span>
                                            <span class="meta-sep"> • </span>
                                            <span class="entry-author">
                                                <i class="fa fa-user"></i>
                                                <?php the_author_posts_link(); ?>
                                            </span>
                                            <span class="meta-sep"> • </span>
                                            <span class="comment-count">
                                                <i class="fa fa-comments"></i>
                                                <?php comments_popup_link(__('0 comentarios', 'lanco'), __('1 comentario', 'lanco'), __('% comentarios', 'lanco')); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Contenido del post -->
                        <div class="post-content-wrapper">
                            <div class="post-content">
                                <!-- Tags del post -->
                                <?php if(has_tag()): ?>
                                    <div class="post-tags">
                                        <?php the_tags('<i class="fa fa-tags"></i> ', ', ', ''); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Contenido principal -->
                                <div class="entry-content">
                                    <?php the_content(); ?>
                                    <?php wp_link_pages(array(
                                        'before' => '<div class="page-links"><span class="page-links-title">' . __('Páginas:', 'lanco') . '</span>',
                                        'after'  => '</div>',
                                        'link_before' => '<span>',
                                        'link_after'  => '</span>',
                                    )); ?>
                                </div>
                                <!-- Navegación entre posts -->
                                <div class="post-navigation">
                                    <div class="nav-links">
                                        <div class="nav-previous">
                                            <?php 
                                            // Navegación anterior con filtro de idioma
                                            if (function_exists('pll_current_language')) {
                                                $prev_post = get_previous_post();
                                                if ($prev_post && function_exists('pll_get_post_language') && pll_get_post_language($prev_post->ID) == $current_lang) {
                                                    previous_post_link('%link', '<i class="fa fa-arrow-left"></i> %title');
                                                }
                                            } else {
                                                previous_post_link('%link', '<i class="fa fa-arrow-left"></i> %title');
                                            }
                                            ?>
                                        </div>
                                        <div class="nav-next">
                                            <?php 
                                            // Navegación siguiente con filtro de idioma
                                            if (function_exists('pll_current_language')) {
                                                $next_post = get_next_post();
                                                if ($next_post && function_exists('pll_get_post_language') && pll_get_post_language($next_post->ID) == $current_lang) {
                                                    next_post_link('%link', '%title <i class="fa fa-arrow-right"></i>');
                                                }
                                            } else {
                                                next_post_link('%link', '%title <i class="fa fa-arrow-right"></i>');
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Posts relacionados con filtro de idioma -->
                                <div class="related-posts">
                                    <?php
                                    $related_args = array(
                                        'category__in' => wp_get_post_categories($post->ID),
                                        'numberposts'  => 3,
                                        'post__not_in' => array($post->ID),
                                        'post_status'  => 'publish'
                                    );
                                    
                                    // Agregar filtro de idioma para Polylang
                                    if (function_exists('pll_current_language') && !empty($current_lang)) {
                                        $related_args['lang'] = $current_lang;
                                    }
                                    // Para WPML
                                    elseif (function_exists('icl_get_current_language') && !empty($current_lang)) {
                                        $related_args['suppress_filters'] = false;
                                        global $sitepress;
                                        if ($sitepress) {
                                            $sitepress->switch_lang($current_lang);
                                        }
                                    }
                                    
                                    $related = get_posts($related_args);
                                    
                                    if($related): ?>
                                        <h3><?php 
                                        if ($current_lang == 'en') {
                                            _e('Related Posts', 'lanco');
                                        } else {
                                            _e('Posts Relacionados', 'lanco');
                                        }
                                        ?></h3>
                                        <div class="row">
                                            <?php foreach($related as $post): setup_postdata($post); ?>
                                                <div class="col-md-4">
                                                    <div class="related-post-item">
                                                        <?php if(has_post_thumbnail()): ?>
                                                            <a href="<?php the_permalink(); ?>">
                                                                <?php the_post_thumbnail('medium', array('class' => 'img-responsive')); ?>
                                                            </a>
                                                        <?php endif; ?>
                                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                                        <small><?php the_time('M d, Y'); ?></small>
                                                    </div>
                                                </div>
                                            <?php endforeach; wp_reset_postdata(); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Comentarios -->
                                <div class="comments-section">
                                    <?php comments_template(); ?>
                                </div>

                            </div><!-- .post-content -->
                        </div><!-- .post-content-wrapper -->
                        
                    </article><!-- #post-<?php the_ID(); ?> -->
                    
                <?php 
                endwhile; // End of the loop.
                ?>
                </main><!-- #main -->
            </div><!-- #primary -->
        </div><!-- .col-md-8 -->

        <!-- Sidebar con filtro de idioma -->
        <div class="col-md-4">
            <aside id="secondary" class="widget-area sidebar" role="complementary">
                <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-1' ); ?>
                <?php else: ?>
                    <!-- Posts recientes filtrados por idioma -->
                    <div class="widget">
                        <h3 class="widget-title"><?php 
                        if ($current_lang == 'en') {
                            _e('Recent Posts', 'lanco');
                        } else {
                            _e('Posts Recientes', 'lanco');
                        }
                        ?></h3>
                        <ul>
                            <?php
                            $recent_args = array(
                                'numberposts' => 5,
                                'post_status' => 'publish'
                            );
                            
                            // Filtrar por idioma actual
                            if (function_exists('pll_current_language') && !empty($current_lang)) {
                                $recent_args['lang'] = $current_lang;
                            }
                            
                            $recent_posts = wp_get_recent_posts($recent_args);
                            foreach($recent_posts as $recent){
                                // Verificar idioma del post si es necesario
                                $show_post = true;
                                if (function_exists('pll_get_post_language') && !empty($current_lang)) {
                                    $post_lang = pll_get_post_language($recent["ID"]);
                                    $show_post = ($post_lang == $current_lang);
                                }
                                
                                if ($show_post) {
                                    echo '<li><a href="' . get_permalink($recent["ID"]) . '">' . $recent["post_title"].'</a></li>';
                                }
                            }
                            wp_reset_query();
                            ?>
                        </ul>
                    </div>

                    <!-- Categorías filtradas por idioma -->
                    <div class="widget">
                        <h3 class="widget-title"><?php 
                        if ($current_lang == 'en') {
                            _e('Categories', 'lanco');
                        } else {
                            _e('Categorías', 'lanco');
                        }
                        ?></h3>
                        <ul>
                            <?php 
                            $cat_args = array('title_li' => '');
                            
                            // Filtrar categorías por idioma si Polylang está activo
                            if (function_exists('pll_current_language') && !empty($current_lang)) {
                                $cat_args['lang'] = $current_lang;
                            }
                            
                            wp_list_categories($cat_args); 
                            ?>
                        </ul>
                    </div>

                    <!-- Archivo por idioma -->
                    <div class="widget">
                        <h3 class="widget-title"><?php 
                        if ($current_lang == 'en') {
                            _e('Archive', 'lanco');
                        } else {
                            _e('Archivo', 'lanco');
                        }
                        ?></h3>
                        <ul>
                            <?php 
                            // Para archivos, WordPress automáticamente filtra por idioma cuando Polylang está activo
                            wp_get_archives(array('type' => 'monthly')); 
                            ?>
                        </ul>
                    </div>

                    <!-- Widget adicional: Posts populares por idioma -->
                    <div class="widget">
                        <h3 class="widget-title"><?php 
                        if ($current_lang == 'en') {
                            _e('Popular Posts', 'lanco');
                        } else {
                            _e('Posts Populares', 'lanco');
                        }
                        ?></h3>
                        <ul>
                            <?php
                            $popular_args = array(
                                'numberposts' => 5,
                                'meta_key' => 'post_views_count',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                                'post_status' => 'publish'
                            );
                            
                            // Filtrar por idioma
                            if (function_exists('pll_current_language') && !empty($current_lang)) {
                                $popular_args['lang'] = $current_lang;
                            }
                            
                            $popular_posts = wp_get_recent_posts($popular_args);
                            if (!empty($popular_posts)) {
                                foreach($popular_posts as $popular){
                                    echo '<li><a href="' . get_permalink($popular["ID"]) . '">' . $popular["post_title"].'</a></li>';
                                }
                            } else {
                                // Fallback a posts recientes si no hay posts populares
                                foreach($recent_posts as $recent){
                                    echo '<li><a href="' . get_permalink($recent["ID"]) . '">' . $recent["post_title"].'</a></li>';
                                }
                            }
                            wp_reset_query();
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </aside><!-- #secondary -->
        </div><!-- .col-md-4 -->

    </div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoSection = document.getElementById('videoHeroSection');
    const customPlayBtn = document.getElementById('customPlayBtn');
    const youtubePlayer = document.getElementById('youtubePlayer');
    
    if (videoSection && youtubePlayer) {
        // Función para hacer el video más interactivo
        videoSection.addEventListener('click', function(e) {
            const rect = videoSection.getBoundingClientRect();
            const clickY = e.clientY - rect.top;
            const videoHeight = rect.height;
            
            if (clickY > videoHeight * 0.25 && clickY < videoHeight * 0.75) {
                youtubePlayer.focus();
            }
        });
        
        // Manejar el botón de play personalizado
        if (customPlayBtn) {
            customPlayBtn.addEventListener('click', function() {
                const currentSrc = youtubePlayer.src;
                if (currentSrc.includes('autoplay=0')) {
                    youtubePlayer.src = currentSrc.replace('autoplay=0', 'autoplay=1');
                    customPlayBtn.style.display = 'none';
                }
            });
        }
        
        // Ocultar overlays gradualmente
        let overlayTimeout;
        videoSection.addEventListener('mouseenter', function() {
            clearTimeout(overlayTimeout);
        });
        
        videoSection.addEventListener('mouseleave', function() {
            overlayTimeout = setTimeout(function() {
                const overlayTop = videoSection.querySelector('.overlay-top');
                const overlayBottom = videoSection.querySelector('.overlay-bottom');
                if (overlayTop && overlayBottom) {
                    overlayTop.style.opacity = '0.7';
                    overlayBottom.style.opacity = '0.7';
                }
            }, 2000);
        });
    }
    
    // Mejorar la navegación de posts relacionados
    const relatedPosts = document.querySelectorAll('.related-post-item');
    relatedPosts.forEach(function(post) {
        post.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        post.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>