<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/2/2023
 * Time: 11:59 AM
 */
class Service extends prescoBase
{
    public function getFeatureImage()
    {
        return get_the_post_thumbnail($this->Post, 'tall-grid');
    }
    public function getGalleryImages()
    {
        $gallery = Array();
        $field = get_post_meta($this->id());
        foreach($field['wpcf-service-gallery-images'] as $image) {
            $gallery[] = $image;
        }
        return $gallery;
    }
    function displayImages($feature = false)
    {
        $html = '';
        foreach ($this->getGlalleryImages() as $image)
        {
            $p_imageid = getImageID($image);
            $p_img = wp_get_attachment_image_src($p_imageid, 'full');
            $html .= '<div><img src="' . $p_img[0] . '" alt="' . $this->getTitle() . '" /></div>';
            if($feature) break;
        }

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
    public function getCustomField($field)
    {
        return $this->getPostMeta($field);
    }
}