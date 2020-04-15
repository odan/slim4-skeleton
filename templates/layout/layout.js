// jQuery
window.jQuery = require('jquery');
window.$ = window.jQuery;

// Bootstrap
require('bootstrap');
require('popper.js');
require('bootstrap/dist/css/bootstrap.css');

// Fontawesome
require('@fortawesome/fontawesome-free/css/all.min.css');

// SweetAlert2
window.Swal = require('sweetalert2');

// Loading indicator
global.spinner = require('./spinner');

// Custom styles
require('./layout.css');
require('./print.css');
