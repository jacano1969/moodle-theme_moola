<?php

class theme_moola_core_renderer extends core_renderer {
    function block(block_contents $bc, $region) {
        $bc = clone($bc); // Avoid messing up the object passed in.
        if (empty($bc->blockinstanceid) || !strip_tags($bc->title)) {
            $bc->collapsible = block_contents::NOT_HIDEABLE;
        }
        if ($bc->collapsible == block_contents::HIDDEN) {
            $bc->add_class('hidden');
        }
        if (!empty($bc->controls)) {
            $bc->add_class('block_with_controls');
        }

        $skiptitle = strip_tags($bc->title);
        if (empty($skiptitle)) {
            $output = '';
            $skipdest = '';
        } else {
            $output = html_writer::tag('a', get_string('skipa', 'access', $skiptitle), array('href' => '#sb-' . $bc->skipid, 'class' => 'skip-block'));
            $skipdest = html_writer::tag('span', '', array('id' => 'sb-' . $bc->skipid, 'class' => 'skip-block-to'));
        }

        $output .= html_writer::start_tag('div', $bc->attributes);

        $output .= $this->block_header($bc);
        $output .= html_writer::tag('div', $this->block_content($bc), array('class'=>'content-wrap'));

        $output .= html_writer::end_tag('div');

        $output .= $this->block_annotation($bc);

        $output .= $skipdest;

        return $output;
    }

    protected function block_header(block_contents $bc) {

        $title = '';
        if ($bc->title) {
            $title = html_writer::tag('h2', $bc->title, null);
        }

        $controlshtml = $this->block_controls($bc->controls);

        $output = '';
        $output .= html_writer::tag('div', html_writer::tag('div', html_writer::tag('div', '', array('class'=>'block_action')). $title . $controlshtml, array('class' => 'title')), array('class' => 'header'));
        return $output;
    }

    /**
     * Returns lang menu or '', this method also checks forcing of languages in courses.
     * @return string
     */
    public function lang_menu() {
        global $CFG;

        $output = '';

        if (empty($CFG->langmenu)) {
            return $output;
        }

        if ($this->page->course != SITEID and !empty($this->page->course->lang)) {
            // do not show lang menu if language forced
            return $output;
        }

        $currlang = current_language();
        $langs = get_string_manager()->get_list_of_translations();
        $langcount = count($langs);

        if ($langcount < 2) {
            return $output;
        } else if ($langcount < 16) {
            foreach ($langs as $code => $title) {
                $icon = $this->pix_icon('flags/'.$code, $title, 'theme');
                $link = new moodle_url($this->page->url, array('lang'=>$code));
                $output .= html_writer::link($link, $icon, array('class'=>'langlink','title'=>$title));
            }
        } else {
            $s = new single_select($this->page->url, 'lang', $langs, $currlang, null);
            $s->label = get_accesshide(get_string('language'));
            $s->class = 'langmenu';
            $output .= $this->render($s);
        }

        return $output;
    }
    
    /**
     * Return the navbar content so that it can be echoed out by the layout
     * @return string XHTML navbar
     */
    public function navbar() {

        $items = $this->page->navbar->get_items();

        $htmlblocks = array();
        // Iterate the navarray and display each node
        $itemcount = count($items);
        $separator = get_separator();
        for ($i=0;$i < $itemcount;$i++) {
            $item = $items[$i];
            
            if (!($item->icon instanceof pix_icon) || $item->icon->pix == 'i/navigationitem') {            
                $item->hideicon = true;
            }
            
            $content = '';
            if ($i !== 0) {
                $content .= $separator;
            }
            $content .= $this->render($item);
            
            if ($item->has_children()) {
                $siblingcontent  = html_writer::start_tag('div', array('class'=>'siblings'));
                $siblingcontent .= html_writer::start_tag('div', array('class'=>'siblings-wrap'));
                $siblingcount = 0;
                foreach ($item->children as $child) {
                    if (array_key_exists($i+1, $items) && $child->key == $items[$i+1]->key || empty($child->action)) {
                        continue;
                    }
                    $siblingcount++;
                    $siblingcontent .= html_writer::tag('div', $this->render($child), array('class'=>'node-sibling'));
                    if ($siblingcount > 15) {
                        break;
                    }
                }
                $siblingcontent .= html_writer::end_tag('div');
                $siblingcontent .= html_writer::end_tag('div');
                if ($siblingcount > 0) {
                    $content .= $siblingcontent;
                }
            }
            
            $content = html_writer::tag('li', $content);
            
            $htmlblocks[] = $content;
        }

        $navbarcontent = html_writer::tag('span', get_string('pagepath'), array('class'=>'accesshide'));
        $navbarcontent .= html_writer::tag('ul', join('', $htmlblocks));
        return $navbarcontent;
    }
    
}