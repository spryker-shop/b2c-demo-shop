import ProductItemColorSelectorCore from 'ProductGroupWidget/components/molecules/product-item-color-selector/product-item-color-selector';
import ProductItem, { ProductItemData } from 'ShopUiProject/components/molecules/product-item/product-item';

export default class ProductItemColorSelector extends ProductItemColorSelectorCore {
    protected productItemData: ProductItemData;
    protected productItem: ProductItem;

    protected getProductItemData(): void {
        super.getProductItemData();
        this.productItemData.reviewCount = this.reviewCount;
        this.productItemData.formAddToCartAction = this.formAddToCartAction;
    }

    protected get reviewCount(): number {
        return Number(this.currentSelection.getAttribute('data-product-review-count'));
    }

    protected get formAddToCartAction(): string {
        return this.currentSelection.getAttribute('data-product-add-to-cart-url');
    }
}
