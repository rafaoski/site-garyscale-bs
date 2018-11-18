<?php namespace ProcessWire;

// Get Mail
$save_message = page('save_message');
$contactMail = page()->e_mail;
$emailSubject = page()->email_subject;
$privacyPage = pages('/privacy-policy/')->url;

// Optional 
// $fromPage = page()->httpUrl;

// Get Map Latitude and Longitude
// https://www.latlong.net/
// https://www.openstreetmap.org/
$latitude = page()->latitude;
$longitude = page()->longitude;
$markerText = page()->marker_text;
?>

<!-- CONTENT BODY -->
<div id='main' pw-prepend>

    <div id='content-main' class="container p-3">

        <?php // Include contact form
        wireIncludeFile(
            "inc/_c-form",
            [
            'saveMessage' => $save_message, // true or false
            'contactPage' => page(), // Get Contact Page to save items pages('/contact/')
            'contactItem' => 'contact-item', // Template to create item ( It must have a body field )
            'mailTo' => $contactMail ?: 'user@gmail.com', // Send To Mail
            'emailSubject' => $emailSubject, // Mail Subject
            'privacyPage' => $privacyPage, // Privacy Policy Page
            // 'fromPage' => $fromPage // Get Url Page
            ]
        );?>

        <br>

        <?php echo page()->body;?> 

    </div><!-- /#content-main -->

    <?php if($latitude && $longitude) :?>

        <div id='map'></div><!-- /#map -->

    <?php endif; ?>

</div><!-- /#main -->

<style id='head-style' pw-append>
    .hide-robot {
        display: none;
    }
    #map { 
        height: 380px; 
        box-sizing: unset;
    }
</style>

<?php if($latitude && $longitude) :?>

<pw-region id="bottom-region">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>

    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>

    <script>
    var map = L.map('map').setView([<?=$latitude?>, <?=$longitude?>], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    <?php if($markerText) :
    // Sanitizer Full Markdown https://processwire.com/api/ref/sanitizer/entities-markdown/g/ ?>
    L.marker([<?=$latitude?>, <?=$longitude?>]).addTo(map)
        .bindPopup("<?=$sanitizer->entitiesMarkdown($markerText, true)?>")
        .openPopup();
    <?php endif;?>
    </script>

</pw-region>

<?php endif;
