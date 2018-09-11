import './style';
import register from 'ShopUi/app/registry';
export default register('autocomplete-form', () => import(/* webpackMode: "lazy" */'./autocomplete-form'));
