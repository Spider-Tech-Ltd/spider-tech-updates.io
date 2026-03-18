// JavaScript to hide success and error messages after 1.5 seconds
setTimeout(function() {
    var alerts = document.querySelectorAll('.alert, .error');
    alerts.forEach(function(alert) {
        alert.style.display = 'none';
    });
}, 1500);

