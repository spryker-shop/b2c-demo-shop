import './side-drawer';
import register from 'ShopUi/app/registry';
export default register('side-drawer', () => import(/* webpackMode: "eager" */'ShopUi/components/organisms/side-drawer/side-drawer'));
