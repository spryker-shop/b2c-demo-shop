import Component from 'ShopUi/models/component';

export default class TogglerAccordion extends Component {
    protected triggers: HTMLElement[];

    protected readyCallback(): void {}

    protected init(): void {
        this.triggers = <HTMLElement[]>Array.from(document.getElementsByClassName(this.triggerClassName));
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.triggers.forEach(trigger => trigger.addEventListener('click', this.triggerHandler.bind(this, trigger)));
    }

    protected triggerHandler(trigger: HTMLElement): void {
        const togglerContent = document.getElementsByClassName(
            trigger.getAttribute('data-toggle-target-class-name')
        )[0];
        trigger.classList.toggle(this.activeClass);
        togglerContent.classList.toggle(this.toggleClass);
    }

    protected get triggerClassName(): string {
        return this.getAttribute('trigger-class-name');
    }

    protected get toggleClass(): string {
        return this.getAttribute('class-to-toggle');
    }

    protected get activeClass(): string {
        return this.getAttribute('active-class');
    }
}
