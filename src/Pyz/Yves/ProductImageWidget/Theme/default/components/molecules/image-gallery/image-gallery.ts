import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';
import 'slick-carousel';

export default class ImageGallery extends Component {
    readonly galleryItems: HTMLElement[]
    readonly quantityImages: number
    readonly thumbnailSlider: $


    constructor() {
        super();
        this.galleryItems = <HTMLElement[]>Array.from(this.querySelectorAll(`.${this.jsName}-item`));
        this.quantityImages = this.galleryItems.length;
        this.thumbnailSlider = $(`.${this.jsName}-thumbnail`);
    }

    readyCallback(): void {
        this.initializationSlider();
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.thumbnailSlider.on('mouseenter', '.slick-slide', (event: Event) => this.onThumbnailHover(event));
        this.thumbnailSlider.on('afterChange', (event: Event, slider: $) => this.onAfterChange(event, slider));
    }

    protected initializationSlider(): void {
        if(this.quantityImages > 1) {
            this.thumbnailSlider.slick(
                this.thumbnailSliderConfig
            );
        }
    }

    protected onThumbnailHover(event: Event): void {
        let slide = $(event.currentTarget),
            index = slide.data('slick-index');
        if(!slide.hasClass('slick-current')) {
            this.thumbnailSlider.find('.slick-slide').removeClass('slick-current');
            slide.addClass('slick-current');
            this.changeImage(index);
        }
    }

    protected onAfterChange(event: Event, slider: $): void {
        let index = slider.currentSlide;
        this.changeImage(index);
    }

    protected changeImage(activeItemIndex: number): void {
        this.galleryItems.forEach((galleryItem, index) => {
            if(galleryItem.classList.contains(this.activeClass) && activeItemIndex !== index){
                galleryItem.classList.remove(this.activeClass);
            }
            if(activeItemIndex === index) {
                galleryItem.classList.add(this.activeClass);
            }
        });
    }

    get activeClass(): string {
        return this.getAttribute('active-class');
    }

    get thumbnailSliderConfig(): object {
        return JSON.parse(this.getAttribute('slider-config'));
    }
}
