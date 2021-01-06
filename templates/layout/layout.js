// Bootstrap
require('bootstrap');
require('@popperjs/core');
require('bootstrap/dist/css/bootstrap.css');

// Fontawesome
require('@fortawesome/fontawesome-free/css/all.min.css');

// SweetAlert2
global.Swal = require('sweetalert2');
require('./swal2.css');

// notifIt!
require('notifit-js/notifIt/css/notifIt.min.css');
global.notif = require('notifit-js/notifIt/js/notifIt.min').notif;
require('./notifit.css');

// Loading indicator
global.spinner = require('./spinner');

// Custom styles
require('./layout.css');
require('./print.css');
