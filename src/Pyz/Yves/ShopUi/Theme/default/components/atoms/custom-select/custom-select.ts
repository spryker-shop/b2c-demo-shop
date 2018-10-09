import Component from 'ShopUi/models/component';
import $ from 'jquery';
import select from 'select2';

export default class CustomSelect extends Component {

    protected readyCallback(): void {
        const select2 = select;
        const targetSelect = this.querySelector(`.${this.jsName}`);
        if(document.body.classList.contains('no-touch')) {
            $(targetSelect).select2({
                minimumResultsForSearch: Infinity
            });
            $(targetSelect).parents('body').on('click', function (e) {
                const eventTarget = e.target;
                if (eventTarget.classList.contains('select2-container--open')) {
                    $(targetSelect).select2('close');
                }
            });
        }
    }
}
