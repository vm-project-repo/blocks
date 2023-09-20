<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'single_services' );

function single_services() {

    wp_register_style( 'single-services-style', get_stylesheet_directory_uri() . '/inc/blocks/single-services/single-services.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'single_services', __('Single:Services') )
    ->add_fields( array(


        

    ) )
    
    ->set_editor_style( 'editor-style' )
    ->set_style( 'single-services-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {

            $term = get_queried_object();
            $taxonomy = get_queried_object();
            $service_price = carbon_get_post_meta( get_the_ID(), 'service_price' );
            $service_price_valid_date = date('Y-m-d', strtotime('+1 years'));

            ?>


                <article>

                    <div class="services-post-header">
                            
                        <div class="services-post-header-inner">
                            <h1 class="services-post-header-title" ><?php the_title(); ?></h1>
                            <div class="services-post-img"><?php the_post_thumbnail_url(); ?></div>
                        </div>

                    </div>


                    <div class="services-post-breadcrumbs">
                        <div class="breadcrumbs-conteiner"><?php true_breadcrumbs(); ?></div>
                    </div>


                    <div class="services-post-content">
                        <div class="services-post-content-inner"><?php the_content(); ?></div>
                    </div>


                    <div class="services-post-recent-projects">

                        <div class="services-post-recent-projects-name">Recent Projects</div>

                        <ul class="services-post-recent-projects-list">

                            <?php
                                $ProjectsList = new WP_Query([ 'post_type' => 'projects', 'post_status' => 'publish',  'posts_per_page' => 4, 'orderby'=> 'post_date', 'order' => 'DESC' ]);
                                while ( $ProjectsList->have_posts() ) : $ProjectsList->the_post();
                                $projects_category = carbon_get_post_meta( get_the_id(), 'projects_service' );
                            ?>

                            <li class="services-post-recent-projects-item">
                                <div class="services-post-recent-projects-item-img"><?php the_post_thumbnail(); ?></div>
                                <h2 class="services-post-recent-projects-item-title"><?php the_title(); ?></h2>
                                <div class="services-post-recent-projects-item-service"><?php echo $projects_category; ?></div>
                                <a href="<?php the_permalink(); ?>"></a>
                            </li>

                            <?php endwhile;wp_reset_postdata(); ?>

                        </ul>
                        
                    </div>



                </article>













            <?php

        }
    );



}