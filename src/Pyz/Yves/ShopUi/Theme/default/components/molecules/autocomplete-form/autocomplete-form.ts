import AutocompleteFormCore from 'ShopUi/components/molecules/autocomplete-form/autocomplete-form';
import AjaxProvider from 'ShopUi/components/molecules/ajax-provider/ajax-provider';

export default class AutocompleteForm extends AutocompleteFormCore {
    protected parentWrap: HTMLElement;

    protected readyCallback(): void {}

    protected init(): void {
        if (this.parentWrapClassName){
            this.parentWrap = <HTMLElement>document.getElementsByClassName(`${this.parentWrapClassName}`)[0];
        }

        this.textInput = <HTMLInputElement>this.getElementsByClassName(`${this.jsName}__input`)[0];

        if (this.textInput) {
            this.ajaxProvider = <AjaxProvider>this.getElementsByClassName(`${this.jsName}__provider`)[0];
            this.valueInput = <HTMLInputElement>this.getElementsByClassName(`${this.jsName}__input-hidden`)[0];
            this.suggestionsContainer = <HTMLElement>this.getElementsByClassName(`${this.jsName}__suggestions`)[0];
            this.cleanButton = <HTMLButtonElement>this.getElementsByClassName(`${this.jsName}__clean-button`)[0];
            this.mapEvents();
        }

        if (!this.textInput) {
            super.readyCallback();
        }
    }

    protected onBlur(): void {
        super.onBlur();
        if (this.parentWrapClassName) {
            this.hideOverlay();
        }
    }

    protected onFocus(): void {
        if (this.parentWrapClassName) {
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

    protected get parentWrapClassName(): string {
        return this.getAttribute('parent-wrap-class-name');
    }
}
