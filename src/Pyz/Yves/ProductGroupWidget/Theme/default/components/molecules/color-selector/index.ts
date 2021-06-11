import './color-selector.scss';
import register from 'ShopUi/app/registry';
export default register(
    'color-selector',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "color-selector" */
            'ProductGroupWidget/components/molecules/color-selector/color-selector'
        ),
);
