import SuggestSearchCore from 'ShopUi/components/molecules/suggest-search/suggest-search';
import {
    EVENT_HIDE_OVERLAY,
    EVENT_SHOW_OVERLAY,
    OverlayEventDetail,
} from 'ShopUi/components/molecules/main-overlay/main-overlay';
import debounce from 'lodash-es/debounce';
import throttle from 'lodash-es/throttle';

export default class SuggestSearch extends SuggestSearchCore {
    protected wrapper: HTMLElement;
    protected overlay: HTMLElement;
    protected openTriggers: HTMLElement[];
    protected closeTriggers: HTMLElement[];
    protected focusTimeout = 0;
    protected timeout = 400;
    protected eventShowOverlay: CustomEvent<OverlayEventDetail>;
    protected eventHideOverlay: CustomEvent<OverlayEventDetail>;

    protected init(): void {
        this.overlay = <HTMLElement>document.getElementsByClassName(this.overlayClassName)[0];
        this.wrapper = <HTMLElement>document.getElementsByClassName(this.wrapperClassName)[0];
        this.closeTriggers = <HTMLElement[]>Array.from(document.getElementsByClassName(this.closeClassName));
        this.openTriggers = <HTMLElement[]>Array.from(document.getElementsByClassName(this.openClassName));

        super.readyCallback();
    }

    protected mapEvents(): void {
        this.searchInput.addEventListener(
            'keyup',
            debounce(() => {
                this.onInputKeyUp();
            }, this.debounceDelay),
        );
        this.searchInput.addEventListener(
            'keydown',
            throttle((event: Event) => {
                this.onInputKeyDown(<KeyboardEvent>event);
            }, this.throttleDelay),
        );
        this.searchInput.addEventListener('focus', () => this.onInputFocusIn());
        this.searchInput.addEventListener('click', () => this.onInputClick());
        this.searchInput.addEventListener('input', () => this.onInputValueChange());
        this.openTriggers.forEach((trigger) => {
            trigger.addEventListener('click', () => this.openSearchLayout());
        });
        this.closeTriggers.forEach((trigger) => {
            trigger.addEventListener('click', () => this.onInputFocusOut());
        });
        this.mapOverlayEvents();
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
        this.toggleOverlay(false);
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
        this.toggleOverlay(true);
        this.focusTimeout = window.setTimeout(() => this.searchInput.focus(), this.timeout);
    }

    protected mapOverlayEvents(): void {
        const overlayConfig: CustomEventInit<OverlayEventDetail> = {
            bubbles: true,
            detail: {
                id: this.name,
                zIndex: Number(getComputedStyle(this).zIndex) - 1,
            },
        };

        this.eventShowOverlay = new CustomEvent(EVENT_SHOW_OVERLAY, overlayConfig);
        this.eventHideOverlay = new CustomEvent(EVENT_HIDE_OVERLAY, overlayConfig);

        if (this.shouldCloseByOverlayClick) {
            this.mapOverlayClickEvent();
        }
    }

    protected mapOverlayClickEvent(): void {
        this.overlay.addEventListener('click', () => this.onInputFocusOut());
    }

    protected toggleOverlay(isShown: boolean): void {
        this.wrapper.classList.toggle(this.wrapperToggleClassName, isShown);
        this.dispatchEvent(isShown ? this.eventShowOverlay : this.eventHideOverlay);
    }

    protected get overlayClassName(): string {
        return this.getAttribute('overlay-class-name');
    }

    protected get shouldCloseByOverlayClick(): boolean {
        return this.hasAttribute('should-close-by-overlay-click');
    }

    protected get wrapperClassName(): string {
        return this.getAttribute('wrapper-class-name');
    }

    protected get closeClassName(): string {
        return this.getAttribute('close-class-name');
    }

    protected get openClassName(): string {
        return this.getAttribute('open-class-name');
    }

    protected get wrapperToggleClassName(): string {
        return this.getAttribute('wrapper-toggle-class-name');
    }
}
