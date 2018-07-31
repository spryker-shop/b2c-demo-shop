import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';
import 'slick-carousel';

export default class PdpCarousel extends Component {

    readyCallback(): void {

        const thumbnailSlider = $(this).find(`.${this.name}__thumbnail`);
        const imgContainer = $(this).find(`.${this.name}__container`);
        const imgAmount = thumbnailSlider.find('img').length;

        function animateImage(index) {
            imgContainer.find('.pdp-img').stop(true);
            imgContainer.find('.pdp-img').css('opacity', 0);
            imgContainer.find('.pdp-img').eq(index).animate({
                opacity: 1
            }, 600);
        }

        if(imgAmount > 1) {

            const thumbnailSliderConfig = $(this).data('thumbnail-config');

            thumbnailSlider.slick(
                thumbnailSliderConfig
            );

            thumbnailSlider.on('mouseenter', '.slick-slide', function (e) {
                let $currTarget = $(e.currentTarget),
                    index = $currTarget.data('slick-index');

                if(!$currTarget.hasClass('slick-current')) {
                    thumbnailSlider.find('.slick-slide').removeClass('slick-current');
                    $currTarget.addClass('slick-current');
                    animateImage(index);
                }
            });

            thumbnailSlider.on('afterChange', function(slick, currentSlide){
                let index = currentSlide.currentSlide;
                animateImage(index);
            });

        }

    }



}
