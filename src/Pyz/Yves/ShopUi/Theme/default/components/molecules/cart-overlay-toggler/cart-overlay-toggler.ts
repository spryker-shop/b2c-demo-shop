import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';

export default class CartOverlayToggler extends Component {

    readyCallback(): void {
        const triggerOpenSelector = $(this).attr('trigger-open');
        const triggerCloseSelector = $(this).attr('trigger-close')
        const triggerOpen = $(triggerOpenSelector);
        const triggerClose = $(triggerCloseSelector);
        const classToToggle = $(this).attr('class-to-toggle');
        const toggleTarget = $(this).attr('toggle-target');


        // triggers.each(function(){
        //     const _self = $(this);
        //     const targetSelector = _self.data('toggle-target');
        //     const target = $(targetSelector);
        //
        //     _self.on('click', function(){
        //         target.toggleClass(classToToggle);
        //         if (!target.hasClass(classToToggle)) {
        //             _self.addClass('active');
        //             return;
        //         }
        //         _self.removeClass('active');
        //     });
        // });
        //
        console.log(triggerOpen);
    }

}
