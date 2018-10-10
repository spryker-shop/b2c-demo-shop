import Component from 'ShopUi/models/component';
import $ from 'jquery';
import select from 'select2';

export default class CustomSelect extends Component {
    protected select2: select;
    protected targetSelect: HTMLElement;

    protected readyCallback(): void {
        this.targetSelect = this.querySelector(`.${this.jsName}`);
        this.select2 = select;

        if(document.body.classList.contains('no-touch')) {
            this.init(this.select2);
            this.closeHandler(this.select2);
        }
    }

    protected init(select2: select): void {
        $(this.targetSelect).select2({
            minimumResultsForSearch: Infinity
        });
    }

    protected closeHandler(select2: select): void {
        const targetSelect = this.targetSelect;

        $(targetSelect).parents('body').on('click', function (e) {
            const eventTarget = e.target;

            if (eventTarget.classList.contains('select2-container--open')) {
                $(targetSelect).select2('close');
            }
        });
    }
}
