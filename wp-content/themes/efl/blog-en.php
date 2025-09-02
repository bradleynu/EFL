<?php 
/** Template Name: Blog-en */
get_header(); 

// Force English language for this template
$current_lang = 'en';

// Configure pagination
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Configure query with English language filter
$blog_args = array(
    'post_type' => 'post', 
    'post_status' => 'publish', 
    'posts_per_page' => 6, // 6 posts per page
    'suppress_filters' => false, 
    'order' => 'DESC', 
    'orderby' => 'date',
    'paged' => $paged
);

// Add language filter for English posts
if (function_exists('pll_current_language')) {
    $blog_args['lang'] = 'en';
} elseif (function_exists('icl_get_current_language')) {
    $blog_args['suppress_filters'] = false;
    global $sitepress;
    if ($sitepress) {
        $sitepress->switch_lang('en');
    }
}

$wpb_all_query = new WP_Query($blog_args);
?>

<style>
/* English Blog Listing Styles */
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
    max-width: 700px;
    margin: 0 auto;
    color: #fff;
}

.blog-subheading {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    padding: 1rem 2rem;
    border-radius: 50px;
    margin-top: 1.5rem;
    display: inline-block;
    font-size: 0.9rem;
    font-weight: 500;
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
    letter-spacing: 0.5px;
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

/* Pagination */
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

/* English-specific styles */
.american-flag {
    display: inline-block;
    margin-left: 0.5rem;
    font-size: 1.2rem;
}

.blog-stats {
    text-align: center;
    margin: 2rem 0;
    padding: 1.5rem;
    background: rgba(255,255,255,0.1);
    border-radius: 15px;
    color: white;
}

.blog-stats span {
    display: inline-block;
    margin: 0 1rem;
    font-weight: 500;
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
    
    .blog-pagination ul {
        width: 80vw;
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
    
    .blog-pagination ul {
        width: 90vw;
    }
}
</style>

<!-- English Blog Header -->
<div class="blog-header">
    <div class="container">
        <h1>Our Blog</h1>
        <p>Discover the latest insights, scientific breakthroughs, and proven solutions for your health and wellness journey.</p>
    </div>
</div>

<div class="blog-container">
    <?php if ($wpb_all_query->have_posts()) : ?>
        
        <div class="blog-grid">
            <?php while ($wpb_all_query->have_posts()) : $wpb_all_query->the_post();
                // Get YouTube video URL
                $videurl_1 = get_field("p_video");
                $videurl = '';
                if (!empty($videurl_1)) {
                    parse_str(parse_url($videurl_1, PHP_URL_QUERY), $my_array_of_vars);
                    $videurl = isset($my_array_of_vars['v']) ? $my_array_of_vars['v'] : '';
                }
                
                // Calculate reading time (approximately 200 words per minute)
                $content = get_the_content();
                $word_count = str_word_count(strip_tags($content));
                $reading_time = ceil($word_count / 200);
                
                // Get primary category
                $categories = get_the_category();
                $primary_category = !empty($categories) ? $categories[0] : null;
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
                    
                    <!-- Media (image or video) -->
                    <div class="blog-card-media">
                        <?php if (has_post_thumbnail($post->ID)): ?>
                            <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large'); ?>
                            <div class="blog-card-image" style="background-image: url('<?php echo $image[0]; ?>')"></div>
                            <div class="blog-card-overlay"></div>
                            
                            <!-- Reading time badge -->
                            <div class="reading-time">
                                <i class="fa fa-clock-o"></i> <?php echo $reading_time; ?> min read
                            </div>
                            
                            <!-- Category badge -->
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
                            
                            <!-- Video duration badge -->
                            <div class="reading-time">
                                <i class="fa fa-play"></i> Video Content
                            </div>
                            
                        <?php else: ?>
                            <!-- Placeholder if no image or video -->
                            <div class="blog-card-image" style="background: linear-gradient(135deg, #094d75 0%, #297abb 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-file-text" style="font-size: 3rem; color: white; opacity: 0.7;"></i>
                            </div>
                            
                            <!-- Reading time badge -->
                            <div class="reading-time">
                                <i class="fa fa-clock-o"></i> <?php echo $reading_time; ?> min read
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Card content -->
                    <div class="blog-card-content">
                        
                        <!-- Title -->
                        <h2 class="blog-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <!-- Meta information -->
                        <div class="blog-card-meta">
                            <span>
                                <i class="fa fa-calendar"></i>
                                <?php the_time('F j, Y'); ?>
                            </span>
                            <span>
                                <i class="fa fa-user"></i>
                                By <?php the_author(); ?>
                            </span>
                            <span>
                                <i class="fa fa-comments"></i>
                                <?php 
                                $comments_count = get_comments_number();
                                if ($comments_count == 0) {
                                    echo 'No comments';
                                } elseif ($comments_count == 1) {
                                    echo '1 comment';
                                } else {
                                    echo $comments_count . ' comments';
                                }
                                ?>
                            </span>
                        </div>

                        <!-- Excerpt -->
                        <div class="blog-card-excerpt">
                            <?php 
                            $excerpt = get_the_excerpt();
                            echo wp_trim_words($excerpt, 25, '...');
                            ?>
                        </div>

                        <!-- Card footer -->
                        <div class="blog-card-footer">
                            <!-- Tags -->
                            <div class="blog-tags">
                                <?php 
                                $tags = get_the_tags();
                                if ($tags) {
                                    $tag_count = 0;
                                    foreach ($tags as $tag) {
                                        if ($tag_count < 3) { // Show maximum 3 tags
                                            echo '<a href="' . get_tag_link($tag->term_id) . '" class="blog-tag">' . $tag->name . '</a>';
                                            $tag_count++;
                                        }
                                    }
                                }
                                ?>
                            </div>

                            <!-- Read more button -->
                            <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                Read Full Article
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>

                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="blog-pagination">
            <?php
            echo paginate_links(array(
                'total' => $wpb_all_query->max_num_pages,
                'current' => $paged,
                'prev_text' => '<i class="fa fa-chevron-left"></i> Previous',
                'next_text' => 'Next <i class="fa fa-chevron-right"></i>',
                'type' => 'list',
                'end_size' => 1,
                'mid_size' => 2
            ));
            ?>
        </div>

    <?php else : ?>
        
        <!-- Message when no posts found -->
        <div class="no-posts">
            <h3>No Articles Found</h3>
            <p>Sorry, we couldn't find any articles matching your criteria. Please check back soon as we regularly publish new content, or explore our other health and wellness resources.</p>
            <a href="<?php echo home_url(); ?>" class="read-more-btn" style="margin-top: 1rem;">
                <i class="fa fa-home"></i> Return to Homepage
            </a>
        </div>

    <?php endif; 
    
    wp_reset_postdata(); 
    ?>
</div>

<?php get_footer(); ?>