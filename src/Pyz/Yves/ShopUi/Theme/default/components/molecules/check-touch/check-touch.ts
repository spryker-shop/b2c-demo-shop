import Component from 'ShopUi/models/component';

export default class CheckTouch extends Component {
    protected readyCallback(): void {}

    protected init(): void {
        this.addTouchClass();
    }

    protected addTouchClass(): void {
        if (this.isTouchDevice) {
            document.body.classList.add('touch');
        } else {
            document.body.classList.add('no-touch');
        }
    }

    protected get isTouchDevice(): boolean {
        return (('ontouchstart' in window)
            || (navigator.maxTouchPoints > 0)
            || (navigator.msMaxTouchPoints > 0));
    }
}
