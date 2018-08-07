import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';

export default class NavHeaderMobile extends Component {

    readyCallback(): void {

        const $container = $(this).find(`.${this.name}__block`);
        const $scrollBar = $(this).find(`.${this.name}__bar`);
        const $arrowLeft = $container.find(`.${this.name}__arrow--left`);
        const $arrowRight = $container.find(`.${this.name}__arrow--right`);
        const $scroll = $container.find(`.${this.name}__scroll`);

        const $dropDown = $(this).find(`.${this.name}__dropdown-container`);
        const $tabs = $dropDown.find(`.${this.name}__tab`);
        const $tabTogglers = $scroll.find('[data-target]');
        const $tabClose = $dropDown.find(`.${this.name}__tab-close`);

        $tabTogglers.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            $.each($tabs, (i, item)=>{
                $(item).hide();
                if($(this).data('target') == $(item).data('tab')){
                    $(item).show();
                    $dropDown.slideDown();
                    $(item).animate({opacity: 1}, 500);
                }
            })
        });

        $tabClose.on('click', function () {
            $.each($tabs, (i, item)=> {
                $(item).animate({opacity: 0}, 400);
            });
            $dropDown.slideUp();
        });

        function getRightEdge() {
            return $scroll.get(0).scrollWidth - $scrollBar.width() - 5;
        }

        function toggleLeftArrow(point, pointMin) {
            switch (true){

                case (point > pointMin): $arrowLeft.fadeIn(200); break;

                case (point < pointMin): $arrowLeft.fadeOut(200); break;

            }
        }

        function toggleRightArrow(point, pointMax) {
            switch (true){

                case (point > pointMax): $arrowRight.fadeOut(200); break;

                case (point < pointMax): $arrowRight.fadeIn(200); break;

            }
        }

        $scroll.on('scroll', function () {
            toggleLeftArrow($scroll.scrollLeft(), 5);
            toggleRightArrow($scroll.scrollLeft(), getRightEdge())

        });
    }
}
