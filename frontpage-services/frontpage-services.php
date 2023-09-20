<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'frontpage_services' );

function frontpage_services() {


    wp_register_style( 'frontpage-services-style', get_stylesheet_directory_uri() . '/inc/blocks/frontpage-services/frontpage-services.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'frontpage_services', __('Frontpage:Services') )
    ->add_fields( array(



    ) )

    ->set_editor_style( 'editor-style' )
    ->set_style( 'frontpage-services-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {

            $home_service_title = carbon_get_post_meta( get_the_ID(), 'home_service_title' );
            $home_services_img_id = carbon_get_post_meta( get_the_ID(), 'home_services_img' );

            $home_services_btn_text = carbon_get_post_meta( get_the_ID(), 'home_services_btn_text' );
            $home_services_btn_link = carbon_get_post_meta( get_the_ID(), 'home_services_btn_link' );

            ?>

                <section class="home-services" id="home_services">


                    <div class="home-services-flex">

                        <div class="home-services-section-text">
                            <?php 
                                if($home_service_title) : 

                                $allowed_html = array( 
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                );
                            ?>
                                <h2 class="home-services-section-title"><?php echo wp_kses($home_service_title, $allowed_html ); ?></h2>
                            <?php endif; ?>
                        </div>

                        <div class="home-services-conteiner-content">

                            <?php 
                                if($home_services_img_id) : 
                                    echo wp_get_attachment_image( $home_services_img_id, 'full' );
                                endif;


                                $number = 0;
                                $ServicesItems = carbon_get_the_post_meta( 'home_services_list' );
                                if( $ServicesItems ) : //Home service loop validations start
                            ?>
                            <div class="home-services-conteiner-list">
                                <?php

                                    foreach ( $ServicesItems as $ServicesItem ) :
                                    $number++;
                                    $home_services_title = $ServicesItem['home_services_title'];
                                    $home_services_description = $ServicesItem['home_services_description'];
                                ?>

                                    <div class="home-service-accordion">

                                        <input class="home-service-accordion-trigger" type="checkbox" aria-label="accordion-<?php echo esc_html($number); ?>"/>
                                        
                                        <?php if($home_services_title) : ?>
                                            <h2 class="home-service-accordion-title"><span class="home-service-accordion-title-text"><?php echo esc_html($home_services_title); ?></span><span class="home-service-accordion-btn"><span class="home-service-accordion-arrow"></span></span></h2>
                                        <?php endif;  ?>

                                        <?php if($home_services_description) : ?>
                                            <div class="home-service-accordion-description"><span><?php echo esc_html($home_services_description); ?></span></div>
                                        <?php endif;  ?>

                                    </div>

                                        
                                <?php endforeach;wp_reset_query();?>
                            </div>
                            <?php endif;  //End of home service loop validations ?>

                        </div>

                    </div>

                    <?php if( $home_services_btn_text && $home_services_btn_link ) : ?>
                    <div class="home-section-service-btn-conteiner">  
                        <div class="btn-round">
                            <span class="btn-click magnetic" data-strength="100" data-strength-text="50">
                                <span class="btn-text">
                                    <span class="btn-text-inner"><?php echo esc_html($home_services_btn_text); ?></span>
                                </span>
                                <a class="btn-link" href="<?php echo esc_html($home_services_btn_link); ?>" aria-label="Services" ></a>
                            </span>
                        </div>
                    </div><!-- Rounded button conteiner --> 
                    <?php endif; ?>


                </section>


    
            <?php

        }
    );



}



       






