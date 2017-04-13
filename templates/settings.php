<div class="wrap">
    <h2>Oleville Documents Settings</h2>
    <form method="post" action="options.php">
        <?php @settings_fields('oleville_docs-group'); ?>
        <?php @do_settings_fields('oleville_docs-group'); ?>

        <?php do_settings_sections('oleville_documents'); ?>

        <?php @submit_button(); ?>
    </form>
</div>
