import 'slick-carousel/slick/slick.scss';
import './style.scss';
import register from 'ShopUi/app/registry';
export default register('navigation-slider', () => import(/* webpackMode: "lazy" */'./navigation-slider'));