<?php
/*
add_action('letsdoit_import_content', function(){
    touch(__DIR__ . '/demo-' . time());
});

add_filter('cron_schedules', function ($schedules){
    $schedules['ten_seconds'] = [
        'interval' => 10,
        'display' => __('Every 10 seconds', 'letsdoit')
    ];
    return $schedules;
});


if ($time = wp_next_scheduled('letsdoit_import_content')){
    wp_unschedule_event($timestamp, 'letsdoit_import_content');
}

echo '<pre>';
var_dump(_get_cron_array());
echo '</pre>';
die();


if (!wp_next_scheduled('letsdoit_import_content')){
    wp_schedule_event(time(), 'ten_seconds', 'letsdoit_import_content');
}
*/