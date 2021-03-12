import './toggler-accordion.scss';
import register from 'ShopUi/app/registry';
export default register(
    'toggler-accordion',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "toggler-accordion" */
            './toggler-accordion'
        ),
);
