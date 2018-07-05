import Component from 'ShopUi/models/component';
import $ from 'jquery/dist/jquery';

export default class VideoReplacer extends Component {
    readyCallback(): void {
        const video = $(this).find('video');
        const videoSrc = video.data('src');
        const width = document.body.clientWidth;

        $(window).on('load resize', function () {
            if(width > 550){
                video.prop('src', videoSrc);
            }
        })
    }
}
