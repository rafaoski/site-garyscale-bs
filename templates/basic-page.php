<?php namespace ProcessWire; 

/**
 * 
 *  LEARN MORE ABOUT MARKUP REGIONS
 *  https://processwire.com/blog/posts/processwire-3.0.49-introduces-a-new-template-file-strategy/
 *  https://processwire.com/blog/posts/processwire-3.0.62-and-more-on-markup-regions/
 * 
 */

?>

<div id='main' pw-prepend>

	<div class="container basic-page p-3">
	
		<?=page()->body;?>

		<?php if(page()->hasChildren) :?>

		<h3 class='text-uppercase display-4'><?=__('More Pages')?></h3>

    <div class="row">
	
		<?php foreach (page()->children as $child): 
			// grab and output first image https://processwire.com/api/fieldtypes/images/
			$image = $child->images->first();?>

				<a class='col-sm-12 col-md-4 p-2' href='<?=$child->url?>'>
					<div class="card">
						<?php if($image) :?>
						<img class="card-img-top" src="<?=$image->url?>" alt="<?=$child->title?>">
						<?php endif;?>	
						<div class="card-body">
							<h4><?=$child->title?></h4>
							<p class="card-text"><?=$child->render('body' , 'txt-small')?></p>
						</div>
					</div>
				</a>

		<?php endforeach ?>

	</div><!-- /.row -->

		<?php endif; ?>   

	</div><!-- /.basic-page -->

</div><!-- /#main -->