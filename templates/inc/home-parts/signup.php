<?php namespace ProcessWire;
// Get IP Adress
$ip = session()->getIP();
// Root Url
$p_url = page()->httpUrl;
// Mail To  From ( Your E-Mail )
$mailTo = isset($mailTo) ? $mailTo : '';
// Save Message
$saveMessage = isset($saveMessage) ? $saveMessage : '';
// Mail Subject
$emailSubject = isset($emailSubject) ? $emailSubject : '';
// Set Contact Page & Contact Items To Save Message
$signupPage = isset($signupPage) ? $signupPage : '';
$signupItem = isset($signupItem) ? $signupItem : '';
// Basic Translate
$notFill = __('Do Not Fill First Security Input !!!');
$labelEmail = __('E-Mail');
$enterEmailAdress = __('Enter email address...');
$subscribe = __('Subscribe');
$showForm = __('Submit Again');
// Security Message
$fillFields = __('Fill the fields correctly !!!');
$csrfMatch =  __('Stop ... Session CSRF Not Match !!!');
// Subscribe form Message
$mess = __('Subscribe to receive updates!');
$thanksforSignup = __('Thanks For Signup');

// If Submit Form
if ($input->post->submit) :

// IF CSRF TOKEN NOT FOUND
if (!session()->CSRF->hasValidToken()) {
    session()->Message = "<h2 class='text-danger text-uppercase display-4 mb-5'>" . $csrfMatch . "</h2>";
    // session()->redirect('./http404');
    session()->redirect('./');
}

// Check Chidden Input
if ($input->firstname) {
    $session->Message = "<a href='{$p_url}'>
    <div class='alert alert-danger' role='alert'>
    <h2 class='text-uppercase display-4'>
    $notFill <br> $showForm </h2></div></a>";
    session()->redirect('./#signup');
}

// Sanitize Input 
  $subscribent_mail = strtolower( $sanitizer->email($input->post->subscribent) );

// Fill fields correctly 
    if (!$subscribent_mail) {
        $session->Message = "<a href='{$p_url}'><div class='alert alert-danger' role='alert'>
        <h2 class='text-uppercase display-4'>
        $fillFields <br> $showForm </h2></div></a>";
        session()->redirect('./#signup');
    }

// Prepare a message
        $html = "<html><body>
                <p><h4>$labelEmail:</h4> $subscribent_mail</p>
            </body></html>";

// Send Message to your E-mail Adress
        $m = wireMail();
        // separate method call usage
        $m->to($mailTo); // specify CSV string or array for multiple addresses
        $m->from($subscribent_mail);
        $m->subject($emailSubject);
        $m->body($html);
        $m->send();

// Save Message to child page ... Template => ( mailing-item )
    if ($saveMessage == true) {
        $p = new Page();
        $p->template = $signupItem;
        $p->parent = $signupPage;
        $p->title = $subscribent_mail . ' - ' . date("Y.m.d | H:i");
        $p->e_mail = $subscribent_mail;
        $p->session_ip = $ip;
    // https://processwire.com/api/ref/page/add-status/g/
        $p->addStatus(Page::statusHidden);
        $p->addStatus(Page::statusLocked);
    // Save Page    
        $p->save();
    }

// Session Message
    session()->Message = "$thanksforSignup <br> <small class='text-lowercase'>$subscribent_mail</small>";

// Finally redirect ( refresh page ) user with Success Message
    session()->redirect('./#signup');

else :

// Session Message

if ($session->Message) {

    echo "<h2 class='text-warning text-uppercase display-2 mb-5'>$session->Message</h2>";

} else {

// CSRF Tokens        
    $tokenName = $this->session->CSRF->getTokenName();
    $tokenValue = $this->session->CSRF->getTokenValue();

// Show Basic Contact Form ?>

    <i class="far fa-paper-plane fa-2x mb-2 text-white"></i>

    <h2 class="text-white mb-5">

        <?=$mess?>
            
    </h2>

    <form class="form-inline d-flex" action='./' method='post'>
    
      <!-- Create fields for the honeypot -->
      <input name='firstname' placeholder='<?=$notFill?>' type='text' id='firstname' class='mr-0 mr-sm-2 mb-3 mb-sm-0 hide-robot'>

      <input type='hidden' id='_post_token' name='<?=$tokenName?>' value='<?=$tokenValue?>'>

      <input type="email" name='subscribent' class="form-control flex-fill mr-0 mr-sm-2 mb-3 mb-sm-0" placeholder="<?=$enterEmailAdress;?>" required>
      
      <input name='submit' class="btn btn-primary mx-auto" value='<?=$subscribe;?>' type='submit'>
      
    </form>
   
<?php }

    endif;

  // Remove Session Message
    session()->remove('Message');
?>
