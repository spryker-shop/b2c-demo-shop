import './style';
import register from 'ShopUi/app/registry';
export default register('ajax-loader', () => import(/* webpackMode: "eager" */'./ajax-loader'));
