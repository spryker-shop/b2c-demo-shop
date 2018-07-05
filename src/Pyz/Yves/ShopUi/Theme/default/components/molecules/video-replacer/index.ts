import register from 'ShopUi/app/registry';
export default register('video-replacer', () => import(/* webpackMode: "lazy" */'./video-replacer'));
