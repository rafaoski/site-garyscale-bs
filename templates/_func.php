<?php namespace ProcessWire;

/**
 * Shared functions used by the beginner profile
 *
 * This file is included by the _init.php file, and is here just as an example. 
 * You could place these functions in the _init.php file if you prefer, but keeping
 * them in this separate file is a better practice. 
 *
 */

/**
 * Given a group of pages, render a simple <ul> navigation
 *
 * This is here to demonstrate an example of a simple shared function.
 * Usage is completely optional.
 *
 * @param array $enable_pages
 * @param PageArray $items
 *
 */

function renderNav(PageArray $items, $enable_pages = null) {

    if(!$items->count()) return;
    
    if( isset($enable_pages) && in_array('home', $enable_pages)) $items->prepend(pages('/') );

    $out = '';

	// cycle through all the items
	foreach($items as $item) {

        if(!isset($enable_pages) || in_array($item->name, $enable_pages)) {

        // if current item is the same as the page being viewed, add a "current" class to it
            $a_class = $item->id == wire('page')->id ? 'active' : 'no-active';
        // render markup for each navigation item as an <li>
            $out .= "<li class='nav-item'>";
        // Get Basic URL
            $url = $item->url;
        // Get Scroll Effect URL if is Home Page
            if(page()->id == 1) $url = "#$item->name";
        // markup for the link
            $out .= "<a class='nav-link js-scroll-trigger $a_class' href='$url'>$item->title</a> ";
        // close the list item
            $out .= "</li>";
        }    
    
    }

    return $out;

}

/**
 * Given a group of pages, render a <ul> navigation tree
 *
 * This is here to demonstrate an example of a more intermediate level
 * shared function and usage is completely optional. This is very similar to
 * the renderNav() function above except that it can output more than one
 * level of navigation (recursively) and can include other fields in the output.
 *
 * @param array|PageArray $items
 * @param int $maxDepth How many levels of navigation below current should it go?
 * @param string $fieldNames Any extra field names to display (separate multiple fields with a space)
 * @param string $class CSS class name for containing <ul>
 * @return string
 *
 */
function renderNavTree($items, $maxDepth = 0, $fieldNames = '', $class = 'nav flex-column')
{

    // if we were given a single Page rather than a group of them, we'll pretend they
    // gave us a group of them (a group/array of 1)
    if ($items instanceof Page) {
        $items = array($items);
    }

    // $out is where we store the markup we are creating in this function
    $out = '';
    // cycle through all the items
    foreach ($items as $item) {
        // markup for the list item...
        // if current item is the same as the page being viewed, add a "current" class to it

        $a_class = $item->id == wire('page')->id ? 'active' : 'no-active';

        $out .= "<li class='nav-item m-1'>";

        // markup for the link
        $out .= "<a class='nav-item $a_class' href='$item->url'>$item->title</a>";

        // if there are extra field names specified, render markup for each one in a <div>
        // having a class name the same as the field name
        if ($fieldNames) {
            foreach (explode(' ', $fieldNames) as $fieldName) {
                $value = $item->get($fieldName);
                if ($value) {
                    $out .= " <div class='$fieldName'>$value</div>";
                }
            }
        }

        // if the item has children and we're allowed to output tree navigation (maxDepth)
        // then call this same function again for the item's children
        if ($item->hasChildren() && $maxDepth) {

            $class = 'nav flex-column pl-3';

            $out .= renderNavTree($item->children, $maxDepth-1, $fieldNames, $class);
        }

        // close the list item
        $out .= "</li>";
    }

    // if output was generated above, wrap it in a <ul>
    if ($out) {
        $out = "<ul class='$class'>$out</ul>\n";
    }

    // return the markup we generated above
    return $out;
}


/**
 *
 * @param Page|PageArray|null $page
 *
 */
function breadCrumb($page = null)
{

    if ($page == null) {
        return '';
    }

    $out = '';
    // breadcrumbs are the current page's parents
    foreach ($page->parents() as $item) {
        $out .= "<a class='breadcrumb-item' href='$item->url'>$item->title</a>";
       
    }
    // optionally output the current page as the last item
    $out .= $page->id != 1  ? "<span class='breadcrumb-item active'>$page->title</span>" : '';

    return $out;
}


/********* MULTI LANGUAGE SUPPORT *********/

/**
 *
 * @param Page $page
 * @param Page $root
 *
 */
