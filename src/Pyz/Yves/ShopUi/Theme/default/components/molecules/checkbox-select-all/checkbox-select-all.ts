import Component from 'ShopUi/models/component';

export default class CheckboxSelectAll extends Component {
    protected trigger: HTMLInputElement;
    protected targets: HTMLInputElement[];
    protected eventChange: Event = new Event('change');

    protected readyCallback(): void {}

    protected init(): void {
        this.trigger = <HTMLInputElement>this.getElementsByClassName(`${this.jsName}__input`)[0];
        this.targets = <HTMLInputElement[]>Array.from(document.getElementsByClassName(this.targetClassName));

        this.getActiveTargets();
        this.disableTrigger();
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.trigger.addEventListener('change', () => this.onTriggerChange());
        this.targets.forEach((target: HTMLInputElement) => {
            target.addEventListener('change', () => this.onTargetChange());
        });
    }

    protected onTriggerChange(): void {
        this.toggleTargets();
    }

    protected onTargetChange(): void {
        this.toggleTrigger();
    }

    protected getActiveTargets(): void {
        this.targets = this.targets.filter((target: HTMLInputElement) => !target.disabled);
    }

    protected toggleTriggerState(isTriggerChecked: boolean, isTriggerAdditionalIconVisible: boolean): void {
        this.trigger.checked = isTriggerChecked;
        this.trigger.classList.toggle(this.classToToggle, isTriggerAdditionalIconVisible);
    }

    protected disableTrigger(): void {
        this.trigger.disabled = !this.targets.some((target: HTMLInputElement) => !target.disabled);
    }

    toggleTrigger(): void {
        const checkedTargets = this.targets.filter((target: HTMLInputElement) => target.checked);
        const isTriggerChecked = this.trigger.checked;
        const isAllTargetsChecked = this.targets.length === checkedTargets.length;
        const isAllTargetsUnchecked = !checkedTargets.length;

        if (isAllTargetsChecked) {
            this.toggleTriggerState(true, false);

            return;
        }

        if (isAllTargetsUnchecked) {
            this.toggleTriggerState(false, false);

            return;
        }

        if (isTriggerChecked) {
            this.toggleTriggerState(false, true);
        }
    }

    toggleTargets(): void {
        const triggerState = this.trigger.checked;

        this.targets.forEach((target: HTMLInputElement) => {
            target.checked = triggerState;
            target.dispatchEvent(this.eventChange);
        });

        this.toggleTrigger();
    }

    protected get targetClassName(): string {
        return this.getAttribute('target-class-name');
    }

    protected get classToToggle(): string {
        return this.getAttribute('class-to-toggle');
    }
}
