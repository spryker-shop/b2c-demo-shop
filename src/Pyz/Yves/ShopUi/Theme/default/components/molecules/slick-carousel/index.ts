import 'slick-carousel/slick/slick.scss';
import register from 'ShopUi/app/registry';
export default register('slick-carousel', () => import(/* webpackMode: "lazy" */'./slick-carousel'));
