<?php namespace ProcessWire;

/**
 *
 *  LEARN MORE ABOUT MARKUP REGIONS
 *  https://processwire.com/blog/posts/processwire-3.0.49-introduces-a-new-template-file-strategy/
 *  https://processwire.com/blog/posts/processwire-3.0.62-and-more-on-markup-regions/
 *
 */

$image = $page->images->first();
?>

<div id='main' pw-prepend>

    <div class="container p-3 projects-section">

        <!-- Featured Project Row -->
        <div class="row align-items-center no-gutters mb-4 mb-lg-5">

            <div class="col-xl-8 col-lg-7">
                <a href='<?php if($image) echo $image->url; ?>'>  
                    <?=page()->render('images', 'img-large');?>
                </a>    
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="featured-text text-center text-lg-left">
                    <h4><?=page()->title;?></h4>
                    <p class="text-black-50 mb-0"><?=page()->project_description;?></p>
                </div>
            </div>
            
        </div>

        <?=page()->body;?>

    </div>

</div><!-- /#min -->
