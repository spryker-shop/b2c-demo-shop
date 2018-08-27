import Component from 'ShopUi/models/component';
import CheckTouch from 'ShopUiProject/components/molecules/check-touch/check-touch';

export default class VideoReplacer extends Component {
    CheckTouch: CheckTouch
    video: HTMLVideoElement

    readyCallback(): void {
        this.video = <HTMLVideoElement>document.createElement('video');
        this.CheckTouch = <CheckTouch> document.querySelector('.check-touch');

        this.setVideoAttributes();

        if( !this.CheckTouch.isTouchDevice ){
            this.appendChild(this.video);
        }
        else {
            this.video.style.display = 'none';
        }
    }

    protected setVideoAttributes(): void {
        this.video.setAttribute('type', 'video/mp4');
        this.video.setAttribute('preload', 'none');
        this.video.setAttribute('loop', 'loop');
        this.video.setAttribute('muted', 'muted');
        this.video.setAttribute('src', this.videoSrc);
        this.video.setAttribute('autoplay', 'autoplay');
    }

    get videoSrc():string {
        return this.getAttribute('url');
    }
}
