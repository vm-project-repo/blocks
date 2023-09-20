<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'frontpage_stack' );

function frontpage_stack() {


    wp_register_style( 'frontpage-stack-style', get_stylesheet_directory_uri() . '/inc/blocks/frontpage-stack/frontpage-stack.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'frontpage_stack', __('Frontpage:Stack') )
    ->add_fields( array(



    ) )

    ->set_editor_style( 'editor-style' )
    ->set_style( 'frontpage-stack-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {
            
            ?>

                <section class="home-stack">


                    <div class="home-stack-inner">

                        <?php
                            $frontend_list = carbon_get_post_meta( get_the_ID(), 'frontend_loop' );
                            if ( $frontend_list ) : //line__1 loop validations
                        ?>
                            <div class="wrapper-conteiner">
                                <div class="wrapper-conteiner-stack line__1">
                                    <div class="wrapper-conteiner-stack-inner">
                                        <?php
                                            foreach ( $frontend_list as $frontend_img ) :
                                            $frontend_img_id = $frontend_img['frontend_item'];

                                                if($frontend_img_id) : //line__1 loop item validation
                                                    echo '<div class="home-stack-conteiner-item">' . wp_get_attachment_image( $frontend_img_id, 'full' ) . '</div>';
                                                endif;

                                            endforeach;wp_reset_query();
                                        ?>
                                    </div>				
                                </div>
                            </div>
                        <?php 
                            endif;

                            $backend_list = carbon_get_post_meta( get_the_ID(), 'backend_loop' );
                            if ( $backend_list ) : //line__2 loop validations
                        ?>
                        <div class="wrapper-conteiner">
                            <div class="wrapper-conteiner-stack line__2">
                                <div class="wrapper-conteiner-stack-inner">
                                    <?php
                                        foreach ( $backend_list as $backend_img ) :
                                            $backend_img_id = $backend_img['backend_item'];

                                            if($backend_img_id) : //line__2 loop item validation
                                                echo '<div class="home-stack-conteiner-item">' . wp_get_attachment_image( $backend_img_id, 'full' ) . '</div>';
                                            endif;

                                        endforeach;wp_reset_query();  
                                    ?>
                                </div>				
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                        
                </section>


    
            <?php

        }
    );



}



       