function linkTag($page, $root)
{

    // If Multi Language Modules activate
    if (!$page->getLanguages()) {
        return '';
    }
    $out = '';
    // handle output of 'hreflang' link tags for multi-language
    // this is good to do for SEO in helping search engines understand
    // what languages your site is presented in
    foreach (languages() as $language) {
        // if this page is not viewable in the language, skip it
        if (!$page->viewable($language)) {
            continue;
        }
        // get the http URL for this page in the given language
        $url = $page->localHttpUrl($language);
        // hreflang code for language uses language name from homepage
        $hreflang = $root->getLanguageValue($language, 'name');
        // if($hreflang == 'home') $hreflang = page()->ts['languageCode'];
        // output the <link> tag: note that this assumes your language names are the same as required by hreflang.
        $out .= "\t<link rel='alternate' hreflang='$hreflang' href='$url' />\n";
    }
    return $out;
}

/**
 *
 * @param Page $page
 * @param Page $root
 *
 */
function langMenu($page, $root)
{
    // If Enable Multilanguage Modules
    if (!page()->getLanguages()) {
        return '';
    }
    $out = '';
    // language switcher / navigation
    $out .= "<ul class='lang-menu grid' role='navigation'>";
    // Start Loop
    foreach (languages() as $language) {
    // is page viewable in this language?
        if (!$page->viewable($language)) {
            continue;
        }
        if ($language->id == user()->language->id) {
            $out .= "<li class='active'>";
        } else {
            $out .= "<li>";
        }
        $url = $page->localUrl($language);
        $hreflang = $root->getLanguageValue($language, 'name');
        $out .= "<a hreflang='$hreflang' href='$url'>$language->title</a></li>";
    }
    $out .= "</ul>";
    return $out;
}

/********* END MULTI LANGUAGE SUPPORT *********/


/**
 *
 * https://processwire.com/blog/posts/processwire-3.0.107-core-updates/
 *
 * @param Page $item
 *
 */
function articleLinks($page)
{
    $out = '';
    $links = $page->links();
// If another page has links to this page
    if ($links->count()) {
        $out .= "<h3>" . __('You might also like:') . "</h3>";
        $out .= $links->each("<li><a href={url}>{title}</a></li>") . '<br>';
    }
    return $out;
}

/**
 *
 * START PAGINATION https://processwire.com/api/modules/markup-pager-nav/
 *
 * @param Page $items
 *
 */
function basicPagination($items)
{

    return $items->renderPager(array(
        'nextItemLabel' => __('Next &raquo;'),
        'previousItemLabel' => __('&laquo; Previous'),
        'listMarkup' => "<ul class='pagination'>{out}</ul>",
        'itemMarkup' => "<li class='{class} page-item'>{out}</li>",
        'linkMarkup' => "<a class='page-link' href='{url}'><span>{out}</span></a>",
        'separatorItemLabel' => " ... ",
        'numPageLinks' => 10,
        'currentItemClass' => 'active',
        'currentLinkMarkup' => "<a class='page-link bg-primary text-white' href='{url}'>{out}</a>",
    ));
}

/**
 *
 * Prev Next Button
 * Basic Example echo prNx($page)
 *
 * @param Page|null $item
 *
 */
function prNx($item = null)
{

// Prev Next Button
    $p_next = $item->next();
    $p_prev = $item->prev();

    $out = '';
    $out .= "<nav class='text-center p-3'>";

// link to the prev blog post, if there is one
    if ($p_prev->id) {
		$out .= "<a class='btn btn-outline-danger mx-1 my-1' href='$p_prev->url'>&laquo $p_prev->title</a>";
    }

    if($p_next->id && $p_prev->id ) $out .= ' | ';

// link to the next blog post, if there is one
    if ($p_next->id) {
        $out .= "<a  class='btn btn-outline-danger mx-1 my-1' href='$p_next->url'>$p_next->title &raquo</a>";
    }

    $out .= '</nav>';

    return $out;
}

/**
 *
 * Google Webmaster Tools Verification Code
 *
 * @param string|null $code
 *
 */
function gwCode($code = null)
{
    if ($code) {
        return "<meta name='google-site-verification' content='$code' />";
    }
}

/**
 *
 * https://developers.google.com/analytics/devguides/collection/analyticsjs/
 *
 * @param string $code Google Analytics Tracking Code
 *
 */
function gAnalitycs($code = null)
{

if(!$code) return '';
    
$out = "\n
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src='https://www.googletagmanager.com/gtag/js?id=UA-{$code}'></script>
<script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-{$code}');
</script>";

return $out;

}

