import Component from 'ShopUi/models/component';
import noUiSlider from 'nouislider';

interface SliderConfig {
    start: string[];
    step: number;
    connect: boolean;
    margin: number;
    range: {
        'min': number,
        'max': number
    };
}

export default class RangeSlider extends Component {
    protected wrap: HTMLElement;
    protected sliderConfig: SliderConfig;
    protected targetSelectors: HTMLInputElement[];
    protected valueTarget: HTMLElement[];

    protected readyCallback(): void {}

    protected init(): void {
        this.wrap = <HTMLElement>this.getElementsByClassName(this.wrapClassName)[0];
        this.targetSelectors = <HTMLInputElement[]>Array.from(this.getElementsByClassName(this.targetClassName));
        this.sliderConfig = {
            start: [ this.valueCurrentMin, this.valueCurrentMax ],
            step: this.stepAttribute,
            connect: this.connectAttribute,
            margin: this.marginAttribute,
            range: {
                min: Number(this.valueMin),
                max: Number(this.valueMax)
            }
        };
        this.initialize();
    }

    protected initialize(): void {
        noUiSlider.create(this.wrap, this.sliderConfig);
        this.updateValues(this.wrap, this.targetSelectors);

        if (this.valueClassName) {
            this.valueTarget = <HTMLElement[]>Array.from(this.getElementsByClassName(this.valueClassName));
            this.updateSelectors(this.wrap, this.valueTarget);
        }
    }

    protected updateValues(wrap: noUiSlider, target: HTMLInputElement[]): void {
        const update = (values, handle) => {
            if (Number(values[handle]) === Number(this.sliderConfig.start[handle])) {
                return;
            }

            target[handle].value = `${Number(values[handle])}`;
        };

        wrap.noUiSlider.on('update', update);
    }

    protected updateSelectors(wrap: noUiSlider, target: HTMLElement[]): void {
        const currency = (target[0].innerHTML).replace(/[0-9_,.]/g, '');
        const update = (values, handle) => {
            currency.search(/&nbsp;/i) !== -1 ?
                target[handle].innerHTML = `${Number(values[handle])}${currency}` :
                target[handle].innerHTML = `${currency}${Number(values[handle])}`;
        };

        wrap.noUiSlider.on('update', update);
    }

    protected get wrapClassName(): string {
        return this.getAttribute('wrap-class-name');
    }

    protected get valueClassName(): string {
        return this.getAttribute('value-class-name');
    }

    protected get targetClassName(): string {
        return this.getAttribute('target-class-name');
    }

    protected get valueMin(): string {
        return this.getAttribute('value-min');
    }

    protected get valueMax(): string {
        return this.getAttribute('value-max');
    }

    protected get valueCurrentMin(): string {
        return this.getAttribute('active-min');
    }

    protected get valueCurrentMax(): string {
        return this.getAttribute('active-max');
    }

    protected get stepAttribute(): number {
        return parseInt(this.getAttribute('step'));
    }

    protected get connectAttribute(): boolean {
        return Boolean(this.getAttribute('connect'));
    }

    protected get marginAttribute(): number {
        return parseInt(this.getAttribute('margin'));
    }
}
