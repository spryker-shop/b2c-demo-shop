import Component from 'ShopUi/models/component';

export default class TogglerAccordeon extends Component {
    protected triggers: HTMLElement[];
    
    readyCallback(): void {
        this.triggers = <HTMLElement[]>Array.from(document.querySelectorAll(this.triggerSelector));
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.triggers.forEach(trigger => trigger.addEventListener('click', this.triggerHandler.bind(this, trigger)));
    }

    protected triggerHandler(trigger): void {
        const togglerContent = document.querySelector(trigger.getAttribute('data-toggle-target'));
        togglerContent.classList.toggle(this.toggleClass);

        if(!togglerContent.classList.contains(this.toggleClass)) {
            trigger.classList.add('active');
        }else {
            trigger.classList.remove('active');
        }
    }

    get triggerSelector(): string {
        return this.getAttribute('trigger');
    }

    get toggleClass(): string {
        return this.getAttribute('class-to-toggle');
    }
}
