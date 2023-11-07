import './main-popup.scss';
import register from 'ShopUi/app/registry';
export default register(
    'main-popup',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "main-popup" */
            'ShopUi/components/molecules/main-popup/main-popup'
        ),
);
