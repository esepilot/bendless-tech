// Widget Embed Script
// This file is served when hotels request the widget embed code

(function() {
    var script = document.currentScript;
    var hotelId = script.getAttribute('data-hotel-id');
    
    if (!hotelId) {
        console.error('StayDesk Widget: data-hotel-id attribute is required');
        return;
    }
    
    // Load the widget script
    var widgetScript = document.createElement('script');
    widgetScript.src = '<?php echo STAYDESK_WIDGET_URL; ?>assets/js/widget.js';
    widgetScript.setAttribute('data-hotel-id', hotelId);
    document.body.appendChild(widgetScript);
})();
