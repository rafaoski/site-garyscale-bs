<?php namespace ProcessWire;?>

<div class="container cont-contact">

  <div class="row contact-info">

    <?php foreach ($contact->contact_info as $info) :?>
      <div class="col-md-4 mb-3 mb-md-0">
        <div class="card py-4 h-100">
          <div class="card-body text-center">
            <i class="fas <?=$info->txt_1;?> text-primary mb-2"></i>
            <h4 class="text-uppercase m-0"><?=$info->txt_2;?></h4>
            <hr class="my-4">
            <div class="small text-black-50"><?=$info->txt_3;?></div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

  </div><!-- /.contact-info -->

  <div class="social d-flex justify-content-center">

    <?php foreach ($contact->social_profiles as $profile) :?>
      <a href="<?=$profile->url_1;?>" class="mx-2">
        <i class="fab <?=$profile->txt_1;?>"></i>
      </a>
    <?php endforeach; ?>

  </div><!-- /.social -->

</div><!-- /.cont-contact -->