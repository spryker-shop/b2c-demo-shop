import './product-item-list.scss';
import register from 'ShopUi/app/registry';
export default register(
    'product-item-list',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "product-item-list" */
            './product-item-list'
        ),
);
