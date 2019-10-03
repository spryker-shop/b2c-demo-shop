import TogglerRadio from 'ShopUi/components/molecules/toggler-radio/toggler-radio';

export default class TogglerRadioExtended extends TogglerRadio {
    protected readyCallback(): void {}

    protected init(): void {
        super.readyCallback();
    }

    toggle(addClass: boolean = this.addClass): void {
        this.targets.forEach((element: HTMLElement) => {
            if (!addClass) {
                element.classList.remove(this.classToToggle);

                return;
            }

            element.classList.add(this.classToToggle);
        });
    }
}
