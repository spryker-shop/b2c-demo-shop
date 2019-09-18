import Component from 'ShopUi/models/component';

export default class VariantResetter extends Component {
    protected trigger: HTMLElement;
    protected target: HTMLInputElement;

    protected readyCallback(): void {}

    protected init(): void {
        this.trigger = <HTMLElement>this.getElementsByClassName(`${this.jsName}__trigger`)[0];
        this.target = <HTMLInputElement>this.getElementsByClassName(`${this.jsName}__target`)[0];

        this.mapEvents();
    }

    protected mapEvents(): void {
        this.trigger.addEventListener('click', (event: Event) => this.onClick(event));
    }

    protected onClick(event: Event): void {
        event.preventDefault();
        this.target.value = '';
        this.target.closest('form').submit();
    }
}
