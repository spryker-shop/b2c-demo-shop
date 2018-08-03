import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';
import 'slick-carousel';

export default class SlickCarousel extends Component {

    readyCallback(): void {

        const $container = $(this).find(`.${this.name}__container`);

        $container.slick(
            {
                initialSlide: 0,
                infinite: false,
                swipeToSlide: true,
                variableWidth: true,
                slidesToShow: 5,
                responsive: [{
                    breakpoint: 650,
                    settings: {

                    }
                },
                    {
                        breakpoint: 550,
                        settings: {

                        }
                    }
                ]}
        );
    }
}
