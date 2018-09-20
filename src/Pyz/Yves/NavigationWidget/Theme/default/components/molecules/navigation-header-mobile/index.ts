import './navigation-header-mobile.scss';
import register from 'ShopUi/app/registry';
export default register('nav-header-mobile', () => import(/* webpackMode: "lazy" */'./navigation-header-mobile'));