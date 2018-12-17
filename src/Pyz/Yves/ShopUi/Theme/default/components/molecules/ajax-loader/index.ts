import './ajax-loader.scss';
import register from 'ShopUi/app/registry';
export default register('ajax-loader', () => import(/* webpackMode: "eager" */'ShopUi/components/molecules/ajax-loader/ajax-loader'));
