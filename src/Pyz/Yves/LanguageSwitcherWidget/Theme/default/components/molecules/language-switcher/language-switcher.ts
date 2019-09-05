import Component from 'ShopUi/models/component';

export default class LanguageSwitcher extends Component {
    protected select: HTMLSelectElement;

    protected readyCallback(): void {}

    protected init(): void {
        this.select = <HTMLSelectElement>this.getElementsByClassName(`${this.jsName}__select`)[0];
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.select.addEventListener('change', (event: Event) => this.onTriggerChange(event));
    }

    protected onTriggerChange(event: Event): void {
        const selectTarget = <HTMLSelectElement>event.currentTarget;

        if (this.hasUrl(selectTarget)) {
            window.location.assign(this.currentSelectValue(selectTarget));
        }
    }

    protected currentSelectValue(select: HTMLSelectElement): string {
        return select.options[select.selectedIndex].value;
    }

    protected hasUrl(select: HTMLSelectElement): boolean {
        return !!select.value;
    }
}
