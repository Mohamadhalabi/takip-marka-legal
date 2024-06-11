@extends('layouts.dashboard.app')
@section('page-header', 'Görsel İle Arama')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/highlight/jquery.highlight-within-textarea.css">
    <script src="{{ asset('assets/dashboard') }}/vendor/highlight/jquery.highlight-within-textarea.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/tagify/style.css">
    <script src="{{ asset('assets/dashboard') }}/vendor/tagify/main.js"></script>
    <style>
        :root {
            --colorPrimaryNormal: #00b3bb;
            --colorPrimaryDark: #00979f;
            --colorPrimaryGlare: #00cdd7;
            --colorPrimaryHalf: #80d9dd;
            --colorPrimaryQuarter: #bfecee;
            --colorPrimaryEighth: #dff5f7;
            --colorPrimaryPale: #f3f5f7;
            --colorPrimarySeparator: #f3f5f7;
            --colorPrimaryOutline: #dff5f7;
            --colorButtonNormal: #00b3bb;
            --colorButtonHover: #00cdd7;
            --colorLinkNormal: #00979f;
            --colorLinkHover: #00cdd7;
        }

        .upload_dropZone {
            color: #0f3c4b;
            background-color: var(--colorPrimaryPale, #c8dadf);
            outline: 2px dashed var(--colorPrimaryHalf, #c1ddef);
            outline-offset: -12px;
            transition:
                outline-offset 0.2s ease-out,
                outline-color 0.3s ease-in-out,
                background-color 0.2s ease-out;
        }

        .upload_dropZone.highlight {
            outline-offset: -4px;
            outline-color: var(--colorPrimaryNormal, #0576bd);
            background-color: var(--colorPrimaryEighth, #c8dadf);
        }

        .upload_svg {
            fill: var(--colorPrimaryNormal, #0576bd);
        }

        .btn-upload {
            color: #fff;
            background-color: var(--colorPrimaryNormal);
        }

        .btn-upload:hover,
        .btn-upload:focus {
            color: #fff;
            background-color: var(--colorPrimaryGlare);
        }

        .upload_img {
            width: calc(33.333% - (2rem / 3));
            object-fit: contain;
        }
    </style>
@endsection
@section('js')
    <script>
        console.clear();
        ('use strict');


        // Drag and drop - single or multiple image files
        // https://www.smashingmagazine.com/2018/01/drag-drop-file-uploader-vanilla-js/
        // https://codepen.io/joezimjs/pen/yPWQbd?editors=1000
        (function() {

            'use strict';

            // Four objects of interest: drop zones, input elements, gallery elements, and the files.
            // dataRefs = {files: [image files], input: element ref, gallery: element ref}

            const preventDefaults = event => {
                event.preventDefault();
                event.stopPropagation();
            };

            const highlight = event =>
                event.target.classList.add('highlight');

            const unhighlight = event =>
                event.target.classList.remove('highlight');

            const getInputAndGalleryRefs = element => {
                const zone = element.closest('.upload_dropZone') || false;
                const gallery = zone.querySelector('.upload_gallery') || false;
                const input = zone.querySelector('input[type="file"]') || false;
                return {
                    input: input,
                    gallery: gallery
                };
            }

            const handleDrop = event => {
                const dataRefs = getInputAndGalleryRefs(event.target);
                dataRefs.files = event.dataTransfer.files;
                handleFiles(dataRefs);
            }


            const eventHandlers = zone => {

                const dataRefs = getInputAndGalleryRefs(zone);
                if (!dataRefs.input) return;

                // Prevent default drag behaviors
                ;
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event => {
                    zone.addEventListener(event, preventDefaults, false);
                    document.body.addEventListener(event, preventDefaults, false);
                });

                // Highlighting drop area when item is dragged over it
                ;
                ['dragenter', 'dragover'].forEach(event => {
                    zone.addEventListener(event, highlight, false);
                });;
                ['dragleave', 'drop'].forEach(event => {
                    zone.addEventListener(event, unhighlight, false);
                });

                // Handle dropped files
                zone.addEventListener('drop', handleDrop, false);

                // Handle browse selected files
                dataRefs.input.addEventListener('change', event => {
                    dataRefs.files = event.target.files;
                    handleFiles(dataRefs);
                }, false);

            }


            // Initialise ALL dropzones
            const dropZones = document.querySelectorAll('.upload_dropZone');
            for (const zone of dropZones) {
                eventHandlers(zone);
            }


            // No 'image/gif' or PDF or webp allowed here, but it's up to your use case.
            // Double checks the input "accept" attribute
            const isImageFile = file => ['image/jpeg', 'image/png', 'image/svg+xml'].includes(file.type);


            function previewFiles(dataRefs) {
                if (!dataRefs.gallery) return;
                for (const file of dataRefs.files) {
                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onloadend = function() {
                        let img = document.createElement('img');
                        img.className = 'upload_img mt-2';
                        img.setAttribute('alt', file.name);
                        img.src = reader.result;
                        dataRefs.gallery.appendChild(img);
                    }
                }
            }

            // Based on: https://flaviocopes.com/how-to-upload-files-fetch/
            const imageUpload = dataRefs => {

                // Multiple source routes, so double check validity
                if (!dataRefs.files || !dataRefs.input) return;

                const url = dataRefs.input.getAttribute('data-post-url');
                if (!url) return;

                const name = dataRefs.input.getAttribute('data-post-name');
                if (!name) return;

                const formData = new FormData();
                formData.append(name, dataRefs.files);

                fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('posted: ', data);
                        if (data.success === true) {
                            previewFiles(dataRefs);
                        } else {
                            console.log('URL: ', url, '  name: ', name)
                        }
                    })
                    .catch(error => {
                        console.error('errored: ', error);
                    });
            }


            // Handle both selected and dropped files
            const handleFiles = dataRefs => {

                let files = [...dataRefs.files];

                // Remove unaccepted file types
                files = files.filter(item => {
                    if (!isImageFile(item)) {
                        console.log('Not an image, ', item.type);
                    }
                    return isImageFile(item) ? item : null;
                });

                if (!files.length) return;
                dataRefs.files = files;

                previewFiles(dataRefs);
                imageUpload(dataRefs);
            }

        })();
    </script>
@endsection
@section('content')
    <!-- Button trigger modal -->
    <div class="containe">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <!-- Basic Form-->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-heading">GÖRSEL İLE ARAMA
                                </h4>
                            </div>
                            <div class="card-body">
                                <p>Yükleyeceğiniz marka görseli ile geçmiş bültenlerde görselinize benzeyen markaları görebilirsiniz.</p>
                                <h1 class="h4 text-center mb-3">Aranacak Görseli Yükleyin</h1>

                                <form>

                                    <fieldset class="upload_dropZone text-center mb-3 p-4">

                                        <legend class="visually-hidden">Image uploader</legend>

                                        <svg class="upload_svg" width="60" height="60" aria-hidden="true">
                                            <use href="#icon-imageUpload"></use>
                                        </svg>

                                        <p class="small my-2">Aranacak görseli buraya sürükleyin veya yüklemek için tıklayın.</p>

                                        <input id="upload_image_background" data-post-name="image_background"
                                            data-post-url="https://someplace.com/image/uploads/backgrounds/"
                                            class="position-absolute invisible" type="file" multiple
                                            accept="image/jpeg, image/png, image/svg+xml" />

                                        <label class="btn btn-upload mb-3" for="upload_image_background">Görsel Yükle</label>

                                        <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                        </div>

                                    </fieldset>
                                    <div class="mb-3 mt-2">
                                        <button class="btn btn-primary tour-button"
                                            type="submit">Görsel İle Ara</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @isset($filteredTrademarks)
                            <div class="col-lg-12 mt-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h4 class="card-heading">{{ __('search.search_results') }} -
                                            {{ substr(\App\Models\Media::find($SearchedBulletin[0])->name, 0, 3) }} SAYILI
                                            RESMİ
                                            MARKA BÜLTENİ ({{ number_format($time, 3) }}sn -
                                            {{ count($filteredTrademarks) }} {{ __('search.match') }})</h4>
                                    </div>
                                    <div class="card-body">
                                        @if (count($filteredTrademarks) > 0)
                                            <table class="table table-striped table-hover card-text">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ __('search.trademark') }}</th>
                                                        <th>{{ __('search.nice_classes') }}</th>
                                                        <th>{{ __('search.matches_keywords') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($filteredTrademarks as $trademark)
                                                        <tr>
                                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                                            <td><a href="#" data-toggle="modal"
                                                                    data-target="#exampleModalLong{{ $loop->index + 1 }}">{{ $trademark->name }}</a>
                                                            </td>
                                                            <td>{{ $trademark->nice_classes }}</td>
                                                            <td>{{ implode(', ', $trademark->_filtered['matches'] ?? []) }}
                                                            </td>
                                                        </tr>
                                                        <div class="modal fade" id="exampleModalLong{{ $loop->index + 1 }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="exampleModalLongTitle{{ $loop->index + 1 }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document" style="width:850px">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="exampleModalLongTitle{{ $loop->index + 1 }}">
                                                                            {{ $trademark->name }}</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="col-md-12 text-center mb-3"><img
                                                                                src="{{ url('storage/bulletins/' . preg_replace('/\/([^\/]*)$/', '_$1', $trademark['image_path'])) }}"
                                                                                loading="lazy" alt="img"
                                                                                class="img-thumbnail text-center"
                                                                                style="max-height:200px;"></div>
                                                                        <h6>Application No</h6>
                                                                        <p>{{ $trademark->application_no }}</p>
                                                                        <h6>Application Tarihi</h6>
                                                                        <p>{{ $trademark->application_date }}</p>
                                                                        <h6>Nice Sınıfları</h6>
                                                                        <p>{{ $trademark->nice_classes }}</p>
                                                                        @if ($trademark->vienna_classes)
                                                                            <h6>Viyana Sınıfları</h6>
                                                                            <p>{{ $trademark->vienna_classes }}</p>
                                                                        @endif
                                                                        <h6>Vekil Bilgileri</h6>
                                                                        <p>{{ $trademark->attorney_no . ' ' . $trademark->attorney_name . ' ' . $trademark->attorney_title }}
                                                                        </p>
                                                                        <h6>Marka Sahibi Bilgileri</h6>
                                                                        <p>{{ $trademark->holder_tpec_client_id . ' ' . $trademark->holder_title }}
                                                                        </p>
                                                                        <p>{{ $trademark->holder_city . ' ' . $trademark->holder_state . ' ' . $trademark->holder_postal_code . ' ' . $trademark->holder_country_no }}
                                                                        </p>
                                                                        <p>{{ $trademark->holder_address }}</p>
                                                                        @if ($trademark->good_description)
                                                                            <h6>Good</h6>
                                                                            <p>{{ $trademark->good_description }}</p>
                                                                        @endif
                                                                        @if ($trademark->extracted_good_description)
                                                                            <h6>Extracted Good</h6>
                                                                            <p>{{ $trademark->extracted_good_description }}</p>
                                                                        @endif

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Kapat</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p class="text-center">{{ __('search.no_results_found') }}</p>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script data-name="basic">
        (function() {
            // The DOM element you wish to replace with Tagify
            var input = document.querySelector('input[name=exclusion_keywords]');

            // initialize Tagify on the above input node reference
            new Tagify(input, {
                maxTags: 10,
            })
        })()
    </script>
@endsection
