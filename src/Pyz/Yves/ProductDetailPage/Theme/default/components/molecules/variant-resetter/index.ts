import './variant-resetter.scss';
import register from 'ShopUi/app/registry';
export default register(
    'variant-resetter',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "variant-resetter" */
            './variant-resetter'
        ),
);
