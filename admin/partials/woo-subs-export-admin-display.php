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
<h1><?php _e('Woocommerce Subscriptions Export', 'woo-subs-export'); ?></h1>
<form id="wse-ajax-form" method="POST" action="<?php echo admin_url('admin-ajax.php'); ?>">
    <input type="hidden" name="action" value="wse_export">
    <p>
        <label for="startdate">
            <?php _e('Subscribed between', 'woo-subs-export'); ?>
            <input name="startdate" id="startdate" type="date" value="<?php echo date("Y-m-d", strtotime("first day of previous month")); ?>">
        </label>

        <label for="enddate">
            <?php _e('and', 'woo-subs-export'); ?>
            <input name="enddate" id="startdate" type="date" value="<?php echo date("Y-m-d", strtotime("last day of previous month")); ?>">
        </label>
    </p>
    <p>
        <label for="status">
            <?php _e('Subscription Status', 'woo-subs-export'); ?>
            <select name="status" id="status">
                <option value="*"><?php _e('Any', 'woo-subs-export'); ?></option>
                <option value="wc-active"><?php _e('Active', 'woo-subs-export'); ?></option>
                <option value="wc-on-hold"><?php _e('On Hold', 'woo-subs-export'); ?></option>
                <option value="wc-pending"><?php _e('Pending', 'woo-subs-export'); ?></option>
                <option value="wc-expired"><?php _e('Expired', 'woo-subs-export'); ?></option>
                <option value="wc-cancelled"><?php _e('Cancelled', 'woo-subs-export'); ?></option>
                <option value="wc-switched"><?php _e('Switched', 'woo-subs-export'); ?></option>
            </select>
        </label>
    </p>
    <p class="wse-message"></p>
    <p style="max-width: 170px;">
        <input type="submit" value="<?php _e('Export Subscribers', 'woo-subs-export'); ?>">
        <span class="spinner"></span>
        <a class="wse-download-button button hidden" href="<?php echo wp_upload_dir()['baseurl'] . '/subscriber-exports/subscriber_export.csv'; ?>"><?php _e('Download CSV', 'woo-subs-export'); ?></a>
    </p>
    <table class="wse-result widefat hidden"></table>

</form>


