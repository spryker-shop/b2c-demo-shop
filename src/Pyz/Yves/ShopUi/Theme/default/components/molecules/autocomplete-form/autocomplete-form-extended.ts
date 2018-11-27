import AutocompleteForm from 'ShopUi/components/molecules/autocomplete-form/autocomplete-form';

export default class AutocompleteFormExtended extends AutocompleteForm {
    parentWrap: HTMLElement;

    protected readyCallback(): void {
        if (this.wrapSelector){
            this.parentWrap = <HTMLElement> document.querySelector(`.${this.wrapSelector}`);
        }
        super.readyCallback();
    }

    protected onBlur(): void {
        super.onBlur();
        if (this.wrapSelector) {
            this.hideOverlay();
        }
    }

    protected onFocus(): void {
        if (this.wrapSelector) {
            this.showOverlay();
        }
        super.onFocus();
    }

    protected showOverlay(): void {
        this.parentWrap.classList.add('active');
    }

    protected hideOverlay(): void {
        this.parentWrap.classList.remove('active');
    }

    get wrapSelector(): string {
        return this.getAttribute('parent-wrap-selector');
    }
}
