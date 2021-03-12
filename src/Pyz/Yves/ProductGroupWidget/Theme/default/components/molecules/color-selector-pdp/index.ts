import './color-selector-pdp.scss';
import register from 'ShopUi/app/registry';
export default register(
    'color-selector-pdp',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "color-selector-pdp" */
            './color-selector-pdp'
        ),
);
