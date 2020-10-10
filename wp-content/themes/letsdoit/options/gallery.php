<?php
class GalleryMenuPage {

    const GROUP = 'gallery_options';

    public static function register () {
        add_action('admin_menu', [self::class, 'addMenu']);
        add_action('admin_init', [self::class, 'registerSettings']);
        add_action('admin_enqueue_scripts', [self::class, 'registerScripts']); // https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
    }

    public static function registerScripts (){
        wp_enqueue_style('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', [], false);
        wp_register_script('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr', [], false, true);
        wp_register_script('letsdoit_admin', get_template_directory_uri() . '/assets/admin.js', ['flatpickr'], false, true);
        wp_enqueue_script('letsdoit_admin');
        wp_enqueue_style('flatpickr');
    }

    public static function registerSettings ($suffix) {
        if ($suffix === 'settings_page_gallery_options')
        register_setting(self::GROUP, 'gallery_schedule');
        register_setting(self::GROUP, 'gallery_date');
        add_settings_section('gallery_options_section', 'Parameters', function () {
            echo "Here you can manage the parameters related to the gallery";
        }, self::GROUP);
        add_settings_field('gallery_options_schedule', "opening hours", function () {
            ?>
            <textarea name="gallery_schedule" cols="30" rows="10" style="width: 100%"><?= esc_html(get_option('gallery_schedule')) ?></textarea>
            <?php
        }, self::GROUP, 'gallery_options_section');
        add_settings_field('gallery_options_date', "opening dates", function () {
            ?>
            <input type="text" name="gallery_date" value="<?= esc_attr(get_option('gallery_date')) ?>" class="letsdoit_datepicker">
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