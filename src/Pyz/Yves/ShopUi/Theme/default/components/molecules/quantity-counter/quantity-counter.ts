import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';

export default class QuantityCounter extends Component {

    timeout = null;

    protected readyCallback(): void {

        const input = $(this).find(`.${this.name}__input`);
        let maxQuantity = input.data('max-quantity');
        const decrButton = $(this).find('.js-quantity-decr');
        const incrButton = $(this).find('.js-quantity-incr');
        const autoUpdate = input.data('auto-update');
        const form = $(this).closest('.js-quantity-form');


        if(!maxQuantity){
            maxQuantity = Infinity;
        }
        decrButton.click(() => {
            let value = +input.val();
            if(value > 1){
                input.val(value - 1);

                if(autoUpdate) {
                    this.timer(form);
                }
            }
        });
        incrButton.click(() => {
            let value = +input.val();
            if(value < maxQuantity) {
                input.val(value + 1);

                if(autoUpdate) {
                    this.timer(form);
                }
            }
        });

        if(autoUpdate) {
            input.change(() => this.timer(form));
        }
    }

    protected timer(form): void {
        clearTimeout(this.timeout);
        this.timeout = setTimeout(() => form.submit(), 1000);
    }
}
