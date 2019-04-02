import Component from 'ShopUi/models/component';

export default class FormSubmitter extends Component {
    readonly event: string;
    readonly triggers: HTMLElement[];

    constructor() {
        super();
        this.event = <string>this.getAttribute('event');
        this.triggers = <HTMLElement[]>Array.from(document.querySelectorAll(this.triggerSelector));
    }

    protected readyCallback(): void {
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.triggers.forEach((trigger: HTMLElement) => {
            trigger.addEventListener(this.event, (event: Event) => this.onTriggerEvent(event));
        });
    }

    protected onTriggerEvent(event: Event): void {
        event.preventDefault();
        const trigger = <HTMLElement>event.target;
        const form = <HTMLFormElement>trigger.closest('form');
        form.submit();
    }

    get triggerSelector(): string {
        return this.getAttribute('trigger-selector');
    }
}
