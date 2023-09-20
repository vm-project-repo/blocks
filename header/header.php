<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'custom_header' );

function custom_header() {


    wp_register_style( 'header-style', get_stylesheet_directory_uri() . '/inc/blocks/header/header.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'header', __('Header') )
    ->add_fields( array(

        //Хедер меню логотип
        \Carbon_Fields\Field::make( 'image', 'menu_header_logo', __( 'Header menu logo' ) ),

        //Хедер меню главное
        \Carbon_Fields\Field::make( 'complex', 'menu_header_primary_items', __( 'Header menu primary' ) )
        ->add_fields( array(
            \Carbon_Fields\Field::make( 'text', 'menu_header_primary_item_title', __( 'Header menu primary item name' ) )->set_width( 50 ),
            \Carbon_Fields\Field::make( 'text', 'menu_header_primary_item_url', __( 'Header menu primary item link' ) )->set_width( 50 ),
        ) ),
    

        //Хедер меню язык текущего сайта
        \Carbon_Fields\Field::make( 'image', 'menu_currient_lang_flag', __( 'Header menu currient lang flag' ) )->set_width( 50 ),
        \Carbon_Fields\Field::make( 'text', 'menu_currient_lang_name', __( 'Header menu currient lang name' ) )->set_width( 50 ),

        //Хедер меню язык выбор языка
        \Carbon_Fields\Field::make( 'complex', 'menu_header_languages', __( 'Header menu other lang' ) )
        ->add_fields( array(
            \Carbon_Fields\Field::make( 'image', 'menu_header_language_flag', __( 'Header menu other lang flag' ) )->set_width( 33 ),
            \Carbon_Fields\Field::make( 'text', 'menu_header_language_name', __( 'Header menu other lang name' ) )->set_width( 33 ),
            \Carbon_Fields\Field::make( 'text', 'menu_header_language_link', __( 'Header menu other lang link' ) )->set_width( 33 ),
        ) ),

    ) )

    ->set_editor_style( 'editor-style' )
    ->set_style( 'header-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {
            
            ?>

                <header id="masthead" class="site-header">

                    <nav id="site-navigation" class="main-navigation">

                        <div class="site-branding"><?php echo wp_get_attachment_image( $fields['menu_header_logo'], 'full' ); ?><a href="<?php echo get_site_url(); ?>"></a></div>

                        <div class="site-menu-mobile click">
                            <div class="icon"></div>
                        </div>

                        <div class="site-menu hide-menu-item">

                            <div class="site-menu-desktop">
                                <ul class="menu-header-primary-container">
                                    <?php 
                                        $menu_header_primary_items = $fields[ 'menu_header_primary_items' ]; 
                                        if( $menu_header_primary_items ) : foreach ( $menu_header_primary_items as $menu_header_primary_item ) :
                                        $menu_header_primary_item_title = $menu_header_primary_item['menu_header_primary_item_title'];
                                        $menu_header_primary_item_url = $menu_header_primary_item['menu_header_primary_item_url'];
                                    
                                        echo '<li><a href="'. esc_html(get_site_url()) . esc_html($menu_header_primary_item_url) .'">'. esc_html($menu_header_primary_item_title) .'</a></li>';
                                        
                                        endforeach;wp_reset_query();endif; 
                                    ?>
                                </ul>
                            </div>


                            <div class="site-menu-lang-switcher">

                                <div class="site-menu-lang-current">
                                    <div class="site-menu-language-flag"><?php echo wp_get_attachment_image( $fields['menu_currient_lang_flag'] ); ?></div>
                                    <div class="site-menu-language-name"><?php echo esc_html( $fields['menu_currient_lang_name'] ); ?></div>
                                </div>

                                <ul class="site-menu-lang-list">
                                    <?php
                                        $languageItems = $fields[ 'menu_header_languages' ];
                                        if( $languageItems ) : foreach ( $languageItems as $languageItem ) :

                                        $header_lang_image_id = $languageItem['menu_header_language_flag'];
                                        $header_lang_name = $languageItem['menu_header_language_name'];
                                        $header_lang_link = $languageItem['menu_header_language_link'];
                                    ?>
                                    
                                        <li class="site-menu-lang-item">
                                            <div class="site-menu-language-flag"><?php echo wp_get_attachment_image( $header_lang_image_id ); ?></div>
                                            <div class="site-menu-language-name"><?php echo esc_html($header_lang_name); ?></div>
                                            <?php
                                                $post = get_queried_object();
                                                $blog_page_slug = get_post(get_option('page_for_posts'))->post_name;
                                                $postType = get_post_type_object(get_post_type());
                                                $network_home_url = network_home_url();

                                                if($header_lang_link) :
                                                    if( is_front_page() ) ://Главная страница
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html(get_site_url()) .'/' . esc_html($header_lang_link) . '"></span>';
                                                    elseif( is_page() ) ://Обычная страница
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html(get_site_url()) .'/'. esc_html($header_lang_link) .'/'. esc_html($post->post_name) .'"></span>';
                                                    elseif( is_single() && get_post_type() == 'post' ) : //Пост для блога
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html(get_site_url()) .'/'. esc_html($header_lang_link) .'/'. esc_html($blog_page_slug) .'"></span>';
                                                    elseif( get_queried_object_id() == get_option('page_for_posts') ) : //Страница для записей блога
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html(get_site_url()) .'/'. esc_html($header_lang_link) .'/'. esc_html($blog_page_slug) .'"></span>';
                                                    elseif( is_category() ) : //Страница рубрики блога
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html(get_site_url()) .'/'. esc_html($header_lang_link) .'/'. esc_html($blog_page_slug) .'"></span>';
                                                    elseif( is_archive() ) : //Страница архива
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html(get_site_url()) .'/'. esc_html($header_lang_link) .'/'. esc_html(get_queried_object()->rewrite['slug']) .'"></span>';
                                                    elseif( is_single() && get_post_type() == 'leyka_campaign' ) : //Страница кампании по сбору средств
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html(get_site_url()) .'/'. esc_html($header_lang_link) .'/'. esc_html($postType->rewrite['slug']) .'"></span>';
                                                    endif;
                                                else:
                                                    if( is_front_page() ) ://Главная страница
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html($network_home_url) .'"></span>';
                                                    elseif( is_page() ) ://Обычная страница
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html($network_home_url) .'/'. esc_html($post->post_name) .'"></span>';
                                                    elseif( is_single() && get_post_type() == 'post' ) : //Пост для блога
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html($network_home_url) .'/'. esc_html($blog_page_slug) .'"></span>';
                                                    elseif( get_queried_object_id() == get_option('page_for_posts') ) : //Страница для записей блога
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html($network_home_url) .'/'. esc_html($blog_page_slug) .'"></span>';
                                                    elseif( is_category() ) : //Страница рубрики блога
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html($network_home_url) .'/'. esc_html($blog_page_slug) .'"></span>';
                                                    elseif( is_archive() ) : //Страница архива
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html($network_home_url) .'/'. esc_html(get_queried_object()->rewrite['slug']) .'"></span>';
                                                    elseif( is_single() && get_post_type() == 'leyka_campaign' ) : //Страница кампании по сбору средств
                                                        echo '<span class="site-menu-language-link same-link" data-link="'. esc_html($network_home_url) .'/'. esc_html($postType->rewrite['slug']) .'"></span>';
                                                    endif;
                                                endif;
                                            ?>
                                        </li>

                                    <?php endforeach;wp_reset_query();endif; ?>
                                </ul>

                            </div>

                            
                        </div>

                    </nav><!-- #site-navigation -->

                </header><!-- #masthead -->


    
            <?php

        }
    );



}



       







