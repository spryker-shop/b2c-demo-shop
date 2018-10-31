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

        if(trigger.classList.contains(this.activeClass)) {
            trigger.classList.remove('active');
            togglerContent.classList.add(this.toggleClass);
        }else {
            this.resetToggleClass();
            trigger.classList.add('active');
            togglerContent.classList.remove(this.toggleClass);
        }
    }

    protected resetToggleClass(): void {
        this.triggers.forEach(trigger => {
            const togglerContent = document.querySelector(trigger.getAttribute('data-toggle-target'));

            togglerContent.classList.add(this.toggleClass);
            trigger.classList.remove('active');
        });
    }

    get triggerSelector(): string {
        return this.getAttribute('trigger');
    }

    get toggleClass(): string {
        return this.getAttribute('class-to-toggle');
    }

    get activeClass(): string {
        return 'active'
    }
}
