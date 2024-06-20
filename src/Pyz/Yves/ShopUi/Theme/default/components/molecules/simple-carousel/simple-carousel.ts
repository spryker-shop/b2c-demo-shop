import SimpleCarousel from 'ShopUi/components/molecules/simple-carousel/simple-carousel';

export default class SimpleCarouselExtended extends SimpleCarousel {
    slide(): void {
        console.log(`Showing view number ${this.viewCurrentIndex + 1}/${this.viewsCount}!`);

        super.slide();

        // If we've reached the last image, prevent automatic transfer to the 1st one
        if (this.viewCurrentIndex + 1 === this.viewsCount) {
            this.viewCurrentIndex = this.viewCurrentIndex -1;
        }
    }
}
