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
import './styles/home/nav.scss';
import '@fortawesome/fontawesome-free';
import 'select2/dist/css/select2.min.css';

import './styles/home/default.scss';
import './styles/home/contact.scss';
import './styles/home/header.scss';

import './styles/admin/login.scss';
import './styles/admin/sidebar.scss';
import './styles/admin/topbar.scss';
import './styles/admin/content.scss';
import './styles/admin/calendar.scss';
import './styles/admin/detail.scss';
import './styles/overrides/select2.scss';
