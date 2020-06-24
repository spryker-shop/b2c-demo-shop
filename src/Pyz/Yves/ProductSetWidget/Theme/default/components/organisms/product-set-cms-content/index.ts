import './product-set-cms-content.scss';
import register from 'ShopUi/app/registry';
export default register('product-set-cms-content', () => import(
    /* webpackMode: "lazy" */'ProductSetWidget/components/organisms/product-set-cms-content/product-set-cms-content'
));
