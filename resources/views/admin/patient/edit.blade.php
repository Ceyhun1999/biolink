@extends('admin.layouts.default')
@section('title', 'XƏSTƏ MƏLUMATININ YENİLƏNMƏSİ')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h5 class="panel-title text-semibold">XƏSTƏ MƏLUMATININ YENİLƏNMƏSİ <a class="heading-elements-toggle"><i
                        class="icon-more"></i></a></h5>
            <div class="heading-elements"></div>
        </div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('admin.patients.update', ['patient' => $patient->id]) }}" class="has-feedback" id="form-save"
            method="post" accept-charset="utf-8">
            @csrf
            @method('put')
            <div class="panel-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            <input type="text" name="firstName" value="{{ $patient->firstName }}" id="firsName"
                                class="form-control" placeholder="Adı">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <input type="text" name="lastName" value="{{ $patient->lastName }}" id="lastName"
                                class="form-control" placeholder="Soyadı">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <input type="text" name="fatherName" value="{{ $patient->fatherName }}" class="form-control"
                                placeholder="Ata adı">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <input type="text" name="birthday" value="{{ $patient->birthday }}" id="birthday"
                                class="form-control datepicker" placeholder="Doğum tarixini seçin" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <input type="text" name="phone" value="{{ $patient->phone }}" id="phone"
                                class="form-control" placeholder="Telefon">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <input type="text" name="phone2" value="{{ $patient->phone2 }}" id="phone2"
                                class="form-control" placeholder="Telefon (əlavə)">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select id="patient_source_id" name="patient_source_id" class="form-control select-search">
                                <option value="">-- Haradan gəlib --</option>
                                @foreach ($sources as $source)
                                    <option value="{{ $source->id }}"
                                        {{ old('patient_source_id', $patient->patient_source_id) == $source->id ? 'selected' : '' }}>
                                        {{ $source->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <select id="gender" name="gender" class="form-control select-search">
                                <option value="">-- Cinsi seçin --</option>
                                <option value="Kişi"
                                    {{ old('gender', $patient->gender ?? '') == 'Kişi' ? 'selected' : '' }}>Kişi</option>
                                <option value="Qadın"
                                    {{ old('gender', $patient->gender ?? '') == 'Qadın' ? 'selected' : '' }}>Qadın</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group ">
                            <input type="text" name="diagnose" value="{{ $patient->diagnose }}" id="diagnose"
                                class="form-control" placeholder="Diaqnoz">
                        </div>
                    </div>

                </div>
                <div class="row text-center gond">
                    <button type="submit" class="btn btn-success gonder">MƏLUMATLARI DƏYİŞ</button>
                </div>
            </div>
        </form>
    </div>
    <hr>
    <div class="back">
        <div class="panel-heading">
            <h5 class="panel-title text-semibold">YENİ MÜAYİNƏ</h5>
        </div>
        <form id="examination-form" enctype="multipart/form-data"
            action="{{ route('admin.patients.examination.store', ['patient' => $patient->id]) }}" class="has-feedback"
            method="post" accept-charset="utf-8">
            @csrf
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <textarea rows="10" class="form-control" name="notes" placeholder="QEYDLƏR"></textarea>
                    </div>
                </div>
            </div>
            <div class="panel-heading">
                <h5 class="panel-title text-semibold">Yüklə PDF və ya şəkil</h5>
            </div>
            <div class="panel-body">
                <div class="form-group col-md-6">
                    <div class="custom-file-input-wrapper">
                        <input type="file" name="files[]" id="files" class="custom-file-input"
                            accept=".jpg,.jpeg,.png,.webp,.pdf" multiple>
                        <label for="files" class="custom-file-label">
                            <span class="file-icon">📁</span>
                            <span class="file-text">Faylları seçin</span>
                            <span class="file-button">Seç</span>
                        </label>
                        <div id="file-list" class="file-list"></div>
                    </div>
                    <small class="text-muted">
                        Fayl formatları: JPG, PNG, WEBP, PDF. Maksimum 10MB hər biri.
                    </small>
                </div>
            </div>
            <div class="row text-center gond">
                <button type="submit" class="btn btn-success gonder">YENİ MÜAYİNƏ YARAT</button>
            </div>
        </form>
    </div>

    @if ($patient->examinations && $patient->examinations->count() > 0)
        <hr>
        <div class="panel">
            <div class="panel-heading">
                <h5 class="panel-title text-semibold">MÖVCUD MÜAYİNƏLƏR</h5>
            </div>
            <div class="panel-body">
                @foreach ($patient->examinations->sortByDesc('created_at') as $examination)
                    <div class="examination-item note"
                        style="margin-bottom: 30px; padding: 20px; border: 1px solid #e9ecef; border-radius: 8px; position: relative;">
                        <button type="button" class="btn-delete-examination"
                            data-examination-id="{{ $examination->id }}"
                            style="position: absolute; top: 15px; right: 15px; background: #dc3545; color: white; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer; font-size: 12px; transition: background 0.3s;"
                            title="Müayinəni sil">
                            <span>×</span> Sil
                        </button>
                        <div class="examination-header" style="margin-bottom: 15px;">
                            <h6 class="text-semibold" style="color: #333; margin-bottom: 10px;">
                                Müayinə tarixi: {{ $examination->created_at->format('d.m.Y H:i') }}
                            </h6>
                            @if ($examination->notes)
                                <div class="examination-notes"
                                    style="margin-bottom: 15px; padding: 10px; background: #f8f9fa; border-radius: 5px;">
                                    <strong>Qeydlər:</strong>
                                    <p style="margin: 5px 0 0 0; white-space: pre-wrap;">{{ $examination->notes }}</p>
                                </div>
                            @endif
                        </div>

                        @if ($examination->files && $examination->files->count() > 0)
                            <div class="examination-files">
                                <strong style="display: block; margin-bottom: 15px;">Fayllar:</strong>

                                @php
                                    $images = $examination->files->filter(
                                        fn($f) => str_starts_with($f->mime_type ?? '', 'image/'),
                                    );
                                    $pdfFiles = $examination->files->filter(
                                        fn($f) => ($f->mime_type ?? '') === 'application/pdf',
                                    );
                                    $otherFiles = $examination->files->filter(
                                        fn($f) => !str_starts_with($f->mime_type ?? '', 'image/') &&
                                            ($f->mime_type ?? '') !== 'application/pdf',
                                    );
                                @endphp

                                @if ($images->count() > 0 || $pdfFiles->count() > 0)
                                    <div class="examination-images-gallery"
                                        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; margin-bottom: 20px;">
                                        @foreach ($images as $file)
                                            <a href="{{ asset('storage/' . $file->file_path) }}"
                                                data-fancybox="gallery-{{ $examination->id }}"
                                                data-caption="{{ $file->file_name }}" class="fancybox-image-link"
                                                style="display: block; position: relative; overflow: hidden; border-radius: 8px; border: 2px solid #e9ecef; transition: all 0.3s;">
                                                <img src="{{ asset('storage/' . $file->file_path) }}"
                                                    alt="{{ $file->file_name }}"
                                                    style="width: 100%; height: 150px; object-fit: cover; display: block;">
                                                <div
                                                    style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); padding: 8px; color: white; font-size: 11px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                                    {{ $file->file_name }}
                                                </div>
                                            </a>
                                        @endforeach

                                        @foreach ($pdfFiles as $file)
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                class="pdf-file-link"
                                                style="display: block; position: relative; overflow: hidden; border-radius: 8px; border: 2px solid #e9ecef; background: #f8f9fa; height: 150px; transition: all 0.3s; text-decoration: none; color: inherit;">
                                                <div
                                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; padding: 10px;">
                                                    <div style="font-size: 48px; margin-bottom: 8px; color: #dc3545;">
                                                        📄
                                                    </div>
                                                    <div
                                                        style="font-size: 11px; color: #333; text-align: center; text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; word-break: break-word;">
                                                        {{ $file->file_name }}
                                                    </div>
                                                    @if ($file->file_size)
                                                        <div style="font-size: 10px; color: #6c757d; margin-top: 5px;">
                                                            {{ number_format($file->file_size / 1024, 2) }} KB
                                                        </div>
                                                    @endif
                                                </div>
                                            </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($otherFiles->count() > 0)
                            <div class="file-list">
                                @foreach ($otherFiles as $file)
                                    <div class="file-list-item">
                                        <span class="file-name">
                                            📁
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                style="color: #26A69A; text-decoration: none; margin-left: 5px;"
                                                title="{{ $file->file_name }}">
                                                {{ $file->file_name }}
                                            </a>
                                        </span>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            @if ($file->file_size)
                                                <span class="file-size">
                                                    {{ number_format($file->file_size / 1024, 2) }} KB
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div style="color: #6c757d; font-style: italic;">Bu müayinə üçün fayl yoxdur</div>
                @endif
            </div>
    @endforeach
    </div>
    </div>
    @endif

    <style>
        .custom-file-input-wrapper {
            position: relative;
        }

        .custom-file-input {
            position: absolute;
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            z-index: -1;
        }

        .custom-file-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            background: #fff;
            border: 2px dashed #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 50px;
        }

        .custom-file-label:hover {
            border-color: #26A69A;
            background: #f8f9fa;
        }

        .custom-file-label .file-icon {
            font-size: 20px;
            margin-right: 10px;
        }

        .custom-file-label .file-text {
            flex: 1;
            color: #666;
            font-size: 14px;
        }

        .custom-file-label .file-button {
            background: #26A69A;
            color: #fff;
            padding: 8px 20px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .custom-file-label:hover .file-button {
            background: #1e8e82;
        }

        .file-list {
            margin-top: 15px;
            padding: 0;
        }

        .file-list-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 15px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            margin-bottom: 8px;
            font-size: 13px;
            color: #333;
        }

        .file-list-item:last-child {
            margin-bottom: 0;
        }

        .file-list-item .file-name {
            flex: 1;
            word-break: break-word;
        }

        .file-list-item .file-size {
            color: #999;
            margin-left: 10px;
            font-size: 12px;
        }

        .file-list-item .file-remove {
            color: #dc3545;
            cursor: pointer;
            margin-left: 10px;
            font-size: 16px;
            font-weight: bold;
            padding: 0 5px;
            transition: color 0.2s ease;
        }

        .file-list-item .file-remove:hover {
            color: #c82333;
        }

        .file-list-item a:hover {
            color: #1e8e82 !important;
            text-decoration: underline !important;
        }

        .examination-images-gallery .fancybox-image-link,
        .examination-images-gallery .pdf-file-link {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .examination-images-gallery .fancybox-image-link:hover,
        .examination-images-gallery .pdf-file-link:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-color: #26A69A;
        }

        .examination-images-gallery .pdf-file-link:hover {
            background: #e9ecef !important;
        }

        .btn-delete-examination:hover {
            background: #c82333 !important;
        }
    </style>

    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

    <!-- Fancybox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert@1.1.3/dist/sweetalert.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var $birthdayInput = $('#birthday');

            // Блокируем вставку текста
            $birthdayInput.on('paste', function(e) {
                e.preventDefault();
                return false;
            });

            // Блокируем ввод с клавиатуры (кроме навигации)
            $birthdayInput.on('keydown', function(e) {
                // Разрешаем только клавиши навигации и удаления
                var allowedKeys = [8, 9, 13, 27, 37, 38, 39, 40, 46];
                if (!allowedKeys.includes(e.keyCode)) {
                    e.preventDefault();
                    return false;
                }
            });

            // Custom file input handling
            const fileInput = document.getElementById('files');
            const fileList = document.getElementById('file-list');
            const fileText = document.querySelector('.file-text');
            let selectedFiles = []; // Массив для хранения всех выбранных файлов

            if (fileInput) {
                // Функция для обновления input.files
                function updateFileInput(filesArray) {
                    const dataTransfer = new DataTransfer();
                    filesArray.forEach(function(file) {
                        dataTransfer.items.add(file);
                    });
                    fileInput.files = dataTransfer.files;
                }

                // Функция для отображения списка файлов
                function renderFileList() {
                    fileList.innerHTML = '';

                    if (selectedFiles.length > 0) {
                        fileText.textContent = selectedFiles.length + ' fayl seçildi';

                        selectedFiles.forEach(function(file, index) {
                            const fileItem = document.createElement('div');
                            fileItem.className = 'file-list-item';

                            const fileName = document.createElement('span');
                            fileName.className = 'file-name';
                            fileName.textContent = file.name;

                            const fileSize = document.createElement('span');
                            fileSize.className = 'file-size';
                            fileSize.textContent = formatFileSize(file.size);

                            const fileRemove = document.createElement('span');
                            fileRemove.className = 'file-remove';
                            fileRemove.textContent = '×';
                            fileRemove.title = 'Sil';
                            fileRemove.addEventListener('click', function(e) {
                                e.stopPropagation();
                                selectedFiles.splice(index, 1);
                                updateFileInput(selectedFiles);
                                renderFileList();
                            });

                            fileItem.appendChild(fileName);
                            fileItem.appendChild(fileSize);
                            fileItem.appendChild(fileRemove);
                            fileList.appendChild(fileItem);
                        });
                    } else {
                        fileText.textContent = 'Faylları seçin';
                    }
                }

                // Обработчик выбора файлов
                fileInput.addEventListener('change', function(e) {
                    const newFiles = Array.from(this.files);

                    // Добавляем новые файлы к существующим (проверяем на дубликаты по имени и размеру)
                    newFiles.forEach(function(newFile) {
                        const isDuplicate = selectedFiles.some(function(existingFile) {
                            return existingFile.name === newFile.name && existingFile
                                .size === newFile.size;
                        });

                        if (!isDuplicate) {
                            selectedFiles.push(newFile);
                        }
                    });

                    // Обновляем input.files
                    updateFileInput(selectedFiles);

                    // Обновляем отображение
                    renderFileList();

                    // Сбрасываем значение input, чтобы можно было выбрать те же файлы снова
                    this.value = '';
                });
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
            }

            // Обработчик submit формы - убеждаемся, что файлы установлены перед отправкой
            const examinationForm = document.getElementById('examination-form');
            if (examinationForm) {
                examinationForm.addEventListener('submit', function(e) {
                    // Проверяем, есть ли файлы в selectedFiles, но нет в input
                    if (selectedFiles.length > 0) {
                        // Обновляем input перед отправкой
                        updateFileInput(selectedFiles);

                        // Проверяем еще раз после обновления
                        if (fileInput.files.length === 0) {
                            console.warn('Файлы не были установлены в input перед отправкой');
                            // Пытаемся установить еще раз
                            const dataTransfer = new DataTransfer();
                            selectedFiles.forEach(function(file) {
                                dataTransfer.items.add(file);
                            });
                            fileInput.files = dataTransfer.files;
                        }

                        console.log('Отправка формы с', fileInput.files.length, 'файлами');
                    }
                });
            }
        });

        // Инициализация Fancybox для галерей изображений
        if (typeof Fancybox !== 'undefined') {
            Fancybox.bind('[data-fancybox]', {
                Toolbar: {
                    display: {
                        left: ["infobar"],
                        middle: [],
                        right: ["slideshow", "download", "thumbs", "close"],
                    },
                },
                Thumbs: {
                    autoStart: true,
                },
                Carousel: {
                    infinite: true,
                },
            });
        }

        // Обработчик для кнопок удаления осмотра
        document.querySelectorAll('.btn-delete-examination').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const examinationId = this.getAttribute('data-examination-id');
                const patientId = {{ $patient->id }};

                // Используем SweetAlert для подтверждения
                if (typeof swal !== 'undefined') {
                    swal({
                        title: "Silmək istədiyinizə əminsiniz?",
                        text: "Bu müayinə və onun bütün faylları silinəcək!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        confirmButtonText: "Bəli, sil!",
                        cancelButtonText: "Ləğv et",
                        closeOnConfirm: false
                    }, function(isConfirm) {
                        if (isConfirm) {
                            // Создаем форму для отправки DELETE запроса
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action =
                                `/admin/patient/${patientId}/examination/${examinationId}`;

                            // Добавляем CSRF токен
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';
                            form.appendChild(csrfInput);

                            // Добавляем метод DELETE
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            form.appendChild(methodInput);

                            // Добавляем форму в body и отправляем
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                } else {
                    // Fallback на обычный confirm, если SweetAlert не подключен
                    if (confirm('Bu müayinəni silmək istədiyinizə əminsiniz?')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/patient/${patientId}/examination/${examinationId}`;

                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = '{{ csrf_token() }}';
                        form.appendChild(csrfInput);

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        form.appendChild(methodInput);

                        document.body.appendChild(form);
                        form.submit();
                    }
                }
            });
        });
    </script>
@endsection
