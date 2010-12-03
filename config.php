<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once($CFG->dirroot.'/theme/moola/lib.php');

$THEME->name = 'moola';
$THEME->parents = array('standard','base');
$THEME->sheets = array(
    'base',
    'moola'
);
foreach (moola_get_faces() as $face) {
    $THEME->sheets[] = 'face_'.$face;
}

$THEME->enable_dock = false;
$THEME->parents_exclude_sheets = array('base'=>array('pagelayout'));
$THEME->layouts = array(
    // Most backwards compatible layout without the blocks - this is the layout used by default
    'base' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    // Standard layout with blocks, this is recommended for most pages with general information
    'standard' => array(
        'file' => 'general.php',
        'regions' => array('region-bar'),
        'defaultregion' => 'region-bar',
    ),
    // Main course page
    'course' => array(
        'file' => 'general.php',
        'regions' => array('region-bar'),
        'defaultregion' => 'region-bar',
        'options' => array('showtabs' => true)
    ),
    'coursecategory' => array(
        'file' => 'general.php',
        'regions' => array('region-bar'),
        'defaultregion' => 'region-bar',
    ),
    // part of course, typical for modules - default page layout if $cm specified in require_login()
    'incourse' => array(
        'file' => 'general.php',
        'regions' => array('region-bar'),
        'defaultregion' => 'region-bar',
    ),
    // The site home page.
    'frontpage' => array(
        'file' => 'general.php',
        'regions' => array('region-bar'),
        'defaultregion' => 'region-bar',
    ),
    // Server administration scripts.
    'admin' => array(
        'file' => 'general.php',
        'regions' => array('region-bar'),
        'defaultregion' => 'region-bar',
    ),
    // My dashboard page
    'mydashboard' => array(
        'file' => 'general.php',
        'regions' => array('region-bar'),
        'defaultregion' => 'region-bar',
    ),
    // My public page
    'mypublic' => array(
        'file' => 'general.php',
        'regions' => array('region-bar'),
        'defaultregion' => 'region-bar',
    ),
    'login' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('langmenu'=>true),
    ),

    // Pages that appear in pop-up windows - no navigation, no blocks, no header.
    'popup' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true, 'nocustommenu'=>true, 'nologininfo'=>true),
    ),
    // No blocks and minimal footer - used for legacy frame layouts only!
    'frametop' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true),
    ),
    // Embeded pages, like iframe/object embeded in moodleform - it needs as much space as possible
    'embedded' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true, 'nocustommenu'=>true),
    ),
    // Used during upgrade and install, and for the 'This site is undergoing maintenance' message.
    // This must not have any blocks, and it is good idea if it does not have links to
    // other places - for example there should not be a home link in the footer...
    'maintenance' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('noblocks'=>true, 'nofooter'=>true, 'nonavbar'=>true, 'nocustommenu'=>true),
    ),
    // Should display the content and basic headers only.
    'print' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('noblocks'=>true, 'nofooter'=>true, 'nonavbar'=>false, 'nocustommenu'=>true),
    ),
    'report' => array(
        'file' => 'general.php',
        'regions' => array('region-bar'),
        'defaultregion' => 'region-bar',
    ),
);

$THEME->rendererfactory = 'theme_overridden_renderer_factory';