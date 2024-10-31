<?php
add_action('admin_menu','pcfpfw_menu_settings');
function pcfpfw_menu_settings(){
    add_menu_page( 
        'Call For Price', // page <title>Title</title>
        'Call For Price', // menu link text
        'manage_options', // capability to access the page
        'pcfpfw_generator', // page URL slug
        'pcfpfw_settings', // callback function /w content
        'dashicons-cart', // menu icon
        5
    );
}
function pcfpfw_settings() { 
    ?>
<?php 
     if(isset($_REQUEST['succes']))
     {
          echo '<div class="notice notice-info is-dismissible">
                    <p>setting saved successfully.</p>
                </div>';
     }
?>
<div class="cfpfw_main">
    <h1><?php echo esc_html('General Setting','product-call-for-price-for-woocommerce'); ?></h1>
<?php
settings_fields( 'pcfpfw_generator' );
do_settings_sections( 'pcfpfw_generator' );
?>
    <form action='<?php echo get_permalink(); ?>' id="atcaiofw-add-to-cart" method='post'>
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><?php echo esc_html('Enable Call For Price','product-call-for-price-for-woocommerce'); ?></th>
                    <td>
                        <input type="checkbox" name="cfpfw_enable" value="true" <?php checked('true', get_option("cfpfw_enable",'true')); ?>><label><?php echo esc_html('Enable plugin.','product-call-for-price-for-woocommerce'); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo esc_html('Select Category','product-call-for-price-for-woocommerce'); ?></th>
                        <td>
                        <?php
                            $args = array(
                                'order'      => 'ASC',
                                'hide_empty' => '0',
                                'posts_per_page' =>'-1'
                            );
                            $product_categories = get_terms('product_cat', $args); 
                        ?>
                        <select name='cfpfw_product' id='cfpfw_product'>
                            <?php
                            foreach( $product_categories as $category ){
                                ?>
                           <option value="<?php echo esc_attr($category->term_id); ?>" <?php if(get_option('cfpfw_product') == $category->term_id){ echo "selected";};?>> <?php echo esc_attr($category->name); ?> </option>
                           <?php
                        }
                        ?>
                        </select><label><?php echo esc_html('plz select category to show "call for price" in product.','product-call-for-price-for-woocommerce'); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo esc_html('Enable Call For Price When Price is Zero','product-call-for-price-for-woocommerce'); ?></th>
                    <td>
                        <input type="checkbox" name="pcfpfw_zero" value="true" <?php checked('true', get_option("pcfpfw_zero",'false')); ?>><label><?php echo esc_html('enable this option display call for price text for products whose price is 0 or empty.','product-call-for-price-for-woocommerce'); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo esc_html('Display stock status for empty price products','product-call-for-price-for-woocommerce'); ?></th>
                    <td>
                        <input type="checkbox" name="pcfpfw_status" value="true" <?php checked('true', get_option("pcfpfw_status",'false')); ?>><label><?php echo esc_html('enable this option display stock status for products whose price is empty.','product-call-for-price-for-woocommerce'); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo esc_html('By Product Price Range','product-call-for-price-for-woocommerce'); ?></th>
                    <td>
                        <input type="checkbox" name="cfpfw_price_enable" value="true" <?php checked('true', get_option("cfpfw_price_enable",'false')); ?>><label><?php echo esc_html('Enable this option display Call For Price message by product price range.','product-call-for-price-for-woocommerce'); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo esc_html('Min Price','product-call-for-price-for-woocommerce'); ?>  </th>
                    <td>
                        <input type="number" name="cfpfw_min_price" value="<?php echo esc_attr(get_option('cfpfw_min_price','1',true)); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php echo esc_html('Max Price','product-call-for-price-for-woocommerce'); ?>  </th>
                    <td>
                        <input type="number" name="cfpfw_max_price" value="<?php echo esc_attr(get_option('cfpfw_max_price','0',true)); ?>">
                    </td>
                </tr>
                <tr>
                    <th><?php echo esc_html('Message Text','product-call-for-price-for-woocommerce'); ?></th>
                    <td>
                        <input type="text" name="cfpfw_change_text" value="<?php echo esc_attr(get_option('cfpfw_change_text','Call For Price',true)); ?>">
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="hidden" name="action" value="pcfpfw_save_option">
            <input type="submit" value="Save" name="submit" class="button-primary">
        </p>
    </form>
</div>
  <?php
}
add_action('init','pcfpfw_add_setting_type');
function pcfpfw_add_setting_type(){
    if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'pcfpfw_save_option') {
            if (!empty($_REQUEST['cfpfw_enable'])) {
                update_option('cfpfw_enable',sanitize_text_field($_REQUEST['cfpfw_enable']));
            }else{
                update_option('cfpfw_enable','');
            }
            
            update_option('cfpfw_product',sanitize_text_field($_REQUEST['cfpfw_product']));
            if(!empty($_REQUEST['pcfpfw_zero'])){
                update_option('pcfpfw_zero',sanitize_text_field($_REQUEST['pcfpfw_zero']));
            }else{
                update_option('pcfpfw_zero','');
            }
            if(!empty($_REQUEST['pcfpfw_status'])){
                update_option('pcfpfw_status',sanitize_text_field($_REQUEST['pcfpfw_status']));
            }else{
                update_option('pcfpfw_status','');
            }
            if(!empty($_REQUEST['cfpfw_price_enable'])){
                update_option('cfpfw_price_enable',sanitize_text_field($_REQUEST['cfpfw_price_enable']));
            }else{
                update_option('cfpfw_price_enable','');
            }
            update_option('cfpfw_min_price',sanitize_text_field($_REQUEST['cfpfw_min_price']));
            update_option('cfpfw_max_price',sanitize_text_field($_REQUEST['cfpfw_max_price']));
            update_option('cfpfw_change_text',sanitize_text_field($_REQUEST['cfpfw_change_text']));

        wp_redirect( admin_url( '/admin.php?page=pcfpfw_generator&succes=sucee' ));
    }
}