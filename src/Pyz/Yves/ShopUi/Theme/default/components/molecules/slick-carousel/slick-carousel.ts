import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';
import 'slick-carousel';

export default class SlickCarousel extends Component {

    readyCallback(): void {

        const container = $(this).find(`.${this.name}__container`);
        const sliderConfig = $(this).data('json');
        console.log(typeof sliderConfig);

        container.slick(
            sliderConfig
        );
    }

}
