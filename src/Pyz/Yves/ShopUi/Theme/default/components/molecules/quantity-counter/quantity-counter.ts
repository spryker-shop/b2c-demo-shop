import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';

export default class QuantityCounter extends Component {

    readyCallback(): void {

        const input = $(this).find(`.${this.name}__input`);
        let maxQuantity = input.data('max-quantity');
        const decrButton = $(this).find('.js-quantity-decr');
        const incrButton = $(this).find('.js-quantity-incr');
        if(!maxQuantity){
            maxQuantity = Infinity;
        }
        decrButton.click(function () {
            let value = +input.val();
            if(value > 1){
                input.val(value - 1);
            }
        });
        incrButton.click(function () {
            let value = +input.val();
            if(value < maxQuantity) {
                input.val(value + 1);
            }
        });

    }
}
