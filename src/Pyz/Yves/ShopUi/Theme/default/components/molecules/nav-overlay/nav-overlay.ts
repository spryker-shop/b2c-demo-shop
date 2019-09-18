import Component from 'ShopUi/models/component';

export default class NavOverlay extends Component {
    protected classToggle: string = `${this.name}--active`;
    protected triggers: HTMLElement[];
    protected triggerClose: HTMLElement;
    protected blocks: HTMLElement[];
    protected savedIndex: number = 0;

    protected readyCallback(): void {}

    protected init(): void {
        this.triggers = <HTMLElement[]>Array.from(document.getElementsByClassName(this.triggerOpenClassName));
        this.triggerClose = <HTMLElement>this.getElementsByClassName(`${this.jsName}__shadow`)[0];
        this.blocks = <HTMLElement[]>Array.from(this.getElementsByClassName(`${this.jsName}__drop-down-block`));

        this.hideBlocks();
        this.mapEvents();
    }

    protected hideBlocks(): void {
        this.blocks.forEach(block => block.classList.add('is-hidden'));
    }

    protected mapEvents(): void {
        this.triggers.forEach((trigger, index) => {
            trigger.addEventListener('mouseenter', this.triggersHandler.bind(this, index));
        });
        this.triggerClose.addEventListener('mouseenter', this.triggerCloseHandler.bind(this));
    }

    protected resetTriggersActiveClass(): void {
        this.triggers.forEach(trigger => trigger.classList.remove(this.activeTriggerClass));
    }

    protected triggersHandler(index: number, event: Event): void {
        const eventTarget = <HTMLElement>event.target;
        event.stopPropagation();
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
    }

    protected triggerCloseHandler(): void {
        this.classList.remove(this.classToggle);
        this.hideBlocks();
        this.resetTriggersActiveClass();
    }

    protected get triggerOpenClassName(): string {
        return this.getAttribute('trigger-open-class-name');
    }

    protected get activeTriggerClass(): string {
        return this.getAttribute('active-link');
    }
}
