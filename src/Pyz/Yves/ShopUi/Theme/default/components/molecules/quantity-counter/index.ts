import './quantity-counter.scss';
import register from 'ShopUi/app/registry';
export default register('quantity-counter', () => import(/* webpackMode: "lazy" */'./quantity-counter'));
