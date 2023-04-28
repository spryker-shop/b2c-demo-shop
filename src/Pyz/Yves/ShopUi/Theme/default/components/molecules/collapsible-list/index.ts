import './collapsible-list.scss';
import register from 'ShopUi/app/registry';
export default register(
    'collapsible-list',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "collapsible-list" */
            'ShopUi/components/molecules/collapsible-list/collapsible-list'
        ),
);
