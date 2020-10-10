<?php
class GalleryMenuPage {

    const GROUP = 'gallery_options';

    public static function register () {
        add_action('admin_menu', [self::class, 'addMenu']);
        add_action('admin_init', [self::class, 'registerSettings']);
    }

    public static function registerSettings () {
        register_setting(self::GROUP, 'gallery_schedule');
        add_settings_section('gallery_options_section', 'Parameters', function () {
            echo "Here you can manage the parameters related to the gallery";
        }, self::GROUP);
        add_settings_field('gallery_options_schedule', "opening hours", function () {
            ?>
            <textarea name="gallery_schedule" cols="30" rows="10" style="width: 100%"><?= get_option('gallery_schedule') ?></textarea>
            <?php
        }, self::GROUP, 'gallery_options_section');
    }

    public static function addMenu () {
        add_options_page("Gallery management", "Gallery", "manage_options", self::GROUP, [self::class, 'render']);
    }

    public static function render () {
        ?>
        <h1>Gallery management</h1>

        <form action="options.php" method="post">
            <?php 
            settings_fields(self::GROUP);
            do_settings_sections(self::GROUP);
            submit_button();
            ?>
        </form>
        <?php 
    }

}