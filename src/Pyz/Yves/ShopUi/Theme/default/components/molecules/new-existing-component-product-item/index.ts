import register from 'ShopUi/app/registry';

export default register(
    'new-existing-component-product-item',
    () => {
        return import(/* webpackMode: "eager" */'./new-existing-component-product-item');
    }
);
