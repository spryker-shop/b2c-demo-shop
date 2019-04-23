import './toggler-radio.scss';
import register from 'ShopUi/app/registry';
export default register('toggler-radio', () => import(/* webpackMode: "lazy" */'./toggler-radio-extended'));
