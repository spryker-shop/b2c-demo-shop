import SuggestSearch from 'ShopUi/components/molecules/suggest-search/suggest-search';
import debounce from 'lodash-es/debounce';
import throttle from 'lodash-es/throttle';

export default class SuggestSearchExtended extends SuggestSearch {
    protected searchOverlay: HTMLElement;
    protected overlayOpenButtons: HTMLElement[];
    protected overlayCloseTriggers: HTMLElement[];
    protected focusTimeout: number = 0;
    protected timeout: number = 400;

    protected readyCallback(): void {}

    protected init(): void {
        this.searchOverlay = <HTMLElement>document.getElementsByClassName(`${this.jsName}__overlay`)[0];
        this.overlayOpenButtons = <HTMLElement[]>Array.from(document.getElementsByClassName(`${this.jsName}__show`));
        this.overlayCloseTriggers = <HTMLElement[]>Array.from(document.getElementsByClassName(`${this.jsName}__hide`));
        super.readyCallback();
    }

    protected mapEvents(): void {
        this.searchInput.addEventListener('keyup', debounce(() => {
            this.onInputKeyUp();
        }, this.debounceDelay));
        this.searchInput.addEventListener('keydown', throttle((event: Event) => {
            this.onInputKeyDown(<KeyboardEvent> event);
            }, this.throttleDelay));
        this.searchInput.addEventListener('focus', () => this.onInputFocusIn());
        this.searchInput.addEventListener('click', () => this.onInputClick());
        this.searchInput.addEventListener('input', () => this.onInputValueChange());
        this.overlayOpenButtons.forEach(button => {
            button.addEventListener('click', () => this.openSearchLayout());
        });
        this.overlayCloseTriggers.forEach(trigger => {
            trigger.addEventListener('click', () => this.onInputFocusOut());
        });
    }

    protected onInputKeyDown(event: KeyboardEvent): void {
        this.setHintValue('');
        super.onInputKeyDown(event);
    }

    protected onInputValueChange(): void {
        this.onInputKeyUp();
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
        this.focusTimeout = window.setTimeout(() => this.searchInput.focus(), this.timeout);

    }
}
