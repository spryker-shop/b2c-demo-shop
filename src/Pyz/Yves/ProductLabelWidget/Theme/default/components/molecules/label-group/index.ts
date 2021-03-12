import './label-group.scss';
import register from 'ShopUi/app/registry';
export default register(
    'label-group',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "label-group" */
            'ProductLabelWidget/components/molecules/label-group/label-group'
        ),
);
