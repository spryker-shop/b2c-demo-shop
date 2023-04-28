import register from 'ShopUi/app/registry';
export default register(
    'page-load-state',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "page-load-state" */
            './page-load-state'
        ),
);
