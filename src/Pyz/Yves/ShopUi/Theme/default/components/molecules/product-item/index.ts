import './product-item.scss';
import register from 'ShopUi/app/registry';
export default register('product-item', () => import(/* webpackMode: "lazy" */'./product-item'));
