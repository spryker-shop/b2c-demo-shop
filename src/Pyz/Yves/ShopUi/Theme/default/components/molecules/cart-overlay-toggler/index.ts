import register from 'ShopUi/app/registry';
export default register('cart-overlay-toggler', () => import(/* webpackMode: "lazy" */'./cart-overlay-toggler'));
