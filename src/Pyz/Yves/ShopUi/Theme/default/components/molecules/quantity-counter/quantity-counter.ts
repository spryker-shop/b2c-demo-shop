import Component from 'ShopUi/models/component';

export default class QuantityCounter extends Component {
    quantityInput: HTMLInputElement;
    decrButton: HTMLButtonElement;
    incrButton: HTMLButtonElement;
    form: HTMLFormElement;

    protected readyCallback(): void {
        this.quantityInput = <HTMLInputElement>this.querySelector(`.${this.jsName}__input`);
        this.decrButton = <HTMLButtonElement>this.querySelector(`.${this.jsName}__decr`);
        this.incrButton = <HTMLButtonElement>this.querySelector(`.${this.jsName}__incr`);
        this.form = <HTMLFormElement>document.querySelector(`.${this.jsName}__form`);

        this.mapEvents();
        this.setMaxQuantityToInfinity();
    }

    protected mapEvents(): void {
        this.quantityInput.addEventListener('change', () => this.autoUpdateOnChange());
        this.decrButton.addEventListener('click', () => this.onDecrButtonClick());
        this.incrButton.addEventListener('click', () => this.onIncrButtonClick());
    }

    protected onDecrButtonClick(): void {
        let value: number = +this.quantityInput.value;

        if(value > +this.minQuantity) {
            this.quantityInput.value = (value - 1).toString();

            this.autoUpdateOnChange();
        }
    }

    protected onIncrButtonClick(): void {
        let value: number = +this.quantityInput.value;

        if(value < +this.maxQuantity) {
            this.quantityInput.value = (value + 1).toString();

            this.autoUpdateOnChange();
        }
    }

    protected autoUpdateOnChange(): void {
        if(this.autoUpdate) {
            this.timer(this.form);
        }
    }

    protected timer(form: HTMLFormElement): void {
        let timeout = null;
        clearTimeout(timeout);
        timeout = setTimeout(() => form.submit(), 1000);
    }

    protected setMaxQuantityToInfinity(): void {
        if(!this.maxQuantity) {
            this.quantityInput.setAttribute('data-max-quantity', 'Infinity');
        }
    }

    get maxQuantity(): string {
        return this.quantityInput.getAttribute('data-max-quantity');
    }

    get minQuantity(): string {
        return this.quantityInput.getAttribute('data-min-quantity');
    }

    get autoUpdate(): string {
        return this.quantityInput.getAttribute('data-auto-update');
    }
}
