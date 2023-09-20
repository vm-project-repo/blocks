<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'frontpage_hero' );

function frontpage_hero() {


    wp_register_style( 'frontpage-hero-style', get_stylesheet_directory_uri() . '/inc/blocks/frontpage-hero/frontpage-hero.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'frontpage_hero', __('Frontpage:Hero') )
    ->add_fields( array(





    ) )

    ->set_editor_style( 'editor-style' )
    ->set_style( 'frontpage-hero-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {

            $home_hero_name = carbon_get_post_meta( get_the_ID(), 'home_hero_name' );
            $home_hero_area = carbon_get_post_meta( get_the_ID(), 'home_hero_area' );
            $home_hero_slogan = carbon_get_post_meta( get_the_ID(), 'home_hero_slogan' );

            $home_hero_border_left = carbon_get_post_meta( get_the_ID(), 'home_hero_border_left' );
            $home_hero_border_right = carbon_get_post_meta( get_the_ID(), 'home_hero_border_right' );
            $home_hero_photo = carbon_get_post_meta( get_the_ID(), 'home_hero_photo' );
            
            ?>

                <section class="frontpage-hero">



                    <div class="frontpage-hero-part">
                        <div class="frontpage-hero-part-text">

                            <?php if($home_hero_name) : ?>
                                <div class="frontpage-hero-part-name"><?php echo esc_html($home_hero_name); ?></div>
                            <?php endif; ?>

                            <?php if($home_hero_area) : ?>
                                <div class="frontpage-hero-part-area"><?php echo esc_html($home_hero_area); ?></div>
                            <?php endif; ?>

                            <?php if($home_hero_slogan) : ?>
                                <div class="frontpage-hero-part-slogan"><?php echo esc_html($home_hero_slogan); ?></div>
                            <?php endif; ?>

                        </div>
                    </div>




                    <div class="frontpage-hero-part">
                        

                        <div class="frontpage-hero-part-inner-left">
                            <?php if($home_hero_border_left) : ?>
                            <div class="frontpage-hero-part-border-left" style="border-image: url(<?php echo esc_html(wp_get_attachment_image_url($home_hero_border_left)); ?>) stretch 30;"></div>
                            <?php endif; ?>
                        </div>

                        <div class="frontpage-hero-part-inner-rigth">
                            <?php if($home_hero_border_right) : ?>
                            <div class="frontpage-hero-part-border-rigth" style="border-image: url(<?php echo esc_html(wp_get_attachment_image_url($home_hero_border_right)); ?>) stretch 30;"></div>
                            <?php endif; ?>
                        </div>

                        <?php 
                            if($home_hero_photo) : 
                                echo wp_get_attachment_image($home_hero_photo);
                            endif; 
                        ?>

                    </div>


                </section><!-- Hero section -->


    
            <?php

        }
    );



}



       






