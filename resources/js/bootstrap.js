import loadash from "lodash";
window._ = loadash;

import * as Popper from "@popperjs/core";
window.Popper = Popper;

import jQuery from "jquery";
window.$ = jQuery;
window.jQuery = jQuery;

import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
