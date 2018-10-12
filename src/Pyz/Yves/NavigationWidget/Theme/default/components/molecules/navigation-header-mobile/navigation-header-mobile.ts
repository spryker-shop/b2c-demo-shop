import Component from 'ShopUi/models/component';

export default class NavHeaderMobile extends Component {
    readonly activeClass = 'active'
    readonly dropDownActiveClass = `${this.name}__dropdown-container--active`
    readonly tabActiveClass = `${this.name}__tab--active`
    readonly arrowHiddenClass = `${this.name}__arrow--hidden`

    private currentTab: HTMLElement
    private previousToggler: HTMLElement
    private previousTab: HTMLElement
    private isDropDownOpen: boolean = false
    private isDropDownInAction: boolean = false
    private isPreviousTab: boolean = false

    protected container: HTMLElement
    protected scrollElement: HTMLElement
    protected arrowLeft: HTMLElement
    protected arrowRight: HTMLElement
    protected dropDown: HTMLElement
    protected tabs: HTMLElement[]
    protected tabTogglers: HTMLElement[]
    protected tabClosers: HTMLElement[]

    readyCallback(): void {
        this.initMenuScroll();
        this.initMenuDropDown();
        this.mapEvents();
    }

    protected initMenuScroll(): void {
        this.container = this.querySelector(`.${this.name}__block`);
        this.scrollElement = this.container.querySelector(`.${this.name}__scroll`);
        this.arrowLeft = this.container.querySelector(`.${this.name}__arrow--left`);
        this.arrowRight = this.container.querySelector(`.${this.name}__arrow--right`);
    }

    protected initMenuDropDown(): void {
        this.dropDown = this.querySelector(`.${this.name}__dropdown-container`);
        this.tabs = Array.from(this.dropDown.querySelectorAll(`.${this.name}__tab`));
        this.tabTogglers = Array.from(this.scrollElement.querySelectorAll('[data-target]'));
        this.tabClosers = Array.from(this.dropDown.querySelectorAll(`.${this.name}__tab-close`));
    }

    protected mapEvents(): void {
        this.scrollElement.addEventListener('scroll', this.toggleArrow.bind(this));
        this.tabTogglers.forEach(tab => tab.addEventListener('click', this.tabHandler.bind(this, tab)));
        this.tabClosers.forEach(tab => tab.addEventListener('click', this.closeDropDown.bind(this)))
    }

    protected toggleArrow(e): void {
        const currentPosition = e.target.scrollLeft,
              startPosition = 30,
              endPosition = this.scrollElement.scrollWidth - this.scrollElement.offsetWidth - startPosition;

        if(currentPosition > startPosition && currentPosition < endPosition) {
            this.arrowLeft.classList.remove(this.arrowHiddenClass);
            this.arrowRight.classList.remove(this.arrowHiddenClass);
        } else if(currentPosition < startPosition) {
            this.arrowLeft.classList.add(this.arrowHiddenClass);
        } else {
            this.arrowRight.classList.add(this.arrowHiddenClass);
        }
    }

    protected tabHandler(tab: HTMLElement, e: Event): void {
        e.preventDefault();
        e.stopPropagation();

        if(!this.isDropDownInAction) {
            const currentToggler = tab;
            this.openTab(currentToggler, this.tabs);
            this.openDropDown();
        }
    }

    protected closeDropDown(): void {
        if(this.isDropDownOpen) {
            this.dropDown.classList.remove(this.dropDownActiveClass);
            this.isDropDownInAction = true;
            this.isDropDownOpen = false;
            this.isPreviousTab = false;
            this.isDropDownInAction = false;

            if(this.previousToggler) {
                this.previousToggler.classList.remove(this.activeClass);
            }

            setTimeout(() => {
                this.previousTab.classList.remove(this.tabActiveClass);
                this.currentTab.classList.remove(this.tabActiveClass);
            }, 250);
        }
    }

    protected openTab(toggler: HTMLElement, tabs: HTMLElement[]): void {
        this.currentTab = this.findCurrentTab(toggler, tabs);
        toggler.classList.add(this.activeClass);

        if(this.previousToggler && this.currentTab !== this.previousTab) {
            this.previousToggler.classList.remove(this.activeClass);
        }
        
        if(this.isPreviousTab) {
            this.previousTab.classList.remove(this.tabActiveClass);
            this.currentTab.classList.add(this.tabActiveClass);
        } else {
            this.currentTab.classList.add(this.tabActiveClass);
        }

        this.previousTab = this.currentTab;
        this.previousToggler = toggler;
        this.isPreviousTab = true;
    }

    protected openDropDown(): void {
        if(!this.isDropDownOpen) {
            this.isDropDownOpen = true;
            this.dropDown.classList.add(this.dropDownActiveClass);
            this.isDropDownInAction = false;
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
}
