<?php

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hasregionbar = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('region-bar', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));

$showregionbar = ($hasregionbar && !$PAGE->blocks->region_completely_docked('region-bar', $OUTPUT));

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if (!$showregionbar) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}
$bodyclasses[] = moola_get_user_face($PAGE);

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php echo $PAGE->bodyid ?>" class="<?php echo $PAGE->bodyclasses.' '.join(' ', $bodyclasses) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>
<div id="page">

    <div id="page-wrap">
        <div id="page-header">
            <h1 class="headermain"><?php echo $PAGE->heading ?></h1>
            <div class="headermenu"><?php
                if ($haslogininfo) {
                    echo $OUTPUT->login_info();
                }
                echo $PAGE->headingmenu;
                echo html_writer::tag('div', $OUTPUT->lang_menu(), array('class'=>'langmenu'));
            ?></div>
            <?php if ($hascustommenu) { ?>
            <div id="custommenu"><?php echo $custommenu; ?></div>
            <?php } ?>
            <?php if ($hasnavbar) { ?>
                <div class="navbar clearfix">
                    <div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
                    <div class="navbutton"> <?php echo $PAGE->button; ?></div>
                </div>
            <?php } ?>
        </div>
        <!-- END OF HEADER -->
        <div id="page-content">
            <div id="page-content-wrap">
                <div class="region-content">
                    <?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
                </div>
            </div>
        </div>

    <!-- START OF FOOTER -->
        <?php if ($hasfooter) { ?>
        <div id="page-footer" class="clearfix">
            <p class="helplink"><?php echo page_doc_link(get_string('moodledocslink')) ?></p>
            <?php
            echo $OUTPUT->login_info();
            echo $OUTPUT->home_link();
            echo $OUTPUT->standard_footer_html();
            ?>
        </div>
        <?php } ?>
    </div>
    <div id="menu-bar">
        <div id="menu-bar-mask">&nbsp;</div>
        <div id="menu-bar-wrap">
            <div id="menu-bar-content">
                <?php if ($hasheading) { ?>
                <div id="menu-bar-heading">
                    <h1 class="headermain"><?php echo $PAGE->heading ?></h1>
                </div>
                <?php } ?>
                <?php if ($hasregionbar) { ?>
                <div id="region-bar" class="block-region">
                    <div class="region-content">
                        <?php echo $OUTPUT->blocks_for_region('region-bar') ?>
                        <div class="block fake_block_moola">
                            <div class="header">
                                <div class="title"><?php echo get_string('faceselector', 'theme_moola');?></div>
                            </div>
                            <div class="content-wrap">
                                <div class="content">
                                    <div><?php echo moola_display_face_selector($PAGE); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>