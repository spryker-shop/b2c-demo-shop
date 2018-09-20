import 'slick-carousel/slick/slick.scss';
import './slick-carousel.scss';
import register from 'ShopUi/app/registry';
export default register('slick-carousel', () => import(/* webpackMode: "lazy" */'./slick-carousel'));
