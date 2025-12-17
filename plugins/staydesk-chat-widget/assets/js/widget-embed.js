// Widget Embed Script
// This file is served when hotels request the widget embed code

(function() {
    var script = document.currentScript;
    var hotelId = script.getAttribute('data-hotel-id');
    
    if (!hotelId) {
        console.error('StayDesk Widget: data-hotel-id attribute is required');
        return;
    }
    
    // Load the widget script - use relative path from current script location
    var widgetScript = document.createElement('script');
    var scriptSrc = script.src;
    var baseUrl = scriptSrc.substring(0, scriptSrc.lastIndexOf('/'));
    widgetScript.src = baseUrl + '/widget.js';
    widgetScript.setAttribute('data-hotel-id', hotelId);
    document.body.appendChild(widgetScript);
})();
