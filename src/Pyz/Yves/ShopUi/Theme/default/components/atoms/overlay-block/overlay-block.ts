import Component from 'ShopUi/models/component';

export default class OverlayBlock extends Component {
    protected readyCallback(): void {}

    protected addModifier(modifier?: string, element?: HTMLElement, cssClass?: string): void {
        if (modifier) {
            element.classList.add(`${cssClass}--${modifier}`);
        }
    }

    protected removeModifier(modifier?: string, element?: HTMLElement, cssClass?: string): void {
        if (modifier) {
            element.classList.remove(`${cssClass}--${modifier}`);
        }
    }

    showOverlay(modifier?: string, bodyModifier?: string): void {
        this.addModifier(modifier, this, this.name);
        this.addModifier(bodyModifier, document.body,'body-overlay');
        this.classList.add(this.classToShow);
    }

    hideOverlay(modifier?: string, bodyModifier?: string): void {
        this.removeModifier(modifier, this, this.name);
        this.removeModifier(bodyModifier, document.body,'body-overlay');
        this.classList.remove(this.classToShow);
    }

    protected get classToShow(): string {
        return `${this.name}--is-shown`;
    }

}
