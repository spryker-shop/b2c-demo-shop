import Component from 'ShopUi/models/component';

export default class RemoteFormSubmit extends Component {
    protected formHolder: HTMLElement;
    protected fieldsContainer: HTMLElement;
    protected submitButton: HTMLButtonElement;

    protected readyCallback(): void {}

    protected init(): void {
        this.fieldsContainer = <HTMLElement>Array.from(this.getElementsByClassName(`${this.jsName}__container`))[0];
        this.submitButton = <HTMLButtonElement>Array.from(this.getElementsByClassName(`${this.jsName}__submit`))[0];

        this.getFormHolder();
        this.createForm();
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.mapSubmitEvent();
    }

    protected mapSubmitEvent(): void {
        this.submitButton.addEventListener('click', () => this.submitTargetForm());
    }

    protected submitTargetForm(): void {
        const form = <HTMLFormElement>document.getElementById(this.formName);

        form.submit();
    }

    protected getFormHolder(): void {
        if (this.formHolderClassName) {
            this.formHolder = <HTMLElement>Array.from(document.getElementsByClassName(this.formHolderClassName))[0];

            return;
        }

        this.formHolder = document.body;
    }

    protected createForm(): void {
        const formTemplate = `
            <form id="${this.formName}" class="is-hidden" name="${this.formName}" method="post" action="${this.formAction}">
                ${this.fieldsContainer.innerHTML}
            </form>
        `;
        this.formHolder.insertAdjacentHTML('beforeend', formTemplate);
    }

    protected get formHolderClassName(): string {
        return this.getAttribute('form-holder-class-name');
    }

    protected get formName(): string {
        return this.getAttribute('form-name');
    }

    protected get formAction(): string {
        return this.getAttribute('form-action');
    }
}
