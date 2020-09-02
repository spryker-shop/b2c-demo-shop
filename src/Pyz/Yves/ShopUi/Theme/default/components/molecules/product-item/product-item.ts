import ProductItemCore, { ProductItemData as ProductItemDataCore } from 'ShopUi/components/molecules/product-item/product-item';

export const EVENT_UPDATE_REVIEW_COUNT = 'updateReviewCount';

export interface ProductItemData extends ProductItemDataCore {
    reviewCount: number;
}

export default class ProductItem extends ProductItemCore {
    protected productReviewCount: HTMLElement;

    protected init(): void {
        this.productReviewCount = <HTMLElement>this.getElementsByClassName(`${this.jsName}__review-count`)[0];

        super.init();
    }

    updateProductItemData(data: ProductItemData): void {
        super.updateProductItemData(data);
        this.reviewCount = data.reviewCount;
    }

    protected set reviewCount(reviewCount: number) {
        this.dispatchCustomEvent(EVENT_UPDATE_REVIEW_COUNT, {reviewCount});
    }
}
