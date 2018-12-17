import './volume-price.scss';
import register from 'ShopUi/app/registry';
export default register('volume-price', () => import(/* webpackMode: "eager" */'PriceProductVolumeWidget/components/molecules/volume-price/volume-price'));
