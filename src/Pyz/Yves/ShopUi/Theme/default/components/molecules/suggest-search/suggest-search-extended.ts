import SuggestSearch from 'ShopUi/components/molecules/suggest-search/suggest-search';
import debounce from 'lodash-es/debounce';
import throttle from 'lodash-es/throttle';

export default class SuggestSearchExtended extends SuggestSearch {
    searchOverlay: HTMLElement;
    overlayOpenButtons: HTMLElement[];
    overlayCloseTriggers: HTMLElement[];
    focusTimeout: number;
    protected timeout: number = 400;

    constructor() {
        super();
        this.focusTimeout = 0;
    }

    protected readyCallback(): void {
        this.searchOverlay = <HTMLElement>document.querySelector(`.${this.jsName}__overlay`);
        this.overlayOpenButtons = <HTMLElement[]>Array.from(document.querySelectorAll(`.${this.jsName}__show`));
        this.overlayCloseTriggers = <HTMLElement[]>Array.from(document.querySelectorAll(`.${this.jsName}__hide`));
        super.readyCallback();
    }

    protected mapEvents(): void {
        this.searchInput.addEventListener('keyup', debounce((event: Event) => {
            this.onInputKeyUp();
        }, this.debounceDelay));
        this.searchInput.addEventListener('keydown', throttle((event: Event) => {
            this.onInputKeyDown(<KeyboardEvent> event);
            }, this.throttleDelay));
        this.searchInput.addEventListener('focus', (event: Event) => this.onInputFocusIn());
        this.searchInput.addEventListener('click', (event: Event) => this.onInputClick());

        this.overlayOpenButtons.forEach(button => {
            button.addEventListener('click', () => this.openSearchLayout());
        });
        this.overlayCloseTriggers.forEach(trigger => {
            trigger.addEventListener('click', (event: Event) => this.onInputFocusOut());
        });
    }

    protected onInputKeyDown(event: KeyboardEvent): void {
        this.setHintValue('');
        super.onInputKeyDown(event);
    }

    protected onTab(event: KeyboardEvent): boolean {
        event.preventDefault();
        this.searchInput.value = this.hint;

        return false;
    }

    protected onInputFocusOut(): void {
        super.onInputFocusOut();
        this.searchOverlay.classList.toggle('active');
        this.cleanUpInput();
        clearTimeout(this.focusTimeout);
    }

    protected cleanUpInput(): void {
        this.searchInput.value = '';
        this.suggestionsContainer.innerHTML = '';
    }

    protected openSearchLayout(): void {
        this.saveCurrentSearchValue('');
        this.setHintValue('');
        this.searchOverlay.classList.toggle('active');
        this.focusTimeout = setTimeout(() => this.searchInput.focus(), this.timeout);

    }
}
