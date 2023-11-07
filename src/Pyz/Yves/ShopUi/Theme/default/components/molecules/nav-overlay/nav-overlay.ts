import Component from 'ShopUi/models/component';
import {
    EVENT_HIDE_OVERLAY,
    EVENT_SHOW_OVERLAY,
    OverlayEventDetail,
} from 'ShopUi/components/molecules/main-overlay/main-overlay';

export default class NavOverlay extends Component {
    protected classToggle = `${this.name}--active`;
    protected triggers: HTMLElement[];
    protected blocks: HTMLElement[];
    protected savedIndex = 0;
    protected overlay: HTMLElement;
    protected eventShowOverlay: CustomEvent<OverlayEventDetail>;
    protected eventHideOverlay: CustomEvent<OverlayEventDetail>;

    protected readyCallback(): void {}

    protected init(): void {
        this.triggers = <HTMLElement[]>Array.from(document.getElementsByClassName(this.triggerOpenClassName));
        this.blocks = <HTMLElement[]>Array.from(this.getElementsByClassName(`${this.jsName}__drop-down-block`));
        this.overlay = <HTMLElement>document.getElementsByClassName(this.overlayClassName)[0];

        this.mapEvents();
    }

    protected mapEvents(): void {
        this.triggers.forEach((trigger, index) => {
            trigger.addEventListener('mouseenter', this.triggersHandler.bind(this, index));
        });
        this.overlay.addEventListener('mouseenter', this.triggerCloseHandler.bind(this));
        this.mapOverlayEvents();
    }

    protected hideBlocks(): void {
        this.blocks.forEach((block) => block.classList.add('is-hidden'));
    }

    protected resetTriggersActiveClass(): void {
        this.triggers.forEach((trigger) => trigger.classList.remove(this.activeTriggerClass));
    }

    protected triggersHandler(index: number, event: Event): void {
        const eventTarget = <HTMLElement>event.target;

        event.stopPropagation();
        this.toggleOverlay(false);
        if (!this.classList.contains(this.classToggle)) {
            this.classList.add(this.classToggle);
            this.blocks[index].classList.remove('is-hidden');
            eventTarget.classList.add(this.activeTriggerClass);
        } else if (this.savedIndex !== index) {
            this.hideBlocks();
            this.resetTriggersActiveClass();
            this.blocks[index].classList.remove('is-hidden');
            eventTarget.classList.add(this.activeTriggerClass);
        }
        this.savedIndex = index;
        this.toggleOverlay(true);
    }

    protected triggerCloseHandler(): void {
        this.toggleOverlay(false);
        this.classList.remove(this.classToggle);
        this.hideBlocks();
        this.resetTriggersActiveClass();
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
    }

    protected toggleOverlay(isShown: boolean): void {
        this.dispatchEvent(isShown ? this.eventShowOverlay : this.eventHideOverlay);
    }

    protected get triggerOpenClassName(): string {
        return this.getAttribute('trigger-open-class-name');
    }

    protected get activeTriggerClass(): string {
        return this.getAttribute('active-link');
    }

    protected get overlayClassName(): string {
        return this.getAttribute('overlay-class-name');
    }
}
