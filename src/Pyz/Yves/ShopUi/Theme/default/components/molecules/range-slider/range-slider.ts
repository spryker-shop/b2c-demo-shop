import Component from 'ShopUi/models/component';
import noUiSlider from 'nouislider';

export default class RangeSlider extends Component {
    protected wrap: HTMLElement
    protected sliderConfig: Object
    protected targetSelectors: HTMLElement[]
    protected valueTarget: HTMLElement[]

    protected readyCallback(): void {
        this.wrap = <HTMLElement>document.querySelector(this.wrapSelector);
        this.targetSelectors = <HTMLElement[]>Array.from(document.querySelectorAll(JSON.parse(this.targetSelector)));
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
        this.update(this.wrap, this.targetSelectors, true);

        if(this.valueSelector !== '') {
            this.valueTarget = <HTMLElement[]>Array.from(document.querySelectorAll(JSON.parse(this.valueSelector)));
            this.update(this.wrap, this.valueTarget, false);
        }
    }

    protected init(): void {
        noUiSlider.create(this.wrap, this.sliderConfig);
    }

    protected update(wrap: noUiSlider, target: Array<any>, type: boolean): void {
        if(type) {
            wrap.noUiSlider.on('update', function( values, handle ) {
                target[handle].value = Number(values[handle]);
            });
        } else {
            const currency = (target[0].innerHTML).replace(/[0-9_,.]/g, '');
            wrap.noUiSlider.on('update', function (values, handle) {
                currency.search(/&nbsp;/i) !==-1 ?
                    target[handle].innerHTML = Number(values[handle]) + currency
                    :
                    target[handle].innerHTML = currency + Number(values[handle]);
            });
        }
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
