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

    protected readyCallback(): void {
        this.wrap = <HTMLElement>document.getElementsByClassName(this.wrapSelector)[0];
        this.targetSelectors = <HTMLInputElement[]>Array.from(document.getElementsByClassName(this.targetSelector));
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
        this.init();
    }

    protected init(): void {
        noUiSlider.create(this.wrap, this.sliderConfig);
        this.updateValues(this.wrap, this.targetSelectors);

        if (this.valueSelector !== '') {
            this.valueTarget = <HTMLElement[]>Array.from(document.getElementsByClassName(this.valueSelector));
            this.updateSelectors(this.wrap, this.valueTarget);
        }
    }

    protected updateValues(wrap: noUiSlider, target: HTMLInputElement[]): void {
        const update = (values, handle) => target[handle].value = `${Number(values[handle])}`;

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

    protected get wrapSelector(): string {
        return this.getAttribute('wrap-selector');
    }

    protected get valueSelector(): string {
        return this.getAttribute('value-selector');
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

    protected get targetSelector(): string {
        return this.getAttribute('target-selector');
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
