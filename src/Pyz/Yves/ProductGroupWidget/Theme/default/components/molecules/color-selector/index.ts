import './color-selector.scss';
import register from 'ShopUi/app/registry';
export default register('color-selector', () => import(/* webpackMode: "lazy" */'ProductGroupWidget/components/molecules/color-selector/color-selector'));
