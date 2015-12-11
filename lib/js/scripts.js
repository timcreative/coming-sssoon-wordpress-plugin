/** External Links **/

function externalLinks() { if (!document.getElementsByTagName) return; var anchors = document.getElementsByTagName("a"); for (var i=0; i<anchors.length; i++) { var anchor = anchors[i]; if (anchor.getAttribute("href") && anchor.getAttribute("rel") == "external") anchor.target = "_blank"; } } window.onload = externalLinks;

/** Add class to BODY if screen size is desktop or mobile **/

jQuery(document).ready(function($) {  
    "use strict";
	var $window = $(window),
    $html = $('body');
    $window.resize(function resize() {
		$html.removeClass('mobile');
		$html.removeClass('tablet');
		$html.removeClass('desktop');
		if ($window.width() < 480) {
			return $html.addClass('mobile');
		}
		else if ($window.width() < 768) {
			return $html.addClass('tablet');
		}
        else {
			return $html.addClass('desktop');
		}
    }).trigger('resize');
});


