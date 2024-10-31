<?php
/**
 * Creates shortcode generator for the admin settings page. 
 *
 * @package rooom 3D Product Viewer
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

wp_enqueue_script( 'shortcode-generator', Rooom_Product_Viewer::rooom_plugin_dir() . '/src/shortcode-generator.js', array( 'jquery' ), '2389229', true ); // phpcs:ignore


echo "<h3>" . __("Enter the settings for your shortcode, copy it from below and use it wherever you like", "rooom-3d-product-viewer") . "</h3>";
?>
<table class="form-table">
    <tbody  id="shortcode-generator">
<tr>
    <th scope="row"><?php echo __("rooom 3D Product Viewer Key", "rooom-3d-product-viewer") ?></th>
    <td><input type="text" name="shortcode-product-viewer-key" id="shortcode-product-viewer-key"><p class="hidden no-key"><?php _e("Please enter a viewer key!", "rooom-3d-product-viewer") ?></p></td>
</tr>
<tr>
    <th scope="row"><?php echo __("Iframe height (in px, optional)", "rooom-3d-product-viewer") ?></th>
    <td>
        <input type="text" name="shortcode-iframe-height" id="shortcode-iframe-height">
        <p><?php echo __("Enter the height of the iframe that contains the product viewer. If you don't enter a height, the iframe will have a 16 : 9 format.", "rooom-3d-product-viewer") ?></p>
    </td>
</tr>
</tbody></table>

<button type="submit" id="shortcode-generator-submit" value="<?php echo __("Generate Shortcode", "rooom-3d-product-viewer") ?>"><?php echo __("Generate Shortcode", "rooom-3d-product-viewer") ?></button>



</div>

<label for="iframe-shortcode"><?php echo __("Shortcode", "rooom-3d-product-viewer") ?>
<textarea id="iframe-shortcode" rows="1" cols="80" disabled></textarea>
</label>
<style>
#shortcode-generator{
    display: flex;
    flex-direction: column;
    align-items: start;
    justify-content: space-between;
    gap: 15px;
    /* width: 400px; */
}
#shortcode-generator>label {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    width: 100%;
}
label[for="iframe-shortcode"]{
    display: flex;
    align-items: center;
    width: fit-content;
    margin-top: 20px;
    font-size: 1.5rem;
    border-color: #00aeb3;
    border: 3px solid #00aeb3;
    border-radius: 3px;
    padding: 20px;
}
#iframe-shortcode{
    margin-left: 30px;
}
.empty{
    border-color: #ff0000 !important;
}
</style>