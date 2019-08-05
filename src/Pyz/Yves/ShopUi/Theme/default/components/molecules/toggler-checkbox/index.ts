import './toggler-checkbox.scss';
import register from 'ShopUi/app/registry';
export default register('toggler-checkbox', () => import(/* webpackMode: "lazy" */'ShopUi/components/molecules/toggler-checkbox/toggler-checkbox'));
