/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// Font Awesome
import '@fortawesome/fontawesome-free/js/all';

// ChartJs
import Chart from 'chart.js';

// SCSS Compiler
import '../scss/app.scss';

// Ajax
import './ajaxValue'

// jQuery
const $ = require('jquery');

// Bootstrap
require('bootstrap');


//Slider
require ('noUiSlider');
require ('./patient');

// Project
require('./ChartJs/glycemia.js');

