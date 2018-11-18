<?php namespace ProcessWire;

// Submit From Page
// $fromPage = isset($fromPage) ? __('Message sent from: ') . $fromPage : '';

// Get IP Adress
$ip = session()->getIP();
// Mail To ( Your E-Mail )
$mailTo = isset($mailTo) ? $mailTo : '';
// Privacy Page
$privacyPage = isset($privacyPage) ? $privacyPage : '';
// Mail Subject
$emailSubject = isset($emailSubject) ? $emailSubject : '';
// Save Message
$saveMessage = isset($saveMessage) ? $saveMessage : '';
// Set Contact Page & Contact Items To Save Message
$contactPage = isset($contactPage) ? $contactPage : '';
$contactItem = isset($contactItem) ? $contactItem : '';
// Basic Translate
$notFill = __('Do Not Fill First Security Input !!!');
$labelName = __('Name');
$labelEmail = __('E-Mail');
$labelMessage = __('Message');
$submit = __('Submit');
$reset = __('Reset');
$showForm = __('Show Form');
$labelSuccess = __('Success !!! Your message has been sent');
$labelAccept = __('By submitting a query, you accept');
$labelPrivacy = __('privacy policy');
$somethingWrong = __('Something Wrong !!! Try it again');
$fillFields = __('Fill the fields correctly !!!');
$csrfMatch =  __('Stop ... Session CSRF Not Match !!!');

// If Submit Form
if ($input->post->submit) :

// IF CSRF TOKEN NOT FOUND
if (!session()->CSRF->hasValidToken()) {
    session()->Message = '<h3>' . $csrfMatch . "</h3>";
    // session()->redirect('./http404');
    session()->redirect('./');
}

// Check Chidden Input
if ($input->firstname) {
    session()->Message = '<h3>' . $notFill . "</h3>";
    // session()->redirect('./http404');
    session()->redirect('./');
}

// Sanitize Input 
  $m_name = $sanitizer->text($input->post->name);
  $m_from = $sanitizer->email($input->post->email);
  $m_message = $sanitizer->text($input->post->message);

// Fill fields correctly 
  if (!$m_name or !$m_from  or !$m_message or !input()->post->accept_message) {
        $session->Message = "<h3>$fillFields</h3>";
        session()->redirect('./');
  }
// Prepare a message
    $mess_body = "<h4>$labelName:</h4> $m_name
                <h4>$labelEmail:</h4> $m_from
                <h4>$labelMessage:</h4> $m_message";

    $html = "<html><body>
                <p>$mess_body</p>
            </body></html>";

    // Send Mail
        $m = wireMail();
        // separate method call usage
        $m->to($mailTo); // specify CSV string or array for multiple addresses
        $m->from($m_from);
        $m->subject($emailSubject);
        $m->body($html);
        $m->send();

    // Save Message to child page ... Template => ( contact-item )
        if ($saveMessage == true) {
            // save to log that can be viewed via the pw backend
                $p = new Page();
                $p->template = $contactItem;
                // $p->parent = 1017;
                $p->parent = $contactPage;
                $p->title = $m_from . ' - ' . date("Y.m.d | H:i");
                $p->e_mail = $m_from;
                $p->session_ip = $ip;
                $p->body = $mess_body;
            // https://processwire.com/api/ref/page/add-status/g/
                $p->addStatus(Page::statusHidden);
                $p->addStatus(Page::statusLocked);
                $p->save();
        }

    // Session Message
        session()->Message ="
            <h3 class='success'>$labelSuccess</h3>
            <blockquote>
                <h4><b>$labelName:</b> $m_name</h4>
                <h4><b>$labelEmail:</b>  $m_from</h4>
                <h4><b>$labelMessage:</b></h4> 
                <p>$m_message</p>
            </blockquote>";

    // Finally redirect ( refresh page ) user with Success Message
    session()->redirect('./');

else :
// Session Message
    if ($session->Message) {
        echo $session->Message;
        echo "<a href='./' class='button'>$showForm</a>";
// Show Basic Contact Form
    } else {
// CSRF Tokens        
    $tokenName = $this->session->CSRF->getTokenName();
    $tokenValue = $this->session->CSRF->getTokenValue(); ?>

        <form id='contact-form' class='c-form' action='./' method='post'>

          <input type='hidden' id='_post_token' name='<?=$tokenName?>' value='<?=$tokenValue?>'>

          <!-- Create fields for the honeypot -->
          <input name='firstname' placeholder='<?=$notFill?>' type='text' id='firstname' class='hide-robot'>
          <!-- honeypot fields end -->

        <div class="form-group">
            <label class='label-name'>* <?=$labelName?></label>
            <input class='form-control' name='name' placeholder='<?=$labelName?>' autocomplete='off' type='text' required>
        </div>      

        <div class="form-group">
            <label class='label-email'>* <?=$labelEmail?></label>
            <input class='form-control' name='email' placeholder='<?=$labelEmail?>' type='email' required>
        </div>

        <div class="form-group">
            <label class='label-message'>* <?=$labelMessage?></label>
            <textarea class='form-control' name='message' placeholder='<?=$labelMessage?>' rows='7' required></textarea>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" name='accept_message' class="custom-control-input" id="customCheck1" required>
            <label class="custom-control-label" for="customCheck1">
                <?=$labelAccept?> <a href='<?=$privacyPage?>'><?=$labelPrivacy?></a>.
            </label>
        </div>

        <br>
        
        <div class="form-group">
          <input class="btn btn-primary" name='submit' value='<?=$submit?>' type='submit'>
          <button type='reset' class="btn btn-primary"><?=$reset?></button>
        </div>

        </form>

<?php }

    endif;

      // Remove Session Message
        session()->remove('Message');
