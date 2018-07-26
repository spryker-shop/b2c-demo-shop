import 'slick-carousel/slick/slick.scss';
import register from 'ShopUi/app/registry';
export default register('pdp-carousel', () => import(/* webpackMode: "lazy" */'./pdp-carousel'));
