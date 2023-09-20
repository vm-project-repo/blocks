<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'custom_block_page_default' );

function custom_block_page_default() {

    wp_register_style( 'page-default-style', get_stylesheet_directory_uri() . '/inc/blocks/page-default/page-default.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'page_default_content', __('Page:Default') )
    ->add_fields( array(

        

    ) )
    
    ->set_editor_style( 'editor-style' )
    ->set_style( 'page-default-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {

            ?>


                <div class="page-default-hero">

                    <div class="page-default-hero-title">
                        <div class="page-default-hero-title-text"><?php echo esc_html( get_the_title() ); ?></div>					
                    </div>

                </div>


                <div class="page-default-content">

                    <div class="page-default-content-inner"><?php esc_html( the_content() ); ?></div>

                </div>


            <?php

        }
    );



}