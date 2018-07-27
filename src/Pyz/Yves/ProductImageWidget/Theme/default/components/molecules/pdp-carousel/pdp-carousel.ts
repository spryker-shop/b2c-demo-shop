import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';
import 'slick-carousel';

export default class PdpCarousel extends Component {

    readyCallback(): void {

        const mainSlider = $(this).find(`.${this.name}__container`);
        const thumbnailSlider = $(this).find(`.${this.name}__thumbnail`);
        const mainSliderConfig = $(this).data('main-config');
        const thumbnailSliderConfig = $(this).data('thumbnail-config');

        const afterChangeConfig = {
            afterChange: function (slickSlider, i) {
                thumbnailSlider.find('.slick-slide').removeClass('slick-active');
                thumbnailSlider.find('.slick-slide').eq(i).addClass('slick-active');
            }
        };
        $.extend( mainSliderConfig, afterChangeConfig );

        mainSlider.slick(
            mainSliderConfig
        );

        thumbnailSlider.find('.slick-slide').eq(0).addClass('slick-active');

        thumbnailSlider.slick(
            thumbnailSliderConfig
        );

        thumbnailSlider.on('mouseenter', '.slick-slide', function (e) {
            let $currTarget = $(e.currentTarget),
                index = $currTarget.data('slick-index'),
                slickObj = mainSlider.slick('getSlick');

            slickObj.slickGoTo(index);

        });


    }

}
