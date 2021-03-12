import './custom-select.scss';
import register from 'ShopUi/app/registry';
export default register('custom-select', () => import(/* webpackMode: "eager" */ './custom-select'));
