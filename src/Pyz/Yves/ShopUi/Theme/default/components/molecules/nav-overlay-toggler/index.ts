import './style';
import register from 'ShopUi/app/registry';
export default register('nav-overlay-toggler', () => import(/* webpackMode: "lazy" */'./nav-overlay-toggler'));
