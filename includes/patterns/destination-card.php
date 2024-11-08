<?php
return array(
	'title'         => __( 'Destination Card', 'tour-operator' ),
	'description'   => __( '', 'tour-operator' ),
	'categories'    => array( $this->category ),
	'templateTypes' => array( 'single' ),
	'content'     => '
		<!-- wp:group {"metadata":{"categories":["lsx-tour-operator"],"patternName":"lsx-tour-operator/destination-card","name":"' . __( 'Destination Card', 'tour-operator' ) . '"},"className":"is-style-shadow-xsm","style":{"border":{"radius":"8px"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-shadow-xsm" style="border-radius:8px"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":0,"customOverlayColor":"#7097aa","isUserOverlayColor":true,"contentPosition":"bottom center","isDark":false,"style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}},"border":{"radius":"8px"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-cover is-light has-custom-content-position is-position-bottom-center" style="border-radius:8px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#7097aa"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"center-vertically","style":{"spacing":{"padding":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small","left":"10px","right":"10px"}},"color":{"gradient":"linear-gradient(180deg,rgba(7,146,227,0) 0%,rgba(0,0,0,0.6) 41%)"},"dimensions":{"minHeight":"6rem"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group center-vertically has-background" style="background:linear-gradient(180deg,rgba(7,146,227,0) 0%,rgba(0,0,0,0.6) 41%);min-height:6rem;padding-top:var(--wp--preset--spacing--x-small);padding-right:10px;padding-bottom:var(--wp--preset--spacing--x-small);padding-left:10px"><!-- wp:post-title {"textAlign":"center","level":3,"isLink":true,"linkTarget":"_blank","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"},":hover":{"color":{"text":"var:preset|color|primary-200"}}}}},"textColor":"base","fontSize":"small"} /--></div>
		<!-- /wp:group --></div></div>
		<!-- /wp:cover --></div>
		<!-- /wp:group -->
	',
);