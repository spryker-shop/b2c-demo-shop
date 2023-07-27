import Component from 'ShopUi/models/component';
import { mount } from 'ShopUi/app';

export default class PageLoadState extends Component {
    protected body: HTMLBodyElement;
    protected readyCallback(): void {}

    protected async init(): Promise<void> {
        this.body = <HTMLBodyElement>document.body;

        await mount();
        this.onLoad();
    }

    protected onLoad(): void {
        this.body.classList.remove(this.loadingClassName);
    }

    protected get loadingClassName(): string {
        return this.getAttribute('body-loading-class-name');
    }
}
