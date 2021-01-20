import './rating-selector.scss';
import register from 'ShopUi/app/registry';
export default register(
    'rating-selector',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "rating-selector" */
            './rating-selector'
        ),
);
