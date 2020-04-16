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
require('./swal2.css');

// notifIt!
require('notifit-js/notifIt/css/notifIt.min.css');
window.notif = require('notifit-js/notifIt/js/notifIt.min').notif;
require('./notifit.css');

// Loading indicator
global.spinner = require('./spinner');

// Custom styles
require('./layout.css');
require('./print.css');
