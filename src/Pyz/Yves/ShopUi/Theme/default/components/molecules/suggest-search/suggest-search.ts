import Component from 'ShopUi/models/component';
import AjaxProvider from 'ShopUi/components/molecules/ajax-provider/ajax-provider';
import debounce from 'lodash-es/debounce'
import throttle from 'lodash-es/throttle'

interface keyCodes {
    [keyCode: number]: string;
}

export default class SuggestSearch extends Component {
    readonly keyboardCodes: keyCodes

    searchInput: HTMLInputElement
    hintInput: HTMLInputElement
    suggestionsContainer: HTMLElement
    ajaxProvider: AjaxProvider
    currentSearchValue: string
    hint: string
    navigation: HTMLElement[]
    activeItemIndex: number
    navigationActiveClass: string
    searchOverlay: HTMLElement
    overlayCloseButton: HTMLElement
    overlayOpenButton: HTMLElement
    overlayMobOpenButton: HTMLElement
    bodyTrigger: HTMLElement


    constructor() {
        super();

        this.keyboardCodes = {
            9: 'tab',
            13: 'enter',
            37: 'arrowLeft',
            38: 'arrowUp',
            39: 'arrowRight',
            40: 'arrowDown'
        };
        this.activeItemIndex = 0;
    }

    protected readyCallback(): void {
        this.ajaxProvider = <AjaxProvider> this.querySelector(`.${this.jsName}__ajax-provider`);
        this.suggestionsContainer = <HTMLElement> this.querySelector(`.${this.jsName}__container`);
        this.searchInput = <HTMLInputElement> document.querySelector(this.searchInputSelector);
        this.navigationActiveClass = `${this.name}__item--active`;
        this.searchOverlay = <HTMLElement> document.querySelector('.js-toggle-search');
        this.overlayCloseButton = <HTMLElement> document.querySelector('.js-search-hide-icon');
        this.overlayOpenButton = <HTMLElement> document.querySelector('.js-search-show-icon');
        this.overlayMobOpenButton = <HTMLElement> document.querySelector('.js-search-mob-show-icon');
        this.bodyTrigger = <HTMLElement> document.querySelector('.js-search-hide-overlay');
        this.createHintInput();
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.searchInput.addEventListener('keyup', debounce((event: Event) => this.onInputKeyUp(event), this.debounceDelay));
        this.searchInput.addEventListener('keydown', throttle((event: Event) => this.onInputKeyDown(<KeyboardEvent> event), this.throttleDelay));
        // this.searchInput.addEventListener('blur', debounce((event: Event) => this.onInputFocusOut(event), this.debounceDelay));
        this.searchInput.addEventListener('focus', (event: Event) => this.onInputFocusIn(event));
        this.searchInput.addEventListener('click', (event: Event) => this.onInputClick(event));
        this.overlayCloseButton.addEventListener('click', (event: Event) => this.onInputFocusOut(event));
        this.overlayOpenButton.addEventListener('click', () => this.openSearchLayout());
        this.overlayMobOpenButton.addEventListener('click', () => this.openSearchLayout());
        this.bodyTrigger.addEventListener('click', (event: Event) => this.onInputFocusOut(event));
    }

    protected async onInputKeyUp(event: Event): Promise<void> {
        const suggestQuery = this.getSearchValue();

        if (suggestQuery != this.currentSearchValue && suggestQuery.length >= this.lettersTrashold) {
            this.saveCurrentSearchValue(suggestQuery);

            await this.getSuggestions();
        }

        this.saveCurrentSearchValue(suggestQuery);

        if (suggestQuery.length < this.lettersTrashold) {
            this.setHintValue('');
            this.hideSugestions();
        }
    }

    protected onInputKeyDown(event: KeyboardEvent): void {
        this.setHintValue('');
        var keyCode = event.keyCode;

        switch (this.keyboardCodes[keyCode]) {
            case 'enter': this.onEnter(event); break;
            case 'tab': this.onTab(event); break;
            case 'arrowUp': this.onArrowUp(event); break;
            case 'arrowDown': this.onArrowDown(event); break;
            case 'arrowLeft': this.onArrowLeft(event); break;
            case 'arrowRight': this.onArrowRight(event); break;
        }
    }

    protected onInputClick(event: Event): void {
        this.activeItemIndex = 0;
        if (this.isNavigationExist()) {
            this.updateNavigation();
            this.showSugestions();
        }
    }

    protected onTab(event: KeyboardEvent): boolean {
        this.searchInput.value = this.hint;
        event.preventDefault();
        return false;
    }

    protected onArrowUp(event: KeyboardEvent) {
        this.activeItemIndex = this.activeItemIndex > 0 ? this.activeItemIndex - 1 : 0;
        this.updateNavigation();
    }

    protected onArrowDown(event: KeyboardEvent) {
        this.activeItemIndex = this.activeItemIndex < this.navigation.length ? this.activeItemIndex + 1 : 0;
        this.updateNavigation();
    }

