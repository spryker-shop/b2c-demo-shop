import Component from 'ShopUi/models/component';
import FormattedNumberInput from 'ShopUi/components/molecules/formatted-number-input/formatted-number-input';

export default class QuantityCounter extends Component {
    protected quantityInput: HTMLInputElement;
    protected decrButton: HTMLButtonElement;
    protected incrButton: HTMLButtonElement;
    protected value: number;
    protected duration = 1000;
    protected timeout = 0;
    protected inputEvent: Event = new Event('input');
    protected changeEvent: Event = new Event('change');
    protected formattedNumberInput: FormattedNumberInput;

    protected readyCallback(): void {}

    protected init(): void {
        this.quantityInput = <HTMLInputElement>this.getElementsByClassName(`${this.jsName}__input`)[0];
        this.decrButton = <HTMLButtonElement>this.getElementsByClassName(`${this.jsName}__decr`)[0];
        this.incrButton = <HTMLButtonElement>this.getElementsByClassName(`${this.jsName}__incr`)[0];
        this.formattedNumberInput = <FormattedNumberInput>(
            this.getElementsByClassName(`${this.jsName}__formatted-input`)[0]
        );
        this.value = this.getValue;

        this.mapEvents();
        this.setMaxQuantityToInfinity();
    }

    protected mapEvents(): void {
        this.quantityInput.addEventListener('change', () => this.autoUpdateOnChange());
        this.decrButton.addEventListener('click', () => this.onDecrementButtonClick());
        this.incrButton.addEventListener('click', () => this.onIncrementButtonClick());
    }

    protected onDecrementButtonClick(): void {
        if (this.isDisabled) {
            return;
        }

        const value = this.formattedNumberInput.unformattedValue;

        if (value > this.minQuantity) {
            this.quantityInput.value = (value - 1).toString();

            this.autoUpdateOnChange();
            this.triggerInputEvents();
        }
    }

    protected onIncrementButtonClick(): void {
        if (this.isDisabled) {
            return;
        }

        const value = this.formattedNumberInput.unformattedValue;

        if (value < this.maxQuantity) {
            this.quantityInput.value = (value + 1).toString();

            this.autoUpdateOnChange();
            this.triggerInputEvents();
        }
    }

    protected autoUpdateOnChange(): void {
        if (this.autoUpdate) {
            this.timer();
        }
    }

    protected triggerInputEvents(): void {
        this.quantityInput.dispatchEvent(this.inputEvent);
        this.quantityInput.dispatchEvent(this.changeEvent);
    }

    protected timer(): void {
        clearTimeout(this.timeout);
        this.timeout = window.setTimeout(() => {
            if (this.value !== this.getValue) {
                this.quantityInput.form.submit();
            }
        }, this.duration);
    }

    protected setMaxQuantityToInfinity(): void {
        if (!this.maxQuantity) {
            this.quantityInput.setAttribute('data-max-quantity', 'Infinity');
        }
    }

    protected get maxQuantity(): number {
        return +this.quantityInput.getAttribute('data-max-quantity');
    }

    protected get minQuantity(): number {
        return +this.quantityInput.getAttribute('data-min-quantity');
    }

    protected get autoUpdate(): boolean {
        return this.quantityInput.hasAttribute('data-auto-update');
    }

    protected get isDisabled(): boolean {
        return this.quantityInput.hasAttribute('disabled');
    }

    protected get getValue(): number {
        return this.formattedNumberInput.unformattedValue;
    }
}
