<?php namespace ProcessWire;?>

<div class="projects container">
  <!-- Featured Project Row -->
  <div class="row align-items-center no-gutters mb-4 mb-lg-5">

      <div class="col-xl-8 col-lg-7">
        <a href="<?=$projects->child()->url;?>">
            <?=$projects->child->render('images', 'img-large');?>
        </a>
      </div>

      <div class="col-xl-4 col-lg-5">
        <div class="featured-text text-center text-lg-left">
          <h4><?=$projects->child()->title;?></h4>
          <p class="text-black-50 mb-0"><?=$projects->child()->project_description;?></p>
        </div>
      </div>

  </div>
<?php 
foreach ($projects->children("limit=$limit") as $key => $child ) :
$first_class = '';
$next_class = '';
$last_class = '';
$finally_class = '';
// If Not first item
if($key != 0) :
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
  <!-- Next Projects Row -->
  <div class="next-projects row justify-content-center no-gutters <?=$first_class?>">
      <div class="col-lg-6">
        <a href="<?=$child->url;?>">
            <?=$child->render('images', 'img-medium');?>
        </a>
      </div>
      <div class="col-lg-6 <?=$next_class?>">
        <div class="bg-black text-center h-100 project">
          <div class="d-flex h-100">
            <div class="project-text w-100 my-auto text-center <?=$last_class?>">
              <h4 class="text-white"> <?=$child->title?></h4>
              <p class="mb-0 text-white-50"><?=$child->project_description;?></p>
              <hr class="d-none d-lg-block mb-0 <?=$finally_class;?>">
            </div>
          </div>
        </div>
      </div>
  </div><!-- /.next-projects -->
<?php endif;
        endforeach; ?>
</div><!-- /.projects -->