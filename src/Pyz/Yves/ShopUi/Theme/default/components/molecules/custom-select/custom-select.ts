import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';
import 'select2/dist/js/select2.full';

export default class CustomSelect extends Component {
    protected select: HTMLSelectElement;
    protected $select: $;

    protected readyCallback(): void {}

    protected init(): void {
        this.select = <HTMLSelectElement>this.getElementsByClassName(`${this.jsName}`)[0];
        this.$select = $(this.select);

        this.mapEvents();

        if (document.body.classList.contains('no-touch') && this.autoInit) {
            this.initSelect();
            this.removeAttributeTitle();
        }
    }

    protected mapEvents(): void {
        this.changeSelectEvent();
        document.body.addEventListener('click', (event: Event) => this.closeHandler(event));
    }

    protected onChangeSelect(): void {
        const event = new Event('change');
        this.select.dispatchEvent(event);
        this.removeAttributeTitle();
    }

    changeSelectEvent(): void {
        this.$select.on('select2:select', () => this.onChangeSelect());
    }

    initSelect(): void {
        this.$select.select2({
            minimumResultsForSearch: Infinity,
            width: this.configWidth,
            theme: this.configTheme,
            dropdownCssClass: this.additionalClassName ? `select2-dropdown--${this.additionalClassName}` : ''
        });
    }

    protected removeAttributeTitle(): void {
        this.getElementsByClassName('select2-selection__rendered')[0].removeAttribute('title');
    }

    protected closeHandler(event: Event): void {
        const eventTarget = <HTMLElement>event.target;

        if ($(eventTarget).hasClass('select2-container--open')) {
            this.$select.select2('close');
        }
    }

    protected get configWidth(): string {
        return this.select.getAttribute('config-width');
    }

    protected get configTheme(): string {
        return this.select.getAttribute('config-theme');
    }

    protected get autoInit(): boolean {
        return !this.select.hasAttribute('auto-init');
    }

    protected get additionalClassName(): string {
        return this.select.getAttribute('additional-class-name');
    }
}
