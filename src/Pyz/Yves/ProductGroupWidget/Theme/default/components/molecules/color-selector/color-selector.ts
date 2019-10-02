import Component from 'ShopUi/models/component';

export default class ColorSelector extends Component {
    protected colors: HTMLAnchorElement[];
    protected image: HTMLImageElement;
    protected link: HTMLAnchorElement;

    protected readyCallback(): void {}

    protected init(): void {
        this.colors = <HTMLAnchorElement[]>Array.from(this.getElementsByClassName(`${this.jsName}__color`));
        this.link = <HTMLAnchorElement>document.getElementsByClassName(this.targetLinkClassName)[0];
        this.image = <HTMLImageElement>this.link.getElementsByTagName('img')[0];
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
        if (this.image.src !== newImageSrc) {
            this.image.src = newImageSrc;
        }
    }

    changeProductUrl(url: string): void {
        if (this.link.getAttribute('href') !== url) {
            this.link.setAttribute('href', url);
        }
    }

    protected get targetLinkClassName(): string {
        return this.getAttribute('target-link-class-name');
    }
}
