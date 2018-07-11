import './style';
import register from 'ShopUi/app/registry';
export default register('product-carousel', () => import(/* webpackMode: "eager" */'./product-carousel'));
