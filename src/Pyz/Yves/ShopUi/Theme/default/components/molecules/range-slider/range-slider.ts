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
        this.wrap = <HTMLElement>document.querySelector(this.wrapSelector);
        this.targetSelectors = <HTMLInputElement[]>Array.from(document.querySelectorAll(this.targetSelector));
        this.sliderConfig = {
            start: [ this.valueCurrentMin, this.valueCurrentMax ],
            step: this.stepAttribute,
            connect: this.connectAttribute,
            margin: this.marginAttribute,
            range: {
                min: +this.valueMin,
                max: +this.valueMax
            }
        };
        this.init();
    }

    protected init(): void {
        noUiSlider.create(this.wrap, this.sliderConfig);
        this.updateValues(this.wrap, this.targetSelectors);

        if (this.valueSelector !== '') {
            this.valueTarget = <HTMLElement[]>Array.from(document.querySelectorAll(this.valueSelector));
            this.updateSelectors(this.wrap, this.valueTarget);
        }
    }

    protected updateValues(wrap: noUiSlider, target: HTMLInputElement[]): void {
        const update = (values, handle) => target[handle].value = `${+values[handle]}`;

        wrap.noUiSlider.on('update', update);
    }

    protected updateSelectors(wrap: noUiSlider, target: HTMLElement[]): void {
        const currency = (target[0].innerHTML).replace(/[0-9_,.]/g, '');
        const update = (values, handle) => {
            currency.search(/&nbsp;/i) !== -1 ?
                target[handle].innerHTML = `${+values[handle]}${currency}`
                :
                target[handle].innerHTML = `${currency}${+values[handle]}`;
        };

        wrap.noUiSlider.on('update', update);
    }

    get wrapSelector(): string {
        return this.getAttribute('wrap-selector');
    }

    get valueSelector(): string {
        return this.getAttribute('value-selector');
    }

    get valueMin(): string {
        return this.getAttribute('value-min');
    }

    get valueMax(): string {
        return this.getAttribute('value-max');
    }

    get valueCurrentMin(): string {
        return this.getAttribute('active-min');
    }

    get targetSelector(): string {
        return this.getAttribute('target-selector');
    }

    get valueCurrentMax(): string {
        return this.getAttribute('active-max');
    }

    get stepAttribute(): number {
        return parseInt(this.getAttribute('step'));
    }

    get connectAttribute(): boolean {
        return Boolean(this.getAttribute('connect'));
    }

    get marginAttribute(): number {
        return parseInt(this.getAttribute('margin'));
    }
}
