<?php 
/** Template Name: blog */
get_header(); 

// Obtener idioma actual para Polylang
$current_lang = '';
if (function_exists('pll_current_language')) {
    $current_lang = pll_current_language();
} elseif (function_exists('qtranxf_getLanguage')) {
    $current_lang = qtranxf_getLanguage();
} elseif (function_exists('icl_get_current_language')) {
    $current_lang = icl_get_current_language();
}

// Configurar paginación
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Configurar query con filtro de idioma
$blog_args = array(
    'post_type' => 'post', 
    'post_status' => 'publish', 
    'posts_per_page' => 6, // Paginación de 6 posts por página
    'suppress_filters' => false, 
    'order' => 'DESC', 
    'orderby' => 'date',
    'paged' => $paged
);

// Agregar filtro de idioma si Polylang está activo
if (function_exists('pll_current_language') && !empty($current_lang)) {
    $blog_args['lang'] = $current_lang;
}

$wpb_all_query = new WP_Query($blog_args);
?>

<style>
/* Blog Listing Styles */
.blog-header {
    background: linear-gradient(135deg, #094d75 0%, #297abb 100%);
    padding: 4rem 0;
    margin-bottom: 3rem;
    color: white;
    text-align: center;
}

.blog-header h1 {
	color: #fff;
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.blog-header p {
    font-size: 1.2rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
	color: #fff;
}

.blog-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.blog-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.blog-card-media {
    position: relative;
    height: 211px;
    overflow: hidden;
}

.blog-card-image {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    transition: transform 0.3s ease;
}

.blog-card:hover .blog-card-image {
    transform: scale(1.05);
}

.blog-card-video {
    width: 100%;
    height: 100%;
}

.blog-card-video iframe {
    width: 100%;
    height: 100%;
    border: none;
}

.blog-card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.2) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.blog-card:hover .blog-card-overlay {
    opacity: 1;
}

.blog-card-content {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.blog-card-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.blog-card-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.blog-card-title a:hover {
    color: #007cba;
}

.blog-card-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.blog-card-meta span {
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.blog-card-meta i {
    font-size: 0.8rem;
}

.blog-card-excerpt {
    color: #666;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    flex-grow: 1;
}

.blog-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
}

.read-more-btn {
    background: #007cba;
    color: white!important;
    padding: 0.6rem 1.2rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
	text-transform: uppercase;
}

.blog-pagination ul {
    padding: 0px;
    margin: 0px;
    display: flex;
    width: 37vw;
    justify-content: space-around;
    list-style: none;
}

.read-more-btn:hover {
    background: #005a87;
    color: white!important;
    text-decoration: none;
    transform: translateX(3px);
}

.blog-tags {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.blog-tag {
    background: #f8f9fa;
    color: #6c757d;
    padding: 0.2rem 0.6rem;
    border-radius: 12px;
    font-size: 0.75rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.blog-tag:hover {
    background: #007cba;
    color: white;
    text-decoration: none;
}

/* Reading time badge */
.reading-time {
    background: rgba(255,255,255,0.9);
    color: #333;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 500;
    position: absolute;
    top: 1rem;
    right: 1rem;
    backdrop-filter: blur(5px);
}

/* Category badge */
.category-badge {
    background: #007cba;
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 500;
    position: absolute;
    top: 1rem;
    left: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.category-badge:hover {
    background: #005a87;
    color: white;
    text-decoration: none;
}

/* Paginación */
.blog-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    margin: 3rem 0;
}

.pagination-link {
    padding: 0.75rem 1rem;
    background: white;
    border: 1px solid #ddd;
    color: #666;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.current {
     background: #007cba;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2px 17px;
    border-radius: 10px;
    color: white;
}

.pagination-link:hover,
.pagination-link.current {
     background: #007cba;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2px 17px;
    border-radius: 10px;
    color: white;
}

/* No posts message */
.no-posts {
    text-align: center;
    padding: 4rem 2rem;
    background: #f8f9fa;
    border-radius: 15px;
    margin: 2rem 0;
}

.no-posts h3 {
    color: #666;
    margin-bottom: 1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .blog-header {
        padding: 2rem 0;
    }
    
    .blog-header h1 {
        font-size: 2rem;
    }
    
    .blog-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .blog-card-media {
        height: 200px;
    }
    
    .blog-card-content {
        padding: 1rem;
    }
    
    .blog-card-meta {
        gap: 0.5rem;
    }
    
    .blog-card-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .read-more-btn {
        text-align: center;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .blog-header {
        padding: 1.5rem 0;
        margin-bottom: 2rem;
    }
    
    .blog-header h1 {
        font-size: 1.5rem;
    }
    
    .blog-header p {
        font-size: 1rem;
    }
    
    .blog-card-title {
        font-size: 1.1rem;
    }
}
</style>

<!-- Blog Header -->
<div class="blog-header">
    <div class="container">
        <h1><?php 
        if ($current_lang == 'en') {
            echo 'Our Blog';
        } else {
            echo 'Nuestro Blog';
        }
        ?></h1>
        <p><?php 
        if ($current_lang == 'en') {
            echo 'Discover the latest insights, tips, and solutions for your health and wellness needs.';
        } else {
            echo 'Descubre las últimas novedades, consejos y soluciones para tus necesidades de salud y bienestar.';
        }
        ?></p>
    </div>
</div>

<div class="blog-container">
    <?php if ($wpb_all_query->have_posts()) : ?>
        
        <div class="blog-grid">
            <?php while ($wpb_all_query->have_posts()) : $wpb_all_query->the_post();
                // Obtener URL del video de YouTube
                $videurl_1 = get_field("p_video");
                $videurl = '';
                if (!empty($videurl_1)) {
                    parse_str(parse_url($videurl_1, PHP_URL_QUERY), $my_array_of_vars);
                    $videurl = isset($my_array_of_vars['v']) ? $my_array_of_vars['v'] : '';
                }
                
                // Calcular tiempo de lectura (aproximadamente 200 palabras por minuto)
                $content = get_the_content();
                $word_count = str_word_count(strip_tags($content));
                $reading_time = ceil($word_count / 200);
                
                // Obtener categoría principal
                $categories = get_the_category();
                $primary_category = !empty($categories) ? $categories[0] : null;
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
                    
                    <!-- Media (imagen o video) -->
                    <div class="blog-card-media">
                        <?php if (has_post_thumbnail($post->ID)): ?>
                            <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large'); ?>
                            <div class="blog-card-image" style="background-image: url('<?php echo $image[0]; ?>')"></div>
                            <div class="blog-card-overlay"></div>
                            
                            <!-- Badge de tiempo de lectura -->
                            <div class="reading-time">
                                <i class="fa fa-clock-o"></i> <?php echo $reading_time; ?> min de lectura
                            </div>
                            
                            <!-- Badge de categoría -->
                            <?php if ($primary_category): ?>
                                <a href="<?php echo get_category_link($primary_category->term_id); ?>" class="category-badge">
                                    <?php echo $primary_category->name; ?>
                                </a>
                            <?php endif; ?>
                            
                        <?php elseif (!empty($videurl)): ?>
                            <div class="blog-card-video">
                                <iframe 
                                    src="https://www.youtube.com/embed/<?php echo $videurl; ?>?rel=0&showinfo=0" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                            
                            <!-- Badge de contenido de video -->
                            <div class="reading-time">
                                <i class="fa fa-play"></i> Contenido en Video
                            </div>
                            
                            <!-- Badge de categoría para videos -->
                            <?php if ($primary_category): ?>
                                <a href="<?php echo get_category_link($primary_category->term_id); ?>" class="category-badge">
                                    <?php echo $primary_category->name; ?>
                                </a>
                            <?php endif; ?>
                            
                        <?php else: ?>
                            <!-- Placeholder si no hay imagen ni video -->
                            <div class="blog-card-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-file-text" style="font-size: 3rem; color: white; opacity: 0.7;"></i>
                            </div>
                            
                            <!-- Badge de tiempo de lectura para posts sin imagen -->
                            <div class="reading-time">
                                <i class="fa fa-clock-o"></i> <?php echo $reading_time; ?> min de lectura
                            </div>
                            
                            <!-- Badge de categoría -->
                            <?php if ($primary_category): ?>
                                <a href="<?php echo get_category_link($primary_category->term_id); ?>" class="category-badge">
                                    <?php echo $primary_category->name; ?>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Contenido de la card -->
                    <div class="blog-card-content">
                        
                        <!-- Título -->
                        <h2 class="blog-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <!-- Meta información -->
                        <div class="blog-card-meta">
                            <span>
                                <i class="fa fa-calendar"></i>
                                <?php the_time('M d, Y'); ?>
                            </span>
                            <span>
                                <i class="fa fa-user"></i>
                                <?php the_author(); ?>
                            </span>
                            <span>
                                <i class="fa fa-comments"></i>
                                <?php comments_number('0', '1', '%'); ?>
                            </span>
                        </div>

                        <!-- Excerpt -->
                        <div class="blog-card-excerpt">
                            <?php 
                            $excerpt = get_the_excerpt();
                            echo wp_trim_words($excerpt, 20, '...');
                            ?>
                        </div>

                        <!-- Footer de la card -->
                        <div class="blog-card-footer">
                            <!-- Tags -->
                            <div class="blog-tags">
                                <?php 
                                $tags = get_the_tags();
                                if ($tags) {
                                    $tag_count = 0;
                                    foreach ($tags as $tag) {
                                        if ($tag_count < 3) { // Mostrar máximo 3 tags
                                            echo '<a href="' . get_tag_link($tag->term_id) . '" class="blog-tag">' . $tag->name . '</a>';
                                            $tag_count++;
                                        }
                                    }
                                }
                                ?>
                            </div>

                            <!-- Botón leer más -->
                            <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                <?php 
                                if ($current_lang == 'en') {
                                    echo 'Read More';
                                } else {
                                    echo 'Leer Más';
                                }
                                ?>
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>

                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <!-- Paginación -->
        <div class="blog-pagination">
            <?php
            echo paginate_links(array(
                'total' => $wpb_all_query->max_num_pages,
                'current' => $paged,
                'prev_text' => '<i class="fa fa-chevron-left"></i>',
                'next_text' => '<i class="fa fa-chevron-right"></i>',
                'type' => 'list',
                'end_size' => 1,
                'mid_size' => 2
            ));
            ?>
        </div>

    <?php else : ?>
        
        <!-- Mensaje cuando no hay posts -->
        <div class="no-posts">
            <h3><?php 
            if ($current_lang == 'en') {
                echo 'No posts found';
            } else {
                echo 'No se encontraron publicaciones';
            }
            ?></h3>
            <p><?php 
            if ($current_lang == 'en') {
                echo 'Sorry, no posts matched your criteria. Please try again later.';
            } else {
                echo 'Lo sentimos, no se encontraron publicaciones que coincidan con tus criterios. Inténtalo de nuevo más tarde.';
            }
            ?></p>
        </div>

    <?php endif; 
    
    wp_reset_postdata(); 
    ?>
</div>

<?php get_footer(); ?>