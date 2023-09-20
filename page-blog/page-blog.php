<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'page_blog' );

function page_blog() {


    wp_register_style( 'page-blog-style', get_stylesheet_directory_uri() . '/inc/blocks/page-blog/page-blog.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'page_blog', __('Page:Blog') )
    ->add_fields( array(



    ) )

    ->set_editor_style( 'editor-style' )
    ->set_style( 'page-blog-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {


            ?>





                <div class="blog-archive">


                    <header class="blog-archive-header">
                        <div class="blog-archive-header-inner">
                            <h1 class="blog-archive-header-title">Articles</h1>
                        <div>
                    </header><!-- .page-header -->



                    <div class="breadcrumbs-conteiner"><?php true_breadcrumbs(); ?></div>
                    
                    

                    <div class="blog-archive-content">
                        
                        <div class="blog-archive-inner">

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

                            <?php 
                                $CategoryList = new WP_Term_Query( ['taxonomy' => 'category', 'order' => 'ASC', 'orderby' => 'id', 'hide_empty' => true] );
                                if($CategoryList->terms) : 
                            ?>
                                <h2 class="blog-archive-widget-cat-title">Categories</h2>
                                <ul class="blog-archive-widget-cat-list">

                                    <?php foreach ( $CategoryList->terms as $term  ) :
                                    echo '<li class="blog-archive-widget-cat-item"><a href="'.get_term_link($term->slug, 'category').'">'.$term->name.'</a></li>';
                                    endforeach;wp_reset_query(); ?>

                                </ul>
                            <?php endif; ?>

                            <?php 
                                $TagsList = new WP_Term_Query( ['taxonomy' => 'post_tag', 'order' => 'ASC', 'orderby' => 'id', 'hide_empty' => true] );
                                if($TagsList->terms) : 
                            ?>
                                <h2 class="blog-archive-sidebar-title">Tags</h2>
                                <ul class="blog-archive-widget-tag-list">

                                    <?php foreach ( $TagsList->terms as $term  ) :
                                    echo '<li class="blog-archive-widget-tag-item"><a href="'.get_tag_link($term->term_id).'">'.$term->name.'</a></li>';
                                    endforeach;wp_reset_query(); ?>

                                </ul>
                            <?php endif; ?>

                        </div>

                    </div><!--.blog-archive-content-->

                </div><!-- #main -->









    
            <?php

        }
    );



}



       







