@extends('admin.layouts.default')
@section('title', 'Sazlamalar')
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">Sazlamalar<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
            <div class="heading-elements">
            </div>
        </div>

        <div class="panel-body">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.settings.store') }}" class="form-horizontal has-feedback" id="form-save"
                enctype="multipart/form-data" method="post" accept-charset="utf-8">
                @csrf

                <div class="form-group has-feedback has-feedback-right">
                    <label for="profile_photo" class="control-label col-md-3">Profil fotosu</label>
                    <div class="col-lg-9">
                        <div class="mb-3">
                            <div class="custom-input_file" id="file-upload-container">
                                <input type="file" id="file" name="userfile" accept="image/*">
                                <div class="file-upload-content">
                                    <i class="icon-upload"
                                        style="font-size: 32px; color: #999; display: block; margin-bottom: 10px;"></i>
                                    <span class="file-upload-text">Upload</span>
                                    <div class="file-name-display" id="file-name-display"
                                        style="display: none; margin-top: 10px; color: #333; font-weight: 500;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-right">
                    <label for="profile_fullname" class="control-label col-md-3">Ad Soyad</label>
                    <div class="col-lg-9">
                        <input type="text" name="profile_fullname"
                            value="{{ old('profile_fullname', $settings?->profile_fullname) }}" class="form-control"
                            placeholder="Adınızı və soyadınızı daxil edin">
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-right">
                    <label for="profile_specialization" class="control-label col-md-3">İxtisas</label>
                    <div class="col-lg-9">
                        <input type="text" name="profile_specialization"
                            value="{{ old('profile_specialization', $settings?->profile_specialization) }}"
                            class="form-control" placeholder="İxtisasınızı daxil edin">
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-right">
                    <label for="old_password" class="control-label col-md-3">Köhnə şifrə</label>
                    <div class="col-lg-9">
                        <input type="password" name="old_password" value="" class="form-control"
                            placeholder="Köhnə şifrənizi daxil edin" autocomplete="password">
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-right">
                    <label for="new_password" class="control-label col-md-3">Yeni şifrə</label>
                    <div class="col-lg-9">
                        <input type="password" name="new_password" value="" class="form-control"
                            placeholder="Yeni şifrənizi daxil edin" autocomplete="password">
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-right">
                    <label for="profile_email" class="control-label col-md-3">E-mail adres</label>
                    <div class="col-lg-9">
                        <input type="email" name="profile_email"
                            value="{{ old('profile_email', $settings?->profile_email) }}" class="form-control"
                            placeholder="example@mail.com">
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-right">
                    <label for="telegram_profile" class="control-label col-md-3">Telegram profili</label>
                    <div class="col-lg-9">
                        <input type="text" name="telegram_profile"
                            value="{{ old('telegram_profile', $settings?->telegram_profile) }}" class="form-control"
                            placeholder="@username və ya link">
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-right">
                    <label for="telegram_api_key" class="control-label col-md-3">Telegram API KEY</label>
                    <div class="col-lg-9">
                        <input type="text" name="telegram_api_key"
                            value="{{ old('telegram_api_key', $settings?->telegram_api_key) }}" class="form-control"
                            placeholder="Botunuzun API açarı">
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-right">
                    <label for="whatsapp_number" class="control-label col-md-3">WhatsApp nömrə</label>
                    <div class="col-lg-9">
                        <input type="text" name="whatsapp_number"
                            value="{{ old('whatsapp_number', $settings?->whatsapp_number) }}" class="form-control"
                            placeholder="+994 50 000 00 00">
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-right">
                    <label for="whatsapp_api_key" class="control-label col-md-3">WhatsApp API KEY</label>
                    <div class="col-lg-9">
                        <input type="text" name="whatsapp_api_key"
                            value="{{ old('whatsapp_api_key', $settings?->whatsapp_api_key) }}" class="form-control"
                            placeholder="WhatsApp inteqrasiyası üçün API açarı">
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-right">
                    <label for="gmail_account" class="control-label col-md-3">Gmail</label>
                    <div class="col-lg-9">
                        <input type="email" name="gmail_account"
                            value="{{ old('gmail_account', $settings?->gmail_account) }}" class="form-control"
                            placeholder="yourname@gmail.com">
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-right">
                    <label for="bulk_sms_name" class="control-label col-md-3">Toplu SMS adı</label>
                    <div class="col-lg-9">
                        <input type="text" name="bulk_sms_name"
                            value="{{ old('bulk_sms_name', $settings?->bulk_sms_name) }}" class="form-control"
                            placeholder="Göndərən adı (Sender name)">
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-right">
                    <label for="bulk_sms_number" class="control-label col-md-3">Toplu SMS nömrəsi</label>
                    <div class="col-lg-9">
                        <input type="text" name="bulk_sms_number"
                            value="{{ old('bulk_sms_number', $settings?->bulk_sms_number) }}" class="form-control"
                            placeholder="Toplu SMS xidməti nömrəsi">
                    </div>
                </div>

                <div class="form-group has-feedback has-feedback-right">
                    <label for="bulk_sms_api_key" class="control-label col-md-3">Toplu SMS API KEY</label>
                    <div class="col-lg-9">
                        <input type="text" name="bulk_sms_api_key"
                            value="{{ old('bulk_sms_api_key', $settings?->bulk_sms_api_key) }}" class="form-control"
                            placeholder="Toplu SMS provayder API açarı">
                    </div>
                </div>

                <div class="row text-center gond">
                    <button type="submit" class="btn btn-success gonder">Yadda saxla</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .custom-input_file {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 120px;
            cursor: pointer;
        }

        .file-upload-content {
            text-align: center;
            pointer-events: none;
            z-index: 1;
        }

        .file-upload-text {
            color: #999;
            font-size: 14px;
            font-weight: 500;
        }

        .file-name-display {
            color: #333;
            font-size: 13px;
            word-break: break-word;
        }

        .custom-input_file input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            cursor: pointer;
            opacity: 0;
            z-index: 2;
        }

        .custom-input_file:hover {
            border-color: #26A69A;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file');
            const fileNameDisplay = document.getElementById('file-name-display');
            const fileUploadText = document.querySelector('.file-upload-text');

            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files.length > 0) {
                    const fileName = this.files[0].name;
                    fileNameDisplay.textContent = fileName;
                    fileNameDisplay.style.display = 'block';
                    fileUploadText.textContent = 'Fayl seçildi';
                } else {
                    fileNameDisplay.style.display = 'none';
                    fileUploadText.textContent = 'Upload';
                }
            });
        });
    </script>
@endsection
