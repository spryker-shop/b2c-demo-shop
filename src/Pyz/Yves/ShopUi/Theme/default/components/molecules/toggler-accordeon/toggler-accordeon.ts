import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';

export default class TogglerAccordeon extends Component {

    readyCallback(): void {
        const triggerSelector = $(this).attr('trigger');
        const triggers = $(triggerSelector);
        const classToToggle = $(this).attr('class-to-toggle');

        triggers.each(function(){
            const _self = $(this);
            const targetSelector = _self.data('toggle-target');
            const target = $(targetSelector);

            _self.on('click', function(){
                target.toggleClass(classToToggle);
                if (!target.hasClass(classToToggle)) {
                    _self.addClass('active');
                    return;
                }
                _self.removeClass('active');
            });
        });
    }

}
