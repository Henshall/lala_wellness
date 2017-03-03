
<?php
/**
 * Plugin Overviews.
 * @package Maps
 * @author Flipper Code <flippercode>
 **/

//Setup Product Overview Page
    $premiumFeatures = array('Marks the correct meta tags entry in green color.',
						  'Highlights errors in red color.',
						  'Write optimised title and verfiy using google title rules.',
						  'Enabled with google recommended set of SEO rules.',
						  'Compatible with most popular ALL IN ONE SEO plugin.');
						  
    $productInfo = array('productName' => __('WP Meta Tags Optimisation',MTO_TEXT_DOMAIN),
                        'productSlug' => 'wp-meta-tags-optimisation',
                        'productTagLine' => 'WP Meta Tags Optimisation - A product that automatically write optimised meta tags in header part of post,pages to be recognised by search engines. A free plugin for basic SEO needs of your wordpress website.',
                        'productTextDomain' => MTO_TEXT_DOMAIN,
                        'productIconImage' => MTO_URL.'core/core-assets/images/wp-poet.png',
                        'productVersion' => MTO_VERSION,
                        'docURL' => 'https://codecanyon.net/item/meta-tags-optimization-write-optimized-meta-tags/4915633',
                        'demoURL' => 'https://codecanyon.net/item/meta-tags-optimization-write-optimized-meta-tags/4915633',
                        'productImagePath' => MTO_URL.'core/core-assets/product-images/',
                        'productSaleURL' => 'https://codecanyon.net/item/meta-tags-optimization-write-optimized-meta-tags/4915633',
                        'multisiteLicence' => 'https://codecanyon.net/item/meta-tags-optimization-write-optimized-meta-tags/4915633?license=extended&open_purchase_for_item_id=4915633&purchasable=source',
                        'is_premium' => 'false',
                        'have_premium' => 'true',
                        'productBanner' => 'https://image-cc.s3.envato.com/files/170356995/meta-tags-optimization.png',
                        'premiumFeatures' => $premiumFeatures,
    );

    $productOverviewObj = new Flippercode_Product_Overview($productInfo);

