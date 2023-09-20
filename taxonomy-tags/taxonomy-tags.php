<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'taxonomy_tags' );

function taxonomy_tags() {


    wp_register_style( 'taxonomy-tags-style', get_stylesheet_directory_uri() . '/inc/blocks/taxonomy-tags/taxonomy-tags.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'taxonomy_tags', __('Taxonomy:Tags') )
    ->add_fields( array(



    ) )

    ->set_editor_style( 'editor-style' )
    ->set_style( 'taxonomy-tags-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {

            $term = get_queried_object();
		
            $img_id = carbon_get_term_meta( $term->term_id, 'servicetype_img' );
            $thumbnail_url = wp_get_attachment_image_url( $img_id, 'full' );

            ?>


                <div  class="site-main">



                    <header class="blog-archive-header">
                        <div class="blog-archive-header-inner">
                            <h1 class="blog-archive-header-title">Метка</h1>
                        <div>
                    </header><!-- .page-header -->

                    <div class="breadcrumbs-conteiner"><?php true_breadcrumbs(); ?></div>

                        

                    <div class="blog-archive-category-conteiner">
                        <div class="blog-archive-category-conteiner-inner">

                            <div class="blog-archive-category-conteiner-item">
                                <h1 class="blog-archive-category-title"><?php single_term_title(); ?></h1>
                                <div class="blog-archive-category-description"><?php echo strip_tags(tag_description()); ?></div>
                            </div>

                            <div class="blog-archive-category-conteiner-item">
                                <img src="<?php echo $thumbnail_url; ?>" title="<?php single_term_title(); ?>" alt="<?php tag_description(); ?>" class="alignnone" loading="lazy" width="1200" height="630"/>
                            </div>

                        </div>
                    </div>




                    <div class="blog-archive-content">
                        <div class="blog-archive-content-inner">
                            <div class="blog-archive-list">
                                <?php 
                                    /* Start the Loop */
                                    while ( have_posts() ) : the_post();
                                ?>

                                    <div class="blog-archive-list-item">
                                        <div class="blog-archive-list-img"><img src="<?php the_post_thumbnail_url(); ?>" title="<?php the_title(); ?>" alt="<?php the_excerpt(); ?>" class="alignnone" loading="lazy" width="300" height="158"/></div>
                                        <div class="blog-archive-list-text">
                                            <div class="blog-archive-item-category"><?php the_category(); ?></div>
                                            <div class="blog-archive-item-title"><?php the_title(); ?></div>
                                            <div class="blog-archive-item-description"><?php the_excerpt(); ?></div>
                                            <div class="blog-archive-item-link">
                                                <div class="blog-archive-item-btn">
                                                    <div class="blog-archive-item-btn-text">More detail</div>
                                                    <div class="blog-archive-item-btn-arrow"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="blog-archive-list-item-link" href="<?php the_permalink(); ?>"></a>
                                    </div>
                                    
                                <?php 
                                    endwhile;
                                ?>  
                            </div>

                            <div class="blog-paginations"><?php the_posts_pagination();?></div>
                            
                        </div>



                        <div class="blog-archive-sidebar">

                            <h2 class="blog-archive-sidebar-title">Category</h2>
                            <ul class="blog-archive-widget-cat-list">
                                <?php
                                    $cur_cat_id = get_queried_object()->term_id;
                                    $CategoryList = new WP_Term_Query( ['taxonomy' => 'category', 'order' => 'ASC', 'orderby' => 'id', 'hide_empty' => true, 'exclude' => $cur_cat_id] );
                                    foreach ( $CategoryList->terms as $term  ) :
                                
                                    echo '<li class="blog-archive-widget-cat-item"><a href="'.get_term_link($term->slug, 'category').'">'.$term->name.'</a></li>';

                                    endforeach;wp_reset_query(); 
                                ?>
                            </ul>


                        </div>

                    </div><!--.blog-archive-content-->

                </div><!-- #main -->



    
            <?php

        }
    );



}



       







