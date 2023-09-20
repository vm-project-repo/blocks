<?php


// Register the block using Carbon Fields
add_action( 'carbon_fields_register_fields', 'taxonomy_services' );

function taxonomy_services() {


    wp_register_style( 'taxonomy-services-style', get_stylesheet_directory_uri() . '/inc/blocks/taxonomy-services/taxonomy-services.css' );
    wp_register_style( 'editor-style', get_stylesheet_directory_uri() . '/inc/blocks/my-editor-style.css' );

    \Carbon_Fields\Block::make( 'taxonomy_services', __('Taxonomy:Services') )
    ->add_fields( array(



    ) )

    ->set_editor_style( 'editor-style' )
    ->set_style( 'taxonomy-services-style' )

    ->set_render_callback( 

        function ( $fields, $attributes, $inner_blocks ) {

            $term = get_queried_object();
            $taxonomy = get_queried_object();
            $service_price = carbon_get_term_meta( $term->term_id, 'servicetype_home_price' );
            $img_id = carbon_get_term_meta( $term->term_id, 'servicetype_img' );
            $servicetype_home_desc = carbon_get_term_meta( $term->term_id, 'servicetype_home_desc' );
            $servicetype_desc = strip_tags($servicetype_home_desc);
            $service_valid_price_date = date('Y-m-d', strtotime('+1 years'));
            $servicetype_home_title = carbon_get_term_meta( $term->term_id, 'servicetype_home_title' );

            ?>




                <main id="primary" class="site-main">
                        
                    <div class="services-tax-header">
                        
                        <div class="services-tax-header-inner" >
                            <h1 class="services-tax-title"><?php echo $servicetype_home_title; ?></h1>
                            <div class="services-tax-picture"><img  src="<?php echo wp_get_attachment_url($img_id); ?>" title="<?php echo $servicetype_home_title; ?>" alt="<?php echo $servicetype_desc; ?>" width="300" heigth="300" loading="lazy"></div>
                        </div>

                    </div><!-- tax-header -->
                    

                    <div class="breadcrumbs-conteiner"><?php true_breadcrumbs(); ?></div>
                    
                    
                    <div class="services-type-content">
                        <div class="services-type-content-inner"><?php echo $servicetype_home_desc; ?></div>
                    </div>	
                    

                    <div class="post-stype-grid">

                        <?php 

                            if( have_posts() ) : while (have_posts() ) : the_post();

                                echo '<div class="type-services">';
                                
                                    echo '<div class="post-stype-inner">';
                                    
                                        echo '<div class="post-stype-img"><img src="' . get_the_post_thumbnail_url() . '" title="' . get_the_title() . '" alt="' . get_the_title() . '" class="alignnone" loading="lazy" width="300" height="300"/></div>';
                                        echo '<h2 class="post-stype-title" >';
                                            the_title();
                                        echo '</h2>';
                                        echo '<div class="post-stype-description" >';
                                            the_excerpt(); 
                                        echo '</div>';
                                        echo '<div class="post-stype-btn">See detail</div>';
                                        
                                    echo '</div>';

                                    echo '<div class="post-stype-link"><a href="';
                                        the_permalink();
                                    echo '"></a></div>';

                                echo '</div>';
                                
                            endwhile;endif;
                            
                        ?>
                        
                    </div>
                        

                    <div class="services-type-content">I understand that your time is a valuable resource. That's why I have created a "Frequently Asked Questions" section to help you quickly and easily find answers to the most common questions related to <?php echo $servicetype_home_title; ?>. In this section, you may find useful information and tips for solving problems. I hope that this section will be helpful and help you save time and get the information you need quickly and efficiently.</div>


                    <div class="services-type-faq">

                        <h2 class="services-type-faq-title">Frequently asked questions</h2>

                        <div class="services-type-faq-inner">

                            <?php 
                                $servicetype_faq = carbon_get_term_meta( $term->term_id, 'servicetype_faq' );
                                foreach ( $servicetype_faq as $servicetype_faq_item ) :
                                    echo '<div class="accordion__categ">';
                                    echo '<input class="accordion__trigger"  type="checkbox"/>';
                                    echo '<h3 class="accordion__title"><span class="accordion__title_text">';
                                    echo $servicetype_faq_item['servicetype_faq_title'];
                                    echo '</span><span class="accordion__btn"><span class="svg-icon"></span></span></h3>';
                                    echo '<div class="accordion__descr">';
                                    echo '<span>';
                                    echo $servicetype_faq_item['servicetype_faq_desc'];
                                    echo '</span></div></div>';
                                endforeach;wp_reset_query();
                            ?>
                            
                        </div>
                        
                    </div><!-- FAQ -->


                    <div  class="services-type-content">I am happy to inform you that the process of remote work is well organized and allows me to work on your project efficiently and productively. Remote work has long been an integral part of modern business, and I am ready to discuss the possibility of this format of work on your project. I use modern tools and technologies to provide secure and convenient remote work, such as Git, Jira, Slack. I will be glad to cooperate with you and help you to achieve your goals.</div>

                </main><!-- #main -->





                    <!--WEB PAGE-->
                    <?php

                        $schema_webpage = array(
                            '@context' => 'http://schema.org/',
                            '@type' => 'WebPage',
                            '@id' => get_term_link($term->slug, 'services-type'),
                            'url' => get_term_link($term->slug, 'services-type'),
                            'name' => $servicetype_home_title,
                            'author' => array(
                                '@type' => 'Person',
                                'name' => 'Viktor Malygin',
                                'jobTitle' => array('WordPress Developer', 'Founder'),
                                'url' => get_site_url(),
                                'image' => '/wp-content/uploads/founder_photo.png',
                                'worksFor' => array(
                                    '@type' => 'Organization',
                                    'name' => get_bloginfo(),
                                    'url' => get_site_url(),
                                    'address' => array(
                                        '@type' => 'PostalAddress',
                                        'addressLocality' => 'Tver',
                                        'addressRegion' => 'Tver region',
                                        'postalCode' => '170043',
                                        'addressCountry' => 'Russia'
                                    ),
                                ),
                            ),
                        );

                        $schema_webpage['image'] = array();
                        $schema_webpage['image'][] = array(
                            '@type' => 'ImageObject',
                            'contentUrl' => wp_get_attachment_url($img_id),
                            'name' => $servicetype_home_title,
                            'description' => $servicetype_desc,
                        );

                        $schema_webpage['mainEntityOfPage'] = array();
                        $schema_webpage['mainEntityOfPage'][] = array(
                            '@type' => 'WebPageElement',
                            'headline' => $servicetype_home_title,
                            'description' => $servicetype_desc,
                        );

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

                        if( $ServicesList ) : while ( $ServicesList->have_posts() ) : $ServicesList->the_post();

                            $schema_webpage['mainEntityOfPage'][] = array(
                                '@type' => 'WebPageElement',
                                'alternativeHeadline' => get_the_title(),
                                'description' => strip_tags(get_the_excerpt()),
                            );

                        endwhile;endif;wp_reset_query();


                        
                        if($servicetype_faq) :
                            $schema_webpage['mainEntity'] = array();
                            $faqlist = array(
                                '@type' => 'FAQPage',
                            );			
                            $faqlist['mainEntity'] = array(); 
                            foreach ( $servicetype_faq as $servicetype_faq_item ) :
                                $question = $servicetype_faq_item['servicetype_faq_title'];
                                $ansver = strip_tags($servicetype_faq_item['servicetype_faq_desc']);

                                $faqlist['mainEntity'][] = array(
                                    '@type' => 'Question',
                                    'name' => $question,
                                    'acceptedAnswer' => array(
                                        '@type' => 'Answer',
                                        'text' => $ansver,
                                    ),
                                );
                            endforeach;wp_reset_query();
                            array_push($schema_webpage['mainEntity'], $faqlist);
                        endif;


                        
                        $primary_keywords = carbon_get_term_meta( $term->term_id, 'primary_keywords' );
                        if ( $primary_keywords ) : 
                            $schema_webpage['about'] = array();
                            foreach ( $primary_keywords as $primary_keyword ) :
                            $primary_schema = $primary_keyword['primary_schema'];
                            $primary_keyword_name = $primary_keyword['primary_keyword_name'];
                            $primary_keyword_link = $primary_keyword['primary_keyword_link'];

                            $schema_webpage['about'][] = array(
                                '@type' => $primary_schema,
                                'name' => $primary_keyword_name,
                                'sameAs' => $primary_keyword_link,
                            );

                        endforeach;wp_reset_query();endif;

                        
                        $secondary_keywords = carbon_get_term_meta( $term->term_id, 'secondary_keywords' );
                        if ( $secondary_keywords ) : 
                            $schema_webpage['mentions'] = array();
                            foreach ( $secondary_keywords as $secondary_keyword ) :
                            $secondary_schema = $secondary_keyword['secondary_schema'];
                            $secondary_keyword_name = $secondary_keyword['secondary_keyword_name'];
                            $secondary_keyword_link = $secondary_keyword['secondary_keyword_link'];

                            $schema_webpage['mentions'][] = array(
                                '@type' => $secondary_schema,
                                'name' => $secondary_keyword_name,
                                'sameAs' => $secondary_keyword_link,
                            );

                        endforeach;wp_reset_query();endif; 


                        echo '<script type="application/ld+json">' . json_encode($schema_webpage) . '</script>';

                    ?>
                    <!--WEB PAGE-->



                    <!--PRODUCT-->
                    <?php

                        $schema_product = array(
                            '@context' => 'http://schema.org/',
                            '@type' => 'Product',
                            'name' => $term->name,
                            'image' => array(
                                wp_get_attachment_url($img_id),
                                wp_get_attachment_url($img_id),
                                wp_get_attachment_url($img_id),
                            ),
                            'description' => $servicetype_desc,
                            'sku' => 'sku-' . get_the_id(),
                            'mpn' => 'mnp-' . get_the_id(),
                            'brand' => array(
                                '@type' => 'Brand',
                                'name' => get_bloginfo('name'),
                            ),

                        );  

                        $ratingsArgs = array( 
                            'post_type' => 'projects',
                            'post_status' => 'publish',
                            'meta_query' => array(
                                array(
                                    'key' => 'projects_review_rating',
                                    'value' =>  array('1','2','3','4','5')
                                )
                            )
                        );

                        $ratings = new WP_Query( $ratingsArgs );
                        $count = $ratings->post_count;
                        $total = 0;
                        if( $ratings->have_posts()) :	while( $ratings->have_posts() ) : $ratings->the_post();
                            $projects_review_rating = carbon_get_post_meta(get_the_ID(), 'projects_review_rating');
                            $total += intval( $projects_review_rating );
                        endwhile;endif;wp_reset_postdata();
                        $average = round($total / $count,1);

                        $reviewArgs = array( 
                            'post_type' => 'projects',
                            'post_status' => 'publish',
                            'meta_query' => array(
                                array(
                                    'key' => 'projects_review_rating',
                                    'value' =>  array('1','2','3','4','5')
                                )
                            ),
                            'orderby' => 'rand', 
                            'posts_per_page' => '1'
                        );

                        $schema_product['review'] = array();

                        $ReviewItem = new WP_Query($reviewArgs);

                        if( $ReviewItem->have_posts() ) :while ( $ReviewItem->have_posts() ) : $ReviewItem->the_post();
                            $projects_service = carbon_get_post_meta( get_the_id(), 'projects_service' );
                            $projects_review_rating = carbon_get_post_meta( get_the_id(), 'projects_review_rating' );
                            $projects_reviewer_name = carbon_get_post_meta( get_the_id(), 'projects_reviewer_name' );
                            $projects_review_text = carbon_get_post_meta( get_the_id(), 'projects_review_text' );
                                
                            $schema_product['review'][] = array(
                                '@type' => 'Review',
                                'itemReviewed' => array(
                                    '@type' => 'Organization',
                                    'name' => get_bloginfo(),
                                    'url' => get_site_url(),
                                ),
                                'author' => array(
                                    '@type' => 'Person',
                                    'name' => $projects_reviewer_name,
                                ),
                                'datePublished' => get_the_date('Y-m-d'),
                                'reviewBody' => $projects_review_text,
                                'reviewRating' => array(
                                    '@type' => 'Rating',
                                    'ratingValue' =>  $projects_review_rating,
                                    'worstRating' => '1',
                                    'bestRating' => '5',
                                )
                            );

                        endwhile;endif;wp_reset_postdata();

                        $schema_product['aggregateRating'] = array();
                        $schema_product['aggregateRating'][] = array(
                            '@type' => 'AggregateRating',
                            'ratingValue' => $average,
                            'reviewCount' => $count,
                        );


                        $schema_product['offers'] = array();
                        $schema_product['offers'][] = array(
                            '@type' => 'Offer',
                            'name' => $term->name . ' ' . 'в Твери',
                            'url' => get_term_link($term->slug, 'services-type'),
                            'price' => $service_price,
                            'priceCurrency' => 'EUR',
                            'priceValidUntil' => $service_valid_price_date,
                            'itemCondition' => 'https://schema.org/NewCondition',
                            'availability' => 'https://schema.org/InStock',
                        );

                        echo '<script type="application/ld+json">' . json_encode($schema_product) . '</script>';

                    ?>
                    <!--PRODUCT-->









    
            <?php

        }
    );



}



       







