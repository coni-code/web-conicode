/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import $ from 'jquery';
import select2 from 'select2';
$.select2 = select2;
global.$ = $;
global.jQuery = $;

import './styles/app.scss';
import 'bootstrap';
import '@fortawesome/fontawesome-free';
import 'select2/dist/css/select2.min.css';

import './styles/home/nav.scss';
import './styles/home/contact.scss';
import './styles/home/header.scss';
import './styles/home/technology.scss';
import './styles/home/team.scss';
import './styles/home/carousel.scss';
import './styles/home/exception.scss';
import './styles/home/footer.scss';
