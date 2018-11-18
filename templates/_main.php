<?php namespace ProcessWire;

/**
 *
 * _main.php template file, called after a page’s template file
 *  All settings and options are in the file _init.php
 *  All functions are in the file _func.php
 *  Basicaly usage fields:
 *  page('title') or page()->title or $page('title') or $page->title or $page->get('title') or page()->get('title')
 *
 */

?>
<!doctype html>
<html lang="<?=_x('en', 'HTML language code')?>" prefix="og: http://ogp.me/ns#">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?=setting('meta-title');?> | <?=setting('site-name');?></title>
        <meta name="description" content="<?=setting('meta-description');?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?=setting('favicon');?>"/>
        <link rel="apple-touch-icon" href="<?=setting('favicon');?>">
        <?=smartSeo(page(), setting('options'));?>
        <?=setting('css-files')->each("<link rel='stylesheet' href='{value}'>" . "\n\t\t");?>
        <style id='head-style'>
            <?php wireIncludeFile('./inc/custom-css', 
            ['header_image' => setting('header-image'),
            'bg_signup' => setting('bg-signup')]);?>
        </style> 
    </head>
<body id="page-top" class='<?=setting('body-classes')->implode(' ')?>'>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
  <div class="container">

    <a class="navbar-brand js-scroll-trigger" href="<?=page() == setting('home') ? '#page-top' : setting('root')?>">
      <?php if(setting('logo')) :?>
          <img src="<?=setting('logo')->url?>" alt="<?=setting('options')->logo_text;?>">
      <?php else : 
          echo setting('options')->logo_text;
      endif;?>
    </a>

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" 
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <?=__('Menu');?>
      <i class="fas fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <?php if(page() == setting('home')) {
            echo renderNav(setting('home')->children, ['about','projects','signup']);
          } else {
            echo renderNav(setting('home')->children);
          }  
        ?>
      </ul>
    </div>

  </div>
</nav>

<!-- Header -->
<header class="masthead">
  <div class="container d-flex h-100 align-items-center">

    <div class="mx-auto text-center w-100">

      <h1 id='title' class="mx-auto my-0 text-uppercase">
        <?php if(page() == setting('home')) {
          echo setting('site-name');
        } else {
          echo page('meta_title');
        } ?>
      </h1>

      <h2 id='description' class="text-white-50 mx-auto mt-2 mb-5">
        <?=setting('meta-description')?>
      </h2>

      <a href="#main" class="btn btn-primary js-scroll-trigger">
        <?php if(page() == setting('home')) {
            echo  __('Get Started');
          } else {
            echo page('title');
          } ?>
      </a>

    </div>

  </div>
  
</header>

<?php // Show Breadcrumbs if is not Home Page
if(page() != setting('home')) :?> 
<div id="breadcrumb">

  <nav class='breadcrumb'>
    <?=breadCrumb(page())?>
  </nav>

</div>
<?php endif; ?>

<div id='main'>
<?php // Next Previous Page
if (page() != setting('home')) {
    echo prNx(page());
} ?>
  <!-- Contact Section -->
  <section class="contact-section bg-black">
    <?php wireIncludeFile('inc/home-parts/contact', [ 'contact' => pages('/contact/') ]); ?>
  </section>

</div><!-- /#main -->

<!-- Footer -->
<footer class="bg-black small text-center text-white-50">

  <div class="container">
    <?= __('Copyright &copy; ') . setting('site-name') . ' ' . date('Y');?>
  </div>

<?php // Footer Menu
if(setting('options')->on_off) :?> 
  <nav id='footer-menu' class="nav">
    <?php // https://processwire.com/docs/tutorials-old/quick-start/navigation/
      $children = setting('home')->children();
      foreach($children as $child) {
        $active  =  $child == page() ? 'active' : 'no-active';
        echo "<a class='text-sm-center nav-link $active' href='{$child->url}'>{$child->title}</a>";
      }
    ?>
  </nav>
<?php endif;?>

</footer>

<?php
// Edit Button
    echo editBtn(page());
// Display region debugging info
    echo debugRegions();
// Basic Scripts
    echo setting('js-files')->each("<script src='{value}'></script>" . "\n\t\t");
?>
    <pw-region id="bottom-region"></pw-region>
    </body>

</html>
