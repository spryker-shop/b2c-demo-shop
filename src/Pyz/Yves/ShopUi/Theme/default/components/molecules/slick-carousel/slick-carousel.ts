import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';
import 'slick-carousel';

export default class SlickCarousel extends Component {
    protected container: $
    protected sliderConfig: Object

    readyCallback(): void {
        this.container = $(this).find(`.${this.name}__container`);
        this.sliderConfig = JSON.parse(this.getAttribute('data-json'));
        this.init();
    }

    protected init(): void {
        this.container.slick(
            this.sliderConfig
        );

        if ("ontouchstart" in document.documentElement){
            this.container.slick('slickPause');
        }
    }
}
