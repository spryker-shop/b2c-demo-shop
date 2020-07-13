import ProductItemCore, { ProductItemData as ProductItemDataCore } from 'ShopUi/components/molecules/product-item/product-item';

export const EVENT_UPDATE_REVIEW_COUNT = 'updateReviewCount';
export const EVENT_UPDATE_AJAX_ADD_TO_CART_URL = 'updateAjaxAddToCartUrl';

export interface ProductItemData extends ProductItemDataCore {
    reviewCount: number;
    formAddToCartAction: string;
}

export default class ProductItem extends ProductItemCore {
    protected productReviewCount: HTMLElement;
    protected productFormAddToCart: HTMLFormElement;

    protected init(): void {
        this.productReviewCount = <HTMLElement>this.getElementsByClassName(`${this.jsName}__review-count`)[0];
        this.productFormAddToCart = <HTMLFormElement>this.getElementsByClassName(`${this.jsName}__form-add-to-cart`)[0];

        super.init();
    }

    updateProductItemData(data: ProductItemData): void {
        super.updateProductItemData(data);
        this.reviewCount = data.reviewCount;
        this.formAddToCartAction = data.formAddToCartAction;
    }

    protected set reviewCount(reviewCount: number) {
        this.dispatchCustomEvent(EVENT_UPDATE_REVIEW_COUNT, {reviewCount});
    }

    protected set formAddToCartAction(formAddToCartAction: string) {
        if (this.productFormAddToCart) {
            this.productFormAddToCart.action = formAddToCartAction;
        }
    }

    protected get formAddToCartAction(): string {
        if (this.productFormAddToCart) {
            return this.productFormAddToCart.action;
        }
    }

    set ajaxAddToCartUrl(ajaxAddToCartUrl: string) {
        if (this.productAjaxButtonAddToCart) {
            this.productAjaxButtonAddToCart.disabled = !ajaxAddToCartUrl;
            this.productAjaxButtonAddToCart.dataset.url = ajaxAddToCartUrl;
        }

        if (!ajaxAddToCartUrl) {
            return;
        }

        this.dispatchCustomEvent(EVENT_UPDATE_AJAX_ADD_TO_CART_URL, {sku: ajaxAddToCartUrl.split('/').pop()});
    }
}
