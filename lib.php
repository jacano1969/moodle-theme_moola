<?php

require_once($CFG->dirroot.'/lib/adminlib.php');

class moola_admin_setting_faceselector extends admin_setting {

    protected $faces = array();

    /**
     *
     * @param string $name
     * @param string $visiblename
     * @param string $description
     * @param string $defaultsetting
     * @param array $faces Array('selector'=>'.some .css .selector','style'=>'backgroundColor');
     */
    public function __construct($name, $visiblename, $description, $defaultsetting, array $faces=null) {
        $this->faces = $faces;
        parent::__construct($name, $visiblename, $description, $defaultsetting);
    }

    /**
     * Return the setting
     *
     * @return mixed returns config if successful else null
     */
    public function get_setting() {
        return $this->config_read($this->name);
    }

    /**
     * Saves the setting
     *
     * @param string $data
     * @return bool
     */
    public function write_setting($data) {
        $data = $this->validate($data);
        if ($data === false) {
            return  get_string('validateerror', 'admin');
        }
        return ($this->config_write($this->name, $data) ? '' : get_string('errorsetting', 'admin'));
    }

    /**
     * Validates the colour that was entered by the user
     *
     * @param string $data
     * @return string|false
     */
    protected function validate($data) {

        if (!in_array($data, $this->faces)) {
            return $this->defaultsetting;
        }
        return $data;

    }

    /**
     * Generates the HTML for the setting
     *
     * @global moodle_page $PAGE
     * @global core_renderer $OUTPUT
     * @param string $data
     * @param string $query
     */
    public function output_html($data, $query = '') {
        global $PAGE, $OUTPUT;

        $content  = html_writer::start_tag('div', array('class'=>'moola_face_selector'));
        foreach ($this->faces as $face) {
            $content .= html_writer::start_tag('div', array('class'=>'moola_face', 'id'=>'moola_face_'.$face));
            $content .= html_writer::start_tag('h1', array('class'=>'moola_face_name'));
            $attributes = array('type'=>'radio','id'=>$this->get_id().'_'.$face, 'name'=>$this->get_full_name(), 'value'=>$face);
            if (($this->get_setting()!='' && $this->get_setting() == $face) || $this->get_defaultsetting() == $face) {
                $attributes['checked'] = 'checked';
            }
            $content .= html_writer::empty_tag('input', $attributes);
            $content .= ' '.html_writer::tag('span', get_string('face_name_'.$face, 'theme_moola'));
            $content .= html_writer::end_tag('h1');
            $content .= html_writer::start_tag('div', array('class'=>'moola_face_img'));
            $content .= html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url($face.'/faceimg', 'theme_moola'), 'alt'=>get_string('face_image_'.$face, 'theme_moola'), 'width'=>'640px', 'height'=>'64px'));
            $content .= html_writer::end_tag('div');
            $content .= html_writer::end_tag('div');
        }
        $content .= html_writer::end_tag('div');
        
        return format_admin_setting($this, $this->visiblename, $content, $this->description, false, '', $this->get_defaultsetting(), $query);
    }

}

function moola_get_faces() {
    return array(
        'golden',
        'steel',
        'vintage',
        'ruby',
        'melt'
    );
}

function moola_default_face() {
    return 'golden';
}

function moola_display_face_selector(moodle_page $page) {
    
    $args = new stdClass;
    $args->currentface = moola_get_user_face($page);
    $page->requires->yui_module('moodle-theme_moola-moola', 'M.theme.moola.init', array($args));
    
    $renderer = $page->get_renderer('core');
    
    $output = '';
    $faces = moola_get_faces();
    foreach ($faces as $face) {
        $output .= html_writer::start_tag('div', array('class'=>'possibleface '.$face, 'rel'=>$face));
        $output .= html_writer::end_tag('div');
    }
    
    return $output;
    
}

function moola_get_user_face(moodle_page $page) {
    if (!empty($page->theme->settings->face)) {
        return 'moola_face_'.$page->theme->settings->face;
    } else {
        return 'moola_face_'.moola_default_face();
    }
}