import register from 'ShopUi/app/registry';
export default register(
    'formatted-number-input',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "formatted-number-input" */
            'ShopUi/components/molecules/formatted-number-input/formatted-number-input'
        ),
);
