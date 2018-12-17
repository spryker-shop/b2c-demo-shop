import Component from 'ShopUi/models/component';

export default class LanguageSwitcher extends Component {
    readonly selectList: HTMLSelectElement[];

    constructor() {
        super();
        this.selectList = <HTMLSelectElement[]>Array.from(document.querySelectorAll(`.${this.jsName}`));
    }

    protected readyCallback(): void {
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.selectList.forEach((select: HTMLSelectElement) => select.addEventListener('change', (event: Event) => this.onTriggerChange(event)));
    }

    protected onTriggerChange(event: Event): void {
        const selectTarget = <HTMLSelectElement>event.currentTarget;
        if(this.hasUrl(selectTarget)) {
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
