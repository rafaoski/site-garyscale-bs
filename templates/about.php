<?php namespace ProcessWire;

/**
 *
 *  LEARN MORE ABOUT MARKUP REGIONS
 *  https://processwire.com/blog/posts/processwire-3.0.49-introduces-a-new-template-file-strategy/
 *  https://processwire.com/blog/posts/processwire-3.0.62-and-more-on-markup-regions/
 *
 */

?>

<div id='main' pw-prepend>

  <div class="container cont-about">

    <div class="row">
      <div class="col-lg-8 mx-auto">
        <h2 class="text-black mt-4 mb-4"><?=page('meta_title');?></h2>
          <?=page()->body;?>
      </div>
    </div>

    <?=page()->render('images', 'img-medium'); ?>

	</div><!-- /.cont-about -->

</div><!-- /#main -->
