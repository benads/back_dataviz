require('../css/app.css');
require('../scss/app.scss');
const $ = require('jquery');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');


// TOOLTIP

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});



