import './suggest-search.scss';
import register from 'ShopUi/app/registry';
export default register('suggest-search', () => import(/* webpackMode: "eager" */'./suggest-search-extended'));
