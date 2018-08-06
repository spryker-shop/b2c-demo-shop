import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';

export default class NavHeaderMobile extends Component {

    readyCallback(): void {

        const $container = $(this).find(`.${this.name}__block`);
        const $scrollBar = $(this).find(`.${this.name}__bar`);
        const $arrowLeft = $container.find(`.${this.name}__arrow--left`);
        const $arrowRight = $container.find(`.${this.name}__arrow--right`);
        const $scroll = $container.find(`.${this.name}__scroll`);

        function getRightEdge() {
            return $scroll.get(0).scrollWidth - $scrollBar.width() - 5;
        }

        function toggleLeftArrow(point, pointMin) {
            switch (true){

                case (point > pointMin): $arrowLeft.show(); break;

                case (point < pointMin): $arrowLeft.hide(); break;

            }
        }

        function toggleRightArrow(point, pointMax) {
            switch (true){

                case (point > pointMax): $arrowRight.hide(); break;

                case (point < pointMax): $arrowRight.show(); break;

            }
        }

        $scroll.on('scroll', function () {
            console.log($scroll.scrollLeft(), getRightEdge());

            toggleLeftArrow($scroll.scrollLeft(), 5);
            toggleRightArrow($scroll.scrollLeft(), getRightEdge())

        });
    }
}
