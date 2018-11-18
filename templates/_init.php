<?php namespace ProcessWire;
/**
 * This _init.php file is called automatically by ProcessWire before every page render
 * More Info To Learn Basics
 * https://processwire.com/blog/posts/processwire-3.0.119-and-new-site-updates/
 *
 */
/** @var ProcessWire $wire */

setting([
// Url Settings
    'root' => urls()->root,
    'home' =>  pages()->get('/'),
    'templates' => urls()->templates,
// Basic SEO    
    'meta-title' => page('meta_title|title'),
    'meta-description' => page('meta_description'),
    'canonical-url' => page()->httpUrl(),
// Options Page
    'options' => pages('/options/'),
    'site-name' => pages('/options/')->site_name,
    'favicon' => pages('/options/')->favicon ?: '',
    'logo' => pages('/options/')->logo ?: '',
// Images Options
    'header-image' => count(page()->images) ? page()->images->first()->url : urls('templates') . "assets/img/bg-masthead.jpg",   
    'bg-signup' => pages('/signup/')->signup_img ? pages('/signup/')->signup_img->first()->url : urls('templates') . "assets/img/bg-masthead.jpg",   
// Custom CSS Classes
    'body-classes' => WireArray([
      'template-' . page()->template->name,
      'page-' . page()->id,
    ]),  
// Get Styles
    'css-files' => WireArray([
        urls('templates') . "assets/vendor/bootstrap/css/bootstrap.min.css",
        urls('templates') . "assets/vendor/fontawesome-free/css/all.min.css",
        "https://fonts.googleapis.com/css?family=Varela+Round",
        "https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i",
        urls('templates') . "assets/css/grayscale.min.css",
        urls('templates') . "assets/css/master.css"
    ]),
// Get Scripts
    'js-files' => WireArray([
        urls('templates') . "assets/vendor/jquery/jquery.min.js",
        urls('templates') . "assets/vendor/bootstrap/js/bootstrap.bundle.min.js",
        urls('templates') . "assets/vendor/jquery-easing/jquery.easing.min.js",
        urls('templates') . "assets/js/grayscale.min.js"
    ]),
// Transate    
// 'search-placeholder' => __('Search…'),
]);

include_once('./_func.php');
