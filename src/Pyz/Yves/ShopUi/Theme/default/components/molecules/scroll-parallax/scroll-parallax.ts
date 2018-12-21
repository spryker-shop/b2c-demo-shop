import Component from 'ShopUi/models/component';

const DIRECTIONS = {
    TOP: 'top',
    DOWN: 'down'
};
const THROTTLE_DURATION = 300;

export default class ScrollParallax extends Component {
    protected target: HTMLElement;
    protected wrapper: HTMLElement;
    windowHeight: number;
    windowWidth: number;
    wrapperHeight: number;
    distanceToWrapper: number;
    initialized: boolean;
    
    readyCallback(): void {
        this.wrapper = <HTMLElement>document.querySelector(this.wrapperSelector);
        this.target = <HTMLElement>this.wrapper.querySelector(this.targetSelector);
        this.initialized = false;
        this.defineDimensions();

        this.mapEvents();
    }

    protected mapEvents(): void {
        window.addEventListener('resize', () => setTimeout(() => this.defineDimensions(), THROTTLE_DURATION));
        window.addEventListener('scroll', this.checkBreakpointsToScroll.bind(this));
    }

    protected defineDimensions(): void {
        this.windowHeight = window.innerHeight;
        this.windowWidth = window.innerWidth;
        this.wrapperHeight = this.wrapper.offsetHeight;
        this.distanceToWrapper = this.getDistanceToWrapper();
    }

    protected checkBreakpointsToScroll(): void {
        if(this.minBreakPoint !== NaN && this.maxBreakPoint !== NaN) {
            if(this.minBreakPoint < this.windowWidth && this.maxBreakPoint > this.windowWidth) {
                this.moveTarget();
                return;
            }
            this.cleanOffset();
        }
    }

    protected cleanOffset(): void {
        if(this.initialized) {
            this.initialized = false;
            this.target.removeAttribute('style');
        }
    }

    protected moveTarget(): void {
        let scrollHeight: number = window.scrollY + this.windowHeight;
        let targetOffset: string = '';

        if(scrollHeight > this.distanceToWrapper) {
            if (this.motionDirection === DIRECTIONS.TOP) {
                targetOffset = `-${this.getTargetOffest(scrollHeight)}`;
            }
            if (this.motionDirection === DIRECTIONS.DOWN) {
                targetOffset = this.getTargetOffest(scrollHeight);
            }
            if (targetOffset !== '') {
                this.target.style.transform = `translateY(${targetOffset})`;
                this.initialized = true;
            }
        }
    }

    protected getTargetOffest(scrollHeight): string {
        return (scrollHeight - this.distanceToWrapper) / this.motionRatio + 'px';
    }

    protected getDistanceToWrapper(): number {
        let wrapper: HTMLElement = this.wrapper;
        let yPosition: number  = 0;

        while(wrapper) {
            yPosition += (wrapper.offsetTop - wrapper.scrollTop + wrapper.clientTop);
            wrapper = <HTMLElement>wrapper.offsetParent;
        }
        return yPosition;
    }

    get targetSelector(): string {
        return this.getAttribute('target-selector');
    }

    get wrapperSelector(): string {
        return this.getAttribute('wrapper-selector');
    }

    get motionRatio(): number {
        return +this.getAttribute('motion-ratio');
    }

    get motionDirection(): string {
        return this.getAttribute('motion-direction');
    }

    get minBreakPoint(): number {
        return +this.getAttribute('breakpoint-min');
    }

    get maxBreakPoint(): number {
        return +this.getAttribute('breakpoint-max');
    }
}
