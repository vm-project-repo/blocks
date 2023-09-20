<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'single_projects' );

function single_projects() {

    wp_register_style( 'single-projects-style', get_stylesheet_directory_uri() . '/inc/blocks/single-projects/single-projects.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'single_projects', __('Single:Projects') )
    ->add_fields( array(


        

    ) )
    
    ->set_editor_style( 'editor-style' )
    ->set_style( 'single-projects-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {

            $projects_customer = carbon_get_post_meta( get_the_id(), 'projects_customer' );
            $projects_service = carbon_get_post_meta( get_the_id(), 'projects_service' );
            $projects_link = carbon_get_post_meta( get_the_id(), 'projects_link' );
            $projects_url = carbon_get_post_meta( get_the_id(), 'projects_url' );
            $projects_reviewer_name = carbon_get_post_meta( get_the_id(), 'projects_reviewer_name' );
            $projects_review_text = carbon_get_post_meta( get_the_id(), 'projects_review_text' );
            $projects_review_photo_id = carbon_get_post_meta( get_the_id(), 'projects_review_photo' );
            $projects_review_photo = wp_get_attachment_image($projects_review_photo_id , 'full');
            $projects_review_no_photo = wp_get_attachment_image('270', 'full');
            $projects_review_rating = intval( carbon_get_post_meta( get_the_id(), 'projects_review_rating' ) );

            ?>






                <div class="portfolio-post-header">
                    <div class="portfolio-post-header-inner">
                        <div class="portfolio-post-header-title"><?php the_title(); ?></div>
                    </div>
                </div><!-- .page-header -->


                <div class="breadcrumbs-conteiner"><?php true_breadcrumbs(); ?></div>



                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <div class="projects-content-desc-list">

                        <div class="projects-content-desc-row">
                            <strong>Date</strong><span><?php the_date('Y'); ?></span>
                        </div>

                        <div class="projects-content-desc-row">
                            <strong>Customer</strong><span><?php echo $projects_customer; ?></span>
                        </div>

                        <div class="projects-content-desc-row">
                            <strong>Task</strong><span><?php echo $projects_service; ?></span>
                        </div>

                        <div class="projects-content-desc-row">
                            <strong>Project link</strong><a class="link" href="" data-link="<?php echo $projects_url; ?>" rel="nofollow">https://<?php echo $projects_link; ?></a>
                        </div>

                    </div>




                    <div class="projects-content-desc">
                        <div class="projects-content-desc-text"><?php the_content(); ?></div>
                    </div><!-- .entry-content -->





                    <div class="projects-swiper-navigations">

                        <div class="projects-swiper-prev"></div>
                        <div class="projects-scrollbar"></div>
                        <div class="projects-swiper-next"></div>

                    </div>


                    <div class="projects-content-slider">

                        <div class="projectswiper">
                            <div class="swiper-wrapper">


                            <?php 
                                $projects_slider = carbon_get_post_meta( get_the_id(), 'projects_slider' );
                                foreach ( $projects_slider as $projects_slide ) :

                                    $projects_slider_img_id = $projects_slide['projects_slider_item'];
                                    $projects_slider_img = wp_get_attachment_image($projects_slider_img_id , 'full'); ?>
                                

                                    <div class="swiper-slide">
                                        <div class="project-slide"><?php echo $projects_slider_img; ?></div>
                                    </div>
                                <?php  
                                endforeach;wp_reset_query();
                                ?>

                            </div><!-- .swiper-wrapper -->
                        </div><!-- .projectswiper -->

                    </div>

                </div><!-- #post-<?php the_ID(); ?> -->


                <div class="other-projects-conteiner">

                    <div class="otherprojects-swiper-prev"></div>
                    <div class="otherprojects-swiper-next"></div>

                    <div class="other-project">
                        <div class="swiper-wrapper">
                            
                            <?php
                                $ProjectsList = new WP_Query([ 'post_type' => 'projects', 'post_status' => 'publish',  'posts_per_page' => -1, 'post__not_in' => array(get_the_ID()), 'orderby'=> 'post_date', 'order' => 'DESC' ]); 
                                while( $ProjectsList->have_posts()):$ProjectsList->the_post();
                                $projects_service = carbon_get_post_meta( get_the_id(), 'projects_service' );
                            ?>

                                <div class="swiper-slide">
                                    <div class="other-projects-item">
                                        
                                        <div class="other-projects-item-title"><?php the_title(); ?></div>

                                        <div class="other-projects-item-category"><?php echo $projects_service; ?></div>

                                        <div class="other-projects-item-img"><?php the_post_thumbnail(); ?></div>

                                        <a href="<?php the_permalink() ?>"></a>
                                    </div>
                                </div>
                                
                            <?php endwhile;wp_reset_query();?>

                        </div>
                    </div>
                    
                </div>



            <?php

        }
    );



}