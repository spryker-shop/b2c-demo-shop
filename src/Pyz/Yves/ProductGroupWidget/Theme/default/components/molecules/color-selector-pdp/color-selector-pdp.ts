import Component from 'ShopUi/models/component';

export default class ColorSelectorPdp extends Component {
    protected container: HTMLElement;
    protected colors: HTMLAnchorElement[];
    protected image: HTMLImageElement;

    protected readyCallback(): void {}

    protected init(): void {
        this.colors = <HTMLAnchorElement[]>Array.from(this.getElementsByClassName(`${this.jsName}__color`));
        this.container = <HTMLImageElement>document.getElementsByClassName(`${this.jsName}__image-container`)[0];
        this.image = <HTMLImageElement>this.container.getElementsByTagName('img')[0];

        this.mapEvents();
    }

    protected mapEvents(): void {
        this.colors.forEach((color: HTMLAnchorElement, index: number) => {
            if (index !== 0) {
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
        this.setActiveImage(imageSrc);
    }

    protected onColorUnselection(event: Event): void {
        event.preventDefault();
        this.changeActiveColor(this.colors[0]);
        this.resetActiveImage();
    }

    changeActiveColor(newColor: HTMLAnchorElement): void {
        this.colors.forEach((color: HTMLAnchorElement) => {
            color.classList.remove(`${this.name}__color--active`);
        });

        newColor.classList.add(`${this.name}__color--active`);
    }

    setActiveImage(newImageSrc: string): void {
        if (this.image.src === newImageSrc) {
            return;
        }

        this.image.src = newImageSrc;
        this.container.classList.add(`${this.container.classList[0]}--active`);
    }

    resetActiveImage(): void {
        this.container.classList.remove(`${this.container.classList[0]}--active`);
    }
}
