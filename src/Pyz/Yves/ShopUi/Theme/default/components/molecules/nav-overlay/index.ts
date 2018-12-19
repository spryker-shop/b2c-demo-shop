import './nav-overlay.scss';
import register from 'ShopUi/app/registry';
export default register('nav-overlay', () => import(/* webpackMode: "lazy" */'./nav-overlay'));
