@extends('admin.layouts.app')

@section('title', 'Bulk Upload Members')

@section('content')

<div class="container">

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Bulk Upload Members</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.members.bulk-upload.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">

                    <label class="form-label">Excel File</label>

                    <div id="dropZone" class="upload-zone">
                        <i class="bi bi-cloud-arrow-up upload-icon"></i>

                        <div class="upload-text">
                            <strong>Drag & Drop your Excel file here</strong>
                            <span>or click to browse</span>
                        </div>

                        <small>Supported: .xlsx, .xls, .csv | Maximum file size: 10 MB</small>
                        <small>Download Template: <a href="{{ asset('uploads/excel_files/demo.xlsx') }}" class="text-decoration-underline" download="members-bulk-upload.xlsx">Click here</a></small>
                        <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" required>
                    </div>

                    <div id="fileInfo" class="file-info d-none">
                        <i class="bi bi-file-earmark-excel"></i>
                        <span id="fileName"></span>
                        <button type="button" id="removeFile" class="btn btn-sm btn-link text-danger">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload"></i> Upload Members
                </button>

            </form>

        </div>
    </div>

</div>


<style>
    .upload-zone {
        position: relative;
        border: 2px dashed #ced4da;
        border-radius: 10px;
        padding: 45px 20px;
        text-align: center;
        cursor: pointer;
        background: #f8f9fa;

        transition:
            transform 0.25s ease,
            border-color 0.25s ease,
            background 0.25s ease,
            box-shadow 0.25s ease;
    }

    /* Normal hover */
    .upload-zone:hover {
        border-color: #0d6efd;
        background: #f0f6ff;
        transform: translateY(-2px);
    }

    /* File dragged inside */
    .upload-zone.dragover {
        border-color: #0d6efd;
        background: #eaf3ff;
        transform: scale(1.015);
        box-shadow: 0 10px 30px rgba(13, 110, 253, 0.15);

        animation: dropPulse 1.2s infinite;
    }

    .upload-icon {
        display: block;
        font-size: 45px;
        color: #0d6efd;
        margin-bottom: 10px;

        transition:
            transform 0.3s ease,
            color 0.3s ease;
    }

    /* Animate upload icon */
    .upload-zone.dragover .upload-icon {
        color: #0d6efd;
        transform: scale(1.15) translateY(-5px);

        animation: uploadBounce 0.7s infinite alternate;
    }

    .upload-text strong {
        display: block;
        font-size: 16px;
        margin-bottom: 5px;

        transition: color 0.25s ease;
    }

    .upload-zone.dragover .upload-text strong {
        color: #0d6efd;
    }

    .upload-text span {
        display: block;
        color: #6c757d;
        margin-bottom: 8px;
    }

    .upload-zone small {
        color: #6c757d;
        position: relative;
        z-index: 10;
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

    .upload-zone a {
        position: relative;
        z-index: 10;
        color: #055ab1;
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 12px;
        padding: 10px 15px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        background: #fff;
    }

    .file-info>i {
        font-size: 22px;
        color: #198754;
    }

    .file-info span {
        flex: 1;
        font-size: 14px;
    }


    /* Drop zone pulse */
    @keyframes dropPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.18);
        }

        70% {
            box-shadow: 0 0 0 12px rgba(13, 110, 253, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
        }
    }


    /* Upload icon bounce */
    @keyframes uploadBounce {
        from {
            transform: translateY(-4px) scale(1.12);
        }

        to {
            transform: translateY(-12px) scale(1.2);
        }
    }
</style>



<script>
    document.addEventListener('DOMContentLoaded', function() {

        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('file');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const removeFile = document.getElementById('removeFile');

        // Click / select file
        fileInput.addEventListener('change', function() {
            showFile(this.files[0]);
        });

        // Drag over
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        // Drag leave
        dropZone.addEventListener('dragleave', function() {
            dropZone.classList.remove('dragover');
        });

        // Drop
        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();

            dropZone.classList.remove('dragover');

            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                showFile(e.dataTransfer.files[0]);
            }
        });

        // Show selected file
        function showFile(file) {

            if (!file) {
                return;
            }

            fileName.textContent = file.name;

            fileInfo.classList.remove('d-none');
        }

        // Remove selected file
        removeFile.addEventListener('click', function() {

            fileInput.value = '';

            fileInfo.classList.add('d-none');

        });

    });
</script>

@endsection