/**
 *
 * @param array $fonts
 *
 */
function googleFonts($fonts)
{

// Implode to format => 'Roboto','Montserrat','Limelight','Righteous'
$font_family = "'" . implode("','", $fonts) . "'";

return"<script>
/* ADD GOOGLE FONTS WITH WEBFONTLOADER ( BETTER PAGESPEED )
    https://github.com/typekit/webfontloader
*/

WebFontConfig = {
        google: {
        families: [$font_family]
    }
};
    (function(d) {
        var wf = d.createElement('script'), s = d.scripts[0];
        wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
        wf.async = true;
        s.parentNode.insertBefore(wf, s);
    })(document);

</script>";
}

/**
 *
 * @param Page $page
 *
 */
function editBtn($page) 
{
    if ($page->editable()) echo "\t\t<a class='button b-edit' href='" . $page->editURL . "'>" . __('Edit') . "</a>\n";
}

/**
 *
 * @param Page $page
 *
 */
function debugRegions($class = 'sec-debug') 
{
    $out = '';

if (config()->debug && user()->isSuperuser()) {

$out .= "\n\t\t<section id='debug' class='$class'>

            <!--PW-REGION-DEBUG-->
        \n\t\t</section>\n";

    }

 return $out;   
}

/**
 *
 * Smart SEO
 *
 * @param Page $page
 *
 */
function smartSeo($page, $options_page)
{
// Reset variables
    $out = '';
    $tw_image = '';
    $metaTitle = $page('meta_title|title');
    $metaDescription = $page->meta_description;
// No index
    // if (page()->check_1) {
    //     echo "\t<meta name='robots' content='noindex'>\n";
    // }
// https://processwire.com/blog/posts/processwire-2.6.18-updates-pagination-and-seo/
    if (input()->pageNum > 1) {
        echo "\t<meta name='robots' content='noindex,follow'>\n";
    }
// https://weekly.pw/issue/222/
    if (config()->pagerHeadTags) {
        echo "\t" . config()->pagerHeadTags . "\n";
    }
// https://processwire.com/blog/posts/processwire-2.6.18-updates-pagination-and-seo/#using-a-pagination-view-all-page
// specify scheme and host statically rather than from $page->httpUrl
// $canonicalURL = 'https://www.domain.com' . $page->url;
    if ($options_page->canonical_url) {
        $canonicalURL = $options_page->canonical_url . $page->url;
    } else {
        $canonicalURL = setting('canonical-url');
    }
// if on a pagination, include that as part of your canonical URL
    if (input()->pageNum > 1) {
        $canonicalURL .= config()->pageNumUrlPrefix . input()->pageNum;
    }
// Get locale
    $locale = _x('en_US', 'HTML locale code');
// Site Name
    $siteName = setting('site-name');
// Basic Meta
    $out .= "<meta property='og:locale' content='{$locale}'/>\n";
    $out .= "\t\t<meta property='og:site_name' content='$siteName'/>\n";
    $out .= "\t\t<meta id='og-title' property='og:title' content='$metaTitle'/>\n";
    $out .= "\t\t<meta id='og-desc' property='og:description' content='$metaDescription'>\n";
    $out .= "\t\t<meta id='og-type' property='og:type' content='website'/>\n";
    $out .= "\t\t<meta id='og-url' property='og:url' content='{$canonicalURL}'/>\n";
// If Page Images
    if ($page->images && count($page->images)) {
        // Get image width
            $img = $page->images->first()->width(1200);
        // Show Image
            $out .= "\t\t<meta id='og-image' property='og:image' content='{$img->httpUrl()}'/>\n";
        // Image Size
            $out .= "\t\t<meta property='og:image:width' content='$img->width'/>\n";
            $out .= "\t\t<meta property='og:image:height' content='$img->height'/>\n";
        // TWITTER IMAGE
            $tw_image = "\t\t<meta name='twitter:image' content='{$img->httpUrl()}'/>\n";
    }
// Twitter Card
    $out .= "\t\t<meta name='twitter:card' content='summary_largeImage'/>\n";
    $out .= "\t\t<meta name='twitter:title' content='$metaTitle'/>\n";
    $out .= "\t\t<meta name='twitter:description' content='$metaDescription'/>\n";
    $out .= "$tw_image";
// Cannonical Link
    $out .= "\t\t<link rel='canonical' href='{$canonicalURL}'/>\n";
    return $out;
}
