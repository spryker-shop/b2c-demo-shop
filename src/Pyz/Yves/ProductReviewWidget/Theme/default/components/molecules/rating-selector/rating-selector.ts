import RatingSelectorCore from 'ProductReviewWidget/components/molecules/rating-selector/rating-selector';
import { EVENT_UPDATE_REVIEW_COUNT } from 'ShopUiProject/components/molecules/product-item/product-item';

export default class RatingSelector extends RatingSelectorCore {
    protected reviewCount: HTMLElement;

    connectedCallback() {
        this.init();
    }

    protected init(): void {
        this.reviewCount = <HTMLElement>this.getElementsByClassName(`${this.jsName}__review-count`)[0];

        super.init();
    }

    protected mapUpdateRatingEvents(): void {
        super.mapUpdateRatingEvents();
        this.mapProductItemUpdateReviewCountCustomEvent();
    }

    protected mapProductItemUpdateReviewCountCustomEvent() {
        if (!this.productItem) {
            return;
        }

        this.productItem.addEventListener(EVENT_UPDATE_REVIEW_COUNT, (event: Event) => {
            this.updateReviewCount((<CustomEvent>event).detail.reviewCount);
        });
    }

    protected updateReviewCount(value: number): void {
        if (!this.reviewCount) {
            return;
        }

        this.reviewCount.innerText = `${value}`;
    }
}
