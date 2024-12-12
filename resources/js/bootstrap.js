import axios from 'axios';
window.axios = axios;

import jQuery from "jquery";
import Mmenu from 'mmenu-js';

window.$ = jQuery;
window.jQuery = jQuery;
window.Mmenu = Mmenu;


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
