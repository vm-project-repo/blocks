<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'archive_services' );

function archive_services() {


    wp_register_style( 'archive-services-style', get_stylesheet_directory_uri() . '/inc/blocks/archive-services/archive-services.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'archive_services', __('Archive:Services') )
    ->add_fields( array(



    ) )

    ->set_editor_style( 'editor-style' )
    ->set_style( 'archive-services-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {


            ?>

                <main id="primary" class="site-main">

                    <div class="archive-services-header">
                        <div class="archive-services-header-inner">
                            <?php the_archive_title( '<h1 class="archive-services-header-title">', '</h1>' ); ?>
                        </div>
                    </div><!-- .page-header -->

                    <div class="breadcrumbs-conteiner"><?php true_breadcrumbs(); ?></div>

                    <div class="archive-services-desc">
                        <div  class="archive-services-desc-inner" itemscope itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage">I provide WordPress development services that include custom design and adding custom features with custom WordPress plugins. In my work, I adhere to the WordPress developer code, BEM methodology and use modern technologies such as GSAP and LENIS animation, CSS Grid and FlexBox adaptive layout, schema markup, Redis caching and Brotli compression. I can also help with optimizing SQL queries and server-side tasks on NGINX. With my expertise, your WordPress site will be able to rank high in search results and succeed in SEO</div>
                    </div>


                    <div class="archive-services-content" >

                        <div class="archive-services-list">

                            <?php	

                                $ServicesTermsList = new WP_Term_Query( [ 'taxonomy' => 'services-type', 'hide_empty' => true, 'orderby' => 'id', 'order' => 'ASC' ] );
                                foreach ( $ServicesTermsList -> terms as $term ) :

                                $thumbnail_id = carbon_get_term_meta( $term->term_id, 'servicetype_img' );
                                $thumbnail_url = wp_get_attachment_image_url( $thumbnail_id, 'full' );
                                $description = strip_tags(term_description( $term, 'services-type'));

                            ?>
                                <div class="archive-services-item" >
                                
                                    <div class="archive-services-item-part">
                                        <h2 class="archive-services-title"><?php echo $term->name ?></h2>
                                        <div class="archive-services-description"><?php echo $description; ?></div>
                                        <div class="archive-services-btn">
                                            <div class="archive-services-btn-text">See detail</div>
                                            <div class="archive-services-btn-arrow"></div>
                                        </div>
                                    </div>

                                    <div class="archive-services-item-part">
                                        <img src="<?php echo $thumbnail_url ?>" title="<?php echo $term->name ?>" alt="<?php echo $description; ?>" class="aligncenter" loading="lazy" width="300" height="300"/>
                                    </div>
                                    
                                    <a href="<?php echo get_term_link($term->slug, 'services-type') ?>"></a>
                                    
                                </div>
                                    
                            <?php endforeach;wp_reset_query(); ?>
                            
                        </div>
                        
                    </div>

                </main><!-- #main -->


                <!--SERVICES LIST-->
                <?php

                $schema_services_list = array(
                    '@context' => 'http://schema.org/',
                );
                $schema_services_list['ItemList'] = array();

                $ServicesTermsList = new WP_Term_Query( ['taxonomy' => 'services-type', 'hide_empty' => true, 'orderby' => 'id', 'order' => 'ASC'] );
                foreach ( $ServicesTermsList -> terms as $term ) :

                    $service_term_title = carbon_get_term_meta( $term->term_id, 'servicetype_home_title' );
                    $thumbnail_id = carbon_get_term_meta( $term->term_id, 'servicetype_img' );
                    $thumbnail_url = wp_get_attachment_image_url( $thumbnail_id, 'full' );
                    $term_description = strip_tags( carbon_get_term_meta( $term->term_id, 'servicetype_home_desc') );

                    $catalog = array(
                        '@type'       => 'OfferCatalog',
                        'image'       => $thumbnail_url,
                        'name'        => $service_term_title,
                        'description' => $term_description,
                        'url'         => get_term_link($term->slug, 'services-type')
                    );
                    $catalog['itemListElement'] = array();                

                        $ServicesList = new WP_Query( 
                            array(
                                'post_type' => 'services', 
                                'post_status' => 'publish', 
                                'posts_per_page' => -1,
                                'orderby'=> 'post_date', 
                                'order' => 'DESC', 
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'services-type', 
                                        'field' => 'term_id', 
                                        'terms' => $term->term_id
                                    )) 
                            ) 
                        );
                        while ( $ServicesList->have_posts() ) : $ServicesList->the_post();
                        $service_price = carbon_get_post_meta( get_the_ID(), 'service_price' );

                            $servicesPost = array(
                                '@type' => 'Offer',
                                'itemOffered' => array(
                                    '@type' => 'Service',
                                    'name' => get_the_title(),
                                    'image' => get_the_post_thumbnail_url(),
                                    'url' => get_the_permalink(),
                                    'description' => strip_tags(get_the_content()),
                                    'price' => $service_price,
                                    'priceCurrency' => 'EUR',
                                    'priceValidUntil' => date('Y-m-d', strtotime('+1 years')),
                                    'sku' => get_the_id(),
                                    'category' => wp_get_object_terms( $post->ID, 'services-type', array( 'fields' => 'names' ) )
                                )
                            );

                            array_push($catalog['itemListElement'], $servicesPost);
                            
                        endwhile;

                    array_push($schema_services_list['ItemList'], $catalog);

                endforeach;wp_reset_query();

                echo '<script type="application/ld+json">' . json_encode($schema_services_list) . '</script>';

                ?>
                <!--SERVICES LIST-->











    
            <?php

        }
    );



}



       







