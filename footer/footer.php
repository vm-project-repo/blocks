<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'custom_footer' );

function custom_footer() {

    wp_register_style( 'footer-style', get_stylesheet_directory_uri() . '/inc/blocks/footer/footer.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'footer', __('Footer') )
    ->add_fields( array(

        //Логотип и заголовок
        \Carbon_Fields\Field::make( 'image', 'footer_logo', __( 'Футер логотип' ) )->set_width( 20 ),
        \Carbon_Fields\Field::make( 'text', 'footer_title', __( 'Футер заголовок' ) )->set_width( 80 ),

        //Футер меню основное
        \Carbon_Fields\Field::make( 'complex', 'menu_footer_primary_items', __( 'Футер меню основное' ) )
        ->add_fields( array(
            \Carbon_Fields\Field::make( 'text', 'menu_footer_primary_item_title', __( 'Меню наименование' ) )->set_width( 50 ),
            \Carbon_Fields\Field::make( 'text', 'menu_footer_primary_item_url', __( 'Меню ссылка' ) )->set_width( 50 ),
        ) ),

        //Футер меню документы
        \Carbon_Fields\Field::make( 'complex', 'menu_footer_docs_items', __( 'Футер меню документы' ) )
        ->add_fields( array(
            \Carbon_Fields\Field::make( 'text', 'menu_footer_docs_item_title', __( 'Меню наименование' ) )->set_width( 50 ),
            \Carbon_Fields\Field::make( 'text', 'menu_footer_docs_item_url', __( 'Меню ссылка' ) )->set_width( 50 ),
        ) ),
    
        //Копирайт
        \Carbon_Fields\Field::make( 'text', 'footer_copyright_title', __( 'Сopyright название раздела' ) ),//Название пункта
        \Carbon_Fields\Field::make( 'text', 'footer_copyright_date', __( 'Дата основания фонда' ) )->set_width( 50 ),
        \Carbon_Fields\Field::make( 'text', 'footer_copyright_name', __( 'Название организации' ) )->set_width( 50 ),    

    ) )

    ->set_editor_style( 'editor-style' )
    ->set_style( 'footer-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {

            ?>

                <footer id="footer" class="site-footer">
                    <div class="site-footer-inner">

                        <div  class="site-footer-bg-animation"></div>

                        <div class="site-footer-conteiner">

                            <div class="site-footer-conteiner-section">

                                <div class="site-footer-section-title">
                                    <div class="site-footer-section-title-img"><?php echo wp_get_attachment_image( $fields['footer_logo'], 'full' ); ?></div>
                                    <div class="site-footer-section-title-text"><?php echo esc_html( $fields['footer_title'] ); ?></div>
                                </div>
                            </div>

                            <div class="site-footer-conteiner-info">
                                <div class="site-footer-conteiner-info-inner">

                                    <div class="site-footer-conteiner-info-item">
                                        <div class="menu-footer-menu-container">
                                            <ul>
                                                <?php
                                                    $CategoryList = new WP_Term_Query( ['taxonomy' => 'category', 'order' => 'ASC', 'orderby' => 'id', 'hide_empty' => true] );
                                                    if( $CategoryList ) : foreach ( $CategoryList->terms as $term  ) :
                                                
                                                    echo '<li><a href="'. esc_html(get_term_link($term->slug, 'category')) .'">'. esc_html($term->name) .'</a></li>';

                                                    endforeach;wp_reset_query();endif; 
                                                ?>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="site-footer-conteiner-info-item">
                                        <div class="menu-footer-menu-container">
                                            <ul>
                                                <?php 
                                                    $menu_footer_primary_items = $fields[ 'menu_footer_primary_items' ]; 
                                                    if( $menu_footer_primary_items ) : foreach ( $menu_footer_primary_items as $menu_footer_primary_item ) :
                                                    $menu_footer_primary_item_title = $menu_footer_primary_item['menu_footer_primary_item_title'];
                                                    $menu_footer_primary_item_url = $menu_footer_primary_item['menu_footer_primary_item_url'];
                                                ?>
                                                    <li><a href="<?php echo esc_html( get_site_url() . $menu_footer_primary_item_url); ?>"><?php echo esc_html($menu_footer_primary_item_title); ?></a></li>
                                                <?php endforeach;wp_reset_query();endif; ?>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="site-footer-conteiner-info-item">
                                        <div class="menu-footer-menu-container">
                                            <ul>
                                                <?php 
                                                    $menu_footer_docs_items = $fields[ 'menu_footer_docs_items' ]; 
                                                    if( $menu_footer_docs_items ) : foreach ( $menu_footer_docs_items as $menu_footer_docs_item ) :
                                                    $menu_footer_docs_item_title = $menu_footer_docs_item['menu_footer_docs_item_title'];
                                                    $menu_footer_docs_item_url = $menu_footer_docs_item['menu_footer_docs_item_url'];
                                                ?>
                                                    <li><a href="<?php echo esc_html( get_site_url() . $menu_footer_docs_item_url); ?>"><?php echo esc_html($menu_footer_docs_item_title); ?></a></li>
                                                <?php endforeach;wp_reset_query();endif; ?>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="site-footer-conteiner-contact">
                                        <?php 
                                            $menu_contacts = carbon_get_theme_option( 'menu_contacts' ); 
                                            if( $menu_contacts ) : foreach ( $menu_contacts as $menu_contact_item ) :
                                            $menu_contact_item_name = $menu_contact_item['menu_contact_item_name'];
                                            $menu_contact_item_data = $menu_contact_item['menu_contact_item_data'];
                                            $menu_contact_item_link = $menu_contact_item['menu_contact_item_link'];
                                            if( $menu_contact_item_link ) :
                                        ?>

                                            <div class="site-footer-contact-item">
                                                <div class="site-footer-contact-name"><?php echo esc_html($menu_contact_item_name); ?></div>
                                                <div class="site-footer-contact-data"><a href="<?php echo esc_html($menu_contact_item_link); ?>"><?php echo esc_html($menu_contact_item_data); ?></a></div>
                                            </div>

                                            <?php else: ?>

                                            <div class="site-footer-contact-item">
                                                <div class="site-footer-contact-name"><?php echo esc_html($menu_contact_item_name); ?></div>
                                                <div class="site-footer-contact-data"><?php echo esc_html($menu_contact_item_data); ?></div>
                                            </div>

                                        <?php endif;endforeach;wp_reset_query();endif; ?>
                                    </div>

                                </div>
                            </div>

                            <div class="site-footer-conteiner-copyright">

                                <div class="site-footer-copyright-item">
                                    <div class="site-footer-copyright-name"><?php echo esc_html( $fields['footer_copyright_title'] ); ?></div>
                                    <div class="site-footer-copyright-data"><?php echo esc_html( $fields['footer_copyright_date'] ); ?>-<?php echo date("Y"); ?> © <?php echo esc_html( $fields['footer_copyright_name'] ); ?></div>
                                </div>

                                <div class="site-footer-copyright-item">
                                    <div class="site-footer-copyright-name"><?php echo esc_html( carbon_get_theme_option( 'social_links_name') ); ?></div>
                                    <div class="site-footer-copyright-data social">
                                        <?php 
                                            $social_links = carbon_get_theme_option( 'social_links' ); 
                                            if( $social_links ) : foreach ( $social_links as $social_link ) :
                                            $social_link_title = $social_link['social_link_title'];
                                            $social_link_url = $social_link['social_link_url'];
                                        ?>
                                            <div class="site-footer-copyright-data-item"><a href="<?php echo esc_html($social_link_url); ?>"><?php echo esc_html($social_link_title); ?></a></div>
                                        <?php endforeach;wp_reset_query();endif; ?>
                                    </div>
                                </div>

                            </div>
                        
                        </div>

                    </div>
                </footer>

            <?php

        }
    );

}