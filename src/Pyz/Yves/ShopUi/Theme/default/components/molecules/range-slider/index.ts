import './range-slider.scss';
import register from 'ShopUi/app/registry';
export default register(
    'range-slider',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "range-slider" */
            './range-slider'
        ),
);
