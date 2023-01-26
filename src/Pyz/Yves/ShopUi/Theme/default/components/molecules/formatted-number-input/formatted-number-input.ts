import FormattedNumberInputCore from 'ShopUi/components/molecules/formatted-number-input/formatted-number-input';

export default class FormattedNumberInput extends FormattedNumberInputCore {
    protected hiddenInputChangeEvent: Event = new Event('change');

    protected updateHiddenInput(value: number = this.unformattedValue): void {
        super.updateHiddenInput(value);
        this.hiddenInput.dispatchEvent(this.hiddenInputChangeEvent);
    }
}
