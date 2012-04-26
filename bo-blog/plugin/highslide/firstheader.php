<?php

if (!defined('VALIDREQUEST')) {
    die ('Access Denied.');
}

function plugin_highslide_firstheader($str)
{
    $str .= <<<eot
<link rel="stylesheet" href="plugin/highslide/highslide.css">
<script src="plugin/highslide/highslide-with-gallery.js"></script>
<script>
hs.graphicsDir = 'plugin/highslide/graphics/';
hs.align = 'center';
hs.transitions = ['expand', 'crossfade'];
hs.outlineType = 'rounded-white';
hs.fadeInOut = true;
hs.numberPosition = 'caption';
hs.dimmingOpacity = 0.75;

// Add the controlbar
if (hs.addSlideshow) hs.addSlideshow({
	//slideshowGroup: 'group1',
	interval: 5000,
	repeat: false,
	useControls: true,
	fixedControls: 'fit',
	overlayOptions: {
		opacity: .75,
		position: 'bottom center',
		hideOnMouseOut: true
		}
	});
</script>
eot;
    return $str;
}
