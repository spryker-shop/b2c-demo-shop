import register from 'ShopUi/app/registry';
export default register(
    'form-submitter',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "form-submitter" */
            './form-submitter'
        ),
);
