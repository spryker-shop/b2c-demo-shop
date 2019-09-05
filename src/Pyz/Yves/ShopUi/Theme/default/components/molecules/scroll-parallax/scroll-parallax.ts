import Component from 'ShopUi/models/component';

const DIRECTIONS = {
    TOP: 'top',
    DOWN: 'down'
};
const THROTTLE_DURATION = 300;

export default class ScrollParallax extends Component {
    protected target: HTMLElement;
    protected wrapper: HTMLElement;
    protected windowHeight: number;
    protected windowWidth: number;
    protected wrapperHeight: number;
    protected distanceToWrapper: number;
    protected initialized: boolean = false;

    protected readyCallback(): void {}

    protected init(): void {
        this.wrapper = <HTMLElement>document.getElementsByClassName(this.wrapperClassName)[0];
        this.target = <HTMLElement>this.wrapper.getElementsByClassName(this.targetClassName)[0];
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
        if (!isNaN(this.minBreakPoint) && !isNaN(this.maxBreakPoint)) {
            if (this.minBreakPoint < this.windowWidth && this.maxBreakPoint > this.windowWidth) {
                this.moveTarget();

                return;
            }
            this.cleanOffset();
        }
    }

    protected cleanOffset(): void {
        if (this.initialized) {
            this.initialized = false;
            this.target.removeAttribute('style');
        }
    }

    protected moveTarget(): void {
        const scrollHeight: number = window.scrollY + this.windowHeight;
        let targetOffset = '';

        if (scrollHeight > this.distanceToWrapper) {
            if (this.motionDirection === DIRECTIONS.TOP) {
                targetOffset = `-${this.getTargetOffset(scrollHeight)}`;
            }
            if (this.motionDirection === DIRECTIONS.DOWN) {
                targetOffset = this.getTargetOffset(scrollHeight);
            }
            if (targetOffset !== '') {
                this.target.style.transform = `translateY(${targetOffset})`;
                this.initialized = true;
            }
        }
    }

    protected getTargetOffset(scrollHeight: number): string {
        return `${(scrollHeight - this.distanceToWrapper) / this.motionRatio}px`;
    }

    protected getDistanceToWrapper(): number {
        let wrapper: HTMLElement = this.wrapper;
        let yPosition = 0;

        while (wrapper) {
            yPosition += (wrapper.offsetTop - wrapper.scrollTop + wrapper.clientTop);
            wrapper = <HTMLElement>wrapper.offsetParent;
        }

        return yPosition;
    }

    protected get wrapperClassName(): string {
        return this.getAttribute('wrapper-class-name');
    }

    protected get targetClassName(): string {
        return this.getAttribute('target-class-name');
    }

    protected get motionRatio(): number {
        return +this.getAttribute('motion-ratio');
    }

    protected get motionDirection(): string {
        return this.getAttribute('motion-direction');
    }

    protected get minBreakPoint(): number {
        return +this.getAttribute('breakpoint-min');
    }

    protected get maxBreakPoint(): number {
        return +this.getAttribute('breakpoint-max');
    }
}
