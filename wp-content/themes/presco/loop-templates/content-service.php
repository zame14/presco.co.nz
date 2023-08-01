<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/2/2022
 * Time: 8:18 PM
 */
global $post;
$service = new Service($post->ID);
$gallery = $service->getGalleryImages();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-7">
            <div class="ani-in1 gallery-images-wrapper">
                <div class="gallery-images">
                    <?php
                    foreach ($gallery as $image)
                    {
                        $p_imageid = getImageID($image);
                        $p_img = wp_get_attachment_image_src($p_imageid, 'default');
                        echo '<div><img src="' . $p_img[0] . '" alt="' . $service->getTitle() . '" /></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-5">
            <h1><?=$service->getTitle()?></h1>
            <div class="description">
                <?=the_content()?>
            </div>
            <a href="#enquire" class="btn btn-primary">Enquiry now</a>
        </div>
        <div class="col-12 additional-info">
            <?=wpautop($service->getCustomField('service-additional-information'))?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 form-wrapper">
            <a name="enquire"></a>
            <h2>Get in touch</h2>
            <p>See how we can help you with <?=$service->getTitle()?>.</p>
            <?=do_shortcode('[contact-form-7 id="5" title="Service Enquiry"]')?>
        </div>
    </div>
</article>