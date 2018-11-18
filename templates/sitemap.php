<?php namespace ProcessWire;

/**
 * 
 *  LEARN MORE ABOUT MARKUP REGIONS
 *  https://processwire.com/blog/posts/processwire-3.0.49-introduces-a-new-template-file-strategy/
 *  https://processwire.com/blog/posts/processwire-3.0.62-and-more-on-markup-regions/
 * 
 */

// Set Max Depth
	$maxDepth = 4; 

?>

<div id='main' pw-prepend>

    <div class="container cont-sitemap p-3">

        <?php 
            // see the _func.php for the renderNavTree function 
            echo renderNavTree(pages()->get('/'), $maxDepth);
        ?>

    </div><!-- /.cont-sitemap -->

</div><!-- /#main -->
