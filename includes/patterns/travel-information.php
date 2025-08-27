<?php
// phpcs:ignoreFile PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage
return array(
	'title'         => __( 'Travel Information', 'tour-operator' ),
	'description'   => __( 'Display the travel information like banking and cusine.', 'tour-operator' ),
	'categories'    => array( $this->category ),
	'content'       => '<!-- wp:group {"tagName":"section","metadata":{"name":"Travel Information","categories":["lsx-tour-operator"],"patternName":"lsx-tour-operator/travel-information"},"align":"wide","className":"lsx-travel-information-wrapper lsx-to-slider is-style-section-6","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignwide lsx-travel-information-wrapper lsx-to-slider is-style-section-6"><!-- wp:heading {"textAlign":"left","align":"wide"} -->
<h2 class="wp-block-heading alignwide has-text-align-left">Travel Information</h2>
<!-- /wp:heading -->

<!-- wp:separator {"align":"wide"} -->
<hr class="wp-block-separator alignwide has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","right":"var:preset|spacing|50","left":"var:preset|spacing|50"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:group {"align":"wide","className":"travel-information is-style-section-9","style":{"spacing":{"blockGap":"var:preset|spacing|40","padding":{"right":"0","left":"0"}}},"layout":{"type":"grid"}} -->
<div class="wp-block-group alignwide travel-information is-style-section-9" style="padding-right:0;padding-left:0"><!-- wp:group {"metadata":{"name":"Additional Info"},"align":"full","className":"lsx-general-wrapper additional-info","style":{"border":{"radius":"8px"},"shadow":"0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926","color":{"background":"#ffffff"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull lsx-general-wrapper additional-info has-background" style="border-radius:8px;background-color:#ffffff;box-shadow:0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926"><!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4} -->
<h4 class="wp-block-heading has-text-align-center" id="h-general">General</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"content","layout":{"type":"constrained"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"additional_info"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons {"align":"full"} -->
<div class="wp-block-buttons alignfull"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-general">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Banking"},"className":"lsx-banking-wrapper additional-info","style":{"shadow":"0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926","border":{"radius":"8px"}},"backgroundColor":"custom-white","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-banking-wrapper additional-info has-custom-white-background-color has-background" style="border-radius:8px;box-shadow:0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:heading {"textAlign":"center","level":4} -->
<h4 class="wp-block-heading has-text-align-center" id="h-banking">Banking</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"banking"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-banking" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Climate"},"className":"lsx-climate-wrapper additional-info is-style-shadow-xsm","style":{"shadow":"0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926","border":{"radius":"8px"}},"backgroundColor":"custom-white","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-climate-wrapper additional-info is-style-shadow-xsm has-custom-white-background-color has-background" style="border-radius:8px;box-shadow:0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926"><!-- wp:group {"metadata":{"name":"Content"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:heading {"textAlign":"center","level":4} -->
<h4 class="wp-block-heading has-text-align-center" id="h-climate">Climate</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"climate"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-climate" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Cuisine"},"className":"lsx-cuisine-wrapper additional-info is-style-shadow-xsm additional-info","style":{"shadow":"0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926","border":{"radius":"8px"}},"backgroundColor":"custom-white","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-cuisine-wrapper additional-info is-style-shadow-xsm has-custom-white-background-color has-background" style="border-radius:8px;box-shadow:0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926"><!-- wp:group {"metadata":{"name":"Content"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"Title"},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4} -->
<h4 class="wp-block-heading has-text-align-center" id="h-cuisine">Cuisine</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"cuisine"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons {"align":"full"} -->
<div class="wp-block-buttons alignfull"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-cuisine" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Electricity"},"className":"lsx-electricity-wrapper additional-info","style":{"color":{"background":"#ffffff"},"shadow":"0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926","border":{"radius":"8px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-electricity-wrapper additional-info has-background" style="border-radius:8px;background-color:#ffffff;box-shadow:0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926"><!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:heading {"textAlign":"center","level":4} -->
<h4 class="wp-block-heading has-text-align-center" id="h-electricity">Electricity</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"content","layout":{"type":"constrained"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"electricity"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons {"align":"full"} -->
<div class="wp-block-buttons alignfull"><!-- wp:button {"backgroundColor":"primary","width":100,"metadata":{"name":"More Button"},"className":"lsx-to-more-link","style":{"border":{"radius":{"topLeft":"0px 8px 8px 0px","topRight":"0px 8px 8px 0px","bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-electricity" style="border-top-left-radius:0px 8px 8px 0px;border-top-right-radius:0px 8px 8px 0px;border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Dress"},"className":"lsx-dress-wrapper additional-info is-style-shadow-xsm","style":{"shadow":"0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926","border":{"radius":"8px"}},"backgroundColor":"custom-white","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-dress-wrapper additional-info is-style-shadow-xsm has-custom-white-background-color has-background" style="border-radius:8px;box-shadow:0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926"><!-- wp:group {"metadata":{"name":"Content"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"Title"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4} -->
<h4 class="wp-block-heading has-text-align-center" id="h-dress">Dress</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"dress"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-dress">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Health"},"className":"lsx-health-wrapper additional-info is-style-shadow-xsm","style":{"shadow":"0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926","border":{"radius":"8px"}},"backgroundColor":"custom-white","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-health-wrapper additional-info is-style-shadow-xsm has-custom-white-background-color has-background" style="border-radius:8px;box-shadow:0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926"><!-- wp:group {"metadata":{"name":"Content"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"Title"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4} -->
<h4 class="wp-block-heading has-text-align-center" id="h-health">Health</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"health"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-health" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Safety"},"className":"lsx-safety-wrapper additional-info is-style-shadow-xsm","style":{"shadow":"0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926","border":{"radius":"8px"}},"backgroundColor":"custom-white","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-safety-wrapper additional-info is-style-shadow-xsm has-custom-white-background-color has-background" style="border-radius:8px;box-shadow:0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926"><!-- wp:group {"metadata":{"name":"Content"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"Title"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4} -->
<h4 class="wp-block-heading has-text-align-center" id="h-safety">Safety</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"safety"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-safety" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Transport"},"className":"lsx-transport-wrapper additional-info is-style-shadow-xsm","style":{"shadow":"0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926","border":{"radius":"8px"}},"backgroundColor":"custom-white","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-transport-wrapper additional-info is-style-shadow-xsm has-custom-white-background-color has-background" style="border-radius:8px;box-shadow:0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926"><!-- wp:group {"metadata":{"name":"Content"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"Title"},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4} -->
<h4 class="wp-block-heading has-text-align-center" id="h-transport">Transport</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"transport"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-transport" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Visa"},"className":"lsx-visa-wrapper additional-info is-style-shadow-xsm","style":{"border":{"radius":"8px"},"shadow":"0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926"},"backgroundColor":"custom-white","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-visa-wrapper additional-info is-style-shadow-xsm has-custom-white-background-color has-background" style="border-radius:8px;box-shadow:0px 4px 8px 0 #09090940, 0px 0px 1px 0 #09090926"><!-- wp:group {"metadata":{"name":"Content"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"metadata":{"name":"Title"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":4} -->
<h4 class="wp-block-heading has-text-align-center" id="h-visa">Visa</h4>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","layout":{"type":"default"}} -->
<div class="wp-block-group content"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"visa"}}}}} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" href="#to-modal-visa" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->"wp-block-group content" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"banking"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons {"align":"full"} -->
<div class="wp-block-buttons alignfull"><!-- wp:button {"backgroundColor":"primary","width":100,"metadata":{"name":"More Button"},"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Cuisine"},"align":"full","className":"lsx-cuisine-wrapper additional-info is-style-shadow-xsm additional-info","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull lsx-cuisine-wrapper additional-info is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Cuisine</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group content" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"cuisine"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons {"align":"full"} -->
<div class="wp-block-buttons alignfull"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Climate"},"className":"lsx-climate-wrapper additional-info is-style-shadow-xsm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-climate-wrapper additional-info is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Climate</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group content" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"climate"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Transport"},"className":"lsx-transport-wrapper additional-info is-style-shadow-xsm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-transport-wrapper additional-info is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Transport</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group content" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"transport"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Dress"},"className":"lsx-dress-wrapper additional-info is-style-shadow-xsm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-dress-wrapper additional-info is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Dress</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group content" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"dress"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Health"},"className":"lsx-health-wrapper additional-info is-style-shadow-xsm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-health-wrapper additional-info is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Health</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group content" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"health"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Safety"},"className":"lsx-safety-wrapper additional-info is-style-shadow-xsm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-safety-wrapper additional-info is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Safety</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group content" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"safety"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Visa"},"className":"lsx-visa-wrapper additional-info is-style-shadow-xsm","style":{"spacing":{"blockGap":"0px","padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"radius":"8px"}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group lsx-visa-wrapper additional-info is-style-shadow-xsm has-base-background-color has-background" style="border-radius:8px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"metadata":{"name":"Content"},"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:group {"metadata":{"name":"Title"},"style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:0;padding-bottom:0"><!-- wp:paragraph {"align":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"small"} -->
<p class="has-text-align-center has-small-font-size" style="padding-top:0;padding-bottom:0"><strong>Visa</strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Description"},"className":"content","style":{"spacing":{"padding":{"right":"10px","left":"10px","top":"0px","bottom":"0px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group content" style="padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"lsx/post-meta","args":{"key":"visa"}}}},"style":{"spacing":{"padding":{"top":"2px","bottom":"2px"}}}} -->
<p style="padding-top:2px;padding-bottom:2px"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","width":100,"className":"lsx-to-more-link","style":{"border":{"radius":{"bottomLeft":"8px","bottomRight":"8px"}}}} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 lsx-to-more-link"><a class="wp-block-button__link has-primary-background-color has-background wp-element-button" style="border-bottom-left-radius:8px;border-bottom-right-radius:8px">Read more</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->'
);
