import './style';
import register from '../../../app/registry';
export default register('suggest-search', () => import(/* webpackMode: "eager" */'./suggest-search'));