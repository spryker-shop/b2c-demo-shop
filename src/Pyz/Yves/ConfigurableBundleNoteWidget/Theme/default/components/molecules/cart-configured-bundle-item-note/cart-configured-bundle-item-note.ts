import Component from 'ShopUi/models/component';

export default class CartConfiguredBundleItemNote extends Component {
    protected editButton: HTMLButtonElement;
    protected removeButton: HTMLButtonElement;
    protected formTarget: HTMLElement;
    protected textTarget: HTMLElement;

    protected readyCallback(): void {}

    protected init(): void {
        this.editButton = <HTMLButtonElement>this.getElementsByClassName(`${this.jsName}__edit`)[0];
        this.removeButton = <HTMLButtonElement>this.getElementsByClassName(`${this.jsName}__remove`)[0];
        this.formTarget = <HTMLElement>this.getElementsByClassName(`${this.jsName}__form`)[0];
        this.textTarget = <HTMLElement>this.getElementsByClassName(`${this.jsName}__text-wrap`)[0];

        this.mapEvents();
    }

    protected mapEvents(): void {
        if (this.editButton) {
            this.editButton.addEventListener('click', () => this.onEditButtonClick());
        }

        if (this.removeButton) {
            this.removeButton.addEventListener('click', () => this.onRemoveButtonClick());
        }
    }

    protected onEditButtonClick(): void {
        this.classToggle(this.formTarget);
        this.classToggle(this.textTarget);
    }

    protected onRemoveButtonClick(): void {
        const form = <HTMLFormElement>this.formTarget.getElementsByTagName('form')[0];
        const textarea = <HTMLTextAreaElement>form.getElementsByTagName('textarea')[0];
        textarea.value = '';
        form.submit();
    }

    protected classToggle(activeTrigger: HTMLElement): void {
        const isTriggerActive = activeTrigger.classList.contains(this.classToToggle);
        activeTrigger.classList.toggle(this.classToToggle, !isTriggerActive);
    }

    protected get classToToggle(): string {
        return this.getAttribute('class-to-toggle');
    }
}
