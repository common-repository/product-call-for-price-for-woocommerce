<?php
function pcfpfw_call_for_price(){
    $cfpfw_enable = get_option('cfpfw_enable','false');

    if($cfpfw_enable == 'true'){  

        add_filter( 'woocommerce_variable_sale_price_html', 'businessbloomer_remove_prices', 9999, 2 );
        add_filter( 'woocommerce_variable_price_html', 'businessbloomer_remove_prices', 9999, 2 );
        add_filter( 'woocommerce_get_price_html', 'businessbloomer_remove_prices', 9999, 2 );

        add_action('woocommerce_after_shop_loop_item', 'spaatcfw_remove_add_to_cart', 5);
        
        add_action('woocommerce_before_single_product', 'spaatcfw_remove_add_to_cart_single', 5);

        add_filter( 'woocommerce_empty_price_html', 'filter_woocommerce_empty_price_html', 10, 2 );
    }
}
add_action( 'init', 'pcfpfw_call_for_price' );

function businessbloomer_remove_prices( $price, $product ) {
    $cfpfw_min_price = get_option('cfpfw_min_price',1);
    $cfpfw_max_price = get_option('cfpfw_max_price',0);
    $product_price = $product->get_price();
    $cfpfw_change_text = get_option('cfpfw_change_text','Call For Price'); 
    $cfpfw_price_enable = get_option('cfpfw_price_enable','false');

    /*display call for price when product price is 0 or empty.*/
    $pcfpfw_zero = get_option('pcfpfw_zero','false');
    if($pcfpfw_zero == 'true'){
        if ( $product_price === '' || $product_price == 0 ) {
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
            $price = '<strong>'.$cfpfw_change_text.'</strong>';
        }
    } 

    $product_id = $product->get_id();
    // print_r($product_id);
    $product_categories = get_the_terms($product_id,'product_cat');
    $catarr= array();
    foreach($product_categories as $pro_data){
        $cat_id = $pro_data->term_id;
        $catarr[]=$cat_id;
        // print_r($catarr);
    }

    $cfpfw_product = get_option('cfpfw_product','false');
    if (in_array($cfpfw_product, $catarr)){
        // $price = '<strong>'.$cfpfw_change_text.'</strong>';
       
        /*by product price range.*/
        if($cfpfw_price_enable == 'true'){
            if($cfpfw_min_price !== '' && $cfpfw_max_price !== ''){
                if($product_price >= $cfpfw_min_price && $product_price <= $cfpfw_max_price) {
                    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
                    $price = '<strong>'.$cfpfw_change_text.'</strong>';
                }
            }
        }else{
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
            $price = '<strong>'.$cfpfw_change_text.'</strong>';
        }

    }
    
   return $price;
}

function spaatcfw_remove_add_to_cart(){
    $product_id =  get_the_id();
    // print_r($product_id);
    $product_categories = get_the_terms($product_id,'product_cat');
    $catarr= array();
    foreach($product_categories as $pro_data){
        $cat_id = $pro_data->term_id;
        $catarr[]=$cat_id;
        // print_r($catarr);
    }

    $cfpfw_product = get_option('cfpfw_product','false');
    if (in_array($cfpfw_product, $catarr)){
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
    }
    /*else{
        add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');    
    }*/
}

function spaatcfw_remove_add_to_cart_single(){
    $product_id =  get_the_id();
    $product_categories = get_the_terms($product_id,'product_cat');
    $catarr= array();
    foreach($product_categories as $pro_data){
        $cat_id = $pro_data->term_id;
        $catarr[]=$cat_id;
    }

    $cfpfw_product = get_option('cfpfw_product','false');
    if (in_array($cfpfw_product, $catarr)){
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    }else{
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    }
}

/*display stock status when product price empty.*/
function filter_woocommerce_empty_price_html( $html, $product ) {
    $pcfpfw_status = get_option('pcfpfw_status','false');
    $product_price = $product->get_price();
    
    if($pcfpfw_status == 'true'){
        global $product;
        $status = $product->stock_status;
        $html = $status;
    }
    
    return $html;
}