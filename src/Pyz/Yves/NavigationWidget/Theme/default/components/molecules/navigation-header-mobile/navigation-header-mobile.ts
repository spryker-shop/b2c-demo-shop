import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';

export default class NavHeaderMobile extends Component {

    readyCallback(): void {

        // menu scroll goes here

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

        // menu dropdown goes here


        const $dropDown = $(this).find(`.${this.name}__dropdown-container`);
        const $tabs = $dropDown.find(`.${this.name}__tab`);
        const $tabTogglers = $scroll.find('[data-target]');
        const $tabClose = $dropDown.find(`.${this.name}__tab-close`);

        let isDropDownOpen = false;
        let isPreviousTab = false;
        let isDropDownInAction = false;
        let previousToggler;
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

        function openDropDown(){
            if(!isDropDownOpen) {
                isDropDownOpen = true;
                $dropDown.slideDown(200, () => {
                    currentTab.animate({opacity: 1}, 100, 'swing', () => {
                        isDropDownOpen = true;
                        isDropDownInAction = false;
                        console.log(isDropDownInAction);
                    });
                });
            }
        }

        function closeDropDown(){
            if(isDropDownOpen) {
                isDropDownInAction = true;
                let tabToClose = currentTab;
                tabToClose.animate({opacity: 0}, 100, 'swing', ()=>{
                    $dropDown.slideUp(200, ()=>{
                        tabToClose.hide();
                        currentTab.hide().animate({opacity: 0}, 0);
                        previousTab.hide().animate({opacity: 0}, 0);
                        isDropDownOpen = false;
                        isPreviousTab = false;
                        isDropDownInAction = false;
                        if(previousToggler) previousToggler.removeClass('active');

                    });
                });
            }
        }

        function openTab(toggler, tabs){
            if(previousToggler) previousToggler.removeClass('active');
            toggler.addClass('active');

            currentTab = findCurrentTab(toggler, tabs);

            if(isPreviousTab) {
                previousTab.hide().animate({opacity: 0}, 0, 'swing', ()=> {
                    currentTab.show().animate({opacity: 1}, 200);
                })
            }else {
                currentTab.show().animate({opacity: 1}, 200);

            }

            previousTab = currentTab;
            previousToggler = toggler;
            isPreviousTab = true;
        }

        $tabTogglers.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if(!isDropDownInAction){
                let currentToggler = $(this);
                openTab(currentToggler, $tabs);

                openDropDown();
            }

        });

        $tabClose.on('click', function () {

            closeDropDown();

        });
    }
}
