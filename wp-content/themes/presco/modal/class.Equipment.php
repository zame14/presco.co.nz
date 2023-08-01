<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/26/2023
 * Time: 1:22 PM
 */
class Equipment extends prescoBase
{
    public function getFeatureImage()
    {
        return get_the_post_thumbnail($this->Post, 'tall-grid');
    }
    function getPanel()
    {
        $html = '<div class="col-12 col-sm-6 col-md-4 col-lg-3 panel">
            <a href="' . $this->link() . '">
                <div class="image-wrapper">
                    ' . $this->getFeatureImage() . '
                </div>
                <div class="content-wrapper">
                    <h3>' . $this->getTitle() . '</h3>
                </div>
            </a>
        </div>';
        return $html;
    }
    function getCategory()
    {
        global $wpdb;

        $sql = '
        SELECT t.term_id
        FROM ' . $wpdb->prefix . 'term_relationships tr
        INNER JOIN ' . $wpdb->prefix . 'term_taxonomy t
        ON tr.term_taxonomy_id = t.term_taxonomy_id
        WHERE object_id = ' . $this->id();
        $result = $wpdb->get_results($sql);

        return new Category($result[0]->term_id);
    }
    function getCategories()
    {
        global $wpdb;
        $categories = array();
        $sql = '
        SELECT t.term_id
        FROM ' . $wpdb->prefix . 'term_relationships tr
        INNER JOIN ' . $wpdb->prefix . 'term_taxonomy t
        ON tr.term_taxonomy_id = t.term_taxonomy_id
        WHERE object_id = ' . $this->id();
        $results = $wpdb->get_results($sql);
        foreach($results as $result)
        {
            $category = new Category($result->term_id);
            $categories[] = $category;
        }
        return $categories;
    }
}