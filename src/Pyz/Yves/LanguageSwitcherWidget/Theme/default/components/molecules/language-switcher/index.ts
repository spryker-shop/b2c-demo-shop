import register from 'ShopUi/app/registry';
export default register('language-switcher', () => import(/* webpackMode: "lazy" */'./language-switcher'));
