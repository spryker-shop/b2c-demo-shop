import WindowLocationApplicatorCore from 'CatalogPage/components/molecules/window-location-applicator/window-location-applicator';

export default class WindowLocationApplicator extends WindowLocationApplicatorCore {
    protected sortTriggers: HTMLSelectElement[];

    protected init(): void {
        this.sortTriggers = <HTMLSelectElement[]>Array.from(document.getElementsByClassName(this.sortTriggerClassName));

        super.init();
    }

    protected mapEvents(): void {
        this.sortTriggers.forEach((element: HTMLSelectElement) => {
            element.addEventListener('change', (event: Event) => this.onTriggerEvent(event));
        });

        super.mapEvents();
    }

    protected get sortTriggerClassName(): string {
        return this.getAttribute('sort-trigger-class-name');
    }
}
