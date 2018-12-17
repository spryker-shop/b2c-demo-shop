import Component from 'ShopUi/models/component';

export default class BreakpointDependentBlockPlacer extends Component {
    protected data: Object[]
    protected blocks: HTMLElement[]

    protected readyCallback(): void {
        this.blocks = <HTMLElement[]>Array.from(document.querySelectorAll(this.blockSelector));

        this.data = this.blocks.map((block: HTMLElement) => {
            return {
                isMoved: false,
                node: block,
                parentNode: block.parentElement,
                breakpoint: +this.getDataAttribute(block, 'data-breackpoint'),
                selectorBlockToMove: this.getDataAttribute(block, 'data-block-to')
            }
        });

        this.initBlockMoving();
        this.mapEvents();
    }

    protected mapEvents(): void {
        window.addEventListener('resize', () => setTimeout(() => this.initBlockMoving(), 300));
    }

    protected initBlockMoving(): void {
        this.data.forEach((item: {breakpoint: number, selectorBlockToMove: string, node: HTMLElement, parentNode: HTMLElement, isMoved: boolean}) => {
            let {isMoved, breakpoint} = item;

            if (window.innerWidth < breakpoint && !isMoved) {
                const {selectorBlockToMove, node} = item;
                const blockToMove = document.querySelector(selectorBlockToMove);

                item.isMoved = true;
                blockToMove.appendChild(node);
            } else if (window.innerWidth >= breakpoint && isMoved) {
                const {parentNode, node} = item;

                item.isMoved = false;
                parentNode.appendChild(node);
            }
        })
    }

    get blockSelector(): string {
        return this.getAttribute('block-selector');
    }

    protected getDataAttribute(block: HTMLElement, attr: string): string {
        return block.getAttribute(attr);
    }
}
