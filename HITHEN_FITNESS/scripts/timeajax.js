/**
 * Time AJAX Script
 * Handles time-related AJAX requests for DNX FITNESS WEBSITE
 */

$(document).ready(function() {
    // Display current time
    function updateTime() {
        var now = new Date();
        var timeString = now.toLocaleTimeString();
        $('#current-time').html(timeString);
    }

    // Update time every second
    setInterval(updateTime, 1000);
    updateTime(); // Initial call

    // Log page load time
    console.log('Page loaded at: ' + new Date().toLocaleString());
});
