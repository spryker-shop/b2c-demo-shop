import Component from 'ShopUi/models/component';

interface BlockMovingInterface {
    breakpoint: number;
    classNameBlockToMove: string;
    node: HTMLElement;
    parentNode: HTMLElement;
    isMoved: boolean;
}

export default class BreakpointDependentBlockPlacer extends Component {
    protected data: Object[];
    protected blocks: HTMLElement[];
    protected timeout: number = 300;

    protected readyCallback(): void {}

    protected init(): void {
        this.blocks = <HTMLElement[]>Array.from(document.getElementsByClassName(this.blockClassName));

        this.data = this.blocks.map((block: HTMLElement) => {
            return {
                isMoved: false,
                node: block,
                parentNode: block.parentElement,
                breakpoint: +this.getDataAttribute(block, 'data-breakpoint'),
                classNameBlockToMove: this.getDataAttribute(block, 'data-block-to')
            };
        });

        this.initBlockMoving();
        this.mapEvents();
    }

    protected mapEvents(): void {
        window.addEventListener('resize', () => {
            setTimeout(() => this.initBlockMoving(), this.timeout);
        });
    }

    protected initBlockMoving(): void {
        this.data.forEach((item: BlockMovingInterface) => {
            if (window.innerWidth < item.breakpoint && !item.isMoved) {
                const {classNameBlockToMove, node} = item;
                const blockToMove = document.getElementsByClassName(classNameBlockToMove)[0];

                item.isMoved = true;
                blockToMove.appendChild(node);
            } else if (window.innerWidth >= item.breakpoint && item.isMoved) {
                const {parentNode, node} = item;

                item.isMoved = false;
                parentNode.appendChild(node);
            }
        });
    }

    protected getDataAttribute(block: HTMLElement, attr: string): string {
        return block.getAttribute(attr);
    }

    protected get blockClassName(): string {
        return this.getAttribute('block-class-name');
    }
}
