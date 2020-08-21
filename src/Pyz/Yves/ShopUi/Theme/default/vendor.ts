/* tslint:disable: no-any */
declare const require: any;
/* tslint:enable */

// add polyfills
import 'core-js/features/promise';
import 'core-js/features/array';
import 'core-js/features/set';
import 'core-js/features/map';
import 'whatwg-fetch';
import 'element-remove';
import 'classlist-polyfill';
import 'string.prototype.startswith';
import 'intersection-observer';
import elementClosestPolyfill from 'element-closest';
elementClosestPolyfill(window);

// then load a shim for es5 transpilers (typescript or babel)
// https://github.com/webcomponents/webcomponentsjs#custom-elements-es5-adapterjs
/* tslint:disable: no-var-requires no-require-imports */
require('@webcomponents/webcomponentsjs/custom-elements-es5-adapter.js');

// add webcomponents polyfill
require('@webcomponents/webcomponents-platform/webcomponents-platform');
require('@webcomponents/custom-elements/custom-elements.min');
/* tslint:enable */
