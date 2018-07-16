import Component from 'ShopUi/models/component';
import noUiSlider from 'nouislider';

export default class RangeSlider extends Component {

    protected readyCallback(): void {
        const wrap = <any> document.querySelector(this.wrapSelector);
        const sliderConfig = {
            start: [ this.valueCurrentMin, this.valueCurrentMax ],
            step: 1,
            connect: true,
            range: {
                'min': +this.valueMin,
                'max': +this.valueMax
            }
        };

        noUiSlider.create(wrap, sliderConfig);

        const valueUpdate = (wrap, target, type) => {
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

        if(this.valueSelector !== '') {
            const valueTarget = document.querySelectorAll(JSON.parse(this.valueSelector));
            valueUpdate(wrap, valueTarget, false);
        }

        const targetSelector = document.querySelectorAll(JSON.parse(this.targetSelector));
        valueUpdate(wrap, targetSelector, true);
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