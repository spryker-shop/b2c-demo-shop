import 'slick-carousel/slick/slick.scss';
import './image-gallery.scss';
import register from 'ShopUi/app/registry';
export default register('image-gallery', () => import(/* webpackMode: "lazy" */'./image-gallery'));
