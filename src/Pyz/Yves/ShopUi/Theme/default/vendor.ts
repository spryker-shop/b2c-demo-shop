/* tslint:disable: no-any */
declare const require: any;
/* tslint:enable */

// add webcomponents polyfill
import 'core-js/fn/promise';
import 'core-js/fn/array';
import 'core-js/fn/set';
import 'core-js/fn/map';

// check if the browser natively supports webcomponents (and es6)
const hasNativeCustomElements = !!window.customElements;

// then load a shim for es5 transpilers (typescript or babel)
// https://github.com/webcomponents/webcomponentsjs#custom-elements-es5-adapterjs
if (hasNativeCustomElements) {
    import(/* webpackMode: "eager" */'@webcomponents/webcomponentsjs/custom-elements-es5-adapter');
}
/* tslint:disable: no-var-requires no-require-imports */
require('@webcomponents/webcomponentsjs/webcomponents-bundle');
/* tslint:enable */
import 'element-closest';
