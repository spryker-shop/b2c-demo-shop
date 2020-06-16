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
        this.toggleTargetsState();
    }

    protected onTargetChange(): void {
        this.toggleTriggerState();
    }

    protected getActiveTargets(): void {
        this.targets = this.targets.filter((target: HTMLInputElement) => !target.disabled);
    }

    toggleTriggerState(): void {
        const isTriggerChecked = this.trigger.checked;
        const isAllTargetsChecked = this.targets.every((target: HTMLInputElement) => target.checked);
        const isAllTargetsUnchecked = this.targets.every((target: HTMLInputElement) => !target.checked);
        const isTriggerIconChanged = this.targets.some((target: HTMLInputElement) => !target.checked);

        if (isAllTargetsChecked) {
            this.trigger.checked = true;
            this.trigger.classList.remove(this.classToToggle);

            return;
        }

        if (isAllTargetsUnchecked) {
            this.trigger.checked = false;
            this.trigger.classList.remove(this.classToToggle);

            return;
        }

        if (isTriggerIconChanged && isTriggerChecked) {
            this.trigger.checked = false;
            this.trigger.classList.add(this.classToToggle);

            return;
        }
    }

    toggleTargetsState(): void {
        const triggerState = this.trigger.checked;

        this.targets.forEach((target: HTMLInputElement) => {
            target.checked = triggerState;
            target.dispatchEvent(this.eventChange);
        });

        this.toggleTriggerState();
    }

    protected disableTrigger(): void {
        this.trigger.disabled = this.targets.every((target: HTMLInputElement) => target.disabled);
    }

    protected get targetClassName(): string {
        return this.getAttribute('target-class-name');
    }

    protected get classToToggle(): string {
        return this.getAttribute('class-to-toggle');
    }
}
