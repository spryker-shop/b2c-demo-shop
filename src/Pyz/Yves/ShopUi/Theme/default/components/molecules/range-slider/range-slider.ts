import Component from 'ShopUi/models/component';
import noUiSlider from 'nouislider';

interface sliderConfig {
    start: Array<string>,
    step: number,
    connect: boolean,
    margin: number,
    range: {
        'min': number,
        'max': number
    }
}

export default class RangeSlider extends Component {
    protected wrap: HTMLElement
    protected sliderConfig: sliderConfig
    protected targetSelectors: HTMLInputElement[]
    protected valueTarget: HTMLElement[]

    protected readyCallback(): void {
        this.wrap = <HTMLElement>document.querySelector(this.wrapSelector);
        this.targetSelectors = <HTMLInputElement[]>Array.from(document.querySelectorAll(JSON.parse(this.targetSelector)));
        this.sliderConfig = {
            start: [ this.valueCurrentMin, this.valueCurrentMax ],
            step: 1,
            connect: true,
            margin: 1,
            range: {
                'min': +this.valueMin,
                'max': +this.valueMax
            }
        };
        this.init();
    }

    protected init(): void {
        noUiSlider.create(this.wrap, this.sliderConfig);
        this.updateValues(this.wrap, this.targetSelectors);

        if(this.valueSelector !== '') {
            this.valueTarget = <HTMLElement[]>Array.from(document.querySelectorAll(JSON.parse(this.valueSelector)));
            this.updateSelectors(this.wrap, this.valueTarget);
        }
    }
    
    protected updateValues(wrap: noUiSlider, target: Array<HTMLInputElement>): void {
        const update = (values, handle) => target[handle].value = Number(values[handle]) + '';

        wrap.noUiSlider.on('update', update);
    }
    
    protected updateSelectors(wrap: noUiSlider, target: Array<HTMLElement>): void {
        const currency = (target[0].innerHTML).replace(/[0-9_,.]/g, ''),
              update = (values, handle) => {
                  currency.search(/&nbsp;/i) !==-1 ?
                      target[handle].innerHTML = Number(values[handle]) + currency
                      :
                      target[handle].innerHTML = currency + Number(values[handle]);
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
}
