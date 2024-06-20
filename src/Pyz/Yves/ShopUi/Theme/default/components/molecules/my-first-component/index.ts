import './my-first-component.scss';
import register from 'ShopUi/app/registry';
export default register(
    'my-first-component',
    () => import(/* webpackMode: "lazy" */'./my-first-component')
);
