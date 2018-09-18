import './nouislider.min.scss';

import './range-slider.scss';
import register from 'ShopUi/app/registry';
export default register('range-slider', () => import(/* webpackMode: "lazy" */'./range-slider'));