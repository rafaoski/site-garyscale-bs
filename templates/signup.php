<?php namespace ProcessWire;

/**
 *
 *  LEARN MORE ABOUT MARKUP REGIONS
 *  https://processwire.com/blog/posts/processwire-3.0.49-introduces-a-new-template-file-strategy/
 *  https://processwire.com/blog/posts/processwire-3.0.62-and-more-on-markup-regions/
 *  New wireRenderFile() and wireIncludeFile() functions
 *  https://processwire.com/blog/posts/processwire-2.5.2/
 *
 */

?>

<div id='main' pw-prepend>

<!-- Signup Section -->
<section id="signup" class="signup-section">

  <div class="container">

    <div class="row">

        <div class="col-md-10 col-lg-8 mx-auto text-center">

            <?php wireIncludeFile('inc/home-parts/signup',
            [ 
              'signupPage'    => page(), // Signup Page
              'signupItem'    => 'signup-item', // Template to create item ( It must have a body field )
              'saveMessage'   =>  page()->save_message, // true or false
              'mailTo'        =>  page()->e_mail ?: 'user@gmail.com', // Send To Mail
              'emailSubject'  =>  page()->email_subject, // Mail Subject
              'subjectSignup' =>  __('Thanks For Signup to ') .
              setting('site-name'),
            ]); ?>

          </div>

      </div><!-- /.row -->

  </div><!-- /.container -->

</section>

</div><!-- /#main -->
