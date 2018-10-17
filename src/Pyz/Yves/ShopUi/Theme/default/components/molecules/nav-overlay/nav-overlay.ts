import Component from 'ShopUi/models/component';

export default class NavOverlay extends Component {
    readonly classToggle = `${this.name}--active`

    protected triggers: HTMLElement[]
    protected triggerClose: HTMLElement
    protected blocks: HTMLElement[]
    protected savedIndex: number

    readyCallback(): void {
        this.triggers = <HTMLElement[]>Array.from(document.querySelectorAll(this.triggerOpenSelector));
        this.triggerClose = <HTMLElement>this.querySelector(`.${this.name}__shadow`);
        this.blocks = <HTMLElement[]>Array.from(this.querySelectorAll(`.${this.name}__container > div`));
        this.savedIndex = <number> 0;

        this.hideBlocks();
        this.mapEvents();
    }

    protected hideBlocks(): void {
        this.blocks.forEach(block => block.classList.add('is-hidden'));
    }

    protected mapEvents(): void {
        this.triggers.forEach((trigger, index) => trigger.addEventListener('mouseenter', this.triggersHandler.bind(this, index)));
        this.triggerClose.addEventListener('mouseenter', this.triggerCloseHandler.bind(this));
    }

    protected resetTriggersActiveClass(): void {
        this.triggers.forEach(trigger => trigger.classList.remove(this.activeTriggerClass));
    }

    protected triggersHandler(index, e): void {
        e.stopPropagation();
        if(!this.classList.contains(this.classToggle)) {
            this.classList.add(this.classToggle);
            this.blocks[index].classList.remove('is-hidden');
            e.target.classList.add(this.activeTriggerClass);
        } else if(this.savedIndex !== index) {
            this.hideBlocks();
            this.resetTriggersActiveClass();
            this.blocks[index].classList.remove('is-hidden');
            e.target.classList.add(this.activeTriggerClass);
        }
        this.savedIndex = index;
    }

    protected triggerCloseHandler(): void {
        this.classList.remove(this.classToggle);
        this.hideBlocks();
        this.resetTriggersActiveClass();
    }

    get triggerOpenSelector(): string {
        return this.getAttribute('trigger-open');
    }

    get activeTriggerClass(): string {
        return this.getAttribute('active-link');
    }
}
