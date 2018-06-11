import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';

export default class TogglerAccordeon extends Component {

    readyCallback(): void {
        console.log($);
        $('.footer').wrap('<div class="test"></div>');
    }

}
