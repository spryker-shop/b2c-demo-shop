import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';

export default class CartOverlayToggler extends Component {

    readyCallback(): void {
        const triggerOpenSelector = $(this).attr('trigger-open');
        const triggerCloseSelector = $(this).attr('trigger-close')
        const triggerOpen = $(triggerOpenSelector);
        const triggerClose = $(triggerCloseSelector);
        const classToToggle = $(this).attr('class-to-toggle');
        const toggleTargetSelector = $(this).attr('toggle-target');
        const toggleTarget = $(toggleTargetSelector);

        triggerOpen.mouseenter(function () {
            if(!toggleTarget.hasClass('is-active')){
                toggleTarget.addClass(classToToggle);
                triggerOpen.addClass('is-active');
            }
        });
        triggerClose.mouseenter(function () {
            toggleTarget.removeClass(classToToggle);
            triggerOpen.removeClass('is-active');
        });
    }

}
