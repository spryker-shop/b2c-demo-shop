import './side-drawer.scss';
import register from 'ShopUi/app/registry';
export default register('side-drawer', () => import(/* webpackMode: "eager" */ './side-drawer'));
