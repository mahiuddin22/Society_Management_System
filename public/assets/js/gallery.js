/* <============ Image Gallery ============ > */

const gallery = document.getElementById("lightgallery");

lightGallery(gallery, {
  plugins: [lgZoom, lgThumbnail, lgFullscreen, lgAutoplay, lgShare, lgPager, lgHash],
  speed: 500,
  thumbnail: true,
  zoom: true,
  zoomFromOrigin: true,
  zoomScale: 1.5,
  fullscreen: true,
  autoplay: true,
  share: true,
  pager: true,
  hash: true,
});

let rotation = 0;
let scaleX = 1;
let scaleY = 1;

function applyTransform(slideEl) {
  const imgWrap = slideEl.querySelector(".lg-img-wrap");
  if (imgWrap) {
    imgWrap.style.transform = `rotate(${rotation}deg) scale(${scaleX}, ${scaleY})`;
  }
}

function addButtonsToToolbar() {
  const toolbar = document.querySelector(".lg-toolbar");
  if (!toolbar || toolbar.querySelector(".custom-rotate-left")) return; // Prevent duplicates

  const rotateLeft = document.createElement("button");
  rotateLeft.className = "custom-lg-icon custom-rotate-left";
  rotateLeft.title = "Rotate Left";
  rotateLeft.textContent = "⟲";

  const rotateRight = document.createElement("button");
  rotateRight.className = "custom-lg-icon custom-rotate-right";
  rotateRight.title = "Rotate Right";
  rotateRight.textContent = "⟳";

  const flipH = document.createElement("button");
  flipH.className = "custom-lg-icon custom-flip-h";
  flipH.title = "Flip Horizontal";
  flipH.textContent = "⇋";

  const flipV = document.createElement("button");
  flipV.className = "custom-lg-icon custom-flip-v";
  flipV.title = "Flip Vertical";
  flipV.textContent = "⇅";

  toolbar.appendChild(rotateLeft);
  toolbar.appendChild(rotateRight);
  toolbar.appendChild(flipH);
  toolbar.appendChild(flipV);

  rotateLeft.addEventListener("click", () => {
    rotation -= 90;
    const slide = document.querySelector(".lg-current");
    applyTransform(slide);
  });

  rotateRight.addEventListener("click", () => {
    rotation += 90;
    const slide = document.querySelector(".lg-current");
    applyTransform(slide);
  });

  flipH.addEventListener("click", () => {
    scaleX *= -1;
    const slide = document.querySelector(".lg-current");
    applyTransform(slide);
  });

  flipV.addEventListener("click", () => {
    scaleY *= -1;
    const slide = document.querySelector(".lg-current");
    applyTransform(slide);
  });
}

gallery.addEventListener("lgAfterSlide", () => {
  rotation = 0;
  scaleX = 1;
  scaleY = 1;
  addButtonsToToolbar();
  const slide = document.querySelector(".lg-current");
  if (slide) applyTransform(slide);
});

gallery.addEventListener("lgAfterOpen", () => {
  addButtonsToToolbar();
});
