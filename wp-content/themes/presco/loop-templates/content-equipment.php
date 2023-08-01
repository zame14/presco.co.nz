<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/2/2022
 * Time: 8:18 PM
 */
global $post;
$equipment = new Equipment($post->ID);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-7">
            <div class="image-wrapper">
                <?=$equipment->getFeatureImage()?>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-5">
            <h1><?=$equipment->getTitle()?></h1>
            <div class="description">
                <?=the_content()?>
            </div>
            <a href="#enquire" class="btn btn-primary">Enquiry now</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 form-wrapper">
            <a name="enquire"></a>
            <?=do_shortcode('[contact-form-7 id="1101" title="Hire Equipment Enquiry"]')?>
        </div>
    </div>
</article>