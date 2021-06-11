import register from 'ShopUi/app/registry';
export default register(
    'window-location-applicator',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "window-location-applicator" */
            './window-location-applicator'
        ),
);
