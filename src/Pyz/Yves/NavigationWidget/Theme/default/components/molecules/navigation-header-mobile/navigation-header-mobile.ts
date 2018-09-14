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


        const $dropDown = $(this).find(`.${this.name}__dropdown-container`);
        const $tabs = $dropDown.find(`.${this.name}__tab`);
        const $tabTogglers = $scroll.find('[data-target]');
        const $tabClose = $dropDown.find(`.${this.name}__tab-close`);

        let isDropDownOpen = false;
        let isPreviousTab = false;
        let previousTab;
        let currentTab;

        function findCurrentTab (currentToggler, tabs) {
            let currentTab;
            $.each(tabs, (i, item)=>{
                if(currentToggler.data('target') == $(item).data('tab')){
                    currentTab = $(item);
                    return false;
                }
            });
            return currentTab;
        }

        $tabTogglers.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let currentToggler = $(this);

            currentTab = findCurrentTab(currentToggler, $tabs);
            
            if(isPreviousTab) {
                previousTab.hide().animate({opacity: 0}, 0, 'swing', ()=> {
                    currentTab.show();
                });
            }else {
                currentTab.show();

            }
            previousTab = currentTab;
            isPreviousTab = true;

            if(isDropDownOpen) {
                currentTab.animate({opacity: 1}, 0);
            }else{
                $dropDown.slideDown(400, ()=>{
                    currentTab.animate({opacity: 1}, 400, 'swing', ()=> {
                        isDropDownOpen = true;
                    });
                    console.log(isDropDownOpen);

                });
            }
            console.log(isDropDownOpen);
        });

        $tabClose.on('click', function () {

            let tabToClose = currentTab;
            tabToClose.animate({opacity: 0}, 400, 'swing', ()=>{
                $dropDown.slideUp(400, ()=>{
                    tabToClose.hide();
                    isDropDownOpen = false;
                });
            });

            isPreviousTab = false;
            console.log(isDropDownOpen);

        });
    }
}
