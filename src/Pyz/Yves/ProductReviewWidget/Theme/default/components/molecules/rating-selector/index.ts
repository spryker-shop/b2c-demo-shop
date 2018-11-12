import './rating-selector.scss';
import register from 'ShopUi/app/registry';
export default register('rating-selector', () => import(/* webpackMode: "lazy" */'SprykerShop/product-review-widget/src/SprykerShop/Yves/ProductReviewWidget/Theme/default/components/molecules/rating-selector/rating-selector'));
