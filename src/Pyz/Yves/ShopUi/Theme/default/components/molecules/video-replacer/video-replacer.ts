import Component from 'ShopUi/models/component';
import CheckTouch from 'ShopUiProject/components/molecules/check-touch/check-touch';

export default class VideoReplacer extends Component {
    CheckTouch: CheckTouch
    video: HTMLVideoElement

    readyCallback(): void {
        this.video = <HTMLVideoElement>this.querySelector('video');
        this.CheckTouch = <CheckTouch> document.querySelector('.check-touch');

        if( !this.CheckTouch.isTouchDevice ){
            this.video.setAttribute('src', this.videoSrc);
        }
        else {
            this.video.style.display = 'none';
        }
    }

    get videoSrc():string {
        return this.video.getAttribute('data-src');
    }
}
