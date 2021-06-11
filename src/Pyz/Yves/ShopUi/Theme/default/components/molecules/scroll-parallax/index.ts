import register from 'ShopUi/app/registry';
export default register(
    'scroll-parallax',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "scroll-parallax" */
            './scroll-parallax'
        ),
);
