@extends('admin.layouts.app')

@section('title', 'User Manual')

@php
  $manualPdfPath = public_path('uploads/user_manuals/user_manual.pdf');
  $manualPdfUrl = asset('uploads/user_manuals/user_manual.pdf') . '?v=' . filemtime($manualPdfPath);
@endphp

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/page-flip/page-flip.css') }}">
<style>
  .manual-page { max-width:1700px; margin:0 auto; padding:clamp(8px,1vw,16px); }
  .manual-actions { display:flex; justify-content:flex-end; margin-bottom:14px; }
  .manual-reader-area { position:relative; padding:0; }
  .manual-reader { position:relative; width:100%; height:clamp(600px,86vh,1120px); min-height:600px; display:flex; align-items:center; justify-content:center; overflow:hidden; background:transparent; }
  #manualFlipbook { width:100%; height:100%; }
  .manual-pdf-page { width:100%; height:100%; overflow:hidden; background:#fff; }
  .manual-pdf-page img { display:block; width:100%; height:100%; object-fit:contain; }
  .manual-nav-arrow { position:absolute; z-index:5; top:50%; transform:translateY(-50%); width:42px; height:48px; display:grid; place-items:center; border:0; border-radius:12px; background:#fff; color:#244f35; box-shadow:0 4px 14px rgba(15,36,23,.16); transition:background .15s ease,transform .15s ease,opacity .15s ease; }
  .manual-nav-arrow:hover:not(:disabled) { background:#f0f5f0; transform:translateY(-50%) scale(1.04); }
  .manual-nav-arrow:disabled { opacity:.38; cursor:not-allowed; }
  .manual-nav-arrow i { font-size:1.25rem; }
  .manual-nav-arrow.previous { left:6px; }
  .manual-nav-arrow.next { right:6px; }
  .manual-page-count { min-width:100px; text-align:center; color:#fff; font-variant-numeric:tabular-nums; padding-top:14px; }
  .manual-error { display:none; margin-top:12px; color:#fff2f0; }
  @media(max-width:767.98px) { .manual-page { padding:8px; } .manual-reader { height:clamp(500px,74vh,850px); min-height:500px; } .manual-nav-arrow { width:34px; height:42px; border-radius:10px; } .manual-nav-arrow.previous { left:2px; } .manual-nav-arrow.next { right:2px; } }
</style>
@endpush

@section('content')
@php
  $manualPages = collect(glob(public_path('user_manuals/pages/page-*.png')))
      ->sort()
      ->map(fn ($path) => asset('user_manuals/pages/' . basename($path)) . '?v=' . filemtime($manualPdfPath))
      ->values();
@endphp
<div class="manual-page">
  <div class="manual-actions">
    <a class="btn btn-primary" href="{{ $manualPdfUrl }}" download="user_manual.pdf"><i class="bi bi-download me-1"></i> Download PDF</a>
  </div>
  <div class="manual-reader-area">
    <button class="manual-nav-arrow previous" id="previousPage" type="button" aria-label="Previous page" disabled><i class="bi bi-chevron-left"></i></button>
    <div class="manual-reader" aria-label="Interactive page-flip user manual"><div id="manualFlipbook"></div></div>
    <button class="manual-nav-arrow next" id="nextPage" type="button" aria-label="Next page" disabled><i class="bi bi-chevron-right"></i></button>
  </div>
  <div class="manual-error" id="manualError">The manual reader could not be loaded.</div>
  <div class="manual-page-count" id="pageCount" aria-live="polite">Loading…</div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/page-flip/page-flip.browser.js') }}"></script>
<script>
  $(function () {
    var pages = @json($manualPages);
    var error = document.getElementById('manualError');
    var pageCount = document.getElementById('pageCount');
    var previous = document.getElementById('previousPage');
    var next = document.getElementById('nextPage');
    var flipbookElement = document.getElementById('manualFlipbook');

    if (!pages.length || !window.St || !window.St.PageFlip) {
      error.style.display = 'block';
      pageCount.textContent = 'Reader unavailable';
      return;
    }

    Promise.all(pages.map(function (src) {
      return new Promise(function (resolve, reject) {
        var image = new Image();
        image.onload = resolve;
        image.onerror = reject;
        image.src = src;
      });
    })).then(function () {
      pages.forEach(function (src, index) {
        var page = document.createElement('div');
        page.className = 'manual-pdf-page';
        if (index === 0 || index === pages.length - 1) page.dataset.density = 'hard';
        var image = document.createElement('img');
        image.src = src;
        image.alt = 'User manual page ' + (index + 1);
        page.appendChild(image);
        flipbookElement.appendChild(page);
      });

      var book = new St.PageFlip(flipbookElement, {
        width: 595,
        height: 842,
        size: 'stretch',
        minWidth: 300,
        maxWidth: 1100,
        minHeight: 420,
        maxHeight: 1400,
        drawShadow: true,
        flippingTime: 900,
        usePortrait: true,
        startPage: 0,
        autoSize: false,
        maxShadowOpacity: 0.55,
        showCover: true,
        mobileScrollSupport: true,
        useMouseEvents: true,
        showPageCorners: false
      });

      function updateControls() {
        var index = book.getCurrentPageIndex();
        var total = book.getPageCount();
        var first = index + 1;
        var last = book.getOrientation() === 'portrait' ? first : Math.min(first + 1, total);
        pageCount.textContent = first === last ? first + ' / ' + total : first + '–' + last + ' / ' + total;
        previous.disabled = index <= 0;
        next.disabled = index >= total - 1;
      }

      book.on('init', updateControls);
      book.on('flip', updateControls);
      book.on('changeOrientation', updateControls);
      book.loadFromHTML(flipbookElement.querySelectorAll('.manual-pdf-page'));
      previous.addEventListener('click', function () { book.flipPrev('bottom'); });
      next.addEventListener('click', function () { book.flipNext('bottom'); });
    }).catch(function () {
      error.style.display = 'block';
      pageCount.textContent = 'Reader unavailable';
    });
  });
</script>
@endpush
