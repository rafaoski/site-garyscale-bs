<?php namespace ProcessWire;?>

<div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2 class="text-white mb-4"><?=$about('meta_title')?></h2>
          <p class="text-white-50">
          <?php // https://processwire.com/api/ref/sanitizer/truncate/
            echo sanitizer()->truncate($about('body'), [
              // 'type' => 'sentence',
              'maxLength' => 300,
              'keepTags' => ['a'],
              'more' => ' ...'
            ]);
        ?></p>
        </div>
      </div>

      <a href="<?=$about->url;?>">
        <?=$about->render('images', 'img-medium')?>
      </a>

</div>