import Component from 'ShopUi/models/component';

export default class MyFirstComponent extends Component {
    protected counter: HTMLElement
    protected elements: HTMLElement[]

    protected readyCallback(): void {}
    protected init(): void {
        this.counter = <HTMLElement>document.querySelector(`.${this.jsName}__counter`);
        this.elements = <HTMLElement[]>Array.from(document.querySelectorAll(this.elementSelector));
        this.count();
    }

    count(): void {
        this.counter.innerText = `${this.elements.length}`;
    }

    get elementSelector(): string {
        return this.getAttribute('element-selector');
    }
}
