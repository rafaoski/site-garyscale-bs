<?php namespace ProcessWire;

/**
 *
 *  LEARN MORE ABOUT MARKUP REGIONS
 *  https://processwire.com/blog/posts/processwire-3.0.49-introduces-a-new-template-file-strategy/
 *  https://processwire.com/blog/posts/processwire-3.0.62-and-more-on-markup-regions/
 *
 */

?>

<div id='main' class='bg-light' pw-prepend>

  <div class="container projects-section" style='padding: 2rem 0;'>
  
<?php
// Set Limit Items for pagination
$items = page()->children("limit=6");
// Start Loop
foreach ($items  as $key => $child ) :
// Reset Class
$first_class = '';
$next_class = '';
$last_class = '';
$finally_class = '';
// Set Some Class
if ($key % 2 == 0) {
      $first_class = '';
      $next_class = 'order-lg-first';
      $last_class = 'text-lg-right';
      $finally_class = 'mr-0';
} else {
   $first_class = 'mb-5 mb-lg-0';
   $next_class = '';
   $last_class = 'text-lg-left';
   $finally_class = 'ml-0';
} ?>

    <!-- All Projects Row -->
    <div class="all-projects row justify-content-center no-gutters <?=$first_class?>">
      <div class="col-lg-6 pt-2">
        <a href="<?=$child->url;?>">
          <?=$child->render('images', 'img-medium');?>
        </a>
      </div>
      <div class="col-lg-6 <?=$next_class?> pt-2">
        <div class="bg-black text-center h-100 project">
          <div class="d-flex h-100">
            <div class="project-text w-100 my-auto text-center <?=$last_class?>">
              <h4 class="text-white"> <?=$child->title?></h4>
              <p class="mb-0 text-white-50"><?=$child->project_description?></p>
              <hr class="d-none d-lg-block mb-0 <?=$finally_class?>">
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.all-projects -->

  <?php endforeach;
  // Basic Pagination https://processwire.com/api/modules/markup-pager-nav/
  if ($items->renderPager()) :?>
    <div class="items-pagination text-center m-3">
      <?=basicPagination($items);?>
    </div>
  <?php endif;?>

  </div><!-- /.projects-section -->
</div><!-- /#min -->
