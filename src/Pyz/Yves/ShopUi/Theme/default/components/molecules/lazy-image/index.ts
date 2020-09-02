import './lazy-image.scss';
import register from 'ShopUi/app/registry';
export default register('lazy-image', () => import(/* webpackMode: "eager" */'ShopUi/components/molecules/lazy-image/lazy-image'));
