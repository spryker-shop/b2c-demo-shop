import './node-animator.scss';
import register from 'ShopUi/app/registry';
export default register(
    'node-animator',
    () => import(/* webpackMode: "lazy" */'./node-animator')
);
