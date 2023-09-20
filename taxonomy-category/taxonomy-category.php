<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'taxonomy_category' );

function taxonomy_category() {


    wp_register_style( 'taxonomy-category-style', get_stylesheet_directory_uri() . '/inc/blocks/taxonomy-category/taxonomy-category.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'taxonomy_category', __('Taxonomy:Category') )
    ->add_fields( array(



    ) )

    ->set_editor_style( 'editor-style' )
    ->set_style( 'taxonomy-category-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {

            $term = get_queried_object();
            $category = get_queried_object();
            $cur_cat_name = $category->slug;
            $img_id = carbon_get_term_meta( $term->term_id, 'category_image' );
            $thumbnail_url = wp_get_attachment_image_url( $img_id, 'full' );
            $cur_cat_id = get_queried_object()->term_id;

            ?>




                <div class="archive-category">



                    <header class="blog-archive-header">
                        <div class="blog-archive-header-inner">
                            <div class="blog-archive-header-title">Category</div>
                        <div>
                    </header><!-- .page-header -->

                    <div class="breadcrumbs-conteiner"><?php true_breadcrumbs(); ?></div>
                        


                    <div class="blog-archive-category-conteiner">
                        <div class="blog-archive-category-conteiner-inner">

                            <div class="blog-archive-category-conteiner-item">
                                <h1 class="blog-archive-category-title"><?php single_term_title(); ?></h1>
                                <div class="blog-archive-category-description"><?php echo strip_tags(category_description()); ?></div>
                            </div>

                            <div class="blog-archive-category-conteiner-item">
                                <img src="<?php echo $thumbnail_url; ?>" title="<?php single_term_title(); ?>" alt="<?php term_description( $category ); ?>" class="alignnone" loading="lazy" width="1200" height="630"/>
                            </div>

                        </div>
                    </div>

                    <div class="blog-category-content">
                        <div class="blog-category-list-inner">
                            <div class="blog-category-list">
                                <?php 
                                    /* Start the Loop */
                                    while ( have_posts() ) : the_post();
                                ?>

                                    <div class="blog-category-list-item">
                                        <div class="blog-category-list-img"><img src="<?php the_post_thumbnail_url(); ?>" title="<?php the_title(); ?>" alt="<?php the_excerpt(); ?>" class="alignnone" loading="lazy" width="300" height="158"/></div>
                                        <div class="blog-category-list-text">
                                            <div class="blog-category-item-title"><?php the_title(); ?></div>
                                            <div class="blog-category-item-description"><?php the_excerpt(); ?></div>
                                            <div class="blog-category-item-link">
                                                <div class="blog-category-item-btn">
                                                    <div class="blog-category-item-btn-text">More detail</div>
                                                    <div class="blog-category-item-btn-arrow"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="blog-category-list-item-link" href="<?php the_permalink(); ?>"></a>
                                    </div>

                                <?php 
                                    endwhile;
                                ?>  
                            </div>

                            <div class="blog-paginations"><?php the_posts_pagination();?></div>

                        </div>



                        <div class="blog-category-sidebar">

                            <h2 class="blog-category-sidebar-title">Other categories</h2>
                            <ul class="blog-category-widget-cat-list">
                                <?php
                                    $cur_cat_id = get_queried_object()->term_id;
                                    $CategoryList = new WP_Term_Query( ['taxonomy' => 'category', 'order' => 'ASC', 'orderby' => 'id', 'hide_empty' => true, 'exclude' => $cur_cat_id] );
                                    foreach ( $CategoryList->terms as $term  ) :
                                
                                    echo '<li class="blog-category-widget-cat-item"><a href="'.get_term_link($term->slug, 'category').'">'.$term->name.'</a></li>';

                                    endforeach;wp_reset_query();
                                    echo '<li class="blog-category-widget-cat-item"><a href="/blog">Все рубрики</a></li>';
                                ?>
                            </ul>

                            <h2 class="blog-category-sidebar-title">Other tags</h2>
                            <ul class="blog-category-widget-tag-list">
                                <?php
                                
                                    function get_tags_in_cat($cat_id)
                                    {
                                        $posts = get_posts( array('category' => $cat_id, 'numberposts' => -1) );
                                        $tags = array();
                                    
                                        foreach($posts as $post) :
                                        
                                            $post_tags = get_the_tags($post->ID);
                                            if( !empty($post_tags) )
                                                foreach($post_tags as $tag) :
                                                    $tags[$tag->term_id] = $tag->name;
                                                endforeach;
                                            
                                        endforeach;
                                        asort($tags);
                                        return $tags;
                                    }
                                ?>

                                <?php
                                    $cat_id = get_query_var('cat'); // получаем ID текущей категории   
                                    $tags = get_tags_in_cat($cat_id);
                                    foreach($tags as $tag_id => $tag_name)
                                    $tags_print[] = '<li class="blog-category-widget-tag-item"><a href="' .get_tag_link($tag_id). '">' .$tag_name. '</a></li>';
                                    echo implode( $tags_print);
                                ?>

                            </ul>

                        </div>

                    </div><!--.blog-archive-content-->

                </div><!-- #main -->




    
            <?php

        }
    );



}



       







