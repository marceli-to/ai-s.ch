// Replaces pasted YouTube iframes with a sharp poster + play button and only
// loads the player on click. Embeds inside hidden Alpine tabs (x-show) would
// otherwise initialise at 0×0 and get stuck with YouTube's 120×90 thumbnail.

const YOUTUBE_ID = /(?:youtube(?:-nocookie)?\.com\/embed\/)([\w-]{11})/;

const setPoster = (button, id) => {
  const sizes = ['maxresdefault', 'sddefault', 'hqdefault'];
  const tryNext = () => {
    const size = sizes.shift();
    if (!size) return;
    const img = new Image();
    // Missing sizes return a 120×90 placeholder instead of a 404
    img.onload = () => img.naturalWidth > 120 ? button.style.backgroundImage = `url(${img.src})` : tryNext();
    img.onerror = tryNext;
    img.src = `https://i.ytimg.com/vi/${id}/${size}.jpg`;
  };
  tryNext();
};

const createPlayer = (id, title) => {
  const player = document.createElement('iframe');
  player.src = `https://www.youtube-nocookie.com/embed/${id}?autoplay=1&rel=0`;
  player.title = title;
  player.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
  player.referrerPolicy = 'strict-origin-when-cross-origin';
  player.allowFullscreen = true;
  return player;
};

export default function initVideos() {
  document.querySelectorAll('.video-wrapper iframe').forEach((iframe) => {
    const id = iframe.src.match(YOUTUBE_ID)?.[1];
    if (!id) return;

    const title = iframe.title && iframe.title !== 'YouTube video player' ? iframe.title : 'Video abspielen';

    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'video-facade';
    button.setAttribute('aria-label', title);
    setPoster(button, id);

    button.addEventListener('click', () => button.replaceWith(createPlayer(id, title)), { once: true });
    iframe.replaceWith(button);
  });
}
