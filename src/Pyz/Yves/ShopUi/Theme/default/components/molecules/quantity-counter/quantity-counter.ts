import Component from 'ShopUi/models/component';

export default class QuantityCounter extends Component {
    quantityInput: HTMLInputElement;
    decrButton: HTMLButtonElement;
    incrButton: HTMLButtonElement;
    value: number;

    protected readyCallback(): void {
        this.quantityInput = <HTMLInputElement>this.querySelector(`.${this.jsName}__input`);
        this.decrButton = <HTMLButtonElement>this.querySelector(`.${this.jsName}__decr`);
        this.incrButton = <HTMLButtonElement>this.querySelector(`.${this.jsName}__incr`);
        this.value = this.getValue;

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

        if(value > this.minQuantity) {
            this.quantityInput.value = (value - 1).toString();

            this.autoUpdateOnChange();
        }
    }

    protected onIncrButtonClick(): void {
        let value: number = +this.quantityInput.value;

        if(value < this.maxQuantity) {
            this.quantityInput.value = (value + 1).toString();

            this.autoUpdateOnChange();
        }
    }

    protected autoUpdateOnChange(): void {
        if(this.autoUpdate) {
            this.timer();
        }
    }

    protected timer(): void {
        let timeout = null;
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            if(this.value !== this.getValue) {
                this.quantityInput.form.submit();
            }
        }, 1000);
    }

    protected setMaxQuantityToInfinity(): void {
        if(!this.maxQuantity) {
            this.quantityInput.setAttribute('data-max-quantity', 'Infinity');
        }
    }

    get maxQuantity(): number {
        return +this.quantityInput.getAttribute('data-max-quantity');
    }

    get minQuantity(): number {
        return +this.quantityInput.getAttribute('data-min-quantity');
    }

    get autoUpdate(): string {
        return this.quantityInput.getAttribute('data-auto-update');
    }

    get getValue(): number {
        return +this.quantityInput.value;
    }
}
