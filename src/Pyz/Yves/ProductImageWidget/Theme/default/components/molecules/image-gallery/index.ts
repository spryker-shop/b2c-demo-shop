import './image-gallery.scss';
import register from 'ShopUi/app/registry';
export default register(
    'image-gallery',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "image-gallery" */
            './image-gallery'
        ),
);
