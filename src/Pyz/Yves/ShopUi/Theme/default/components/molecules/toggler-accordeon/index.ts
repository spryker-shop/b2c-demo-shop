import './style';
import register from 'ShopUi/app/registry';
export default register('toggler-accordeon', () => import(/* webpackMode: "lazy" */'./toggler-accordeon'));
