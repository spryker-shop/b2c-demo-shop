import register from 'ShopUi/app/registry';
export default register(
    'language-switcher',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "language-switcher" */
            './language-switcher'
        ),
);
