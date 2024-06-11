@extends('layouts.dashboard.app')
@section('page-header', __('theme/images.title'))
@section('content')
    <section>
        @if ($errors->any())
            <div class="alert alert-danger" id="message_id">

                <p><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg> {{ __('theme/images.warning') }}</p>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger" id="message_id">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                {{ Session::get('error') }}
                @php
                    Session::forget('error');
                @endphp
            </div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success" id="message_id">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                {{ Session::get('success') }}
                @php
                    Session::forget('success');
                @endphp
            </div>
        @endif
        <div class="containe">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row">
                        <!-- Basic Form-->
                        <div class="col-lg-12 mb-5">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-heading">{{ __('theme/images.add') }}</h4>
                                </div>
                                <div class="card-body">
                                    <p>{{ __('theme/images.follow-info') }}</p>
                                    <div class="alert alert-primary" role="alert">
                                        {{ __('theme/images.info') }}
                                    </div>
                                    <p>{{ __('theme/images.rules-info') }}</p>
                                    <div class="alert alert-warning" role="alert">
                                        <ul class="mb-0">
                                            <li>Şekil formatı <strong>jpg/jpeg</strong> olmalı.</li>
                                            <li>Önerilen şekil boyutu TÜRKPATENT'in kullandığı <strong>591x591</strong>'dir.
                                            </li>
                                        </ul>
                                    </div>
                                    <form method="post"
                                        action="{{ route('image.store', ['language' => app()->getLocale()]) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="p-3">
                                            <label
                                                class="form-label text-uppercase">{{ __('theme/images.input.title') }}</label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="{{ __('theme/images.input.placeholder') }}" required>
                                            <div class="mb-3 mt-3">
                                                {{-- <label for="formFile"
                                                    class="form-label">{{ __('theme/images.input.file-label') }}</label>
                                                <input class="form-control" type="file" name="image"> --}}
                                                <div class="upload-area" id="upload-area">
                                                    <div id="preview" class="preview"></div>
                                                    Sürükleyip bırakın ya da tıklayarak yükleyin
                                                </div>
                                                <input type="file" id="file-input" name="image" hidden />
                                                <div id="file-name"></div>
                                            </div>
                                        </div>
                                        <script>
                                            const uploadArea = document.getElementById('upload-area');
                                            const fileInput = document.getElementById('file-input');
                                            const previewContainer = document.getElementById('preview');
                                            const fileNameDisplay = document.getElementById('file-name');

                                            uploadArea.addEventListener('dragover', (event) => {
                                                event.stopPropagation();
                                                event.preventDefault();
                                                uploadArea.style.border = "3px solid #007bff";
                                            });

                                            uploadArea.addEventListener('drop', (event) => {
                                                event.stopPropagation();
                                                event.preventDefault();
                                                uploadArea.style.border = "2px dashed #007bff";
                                                const files = event.dataTransfer.files;
                                                handleFiles(files);
                                            });

                                            uploadArea.addEventListener('dragleave', () => {
                                                uploadArea.style.border = "2px dashed #007bff";
                                            });

                                            uploadArea.addEventListener('click', () => {
                                                fileInput.click();
                                                fileInput.addEventListener('change', () => {
                                                    handleFiles(fileInput.files);
                                                });
                                            });

                                            function handleFiles(files) {
                                                if (files.length) {
                                                    const file = files[0];
                                                    fileNameDisplay.textContent = `Seçilen Dosya: ${file.name}`;
                                                    const reader = new FileReader();
                                                    reader.onload = function(e) {
                                                        const img = document.createElement('img');
                                                        img.src = e.target.result;
                                                        previewContainer.innerHTML = ''; // Önizleme alanını temizle
                                                        previewContainer.appendChild(img); // Yeni önizlemeyi ekle
                                                    };
                                                    reader.readAsDataURL(file);
                                                }
                                            }
                                        </script>
                                        <style>
                                            .upload-area {
                                                border: 2px dashed #007bff;
                                                border-radius: 5px;
                                                padding: 60px;
                                                text-align: center;
                                                cursor: pointer;
                                                margin-bottom: 10px;
                                            }

                                            .preview {
                                                margin-bottom: 10px;
                                            }

                                            .preview img {
                                                max-height: 400px;
                                                height: auto;
                                            }
                                        </style>

                                        <div class="mb-3">
                                            <button class="btn btn-primary tour-button"
                                                type="submit">{{ __('theme/images.input.add') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="card card-table mb-4">
            <div class="card-header tour-title" style="box-shadow:none">
                <div class="row">
                    <div class="col-md-6 my-auto">
                        <h5 class="card-heading">{{ __('theme/images.list', ['count' => $images->count()]) }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($images as $image)
                        <div class="col-md-3 text-center p-5">
                            <div class="card image-card">
                                <div class="card-body">
                                    <h5 class="p-3">{{ $image->title }}</h5>
                                    <img src="{{ Storage::url($image->path) }}" class="img-thumbnail"
                                        style="max-width:120px">
                                    <form id="delete-form-{{ $image->id }}" method="POST"
                                        action="{{ route('image.destroy', ['language' => app()->getLocale(), 'image' => $image]) }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <form id="update-form-{{ $image->id }}" method="POST"
                                        action="{{ route('image.update', ['language' => app()->getLocale(), 'image' => $image]) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="title" value="{{ $image->title }}">
                                    </form>
                                    <div class="m-2 mt-3 d-grid gap-2">
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#confirmUpdateModal" data-image-id="{{ $image->id }}"
                                            data-image-title="{{ $image->title }}">{{ __('theme/images.items.actions.edit') }}</button>

                                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal" data-image-id="{{ $image->id }}"
                                            data-image-title="{{ $image->title }}">{{ __('theme/images.items.actions.delete') }}</button>
                                    </div>

                                    <div class="text-right p-3">
                                        <p class="p-0 m-0">
                                            <i><strong>{{ __('theme/images.items.created-at', ['date' => $image->created_at]) }}</strong></i>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="confirmUpdateModal" tabindex="-1" aria-labelledby="confirmUpdateModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmUpdateModalLabel">
                                {{ __('theme/images.models.update.title') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <label
                                    class="form-label text-uppercase">{{ __('theme/images.models.update.label') }}</label>
                                <input type="text" class="form-control" name="title" id="updateFormImageTitleInput"
                                    placeholder="{{ __('theme/images.models.update.placeholder') }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('theme/images.models.update.close') }}</button>
                            <button type="button" class="btn btn-primary"
                                id="confirmUpdateButton">{{ __('theme/images.models.update.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">
                                {{ __('theme/images.models.delete.title') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><span class="font-weight-bold" id="imageTitle"></span>
                                {{ __('theme/images.models.delete.info') }}
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('theme/images.models.delete.close') }}</button>
                            <button type="button" class="btn btn-danger"
                                id="confirmDeleteButton">{{ __('theme/images.models.delete.delete') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                var imageIdToDelete;
                var imageTitleToDelete;

                var imageIdToUpdate;
                var imageTitleToUpdate;

                $('#confirmDeleteModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    imageIdToDelete = button.data('image-id');
                    imageTitleToDelete = button.data('image-title');
                    $('#imageTitle').text(imageTitleToDelete);
                });

                $('#confirmDeleteButton').click(function() {
                    var deleteForm = $('#delete-form-' + imageIdToDelete);
                    deleteForm.submit();
                });

                $('#confirmUpdateModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    // get updateFormImageTitleInput value
                    var updateFormImageTitleInput = $('#updateFormImageTitleInput').val();
                    imageIdToUpdate = button.data('image-id');
                    imageTitleToUpdate = button.data('image-title');
                    $('#updateFormImageTitleInput').val(imageTitleToUpdate);
                });

                $('#confirmUpdateButton').click(function() {
                    $('#update-form-' + imageIdToUpdate + ' input[name="title"]').val(
                        $('#updateFormImageTitleInput').val());
                    var updateForm = $('#update-form-' + imageIdToUpdate);
                    updateForm.submit();
                });
            </script>
        </div>
    </section>
@endsection
