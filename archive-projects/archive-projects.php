<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'archive_projects' );

function archive_projects() {


    wp_register_style( 'archive-projects-style', get_stylesheet_directory_uri() . '/inc/blocks/archive-projects/archive-projects.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'archive_projects', __('Archive:Projects') )
    ->add_fields( array(



    ) )

    ->set_editor_style( 'editor-style' )
    ->set_style( 'archive-projects-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {


            ?>

                <section class="archive-portfolio">

                    <div class="portfolio-archive-header">
                        <div class="portfolio-archive-header-inner">
                            <div class="portfolio-archive-header-title"><?php the_archive_title(); ?></div>
                        </div>
                    </div>

                    <div class="breadcrumbs-conteiner"><?php true_breadcrumbs(); ?></div>

                    <div class="portfolio-archive-description">
                        <div  class="portfolio-archive-description-inner">When I work with a client, I try to follow the principle of exceeding their expectations. This approach pays off in the long run through word-of-mouth recommendations from satisfied clients to potential future clients, which is more effective than any advertising</div>
                    </div>


                    <div class="archive-portfolio-wrap">
                        <ul class="archive-portfolio-list">

                            <?php

                                $ProjectsList = new WP_Query([ 'post_type' => 'projects', 'post_status' => 'publish',  'posts_per_page' => -1, 'orderby'=> 'post_date', 'order' => 'DESC' ]);
                                while ( $ProjectsList->have_posts() ) : $ProjectsList->the_post();
                                
                                $projects_service = carbon_get_post_meta( get_the_id(), 'projects_service' );
                            ?>

                            <li class="archive-portfolio-item">
                                <div class="archive-portfolio-item-img"><?php the_post_thumbnail(); ?></div>
                                <div class="archive-portfolio-item-service"><?php echo $projects_service ?></div>
                                <h2 class="archive-portfolio-item-title"><?php the_title(); ?></h2>
                                <a href="<?php the_permalink(); ?>"></a>
                            </li>

                            <?php endwhile;wp_reset_postdata(); ?>

                        </ul>
                    </div>

                </section><!-- Projects -->











    
            <?php

        }
    );



}



       







