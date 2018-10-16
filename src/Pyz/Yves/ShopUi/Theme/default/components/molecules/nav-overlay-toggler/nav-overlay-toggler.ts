import Component from 'ShopUi/models/component';

export default class NavOverlayToggler extends Component {
    protected triggers: HTMLElement[]
    protected triggerClose: HTMLElement
    protected blocks: HTMLElement[]
    protected overlayElement: HTMLElement
    protected savedIndex: number

    readyCallback(): void {
        this.triggers = <HTMLElement[]>Array.from(document.querySelectorAll(this.triggerOpenSelector));
        this.triggerClose = <HTMLElement>document.querySelector(this.triggerCloseSelector);
        this.blocks = <HTMLElement[]>Array.from(document.querySelectorAll(this.blocksSelector));
        this.overlayElement = <HTMLElement>document.querySelector(this.overlaySelector);
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
        this.triggers.forEach(trigger => trigger.classList.remove(this.activetriggerClass));
    }

    protected triggersHandler(index, e): void {
        e.stopPropagation();
        if(!this.overlayElement.classList.contains(this.classToggle)) {
            this.overlayElement.classList.add(this.classToggle);
            this.blocks[index].classList.remove('is-hidden');
            e.target.classList.add(this.activetriggerClass);
        } else if(this.savedIndex !== index) {
            this.hideBlocks();
            this.resetTriggersActiveClass();
            this.blocks[index].classList.remove('is-hidden');
            e.target.classList.add(this.activetriggerClass);
        }
        this.savedIndex = index;
    }

    protected triggerCloseHandler(): void {
        this.overlayElement.classList.remove(this.classToggle);
        this.hideBlocks();
        this.resetTriggersActiveClass();
    }

    get triggerOpenSelector(): string {
        return this.getAttribute('trigger-open');
    }

    get triggerCloseSelector(): string {
        return this.getAttribute('trigger-close');
    }

    get blocksSelector(): string {
        return this.getAttribute('blocks');
    }

    get overlaySelector(): string {
        return this.getAttribute('toggle-target');
    }

    get classToggle(): string {
        return this.getAttribute('class-to-toggle');
    }

    get activetriggerClass(): string {
        return this.getAttribute('active-link');
    }
}
