<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'single_posts' );

function single_posts() {

    wp_register_style( 'single-posts-style', get_stylesheet_directory_uri() . '/inc/blocks/single-posts/single-posts.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'single_posts', __('Single:Posts') )
    ->add_fields( array(


        

    ) )
    
    ->set_editor_style( 'editor-style' )
    ->set_style( 'single-posts-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {



            ?>




                <header class="blog-post-header">
                    <div class="blog-post-header-inner">
                        <h1 class="blog-post-header-title">Article</h1>
                    <div>
                </header><!-- .page-header -->

                <div class="breadcrumbs-conteiner"><?php //true_breadcrumbs(); ?></div>

                <div class="blog-post-info">

                    <div class="blog-post-categories">
                        <?php
                            if( has_category() ) :
                                echo  get_the_category_list();
                            endif;
                        ?>
                    </div>

                    <div class="blog-post-tags">
                        <?php 
                            if( has_tag() ) : 
                                echo get_the_tag_list(); // Display tags as links 
                            endif; 
                        ?>
                    </div>

                </div>

                <div class="blog-post-title"><?php the_title(); ?></div>
                <?php if(get_the_post_thumbnail_url()) : ?>
                    <div class="blog-post-img"><img src="<?php the_post_thumbnail_url(); ?>" title="<?php the_title(); ?>" alt="<?php echo strip_tags(get_the_excerpt()); ?>" class="alignnone" loading="lazy" width="1200" height="630"/></div>
                <?php endif; ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


                <div class="blog-post-content">

                <div class="blog-post-content-article">
                    
                    <div class="blog-post-content-article-inner"><?php the_content(); ?></div>

                    <div class="blog-post-content-navigations">
                        <?php

                            $prev_post = get_adjacent_post(false, '', true);
                            $next_post = get_adjacent_post(false, '', false);

                            if( !empty($prev_post) ) :
                                
                                echo '<div class="blog-post-content-prevpost">';
                                echo get_the_post_thumbnail($prev_post->ID, 'medium');
                                echo '<div class="blog-post-content-prevpost-tit" >' .$prev_post->post_title. '</div>';
                                echo '<div class="blog-post-content-prevpost-desc" >' .strip_tags(get_the_excerpt($prev_post->ID)). '</div>';
                                echo '<div class="blog-post-content-prevpost-arrow"><span>Prev post</span></div>';
                                echo '<a href="' .get_permalink($prev_post->ID). '"></a>';
                                echo '</div>';

                            else :

                                $first = new WP_Query(['post_type' => 'post', 'posts_per_page' => 1, 'order'=>'DESC']); 
                                while ( $first->have_posts() ) : $first->the_post();
                                echo '<div class="blog-post-content-prevpost">';
                                echo get_the_post_thumbnail($first->ID, 'medium');
                                echo '<div class="blog-post-content-prevpost-tit">' .strip_tags(get_the_title()). '</div>';
                                echo '<div class="blog-post-content-prevpost-desc" >' .strip_tags(get_the_excerpt()). '</div>';
                                echo '<div class="blog-post-content-prevpost-arrow"><span>Prev post</span></div>';
                                echo '<a href="' .get_permalink(). '"></a>';
                                endwhile;wp_reset_postdata();
                                echo '</div>';

                            endif; 

                            if( !empty($next_post) ) : 
                                
                                echo '<div class="blog-post-content-nextvpost">';
                                echo get_the_post_thumbnail($next_post->ID, 'medium');
                                echo '<div class="blog-post-content-nextpost-tit" >' .$next_post->post_title. '</div>';
                                echo '<div class="blog-post-content-nextpost-desc" >' .strip_tags(get_the_excerpt($next_post->ID)). '</div>';
                                echo '<div class="blog-post-content-nextpost-arrow" ><span>Next post</span></div>';
                                echo '<a href="' .get_permalink($next_post->ID). '"></a>';
                                echo '</div>';

                            else :

                                $last = new WP_Query(['post_type' => 'post', 'posts_per_page' => 1, 'order'=>'ASC']);
                                while ( $last->have_posts() ) : $last->the_post();
                                echo '<div class="blog-post-content-nextvpost">';
                                echo get_the_post_thumbnail($last->ID, 'medium');
                                echo '<div class="blog-post-content-nextpost-tit" >' .strip_tags(get_the_title()). '</div>';
                                echo '<div class="blog-post-content-nextpost-desc" >' .strip_tags(get_the_excerpt()). '</div>';
                                echo '<div class="blog-post-content-nextpost-arrow"><span>Next post</span></div>';
                                echo '<a href="' .get_permalink(). '"></a>';
                                endwhile;wp_reset_postdata();
                                echo '</div>';

                            endif; 

                        ?>
                    </div>

                </div>

                    <div class="blog-post-content-category">
                        <div class="blog-post-content-category-inner">

                            <div class="blog-post-content-category-title">Все рубрики</div>

                            <ul class="blog-post-widget-cat-list">
                                <?php
                                    $cur_cat_id = get_queried_object()->term_id;
                                    $CategoryList = new WP_Term_Query( ['taxonomy' => 'category', 'order' => 'ASC', 'orderby' => 'id', 'hide_empty' => true, 'exclude' => $cur_cat_id] );
                                    foreach ( $CategoryList->terms as $term  ) :
                                
                                    echo '<li class="blog-post-widget-cat-item"><a href="'.get_term_link($term->slug, 'category').'">'.$term->name.'</a></li>';

                                    endforeach;wp_reset_query(); 
                                ?>
                            </ul>

                        </div>
                    </div>

                    <div class="blog-post-content-tags">
                        <div class="blog-post-content-tags-inner">
                            <div class="blog-post-content-tags-title">Все метки</div>
                            <ul class="blog-post-widget-tag-list">
                                <?php
                                    $TagsList = new WP_Term_Query( ['taxonomy' => 'post_tag', 'order' => 'ASC', 'orderby' => 'id', 'hide_empty' => true] );
                                    foreach ( $TagsList->terms as $term  ) :
                                
                                    echo '<li class="blog-post-widget-tag-item"><a href="'.get_tag_link($term->term_id).'">'.$term->name.'</a></li>';

                                    endforeach;wp_reset_query(); 
                                ?>
                            </ul>
                        </div>
                    </div>

                </div>


                </article><!-- #post-<?php the_ID(); ?> -->











            <?php

        }
    );



}