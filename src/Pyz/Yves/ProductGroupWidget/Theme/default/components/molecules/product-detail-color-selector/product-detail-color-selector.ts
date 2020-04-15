import ProductDetailColorSelectorCore from 'ProductGroupWidget/components/molecules/product-detail-color-selector/product-detail-color-selector';
import ImageGallery from 'ProductImageWidgetProject/components/molecules/image-gallery/image-gallery';

export default class ProductDetailColorSelector extends ProductDetailColorSelectorCore {
    protected imageGallery: ImageGallery;

    protected init(): void {
        super.init();

        this.imageGallery = <ImageGallery>document.getElementsByClassName(this.imageCarouselClassName)[0];
    }

    protected onTriggerSelection(event: Event): void {
        event.preventDefault();
        this.currentSelection = <HTMLElement>event.currentTarget;
        this.resetActiveItemSelections();
        this.setActiveItemSelection();
        this.imageGallery.slideImageUrl = this.imageUrl;
    }

    protected onTriggerUnselection(): void {
        const firstTriggerElement = <HTMLElement>this.triggers[0];
        this.resetActiveItemSelections();
        this.setActiveItemSelection(firstTriggerElement);
        this.imageGallery.restoreDefaultImageUrl();
    }
}