    protected onArrowLeft(event: KeyboardEvent) {
        this.activeItemIndex = 1;
        this.updateNavigation();
    }

    protected onArrowRight(event: KeyboardEvent): void {
        this.activeItemIndex = this.getFirstProductNavigationIndex() + 1;
        this.updateNavigation();
    }

    protected onEnter(event: KeyboardEvent): void {
        const activeItem = this.getActiveNavigationItem();
        if (activeItem) {
            this.getActiveNavigationItem().click();
            event.preventDefault();
        }
    }

    protected onInputFocusIn(event: Event): void {
        this.activeItemIndex = 0;
    }

    protected onInputFocusOut(event: Event): void {
        this.hideSugestions();
        this.searchOverlay.classList.toggle('active');
        this.cleanUpInput();
    }

    protected getActiveNavigationItem(): HTMLElement {
        if (this.isNavigationExist()) {
            return this.navigation[this.activeItemIndex - 1];
        }
    }

    protected getFirstProductNavigationIndex(): number {
        return this.navigation.findIndex((element: HTMLElement): boolean => {
            return element.classList.contains(`${this.jsName}__product-item--navigable`);
        });
    }

    protected getNavigation(): HTMLElement[] {
        return <HTMLElement[]> Array.from(this.getElementsByClassName(`${this.jsName}__item--navigable`))
    }

    protected updateNavigation(): void {
        if (this.isNavigationExist()) {
            this.navigation.forEach(element => {
                element.classList.remove(this.navigationActiveClass);
            });
            if (this.activeItemIndex > this.navigation.length) {
                this.activeItemIndex = 0;
                this.searchInput.focus();
                return;
            }
            if (this.activeItemIndex > 0) {
                this.navigation[this.activeItemIndex - 1].classList.add(this.navigationActiveClass);
            }
        }
    }

    protected isNavigationExist(): boolean {
        return (this.navigation && !!this.navigation.length);
    }

    protected getSearchValue(): string {
        return this.searchInput.value.trim();
    }

    protected async getSuggestions(): Promise<void> {
        const suggestQuery = this.getSearchValue();

        const urlParams = [['q', suggestQuery]];

        this.addUrlParams(urlParams);

        const response = await this.ajaxProvider.fetch(suggestQuery);

        let suggestions = JSON.parse(response).suggestion;
        this.suggestionsContainer.innerHTML = suggestions;

        this.hint = JSON.parse(response).completion;

        if (suggestions) {
            this.showSugestions();
        }

        if (this.hint) {
            this.updateHintInput();
        }

        if (this.hint == null) {
            this.setHintValue('');
        }

        this.navigation = this.getNavigation();

        this.updateNavigation();
    }

    protected addUrlParams(params: Array<Array<string>>): void {
        const baseSuggestUrl = this.getAttribute('base-suggest-url');
        let paramsString = '?';
        params.forEach( (element, index) => {
            paramsString += index == 0 ? '' : '&';
            paramsString += `${element[0]}=${element[1]}`;
        });
        this.ajaxProvider.setAttribute('url', `${baseSuggestUrl}${paramsString}`);
    }

    showSugestions(): void {
        this.suggestionsContainer.classList.remove('is-hidden');
    }

    hideSugestions(): void {
        this.suggestionsContainer.classList.add('is-hidden');
    }

    cleanUpInput(): void {
        this.searchInput.value = '';
        this.suggestionsContainer.innerHTML = '';
    }

    openSearchLayout(): void {
        this.setHintValue('');
        this.searchOverlay.classList.toggle('active');
        this.searchInput.focus();
    }

    protected createHintInput(): void {
        this.hintInput = document.createElement('input');
        this.hintInput.classList.add(`${this.name}__hint`, 'input', 'input--expand');
        this.searchInput.parentNode.appendChild(this.hintInput);
        this.searchInput.classList.add(`${this.name}__input--transparent`);
    }

    updateHintInput(value?: string): void {
        let hintValue = value ? value : this.hint;
        const inputValue = this.searchInput.value;
        if (!hintValue.toLowerCase().startsWith(inputValue.toLowerCase())) {
            hintValue = '';
        }
        hintValue = hintValue.replace(hintValue.slice(0, inputValue.length), inputValue);
        this.setHintValue(hintValue);
    }

    protected setHintValue(value: string): void {
        this.hintInput.value =  value;
    }

    protected saveCurrentSearchValue(suggestQuery: string): void {
        this.currentSearchValue = suggestQuery;
    }

    get debounceDelay(): number {
        return Number(this.getAttribute('debounce-delay'));
    }

    get throttleDelay(): number {
        return Number(this.getAttribute('throttle-delay'));
    }

    get lettersTrashold(): number {
        return Number(this.getAttribute('letters-trashold'));
    }

    get searchInputSelector(): string {
        return <string> this.getAttribute('input-selector');
    }

}