<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'frontpage_portfolio' );

function frontpage_portfolio() {


    wp_register_style( 'frontpage-portfolio-style', get_stylesheet_directory_uri() . '/inc/blocks/frontpage-portfolio/frontpage-portfolio.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'frontpage_portfolio', __('Frontpage:Portfolio') )
    ->add_fields( array(



    ) )

    ->set_editor_style( 'editor-style' )
    ->set_style( 'frontpage-portfolio-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {


            $home_portfolio_title = carbon_get_post_meta( get_the_ID(), 'home_portfolio_title' );
            $home_portfolio_loop_btn_text = carbon_get_post_meta( get_the_ID(), 'home_portfolio_loop_btn_text' );
            $home_portfolio_btn_text = carbon_get_post_meta( get_the_ID(), 'home_portfolio_btn_text' );
            $home_portfolio_btn_link = carbon_get_post_meta( get_the_ID(), 'home_portfolio_btn_link' );

            ?>


                <section class="home-portfolio" id="home_portfolio" >

                    <div class="home-portfolio-section-text">
                        <?php 
                            $allowed_html = array( 
                                'span' => array(
                                    'class' => array(),
                                ),
                            );

                            if($home_portfolio_title) : 
                        ?>
                            <h2 class="home-portfolio-section-title"><?php echo wp_kses($home_portfolio_title, $allowed_html ); ?></h2>
                        <?php endif; ?>
                    </div>


                    <?php

                        $ProjectsListArgs  = array( 
                            'post_type' => 'projects',
                            'post_status' => 'publish',
                            'posts_per_page' => 4,
                            'orderby'=> 'post_date',
                            'order' => 'DESC'
                        );
                        
                        $ProjectsList = new WP_Query($ProjectsListArgs);
                        if($ProjectsList->have_posts()) : //ProjectsList Loop Validations
                    ?>
                    <ul class="home-portfolio-list portfolio-cursor">

                        <?php
                            while ( $ProjectsList->have_posts() ) : $ProjectsList->the_post();
                            $projects_customer = carbon_get_post_meta( get_the_id(), 'projects_customer' );
                            $projects_service = carbon_get_post_meta( get_the_id(), 'projects_service' );
                        ?>

                            <li class="home-portfolio-item portfolio-item js-marquee">

                                <?php if(get_the_post_thumbnail()) : ?>
                                    <div class="home-portfolio-item-img"><?php the_post_thumbnail(); ?></div>
                                <?php endif; ?>

                                <?php if($projects_service || get_the_title() ) : ?>
                                    <h2 class="home-portfolio-item-title"><?php echo esc_html($projects_service); ?> <span><?php esc_html(the_title()); ?></span></h2>
                                <?php endif; ?>

                                <a href="<?php esc_html(the_permalink()); ?>"></a>
                            </li>

                        <?php endwhile;wp_reset_postdata(); ?>

                    </ul>
                    <?php 
                        endif; 


                        $ProjectsImg = new WP_Query($ProjectsListArgs);
                        if($ProjectsImg->have_posts()) : //ProjectsImg Loop Validations
                    ?>
                    <ul class="portfolio-list-image">
                        <div class="portfolio-list-image-bounce overlay">
                            <div class="portfolio-list-image-wrap">
                                <?php
                                    while ( $ProjectsImg->have_posts() ) : $ProjectsImg->the_post();
                                    
                                ?>

                                <li class="portfolio-list-image-item">
                                    <?php if( get_the_post_thumbnail_url() ) : //ProjectsImg Loop Item Validation Data ?>
                                        <div class="overlay-image" style="background-image:url('<?php esc_html(the_post_thumbnail_url()); ?>');"></div>
                                    <?php endif; ?>
                                </li>

                                <?php endwhile;wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </ul>
                    <?php if( $home_portfolio_loop_btn_text ) : ?>
                    <div class="portfolio-list-image-cursor"><span><?php echo esc_html($home_portfolio_loop_btn_text); ?></span></div>
                    <?php endif;endif; ?>

                    <?php if( $home_portfolio_btn_text || $home_portfolio_btn_link ) : //Rounded Button Validation ?>
                    <div class="home-section-portfolio-btn-conteiner">    
                        <div class="btn-round">
                            <span class="btn-click magnetic" data-strength="100" data-strength-text="50">
                                <span class="btn-text">
                                    <span class="btn-text-inner"><?php echo esc_html($home_portfolio_btn_text); ?></span>
                                </span>
                                <a class="btn-link" href="<?php echo esc_html($home_portfolio_btn_link); ?>" aria-label="Projects"></a>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>

                </section>


    
            <?php

        }
    );



}



       






