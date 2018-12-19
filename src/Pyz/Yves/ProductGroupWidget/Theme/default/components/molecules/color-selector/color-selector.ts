import Component from 'ShopUi/models/component';

export default class ColorSelector extends Component {
    colors: HTMLAnchorElement[]
    images: HTMLImageElement[]
    links: HTMLElement[]

    protected readyCallback(): void {
        this.colors = <HTMLAnchorElement[]>Array.from(this.getElementsByClassName(`${this.jsName}__color`));
        this.links = <HTMLElement[]>Array.from(document.querySelectorAll(this.targetLinkSelector));
        this.images = <HTMLImageElement[]>Array.from(document.querySelectorAll(`${this.targetLinkSelector} img`));
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.colors.forEach((color: HTMLAnchorElement) => {
            color.addEventListener('mouseenter', (event: Event) => this.onColorSelection(event));
        });
    }

    protected onColorSelection(event: Event): void {
        event.preventDefault();
        const color = <HTMLAnchorElement>event.currentTarget;
        const imageSrc = color.getAttribute('data-image-src');
        const productUrl = color.getAttribute('href');
        this.changeActiveColor(color);
        this.changeImage(imageSrc);
        this.changeProductUrl(productUrl);
    }

    changeActiveColor(newColor: HTMLAnchorElement): void {
        this.colors.forEach((color: HTMLAnchorElement) => {
            color.classList.remove(`${this.name}__color--active`);
        });

        newColor.classList.add(`${this.name}__color--active`);
    }

    changeImage(newImageSrc: string): void {
        this.images.forEach((image: HTMLImageElement) => {
            console.log(newImageSrc);
            if (image.src !== newImageSrc) {
                image.src = newImageSrc;
            }
        });
    }

    changeProductUrl(url: string): void {
        this.links.forEach((link: HTMLElement) => {
            if (link.getAttribute('href') !== url) {
                link.setAttribute('href', url);
            }
        });
    }

    get targetLinkSelector(): string {
        return this.getAttribute('target-image-selector');
    }
}
