import Component from 'ShopUi/models/component';

const DIRECTIONS = {
    top: 'top',
    right: 'right',
    bottom: 'bottom',
    left: 'left',
};

const PROPORTIONS = {
    width: 'width',
    height: 'height',
};

interface ClonedElement {
    element: HTMLElement;
    coordinates: DOMRect;
    pageXScroll: number;
    pageYScroll: number;
    animationStarted: number;
}

export default class NodeAnimator extends Component {
    protected triggers: HTMLElement[];
    protected target: HTMLElement;
    protected targetCoordinates: DOMRect;
    protected clonedElements: ClonedElement[] = [];
    protected animationDuration: number;
    protected percent: number = 100;
    protected exponent: number = 2;
    protected observer: IntersectionObserver;
    protected viewportOptions: IntersectionObserverInit = {
        rootMargin: '0px',
        threshold: 0,
    };
    protected isTargetInViewport: boolean = true;

    protected readyCallback(): void {}

    protected init(): void {
        this.triggers = <HTMLElement[]>Array.from(document.getElementsByClassName(this.triggerClassName));
        this.animationDuration = this.animationDurationValue;
        this.validateTarget();

        if (!this.triggers.length || !this.target) {
            return;
        }

        this.observer = this.observerInit();
        this.observerSubscriber();
        this.mapEvents();
    }

    protected observerInit(): IntersectionObserver {
        return new IntersectionObserver(
            this.observerCallback(),
            this.viewportOptions,
        );
    }

    protected observerCallback(): IntersectionObserverCallback {
        return (entries: IntersectionObserverEntry[], observer: IntersectionObserver) => {
            entries.forEach((entry: IntersectionObserverEntry) => {
                this.targetState = Boolean(entry.intersectionRatio) || entry.isIntersecting;
            });
        };
    }

    protected observerSubscriber(): void {
        this.observer.observe(this.target);
    }

    protected validateTarget(): void {
        if (!this.target || this.target.offsetParent === null) {
            this.target = <HTMLElement>Array.from(document.getElementsByClassName(this.targetClassName))
                .filter((target: HTMLElement) => target.offsetParent !== null)[0];
        }

        if (!this.target) {
            return;
        }

        this.updateTargetCoordinates();
    }

    protected updateTargetCoordinates(): void {
        this.targetCoordinates = <DOMRect>this.target.getBoundingClientRect();
    }

    protected set targetState(isInViewport: boolean) {
        if (this.isTargetInViewport !== isInViewport) {
            this.validateTarget();
        }

        this.isTargetInViewport = isInViewport;
    }

    protected mapEvents(): void {
        this.mapTriggerClickEvent();
    }

    protected mapTriggerClickEvent(): void {
        this.triggers.forEach((trigger: HTMLElement) => {
            trigger.addEventListener('click', () => this.onClick(trigger));
        });
    }

    protected onClick(trigger: HTMLElement): void {
        this.cloneElement(trigger);
    }

    protected cloneElement(trigger: HTMLElement): void {
        const wrapperSelector = trigger.dataset.nodeAnimatorWrapperClassName ?? this.wrapperClassName;
        const wrapper = <HTMLElement>trigger.closest(`.${wrapperSelector}`);

        const elementSelector = trigger.dataset.nodeAnimatorNodeClassName ?? this.elementClassName;
        const element = <HTMLElement>wrapper.getElementsByClassName(elementSelector)[0];
        const elementCoordinates = <DOMRect>element.getBoundingClientRect();

        const clonedNode = <HTMLElement>element.cloneNode(true);
        clonedNode.className = `${this.name}__image ${this.cloneNodeClassNames} ${trigger.dataset.cloneNodeClassNames ?? ''}`;
        clonedNode.style.cssText = `
            top: ${elementCoordinates.top + pageYOffset}px;
            left: ${elementCoordinates.left + pageXOffset}px;
            width: ${elementCoordinates.width}px;
            height: ${elementCoordinates.height}px;
        `;
        this.clonedElements.push({
            element: clonedNode,
            coordinates: elementCoordinates,
            pageXScroll: pageXOffset,
            pageYScroll: pageYOffset,
            animationStarted: performance.now(),
        });
        document.body.appendChild(clonedNode);
        this.startAnimation();
    }

    protected startAnimation(): void {
        requestAnimationFrame((time: number) => this.animateElement(time));
    }

    protected animateElement(time: number): void {
        if (!this.clonedElements.length) {
            return;
        }

        this.moveElements(time);
        this.startAnimation();
    }

    protected moveElements(time: number): void {
        this.clonedElements.forEach((item: ClonedElement) => {
            const timeFraction = (time - item.animationStarted) / this.animationDuration;
            const progress = Math.pow(timeFraction, this.exponent);
            const percentageProgress = progress * this.percent;

            if (this.isTargetInViewport) {
                this.validateTarget();
            }

            const sides = [
                DIRECTIONS.top,
                DIRECTIONS.left,
                PROPORTIONS.width,
                PROPORTIONS.height,
            ];
            this.setAnimationDistance(sides, item, percentageProgress);

            if (percentageProgress <= this.percent) {
                return;
            }

            this.clonedElements.shift();
            document.body.removeChild(item.element);
        });
    }

    protected setAnimationDistance(sides: string[], element: ClonedElement, percentageProgress: number): void {
        sides.forEach((side: string) => {
            let pageOffset = 0;
            let initialPageOffset = 0;

            if (side === DIRECTIONS.left || side === DIRECTIONS.right) {
                initialPageOffset = element.pageXScroll;
                pageOffset = pageXOffset;
            }

            if (side === DIRECTIONS.top || side === DIRECTIONS.bottom) {
                initialPageOffset = element.pageYScroll;
                pageOffset = pageYOffset;
            }

            const elementCoordinates = Number(element.coordinates[side]) + initialPageOffset;
            const distance = elementCoordinates - (Number(this.targetCoordinates[side]) + pageOffset);
            const progressDistance = (distance * percentageProgress) / this.percent;

            const newDistance = elementCoordinates - progressDistance;
            element.element.style[side] = `${newDistance}px`;
        });
    }

    protected get triggerClassName(): string {
        return this.getAttribute('trigger-class-name');
    }

    protected get targetClassName(): string {
        return this.getAttribute('target-class-name');
    }

    protected get elementClassName(): string {
        return this.getAttribute('node-class-name');
    }

    protected get wrapperClassName(): string {
        return this.getAttribute('wrapper-class-name');
    }

    protected get cloneNodeClassNames(): string {
        return this.getAttribute('clone-node-class-names');
    }

    protected get animationDurationValue(): number {
        return Number(this.getAttribute('animation-duration'));
    }
    /* tslint:disable: max-file-line-count */
}
