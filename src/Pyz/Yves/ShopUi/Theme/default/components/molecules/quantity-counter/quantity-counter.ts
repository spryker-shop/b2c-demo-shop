import FormattedNumberInput from 'ShopUi/components/molecules/formatted-number-input/formatted-number-input';
import Component from 'ShopUi/models/component';

type RepeatableEvent = CustomEvent<{ repeat: boolean }>;

export default class QuantityCounter extends Component {
    protected quantityInput: HTMLInputElement;
    protected decrButton: HTMLButtonElement;
    protected incrButton: HTMLButtonElement;
    protected value: number;
    protected duration = 1000;
    protected timeout = 0;
    protected repeatableEvent?: Event = null;
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
        this.decrButton.addEventListener('click', (event) => this.onChangeQuantity(event, 'decrease'));
        this.incrButton.addEventListener('click', (event) => this.onChangeQuantity(event, 'increase'));
    }

    protected onChangeQuantity(event: Event | RepeatableEvent, type: 'decrease' | 'increase'): void {
        if (this.isDisabled || (event as RepeatableEvent).detail.repeat) {
            return;
        }

        const value = this.formattedNumberInput.unformattedValue;
        const isDecrease = value > this.minQuantity && type === 'decrease';
        const isIncrease = value < this.maxQuantity && type === 'increase';
        this.quantityInput.value = (isDecrease ? value - 1 : isIncrease ? value + 1 : value).toString();

        if (isDecrease || isIncrease) {
            this.autoUpdateOnChange(event);
            this.quantityInput.dispatchEvent(new Event('input'));
            this.quantityInput.dispatchEvent(new Event('change'));
        }
    }

    protected autoUpdateOnChange(event?: Event): void {
        if (this.autoUpdate) {
            this.timer(event);
        }
    }

    protected timer(event?: Event): void {
        if (event) {
            event.stopPropagation();
            this.repeatableEvent = event;
        }

        clearTimeout(this.timeout);
        this.timeout = window.setTimeout(() => {
            const shouldUpdate = this.value !== this.getValue;

            if (shouldUpdate && this.isAjaxMode && this.repeatableEvent) {
                this.repeatableEvent.target.dispatchEvent(
                    new CustomEvent(this.repeatableEvent.type, {
                        bubbles: true,
                        detail: { repeat: true },
                    }),
                );
                this.repeatableEvent = null;
            }

            if (shouldUpdate && !this.isAjaxMode) {
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

    protected get isAjaxMode(): boolean {
        return !!this.quantityInput.getAttribute('data-ajax-mode');
    }
}
