<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'custom_block_page_404' );

function custom_block_page_404() {

    wp_register_style( 'page-404-style', get_stylesheet_directory_uri() . '/inc/blocks/page-404/page-404.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'page_404', __('Page:404') )
    ->add_fields( array(

        //Заголовок
        \Carbon_Fields\Field::make( 'text', 'page_404_title', __( 'Title' ) ),
        //Описание
        \Carbon_Fields\Field::make( 'textarea', 'page_404_desc', __( 'Описание' ) ),
        

    ) )
    
    ->set_editor_style( 'editor-style' )
    ->set_style( 'page-404-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {

            $page_404_title = $fields[ 'page_404_title' ];
            $page_404_desc = $fields[ 'page_404_desc' ];

            ?>


                <div class="page-404-hero">

                    <div class="page-404-hero-title">
                        <div class="page-404-hero-title-text"><?php echo esc_html( $page_404_title ); ?></div>					
                    </div>

                </div>


                <div class="page-404-content">

                    <div class="page-404-content-inner"><?php echo esc_html( $page_404_desc ); ?></div>

                </div>


            <?php

        }
    );



}