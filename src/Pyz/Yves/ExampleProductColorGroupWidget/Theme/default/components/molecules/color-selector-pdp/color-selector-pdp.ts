import Component from 'ShopUi/models/component';

export default class ColorSelectorPdp extends Component {
    colors: HTMLAnchorElement[]
    images: HTMLImageElement[]

    protected readyCallback(): void {
        this.colors = <HTMLAnchorElement[]>Array.from(this.getElementsByClassName(`${this.jsName}__color`));
        this.images = <HTMLImageElement[]>Array.from(document.querySelectorAll(this.targetImageSelector));
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.colors.forEach((color: HTMLAnchorElement, i: Number) => {
            if (i !== 0) {
                color.addEventListener('mouseenter', (event: Event) => this.onColorSelection(event));
                color.addEventListener('mouseout', (event: Event) => this.onColorUnselection(event));
            }
        });
    }

    protected onColorSelection(event: Event): void {
        event.preventDefault();
        const color = <HTMLAnchorElement>event.currentTarget;
        const imageSrc = color.getAttribute('data-image-src');
        this.changeActiveColor(color);
        this.changeImage(imageSrc);
    }

    changeActiveColor(newColor: HTMLAnchorElement): void {
        this.colors.forEach((color: HTMLAnchorElement) => {
            color.classList.remove(`${this.name}__color--active`);
        });

        newColor.classList.add(`${this.name}__color--active`);
    }

    changeImage(newImageSrc: string): void {
        this.images.forEach((image: HTMLImageElement) => {
            const imgWrapper = <HTMLElement>image.parentNode;
            if (image.src !== newImageSrc) {
                image.src = newImageSrc;
                imgWrapper.classList.add('pdp-img-color-active');
            }
        });
    }

    protected onColorUnselection(event: Event): void {
        event.preventDefault();
        this.removeActiveColor();
        this.removeImage();
    }

    removeActiveColor(): void {
        this.colors.forEach((color: HTMLAnchorElement) => {
            color.classList.remove(`${this.name}__color--active`);
        });

        this.colors[0].classList.add(`${this.name}__color--active`);
    }

    removeImage(): void {
        this.images.forEach((image: HTMLImageElement) => {
            const imgWrapper = <HTMLElement>image.parentNode;
            imgWrapper.classList.remove('pdp-img-color-active');
        });
    }

    get targetImageSelector(): string {
        return this.getAttribute('target-image-selector');
    }
}
