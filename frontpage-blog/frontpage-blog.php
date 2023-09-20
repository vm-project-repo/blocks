<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'frontpage_blog' );

function frontpage_blog() {


    wp_register_style( 'frontpage-blog-style', get_stylesheet_directory_uri() . '/inc/blocks/frontpage-blog/frontpage-blog.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'frontpage_blog', __('Frontpage:Blog') )
    ->add_fields( array(



    ) )

    ->set_editor_style( 'editor-style' )
    ->set_style( 'frontpage-blog-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {



			$home_blog_title = carbon_get_post_meta( get_the_ID(), 'home_blog_title' );
            $home_blog_loop_btn_text = carbon_get_post_meta( get_the_ID(), 'home_blog_loop_btn_text' );
			$home_blog_btn_text = carbon_get_post_meta( get_the_ID(), 'home_blog_btn_text' );
            $home_blog_btn_link = carbon_get_post_meta( get_the_ID(), 'home_blog_btn_link' );



            ?>


                <section class="home-blog" id="home_blog">

                    <div class="home-blog-section-content">

                        <div class="home-blog-section-text">
                            <?php 
                                $allowed_html = array( 
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                );

                                if($home_blog_title) : 
                            ?>
                                <h2 class="home-blog-section-title"><?php echo wp_kses($home_blog_title, $allowed_html ); ?></h2>
                            <?php endif; ?>
                        </div>


                        <?php
                            $ArticleListArgs  = array( 
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page' => 6, 
                                'orderby'=> 'post_date', 
                                'order' => 'DESC',
                                //'post__in' => array( 578, 538, 519, 511, 481, 475 ),
                            );
                            $ArticleList = new WP_Query( $ArticleListArgs );
                            if( $ArticleList->have_posts() ) :
                        ?>
                        <div class="home-blog-list">

                                <div class="home-blog-slider">
                                    <div class="swiper-wrapper">
                                        <?php
                                            while ( $ArticleList->have_posts() ) : $ArticleList->the_post();
                                        ?>
                                        <div class="swiper-slide">
                                            <div class="home-blog-item">

                                                <?php if( get_the_post_thumbnail_url() ) : ?>
                                                    <div class="home-blog-item-img"><?php the_post_thumbnail(); ?></div>
                                                <?php endif; ?>

                                                <div class="home-blog-text">
                                                    <div class="home-blog-text-inner">

                                                        <?php if(get_the_title()) : ?>
                                                            <h2 class="home-blog-text-title"><?php esc_html(the_title()); ?></h2>
                                                        <?php endif; ?>

                                                        <?php if(get_the_excerpt()) : ?>
                                                            <div class="home-blog-text-desc"><?php echo esc_html(get_the_excerpt()); ?></div>
                                                        <?php endif; ?>

                                                        <?php if($home_blog_loop_btn_text) : ?>
                                                            <div class="home-blog-text-btn"><?php echo esc_html($home_blog_loop_btn_text); ?> <span>.</span></div>
                                                        <?php endif; ?>
                                                        
                                                    </div>
                                                </div>

                                                <a rel="nofollow" href="<?php esc_html(the_permalink()); ?>"></a>
                                            </div>
                                        </div>

                                        <?php endwhile;wp_reset_postdata(); ?>
                                    </div>
                                    
                                </div>
                            

                            <div class="home-blog-slider-navigations">
                                <div class="home-blog-slider-prev"></div>
                                <div class="home-blog-slider-next"></div>
                            </div>

                        </div>
                        <?php endif; ?><!--Blog loop --> 

                    </div><!--Blog Content --> 
                    

                    <?php if( $home_blog_btn_text || $home_blog_btn_link ) : ?>
                    <div class="home-section-blog-btn-conteiner">

                        <div class="btn-round">
                            <span class="btn-click magnetic" data-strength="100" data-strength-text="50">
                                <span class="btn-text">
                                    <span class="btn-text-inner"><?php echo esc_html($home_blog_btn_text); ?></span>
                                </span>
                                <a class="btn-link" href="<?php echo esc_html($home_blog_btn_link); ?>" aria-label="Blog"></a>
                            </span>
                        </div>

                    </div><!-- Rounded button conteiner --> 
                    <?php endif; ?>

                </section>


    
            <?php

        }
    );



}