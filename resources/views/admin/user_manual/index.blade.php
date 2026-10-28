@extends('admin.layouts.app')

@section('title', 'User Manual')

@php
  $manualPdfPath = public_path('uploads/user_manuals/user_manual.pdf');
  $manualPdfUrl = asset('uploads/user_manuals/user_manual.pdf') . '?v=' . filemtime($manualPdfPath);
@endphp

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/page-flip/page-flip.css') }}">
<style>
  .manual-page { max-width:1440px; margin:0 auto; padding:clamp(12px,2vw,28px); }
  .manual-heading { display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:24px; }
  .manual-heading h1 { margin:0; color:var(--ink-900); font-size:clamp(1.35rem,2vw,1.8rem); }
  .manual-heading p { margin:5px 0 0; color:var(--ink-600); }
  .manual-book { padding:clamp(14px,2vw,28px); border-radius:18px; background:linear-gradient(135deg,#173822,#244f35 54%,#12301f); box-shadow:0 20px 45px rgba(15,36,23,.2),inset 0 1px rgba(255,255,255,.12); }
  .manual-book-top { display:flex; justify-content:space-between; align-items:center; gap:12px; color:#f6f2e8; padding:0 4px 16px 8px; }
  .manual-reader-area { position:relative; padding:0 54px; }
  .manual-reader { position:relative; width:100%; height:clamp(480px,70vh,840px); min-height:480px; display:flex; align-items:center; justify-content:center; overflow:hidden; background:radial-gradient(ellipse at center,#bdb9b0 0%,#89867e 100%); border:1px solid rgba(100,88,65,.38); border-radius:10px; box-shadow:0 0 0 4px rgba(250,248,241,.88),0 12px 30px rgba(0,0,0,.32),inset 0 0 12px rgba(42,34,21,.16); }
  #manualFlipbook { width:100%; height:100%; }
  #manualFlipbook canvas { filter:drop-shadow(0 1px 1px rgba(35,29,20,.42)) drop-shadow(0 5px 9px rgba(35,29,20,.24)); }
  .manual-nav-arrow { position:absolute; z-index:5; top:50%; transform:translateY(-50%); width:42px; height:48px; display:grid; place-items:center; border:0; border-radius:12px; background:#fff; color:#244f35; box-shadow:0 4px 14px rgba(15,36,23,.16); transition:background .15s ease,transform .15s ease,opacity .15s ease; }
  .manual-nav-arrow:hover:not(:disabled) { background:#f0f5f0; transform:translateY(-50%) scale(1.04); }
  .manual-nav-arrow:disabled { opacity:.38; cursor:not-allowed; }
  .manual-nav-arrow i { font-size:1.25rem; }
  .manual-nav-arrow.previous { left:0; }
  .manual-nav-arrow.next { right:0; }
  .manual-page-count { min-width:100px; text-align:center; color:#fff; font-variant-numeric:tabular-nums; padding-top:14px; }
  .manual-book-footer { display:flex; justify-content:center; gap:12px; align-items:center; color:#e7eee7; font-size:.85rem; padding:12px 4px 0; text-align:center; }
  .manual-error { display:none; margin-top:12px; color:#fff2f0; }
  @media(max-width:767.98px) { .manual-page { padding:12px; } .manual-book { padding:12px; border-radius:14px; } .manual-reader-area { padding:0 40px 0 36px; } .manual-reader { height:68vh; min-height:420px; } .manual-nav-arrow { width:34px; height:42px; border-radius:10px; } .manual-book-footer { align-items:flex-start; } }
</style>
@endpush

@section('content')
@php
  $manualPages = collect(glob(public_path('user_manuals/pages/page-*.jpg')))
      ->sort()
      ->map(fn ($path) => asset('user_manuals/pages/' . basename($path)) . '?v=' . filemtime($manualPdfPath))
      ->values();
@endphp
<div class="manual-page">
  <div class="manual-heading">
    <div><h1>User Manual</h1><p>Drag a page corner or use the reader arrows to browse the manual.</p></div>
    <a class="btn btn-primary" href="{{ $manualPdfUrl }}" download="user_manual.pdf"><i class="bi bi-download me-1"></i> Download PDF</a>
  </div>
  <div class="manual-book">
    <div class="manual-book-top"><strong><i class="bi bi-book-half me-2"></i>Uttara Sector 3 Welfare Society</strong><span>User Guide</span></div>
    <div class="manual-reader-area">
      <button class="manual-nav-arrow previous" id="previousPage" type="button" aria-label="Previous page" disabled><i class="bi bi-chevron-left"></i></button>
      <div class="manual-reader" aria-label="Interactive page-flip user manual"><div id="manualFlipbook"></div></div>
      <button class="manual-nav-arrow next" id="nextPage" type="button" aria-label="Next page" disabled><i class="bi bi-chevron-right"></i></button>
    </div>
    <div class="manual-error" id="manualError">The manual reader could not be loaded. <a class="manual-open-link" href="{{ $manualPdfUrl }}" target="_blank" rel="noopener">Open the PDF directly</a>.</div>
    <div class="manual-page-count" id="pageCount" aria-live="polite">Loading…</div>
    <div class="manual-book-footer"><span>Turn the cover to begin. Drag a page edge or use the arrows to continue reading.</span></div>
  </div>
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

    if (!pages.length || !window.St || !window.St.PageFlip) {
      error.style.display = 'block';
      pageCount.textContent = 'Reader unavailable';
      return;
    }

    var book = new St.PageFlip(document.getElementById('manualFlipbook'), {
      width: 595,
      height: 842,
      size: 'stretch',
      minWidth: 300,
      maxWidth: 900,
      minHeight: 420,
      maxHeight: 1100,
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
    book.loadFromImages(pages);

    previous.addEventListener('click', function () { book.flipPrev('bottom'); });
    next.addEventListener('click', function () { book.flipNext('bottom'); });
  });
</script>
@endpush
