import './toggler-radio.scss';
import register from 'ShopUi/app/registry';
export default register('toggler-radio', () => import(/* webpackMode: "lazy" */'ShopUi/components/molecules/toggler-radio/toggler-radio'));
