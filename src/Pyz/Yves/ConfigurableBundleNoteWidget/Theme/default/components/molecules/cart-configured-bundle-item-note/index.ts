import './cart-configured-bundle-item-note.scss';
import register from 'ShopUi/app/registry';
export default register(
    'cart-configured-bundle-item-note',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "cart-configured-bundle-item-note" */
            './cart-configured-bundle-item-note'
        ),
);
