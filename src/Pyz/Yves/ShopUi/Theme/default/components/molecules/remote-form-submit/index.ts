import register from 'ShopUi/app/registry';
export default register('remote-form-submit', () => import(/* webpackMode: "lazy" */'./remote-form-submit'));
