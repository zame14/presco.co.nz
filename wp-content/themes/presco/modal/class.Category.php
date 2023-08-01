<?php



/**

 * Created by PhpStorm.

 * User: user

 * Date: 10/15/2020

 * Time: 1:03 PM

 */

class Category

{

    public $Term = null;



    function __construct($term)

    {

        // If an ID is passed instead then change for a post array

        if(intval($term)) $term = get_term($term);

        $this->Term = $term;

    }



    public function id() {

        return $this->Term->term_id;

    }



    function getTermMeta($meta, $prefix = true) {

        if($prefix) $meta = 'wpcf-' . $meta;

        return get_term_meta($this->Term->term_id, $meta, true);

    }





    public function getTitle()

    {

        $title = $this->Term->name;

        return $title;

    }


    public function getContent()

    {

        $content = $this->Term->description;

        return $content;

    }

    // public function slug()

    //{

    // $slug = get_page_link(10) . '?category_id=' . $this->Term->term_id;

    //return $slug;

    //}

    /*

        public function getImage($size = 'large')

        {

            return get_the_post_thumbnail($this->Post, $size);

        }

    */

    public function slug()

    {

        $slug = '/' . $this->Term->slug;

        return $slug;

    }
    public function getSnippet()
    {
        return wpautop($this->getTermMeta('category-snippet'));
    }
}