import register from 'ShopUi/app/registry';
export default register('window-location-applicator', () => import(/* webpackMode: "lazy" */'./window-location-applicator'));
