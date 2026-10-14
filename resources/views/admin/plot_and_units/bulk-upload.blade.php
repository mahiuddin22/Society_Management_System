@extends('admin.layouts.app')

@section('title', 'Bulk Upload Members')

@push('styles')
<style>
  .upload-card-wrapper {
    max-width: 820px;
    margin: 0 auto;
  }
  .upload-zone {
    position: relative;
    border: 2px dashed var(--line-strong, #c8d3c5);
    border-radius: var(--radius-m, 12px);
    padding: 42px 20px;
    text-align: center;
    cursor: pointer;
    background: var(--paper-50, #f8faf7);
    transition: all 0.25s ease;
  }
  .upload-zone:hover {
    border-color: #2b6242;
    background: rgba(43, 98, 66, 0.04);
    transform: translateY(-2px);
  }
  .upload-zone.dragover {
    border-color: #2b6242;
    background: rgba(43, 98, 66, 0.08);
    transform: scale(1.01);
  }
  .upload-icon {
    font-size: 44px;
    color: #2b6242;
    display: inline-block;
    margin-bottom: 8px;
  }
  .upload-zone input[type="file"] {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 1;
  }
  .file-selected-box {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 16px;
    background: var(--card, #fff);
    border: 1px solid rgba(43, 98, 66, 0.25);
    border-radius: 8px;
    margin-top: 14px;
  }

  /* Template Download Action Banner */
  .template-banner {
    background: rgba(43, 98, 66, 0.04);
    border: 1px solid rgba(43, 98, 66, 0.15);
    border-radius: var(--radius-s, 8px);
    padding: 10px 14px;
  }
  .download-template-btn {
    background: #ffffff;
    border: 1px solid #2b6242;
    color: #2b6242;
    font-size: 12.5px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none !important;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(43, 98, 66, 0.08);
  }
  .download-template-btn:hover {
    background: #2b6242;
    border-color: #2b6242;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(43, 98, 66, 0.2);
  }

  /* Exact Theme Color Button (#2b6242) */
  .btn-forest-primary {
    background-color: #2b6242 !important;
    border: 1px solid #245338 !important;
    color: #ffffff !important;
    font-weight: 600;
    font-size: 14px;
    border-radius: 8px;
    transition: all 0.2s ease;
    box-shadow: 0 3px 10px rgba(43, 98, 66, 0.22);
  }
  .btn-forest-primary:hover:not(:disabled) {
    background-color: #245338 !important;
    border-color: #1e452e !important;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 6px 14px rgba(43, 98, 66, 0.28);
  }
  .btn-forest-primary:disabled {
    background-color: #8da495 !important;
    border-color: #8da495 !important;
    cursor: not-allowed;
    opacity: 0.65;
    box-shadow: none;
    transform: none;
  }

  /* Animated Progress Bar */
  .custom-progress-container {
    background: var(--paper-100, #e9ecef);
    border-radius: 20px;
    height: 14px;
    overflow: hidden;
    position: relative;
  }
  .custom-progress-bar {
    background: linear-gradient(90deg, #3d835a, #2b6242);
    height: 100%;
    width: 0%;
    border-radius: 20px;
    transition: width 0.35s ease;
    box-shadow: 0 2px 6px rgba(43, 98, 66, 0.3);
  }

  /* Summary Report Card Styles */
  .stat-card-box {
    background: var(--card, #fff);
    border: 1px solid var(--line, #e2e8f0);
    border-radius: 10px;
    padding: 14px 16px;
    text-align: center;
  }
  .stat-card-box.success-box {
    border-color: rgba(43, 98, 66, 0.3);
    background: rgba(43, 98, 66, 0.05);
  }
  .stat-card-box.skip-box {
    border-color: #fde68a;
    background: #fffbeb;
  }
  .stat-card-box.error-box {
    border-color: #fecaca;
    background: #fef2f2;
  }
  .stat-num {
    font-size: 24px;
    font-weight: 700;
    line-height: 1.1;
    font-family: var(--font-ledger, monospace);
  }
  .stat-label {
    font-size: 11.5px;
    color: var(--ink-500, #64748b);
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: .04em;
    margin-top: 4px;
  }
  .error-log-scroll {
    max-height: 150px;
    overflow-y: auto;
    font-family: monospace;
    font-size: 12px;
    background: #fff;
    border: 1px solid var(--line, #e2e8f0);
    border-radius: 6px;
    padding: 10px;
  }
</style>
@endpush

@section('content')
<div class="upload-card-wrapper py-3">

  {{-- 1. FORM VIEW --}}
  <div class="card p-4" id="uploadFormCard" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-m, 12px);">
    
    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
      <div>
        <h5 class="fw-bold mb-1" style="color: #2b6242;">Bulk Upload Plots</h5>
        <span class="hint small text-muted">Upload your Excel file to mass import society records</span>
      </div>
      <a href="{{ route('admin.plot-and-units.index') }}" class="btn btn-ghost border btn-sm px-3" style="height: 34px; line-height: 22px;">
        Back to List
      </a>
    </div>

    <form id="bulkUploadForm" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="job_id" id="jobIdInput">

      {{-- Drop Zone --}}
      <div id="dropZone" class="upload-zone mb-3">
        <i class="bi bi-cloud-arrow-up upload-icon"></i>
        <div class="mb-2">
          <strong class="d-block" style="font-size: 16px; color: #2b6242;">Drag &amp; Drop your Excel file here</strong>
          <span class="text-muted small">or click to browse from computer</span>
        </div>
        <div class="text-muted" style="font-size: 12px;">
          Supported: <code>.xlsx, .xls, .csv</code> | Maximum size: 25 MB
        </div>
        <input type="file" name="file" id="fileInput" accept=".xlsx,.xls,.csv" required>
      </div>

      {{-- Selected File Box --}}
      <div id="fileInfoBox" class="file-selected-box d-none mb-3">
        <i class="bi bi-file-earmark-excel fs-4" style="color: #2b6242;"></i>
        <div class="flex-grow-1 text-truncate">
          <div class="fw-semibold text-dark" id="fileNameLabel" style="font-size: 13.5px;"></div>
          <small class="text-muted" id="fileSizeLabel"></small>
        </div>
        <button type="button" id="removeFileBtn" class="btn btn-ghost text-danger btn-sm p-1" title="Remove file">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>

      {{-- Template Download Banner --}}
      <div class="template-banner d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-info-circle text-muted"></i>
          <span class="small text-muted" style="font-size: 12.5px;">Need the sample column structure and guidelines?</span>
        </div>
        <a href="{{ asset('uploads/excel_files/demo.xlsx') }}" download="plot-and-units-template.xlsx" class="download-template-btn">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="7 10 12 15 17 10"></polyline>
            <line x1="12" y1="15" x2="12" y2="3"></line>
          </svg>
          <span>Download Template</span>
        </a>
      </div>

      {{-- Submit Button (#2b6242) --}}
      <button type="submit" id="submitBtn" class="btn btn-forest-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2" style="height: 44px;" disabled>
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="17 8 12 3 7 8"></polyline>
          <line x1="12" y1="3" x2="12" y2="15"></line>
        </svg>
        <span>Start Processing &amp; Import</span>
      </button>
    </form>
  </div>

  {{-- 2. PROGRESS LOADER VIEW --}}
  <div class="card p-4 d-none text-center" id="progressCard" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-m, 12px);">
    <div class="py-4">
      <div class="spinner-border mb-3" role="status" style="width: 3rem; height: 3rem; border-width: 3px; color: #2b6242 !important;">
        <span class="visually-hidden">Processing...</span>
      </div>
      <h5 class="fw-bold mb-1" style="color: #2b6242;">Importing Records...</h5>
      <p class="text-muted small mb-4">Please keep this window open while we process your data.</p>

      {{-- Progress Bar --}}
      <div class="custom-progress-container mb-2">
        <div class="custom-progress-bar" id="progressBar"></div>
      </div>

      <div class="d-flex align-items-center justify-content-between small text-muted font-monospace mb-2">
        <span id="progressText">0% Completed</span>
        <span id="progressCounter">Processing rows...</span>
      </div>
    </div>
  </div>

  {{-- 3. SUMMARY REPORT VIEW --}}
  <div class="card p-4 d-none" id="reportCard" style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius-m, 12px);">
    
    <div class="text-center pb-3 border-bottom mb-3">
      <div class="d-inline-flex align-items-center justify-content-center text-white rounded-circle mb-2" style="width: 48px; height: 48px; background: #2b6242;">
        <i class="bi bi-check-lg fs-3"></i>
      </div>
      <h5 class="fw-bold mb-1" style="color: #2b6242;">Import Completed Successfully!</h5>
      <span class="text-muted small">Here is the executive summary report of your uploaded file:</span>
    </div>

    {{-- Report Grid Metrics --}}
    <div class="row row-cols-2 row-cols-md-4 g-2 mb-4">
      <div class="col">
        <div class="stat-card-box">
          <div class="stat-num text-dark" id="reportTotal">0</div>
          <div class="stat-label">Total Rows</div>
        </div>
      </div>
      <div class="col">
        <div class="stat-card-box success-box">
          <div class="stat-num" style="color: #2b6242;" id="reportSuccess">0</div>
          <div class="stat-label" style="color: #2b6242;">Imported</div>
        </div>
      </div>
      <div class="col">
        <div class="stat-card-box skip-box">
          <div class="stat-num text-warning" id="reportSkipped">0</div>
          <div class="stat-label text-warning">Skipped / Empty</div>
        </div>
      </div>
      <div class="col">
        <div class="stat-card-box error-box">
          <div class="stat-num text-danger" id="reportErrors">0</div>
          <div class="stat-label text-danger">Errors</div>
        </div>
      </div>
    </div>

    {{-- Error log container (if any) --}}
    <div id="errorLogSection" class="d-none mb-3">
      <label class="form-label small fw-bold text-danger mb-1">Row Exceptions / Notices:</label>
      <div class="error-log-scroll" id="errorLogList"></div>
    </div>

    {{-- Actions Footer --}}
    <div class="d-flex align-items-center justify-content-end gap-2 pt-2 border-top">
      <button type="button" class="btn btn-ghost border" id="uploadAnotherBtn">
        Upload Another
      </button>
      <a href="{{ route('admin.plot-and-units.index') }}" class="btn btn-forest-primary px-3" style="height: 38px; line-height: 24px;">
        Go to Plot
      </a>
    </div>

  </div>

</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const dropZone        = document.getElementById('dropZone');
    const fileInput       = document.getElementById('fileInput');
    const fileInfoBox     = document.getElementById('fileInfoBox');
    const fileNameLabel   = document.getElementById('fileNameLabel');
    const fileSizeLabel   = document.getElementById('fileSizeLabel');
    const removeFileBtn   = document.getElementById('removeFileBtn');
    const submitBtn       = document.getElementById('submitBtn');

    const formCard        = document.getElementById('uploadFormCard');
    const progressCard    = document.getElementById('progressCard');
    const reportCard      = document.getElementById('reportCard');

    const progressBar     = document.getElementById('progressBar');
    const progressText    = document.getElementById('progressText');
    const progressCounter = document.getElementById('progressCounter');

    let currentJobId      = null;
    let pollInterval      = null;

    function generateUUID() {
      return 'job_' + Date.now() + '_' + Math.random().toString(36).substring(2, 9);
    }

    function handleFile(file) {
      if (!file) return;
      fileNameLabel.textContent = file.name;
      fileSizeLabel.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
      fileInfoBox.classList.remove('d-none');
      submitBtn.removeAttribute('disabled');
    }

    fileInput.addEventListener('change', function () {
      if (this.files.length) handleFile(this.files[0]);
    });

    dropZone.addEventListener('dragover', function (e) {
      e.preventDefault();
      dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', function () {
      dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', function (e) {
      e.preventDefault();
      dropZone.classList.remove('dragover');
      if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        handleFile(e.dataTransfer.files[0]);
      }
    });

    removeFileBtn.addEventListener('click', function () {
      fileInput.value = '';
      fileInfoBox.classList.add('d-none');
      submitBtn.setAttribute('disabled', 'disabled');
    });

    // Form submission via AJAX & polling
    document.getElementById('bulkUploadForm').addEventListener('submit', function (e) {
      e.preventDefault();

      currentJobId = generateUUID();
      document.getElementById('jobIdInput').value = currentJobId;

      const formData = new FormData(this);

      // UI Switch: Form to Progress Loader
      formCard.classList.add('d-none');
      progressCard.classList.remove('d-none');
      progressBar.style.width = '5%';
      progressText.textContent = '5% Completed';
      progressCounter.textContent = 'Uploading file to server...';

      // Start Polling progress
      pollInterval = setInterval(pollProgress, 1000);

      fetch("{{ route('admin.plot-and-units.bulk-upload.store') }}", {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        },
        body: formData
      })
      .then(response => response.json())
      .then(result => {
        clearInterval(pollInterval);
        if (result.status === 'completed' || result.status === 'success') {
          showFinalReport(result.data || {});
        } else {
          alert('Upload failed: ' + (result.message || 'Unknown error occurred.'));
          resetToForm();
        }
      })
      .catch(err => {
        clearInterval(pollInterval);
        alert('Server error occurred: ' + err.message);
        resetToForm();
      });
    });

    function pollProgress() {
      if (!currentJobId) return;

      fetch(`{{ route('admin.plot-and-units.bulk-upload.progress') }}?job_id=${currentJobId}`)
        .then(res => res.json())
        .then(data => {
          if (!data) return;

          const pct = Math.max(5, data.percentage || 0);
          progressBar.style.width = pct + '%';
          progressText.textContent = pct + '% Completed';

          if (data.total > 0) {
            progressCounter.textContent = `Processed ${data.processed.toLocaleString()} of ${data.total.toLocaleString()} rows`;
          } else {
            progressCounter.textContent = 'Reading rows from sheet...';
          }

          if (data.status === 'completed') {
            clearInterval(pollInterval);
            showFinalReport(data);
          }
        })
        .catch(() => {});
    }

    function showFinalReport(data) {
      progressCard.classList.add('d-none');
      reportCard.classList.remove('d-none');

      document.getElementById('reportTotal').textContent   = (data.total || data.processed || 0).toLocaleString();
      document.getElementById('reportSuccess').textContent = (data.success || 0).toLocaleString();
      document.getElementById('reportSkipped').textContent = (data.skipped || 0).toLocaleString();
      
      const errCount = (data.errors ? data.errors.length : 0);
      document.getElementById('reportErrors').textContent  = errCount.toLocaleString();

      if (errCount > 0) {
        const errorSection = document.getElementById('errorLogSection');
        const errorList = document.getElementById('errorLogList');
        errorSection.classList.remove('d-none');
        errorList.innerHTML = data.errors.map(err => `<div class="text-danger py-1 border-bottom">&bull; ${err}</div>`).join('');
      }
    }

    function resetToForm() {
      progressCard.classList.add('d-none');
      reportCard.classList.add('d-none');
      formCard.classList.remove('d-none');
      fileInput.value = '';
      fileInfoBox.classList.add('d-none');
      submitBtn.setAttribute('disabled', 'disabled');
      progressBar.style.width = '0%';
    }

    document.getElementById('uploadAnotherBtn').addEventListener('click', resetToForm);
  });
</script>
@endpush