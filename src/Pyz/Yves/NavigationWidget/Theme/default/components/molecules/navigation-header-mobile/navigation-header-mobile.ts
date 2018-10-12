import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';

export default class NavHeaderMobile extends Component {
    private currentTab: HTMLElement
    private previousToggler: HTMLElement
    private previousTab: HTMLElement
    private isDropDownOpen: boolean = false
    private isDropDownInAction: boolean = false
    private isPreviousTab: boolean = false

    protected container: HTMLElement
    protected scrollEl: HTMLElement
    protected arrowLeft: HTMLElement
    protected arrowRight: HTMLElement
    protected dropDown: HTMLElement
    protected tabs: HTMLElement[]
    protected tabTogglers: HTMLElement[]
    protected tabClosers: HTMLElement[]

    readyCallback(): void {
        this.initMenuScroll();
        this.initMenuDropDown();
    }

    protected initMenuScroll(): void {
        this.container = this.querySelector(`.${this.name}__block`);
        this.scrollEl = this.container.querySelector(`.${this.name}__scroll`);
        this.arrowLeft = this.container.querySelector(`.${this.name}__arrow--left`);
        this.arrowRight = this.container.querySelector(`.${this.name}__arrow--right`);

        this.scrollElHandler();
    }

    protected scrollElHandler(): void {
        this.scrollEl.addEventListener('scroll', this.toggleArrow.bind(this));
    }

    protected toggleArrow(e): void {
        const point = e.target.scrollLeft,
              pointMin = 30,
              pointMax = this.scrollEl.scrollWidth - this.scrollEl.offsetWidth - 30;

        if(point > pointMin && point < pointMax) {
            $(this.arrowLeft).fadeIn(200);
            $(this.arrowRight).fadeIn(200);
        } else if(point < pointMin) {
            $(this.arrowLeft).fadeOut(200);
        } else {
            $(this.arrowRight).fadeOut(200);
        }
    }

    protected initMenuDropDown(): void {
        this.dropDown = this.querySelector(`.${this.name}__dropdown-container`);
        this.tabs = Array.from(this.dropDown.querySelectorAll(`.${this.name}__tab`));
        this.tabTogglers = Array.from(this.scrollEl.querySelectorAll('[data-target]'));
        this.tabClosers = Array.from(this.dropDown.querySelectorAll(`.${this.name}__tab-close`));

        this.menuDropDownOpenHandlers();
        this.menuDropDownCloseHandlers();
    }

    protected menuDropDownOpenHandlers(): void {
        const _this = this,
              tabHandler = function (e) {
                  e.preventDefault();
                  e.stopPropagation();

                  if(!_this.isDropDownInAction) {
                      let currentToggler = this;
                      _this.openTab(currentToggler, _this.tabs);
                      _this.openDropDown();
                  }
              };

        this.tabTogglers.forEach(tab => tab.addEventListener('click', tabHandler));
    }

    protected openTab(toggler: HTMLElement, tabs: HTMLElement[]): void {
        this.currentTab = this.findCurrentTab(toggler, tabs);
        toggler.classList.add('active');
        
        if(this.previousToggler) {
            this.previousToggler.classList.remove('active');
        }
        
        if(this.isPreviousTab) {
            $(this.previousTab).hide().animate({opacity: 0}, 0, 'swing', () => {
                $(this.currentTab).show().animate({opacity: 1}, 200);
            });
        } else {
            $(this.currentTab).show().animate({opacity: 1}, 200);
        }

        this.previousTab = this.currentTab;
        this.previousToggler = toggler;
        this.isPreviousTab = true;
    }

    protected openDropDown(): void {
        if(!this.isDropDownOpen) {
            this.isDropDownOpen = true;
            $(this.dropDown).slideDown(200, () => {
                $(this.currentTab).animate({opacity: 1}, 100, 'swing', () => {
                    this.isDropDownInAction = false;
                });
            });
        }
    }

    protected findCurrentTab(currentToggler: HTMLElement, tabs: HTMLElement[]): HTMLElement {
        let currentTab: HTMLElement;

        tabs.forEach(item => {
            if(currentToggler.getAttribute('data-target') === item.getAttribute('data-tab')) {
                currentTab = item;
                return;
            }
        });

        return currentTab;
    }

    protected menuDropDownCloseHandlers(): void {
        this.tabClosers.forEach(tab => tab.addEventListener('click', this.closeDropDown.bind(this)))
    }

    protected closeDropDown(): void {
        if(this.isDropDownOpen) {
            this.isDropDownInAction = true;
            let $tabToClose = $(this.currentTab);
            
            $tabToClose.animate({opacity: 0}, 100, 'swing', () => {
                $(this.dropDown).slideUp(200, () => {
                    $tabToClose.hide();
                    $(this.currentTab).hide();
                    $(this.previousTab).hide();
                    this.isDropDownOpen = false;
                    this.isPreviousTab = false;
                    this.isDropDownInAction = false;
                    if(this.previousToggler) {
                        this.previousToggler.classList.remove('active');
                    }
                });
            });
        }
    }
}
