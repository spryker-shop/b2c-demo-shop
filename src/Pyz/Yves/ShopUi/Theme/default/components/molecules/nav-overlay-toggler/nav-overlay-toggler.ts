import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';

export default class NavOverlayToggler extends Component {

    readyCallback(): void {
        const triggerOpenSelector = $(this).attr('trigger-open');
        const triggerCloseSelector = $(this).attr('trigger-close');
        const triggerOpen = $(triggerOpenSelector);
        const triggerClose = $(triggerCloseSelector);

        const triggerCartSelector = $(this).attr('trigger-cart-open');
        const triggerUserSelector = $(this).attr('trigger-user-open');
        const triggerCart = $(triggerCartSelector);
        const triggerUser = $(triggerUserSelector);


        const classToToggle = $(this).attr('class-to-toggle');
        const toggleTargetSelector = $(this).attr('toggle-target');
        const toggleTarget = $(toggleTargetSelector);

        const toggleCartSelector = $(this).attr('toggle-cart-target');
        const toggleUserSelector = $(this).attr('toggle-user-target');
        const toggleCart = $(toggleCartSelector);
        const toggleUser = $(toggleUserSelector);


        triggerOpen.mouseenter(()=> {
            if(!toggleTarget.hasClass(classToToggle)){
                toggleTarget.addClass(classToToggle);
                triggerOpen.addClass(classToToggle);
            }
        });

        triggerClose.mouseenter(()=> {
            toggleTarget.removeClass(classToToggle);
            triggerOpen.removeClass(classToToggle);
        });

        triggerCart.mouseenter(()=> {
            triggerUser.removeClass(classToToggle);
            triggerCart.addClass(classToToggle);
            toggleUser.addClass('is-hidden');
            toggleCart.removeClass('is-hidden');
        });

        triggerUser.mouseenter(()=> {
            triggerCart.removeClass(classToToggle);
            triggerUser.addClass(classToToggle);
            toggleCart.addClass('is-hidden');
            toggleUser.removeClass('is-hidden');
        });
    }

}
