import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';
import 'slick-carousel';

export default class ImageGallery extends Component {
    readonly galleryItems: HTMLElement[];
    readonly thumbnail: HTMLElement;
    readonly thumbnailItems: HTMLElement[];

    constructor() {
        super();
        this.galleryItems = <HTMLElement[]>Array.from(this.querySelectorAll(`.${this.jsName}__item`));
        this.thumbnail = this.querySelector(`.${this.jsName}-thumbnail`);
        this.thumbnailItems = <HTMLElement[]>Array.from(this.querySelectorAll(`.${this.jsName}-thumbnail__item`));
    }

    protected readyCallback(): void {
        this.initSlider();
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.thumbnail.addEventListener('mouseenter', (event: Event) => this.onThumbnailHover(event), true);
    }

    protected initSlider(): void {
        let imagesQuantity = this.galleryItems.length;
        if(imagesQuantity > 1) {
            $(this.thumbnail).slick(this.thumbnailSliderConfig);
        }
    }

    protected onThumbnailHover(event: Event): void {
        const thumbnail = <HTMLElement> event.target;
        if(thumbnail.classList.contains(`${this.jsName}-thumbnail__item`)) {
           this.thumbnailChange(thumbnail);
        }
    }

    protected thumbnailChange(thumbnail: HTMLElement): void {
        const index = Number(thumbnail.dataset.thumbnailIndex);
        if(!thumbnail.classList.contains(this.thumbnailActiveClass)) {
            this.thumbnailItems.forEach((thumbnailItem) => thumbnailItem.classList.remove(this.thumbnailActiveClass));
            thumbnail.classList.add(this.thumbnailActiveClass);
            this.setActiveImage(index);
        }
    }

    public setActiveImage(activeItemIndex: number): void {
        this.galleryItems.forEach((galleryItem) => {
            galleryItem.classList.remove(this.activeClass);
        });
        this.galleryItems[activeItemIndex].classList.add(this.activeClass);
    }

    get activeClass(): string {
        return this.getAttribute('active-class');
    }

    get thumbnailSliderConfig(): object {
        return JSON.parse(this.getAttribute('slider-config'));
    }

    get thumbnailActiveClass(): string {
        return this.getAttribute('thumbnail-active-class');
    }
}
