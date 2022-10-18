<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://reflekt.ch
 * @since      1.0.0
 *
 * @package    Woo_Subs_Export
 * @subpackage Woo_Subs_Export/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1>Hello World</h1>
<form class="wse-ajax-form" method="POST" action="<?php echo admin_url('admin-ajax.php'); ?>">
    <p>
        <label for="startdate">
            <?php _e('Subscribed between', 'woo-subs-export'); ?>
            <input id="startdate" type="date">
        </label>

        <label for="enddate">
            <?php _e('and', 'woo-subs-export'); ?>
            <input id="startdate" type="date">
        </label>
    </p>
    <p class="message"></p>
    <div class="spinner"></div>
    <input type="hidden" name="action" value="wse_export">
    <input type="submit" value="<?php _e('Export Subscribers', 'woo-subs-export'); ?>">
</form>

<?php //var_dump(Woo_Subs_Export_Admin::get_subscriptions()); ?>