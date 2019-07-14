<div class="wrap">
    <h1>WPCUI Options</h1>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php settings_fields('wpcui_settings'); ?>
        <?php submit_button(); ?>
    </form>
</div>