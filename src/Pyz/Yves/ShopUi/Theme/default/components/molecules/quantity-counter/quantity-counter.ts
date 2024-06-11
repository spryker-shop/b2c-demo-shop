import FormattedNumberInput from 'ShopUi/components/molecules/formatted-number-input/formatted-number-input';
import Component from 'ShopUi/models/component';

export default class QuantityCounter extends Component {
    protected quantityInput: HTMLInputElement;
    protected decrButton: HTMLButtonElement;
    protected incrButton: HTMLButtonElement;
    protected value: number;
    protected duration = 1000;
    protected timeout = 0;
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
        this.decrButton.addEventListener('click', (event) => this.onChangeQuantity(event, 'decrease'));
        this.incrButton.addEventListener('click', (event) => this.onChangeQuantity(event, 'increase'));
        this.quantityInput?.addEventListener('keydown', (event: KeyboardEvent) => this.onKeyDown(event));

        if (this.autoUpdate) {
            this.quantityInput.addEventListener('change', () => this.delayToSubmit());
        }
    }

    protected onChangeQuantity(event: Event, type: 'decrease' | 'increase'): void {
        event.preventDefault();

        if (this.isDisabled) {
            return;
        }

        const value = this.formattedNumberInput.unformattedValue;
        const isDecrease = value > this.minQuantity && type === 'decrease';
        const isIncrease = value < this.maxQuantity && type === 'increase';
        const shouldUpdate = isDecrease || isIncrease;

        if (!shouldUpdate) {
            return;
        }

        this.quantityInput.value = (isDecrease ? value - 1 : isIncrease ? value + 1 : value).toString();

        if (this.isAjaxMode) {
            this.delayToSubmit(true);

            return;
        }

        this.quantityInput.dispatchEvent(new Event('change'));
        this.quantityInput.dispatchEvent(new Event('input'));
    }

    protected delayToSubmit(triggerInput = false): void {
        clearTimeout(this.timeout);
        this.timeout = window.setTimeout(() => {
            if (this.value === this.getValue) {
                return;
            }

            if (this.isAjaxMode && triggerInput) {
                this.quantityInput.dispatchEvent(new Event('input', { bubbles: true }));
                this.quantityInput.dispatchEvent(new Event('change', { bubbles: true }));
                return;
            }

            if (!this.isAjaxMode) {
                this.quantityInput.form.submit();
            }
        }, this.duration);
    }

    protected onKeyDown(event: KeyboardEvent): void {
        if (event.key === 'Enter') {
            event.preventDefault();
        }
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

    protected get isAjaxMode(): boolean {
        return !!this.quantityInput.getAttribute('data-ajax-mode');
    }
}
