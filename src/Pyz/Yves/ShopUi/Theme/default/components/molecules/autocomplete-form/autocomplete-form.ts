import Component from 'ShopUi//models/component';
import AjaxProvider from 'ShopUi/components/molecules/ajax-provider/ajax-provider';
import debounce from 'lodash-es/debounce';

export default class AutocompleteForm extends Component {
    ajaxProvider: AjaxProvider
    inputElement: HTMLInputElement;
    hiddenInputElement: HTMLInputElement;
    suggestionsContainer: HTMLElement;
    cleanButton: HTMLButtonElement;
    parentWrap: HTMLElement;

    protected readyCallback(): void {
        this.ajaxProvider = <AjaxProvider> this.querySelector(`.${this.jsName}__provider`);
        this.suggestionsContainer = <HTMLElement> this.querySelector(`.${this.jsName}__container`);
        this.inputElement = <HTMLInputElement>this.querySelector(`.${this.jsName}__input`);
        this.hiddenInputElement = <HTMLInputElement>this.querySelector(`.${this.jsName}__input-hidden`);
        this.cleanButton = <HTMLButtonElement>this.querySelector(`.${this.jsName}__clean-button`);
        if (this.wrapSelector){
            this.parentWrap = <HTMLElement> document.querySelector(`.${this.wrapSelector}`);
        }
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.inputElement.addEventListener('input', debounce(() => this.onInput(), this.debounceDelay));
        this.inputElement.addEventListener('blur', debounce(() => this.onBlur(), this.debounceDelay));
        this.inputElement.addEventListener('focus', () => this.onFocus());
        if (this.showCleanButton) {
            this.cleanButton.addEventListener('click', () => this.onCleanButtonClick());
        }
    }

    protected onCleanButtonClick(): void {
        this.cleanFields();
    }

    protected onBlur(): void {
        this.hideSuggestions();
        if (this.wrapSelector) {
            this.hideOverlay();
        }
    }

    protected onFocus(): void {
        if (this.wrapSelector) {
            this.showOverlay();
        }
        if (this.inputValue.length >= this.minLetters) {
            this.showSuggestions();
            return;
        }
    }

    protected onInput(): void {
        if (this.inputValue.length >= this.minLetters) {
            this.loadSuggestions();
            return;
        }
        this.hideSuggestions();
    }

    protected showSuggestions(): void {
        this.suggestionsContainer.classList.remove('is-hidden');
    }

    protected hideSuggestions(): void {
        this.suggestionsContainer.classList.add('is-hidden');
    }

    protected showOverlay(): void {
        this.parentWrap.classList.add('active');
    }

    protected hideOverlay(): void {
        this.parentWrap.classList.remove('active');
    }

    async loadSuggestions(): Promise<void> {
        this.showSuggestions();
        this.ajaxProvider.queryParams.set(this.queryParamName, this.inputValue);

        await this.ajaxProvider.fetch();
        this.mapItemEvents();
    }

    protected mapItemEvents(): void {
        const self = this;
        const items = Array.from(this.suggestionsContainer.querySelectorAll(this.itemSelector));
        items.forEach((item: HTMLElement) => item.addEventListener('click', (e: Event) => self.onItemClick(e)));
    }

    protected onItemClick(e: Event): void {
        const dataTarget = <HTMLElement>e.target;
        const textTarget = <HTMLElement>e.srcElement;
        const data = dataTarget.getAttribute(this.valueDataAttribute);
        const text = textTarget.textContent.trim();

        this.setInputs(data, text);
    }

    setInputs(data: string, text: string): void {
        this.inputElement.value = text;
        this.hiddenInputElement.value = data;
    }

    cleanFields(): void {
        this.setInputs('', '');
    }

    get minLetters(): number {
        return Number(this.getAttribute('min-letters'));
    }

    get inputValue(): string {
        return this.inputElement.value.trim();
    }

    get queryParamName(): string {
        return this.getAttribute('query-param-name');
    }

    get valueDataAttribute(): string {
        return this.getAttribute('value-data-attribute');
    }

    get itemSelector(): string {
        return this.getAttribute('item-selector');
    }

    get debounceDelay(): number {
        return Number(this.getAttribute('debounce-delay'));
    }
    get showCleanButton(): boolean {
        return this.hasAttribute('show-clean-button');
    }

    get wrapSelector(): string {
        return this.getAttribute('parent-wrap-selector');
    }
}
