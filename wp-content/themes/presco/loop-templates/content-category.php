<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/19/2023
 * Time: 4:05 PM
 */
$cate = get_queried_object();
$category_id = $cate->term_id;
$arr = getServiceByCategory($category_id);
if($cate->taxonomy == "equipment-category") {
    $arr = getEquipmentByCategory($category_id);
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row justify-content-center services-module">
        <?php
        foreach ($arr as $category) {
            echo $category->getPanel();
        }
        ?>
    </div>
</article>
