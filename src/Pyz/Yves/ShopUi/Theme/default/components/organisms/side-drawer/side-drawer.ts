import SideDrawerCore from 'ShopUi/components/organisms/side-drawer/side-drawer';

export default class SideDrawer extends SideDrawerCore {
    protected overlay: HTMLElement;

    protected init(): void {
        this.overlay = <HTMLElement>document.getElementsByClassName(this.overlayClassName)[0];

        super.init();
    }

    protected mapOverlayEvents(): void {
        super.mapOverlayEvents();

        if (this.shouldCloseByOverlayClick) {
            this.mapOverlayClickEvent();
        }
    }

    protected mapOverlayClickEvent(): void {
        this.overlay.addEventListener('click', () => this.toggle(false));
    }

    protected toggle(isShownFromOutside?: boolean): void {
        const isShown = isShownFromOutside ?? !this.classList.contains(`${this.name}--show`);

        this.classList.toggle(`${this.name}--show`, isShown);
        this.containers.forEach((conatiner: HTMLElement) => conatiner.classList.toggle(`is-not-scrollable`, isShown));
        this.toggleOverlay(isShown);
    }

    protected get overlayClassName(): string {
        return this.getAttribute('overlay-class-name');
    }

    protected get shouldCloseByOverlayClick(): boolean {
        return this.hasAttribute('should-close-by-overlay-click');
    }
}
