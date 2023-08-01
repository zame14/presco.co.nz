<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/29/2023
 * Time: 8:43 PM
 */
class Page extends prescoBase
{
    function isThisPage($page_slug)
    {
        // check if environmental home page
        if($this->id() == get_field($page_slug,13)) {
            return true;
        } else {
            // not on environmental home page but check if we on a environmental sub page
            $children = get_children(get_field($page_slug,13));
            foreach($children as $child) {
                if ($this->id() == $child->ID) {
                    return true;
                    break;
                }
            }
            return false;
        }
    }
    function getLogo()
    {
        return '<img src="' . get_field('logo',$this->id()) . '" alt="' . $this->getTitle() . '" />';
    }
    function getPageClass()
    {
        return strtolower($this->getTitle());
    }
    function getMenuID()
    {
        return strtolower($this->getTitle()) . '-menu';
    }
    public function getFeatureImage()
    {
        return get_the_post_thumbnail($this->Post, 'full');
    }
    function getPageTitle()
    {
        $title = $this->getTitle();
        if(get_field('alt_page_title',$this->id())) {
            $title = get_field('alt_page_title',$this->id());
        }
        return $title;
    }
    function getSnippet()
    {
        $html = '';
        if(get_field('page_snippet',$this->id())) {
            $html = '<div class="snippet">' . get_field('page_snippet',$this->id()) . '</div>';
        }
        return $html;
    }
}