import Component from 'ShopUi/models/component';
import CustomSelect from '../custom-select/custom-select';
import $ from 'jquery/dist/jquery';
import 'slick-carousel';


export default class SlickCarousel extends Component {
    protected container: $;
    protected sliderConfig: Object;
    protected customSelects: CustomSelect[];

    readyCallback(): void {
        this.container = $(this).find(`.${this.name}__container`);
        this.sliderConfig = JSON.parse(this.getAttribute('data-json'));
        if (this.customSelectSelector) {
            this.customSelects = <CustomSelect[]>Array.from(this.querySelectorAll(this.customSelectSelector));
        }

        this.init();
    }

    protected init(): void {
        this.container.on('init', () => {
            if (this.customSelects) {
                this.customSelects.forEach((select: CustomSelect) => {
                    select.initSelect();
                });
            }
        });

        this.container.slick(
            this.sliderConfig
        );

        if ("ontouchstart" in document.documentElement){
            this.container.slick('slickPause');
        }
    }

    get customSelectSelector(): string {
        return this.getAttribute('custom-select-selector');
    }
}
