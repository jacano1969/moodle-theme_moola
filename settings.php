<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/theme/moola/lib.php');

if ($ADMIN->fulltree) {

    $name = 'theme_moola/face';
    $title = get_string('setting_face','theme_moola');
    $description = get_string('setting_facedesc', 'theme_moola');
    $setting = new moola_admin_setting_faceselector($name, $title, $description, moola_default_face(), moola_get_faces());
    $settings->add($setting);
}