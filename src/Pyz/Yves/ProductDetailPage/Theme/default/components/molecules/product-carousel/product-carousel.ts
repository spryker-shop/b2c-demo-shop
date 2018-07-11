import Component from 'ShopUi/models/component';

export default class ProductCarousel extends Component {

    readonly targets: HTMLElement[]

    constructor() {
        super();
        // this.targets = <HTMLElement[]>Array.from(document.querySelectorAll(this.targetSelector));
    }

    protected readyCallback(): void {
        this.moveImage();
    }

    protected moveImage(): void {
        console.log(this.windowHeight);
    }

    get windowHeight(): number {
        return window.innerHeight;
    }

}
