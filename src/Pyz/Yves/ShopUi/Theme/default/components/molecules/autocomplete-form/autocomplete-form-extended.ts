import AutocompleteForm from 'ShopUi/components/molecules/autocomplete-form/autocomplete-form';
import AjaxProvider from 'ShopUi/components/molecules/ajax-provider/ajax-provider';

export default class AutocompleteFormExtended extends AutocompleteForm {
    parentWrap: HTMLElement;

    protected readyCallback(): void {
        if (this.wrapSelector){
            this.parentWrap = <HTMLElement> document.querySelector(`.${this.wrapSelector}`);
        }
        this.textInput = <HTMLInputElement>this.querySelector(`.${this.jsName}__input`);
        if (this.textInput) {
            this.ajaxProvider = <AjaxProvider>this.querySelector(`.${this.jsName}__provider`);
            this.valueInput = <HTMLInputElement>this.querySelector(`.${this.jsName}__input-hidden`);
            this.suggestionsContainer = <HTMLElement>this.querySelector(`.${this.jsName}__container`);
            this.cleanButton = <HTMLButtonElement>this.querySelector(`.${this.jsName}__clean-button`);
            this.mapEvents();
        } else super.readyCallback();
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
