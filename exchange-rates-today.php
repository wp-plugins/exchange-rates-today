<?php
/**
 * @package Exchange Rates Today
 * @version 1.0
 */
/*
Plugin Name: Exchange Rates Today
Plugin URI: http://silver.od.ua
Description: A simple plugin for WooCommerce that allows you to change the price according to the exchange rate. For example, you set the price on the website in dollars and in-store price is displayed in local currency, you simply are asking today's exchange rate, but the plugin automatically changes all prices.
Author: Artyom Lagondyuk
Version: 1.0
Author URI: http://silver.od.ua
*/



add_action ('admin_menu', 'dynamic_price_button');
add_action ('woocommerce_get_price_html', 'change_price');
add_action( 'admin_init', 'register_mysettings' );

function register_mysettings () {
register_setting( 'baw-settings-group', 'kurs' );
register_setting( 'baw-settings-group', 'valuta' );
}

function change_price ($this) {
$int = filter_var($this, FILTER_SANITIZE_NUMBER_INT);
$kurs=get_option('kurs');
$valuta=get_option('valuta');
if ($kurs!='') {
return $int*$kurs.' '.$valuta;
} else  return  $int +' '+ $valuta;

}

function dynamic_price_button () {
	add_submenu_page ('woocommerce', 'Курс сегодня', 'Курс сегодня', 'manage_options', 'dynamic_price', 'setting_page');
	}

function setting_page () {
?>
<div class="wrap">
<h2>Курс на сегодня</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'baw-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Курс</th>
        <td><input type="text" name="kurs" value="<?php echo get_option('kurs'); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Валюта</th>
        <td><input type="text" name="valuta" value="<?php echo get_option('valuta'); ?>" /></td>
        </tr>
        
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } ?>