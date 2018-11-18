<?php namespace ProcessWire;

/**
 *
 *  LEARN MORE ABOUT MARKUP REGIONS
 *  https://processwire.com/blog/posts/processwire-3.0.49-introduces-a-new-template-file-strategy/
 *  https://processwire.com/blog/posts/processwire-3.0.62-and-more-on-markup-regions/
 * 
 *  New wireRenderFile() and wireIncludeFile() functions
 *  https://processwire.com/blog/posts/processwire-2.5.2/
 *
 */

// Get About Page
$about = pages('/about/');
// Get Projects Page
$projects = pages('/projects/');
// Get Signup Page
$signup = pages('/signup/');
?>

<div id='main' pw-prepend>

  <!-- About Section -->
  <section id="<?=$about->name?>" class="about-section text-center">

    <?php wireIncludeFile('inc/home-parts/about', [ 'about' => $about ]); ?>

  </section>

  <!-- Projects Section -->
  <section id="<?=$projects->name?>" class="projects-section bg-light">

    <?php wireIncludeFile('inc/home-parts/projects', [ 'projects' => $projects, 'limit' => 3 ]); ?>
 
  </section>

  <!-- Signup Section -->
  <section id="signup" class="signup-section">

    <div class="container ">

      <div class="row">

          <div class="col-md-10 col-lg-8 mx-auto text-center">

              <?php wireIncludeFile('inc/home-parts/signup',
              [ 
                'signupPage'    => $signup, // Signup Page
                'signupItem'    => 'signup-item', // Template to create item ( It must have a body field )
                'saveMessage'   =>  $signup->save_message, // true or false
                'mailTo'        =>  $signup->e_mail ?: 'user@gmail.com', // Send To Mail
                'emailSubject'  =>  $signup->email_subject, // Mail Subject
                'subjectSignup' =>  __('Thanks For Signup to ') .
                 pages('/options/')->site_name ,
              ]); ?>

            </div>

        </div><!-- /.row -->

    </div><!-- /.container -->

  </section>

</div><!-- /#main -->
