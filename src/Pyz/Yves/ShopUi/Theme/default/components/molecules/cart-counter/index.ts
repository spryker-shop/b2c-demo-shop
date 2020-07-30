import './cart-counter.scss';
import register from 'ShopUi/app/registry';
export default register('cart-counter', () => import(
    /* webpackMode: "eager" */
    /* webpackChunkName: "cart-counter" */
    'ShopUi/components/molecules/cart-counter/cart-counter'));
