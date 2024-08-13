jQuery(document).ready(function($) {

    "use strict";

    /**
     * theia sticky sidebar
     */
    var innerStickyVal  = color_newspaperObject.inner_sticky;
    if ( innerStickyVal === 'on' ) {
        $('#primary, #secondary').theiaStickySidebar({
            additionalMarginTop: 30
        });
    }


});