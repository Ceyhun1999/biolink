@extends('admin.layouts.default')
@section('title', 'Yeni xəstə qeydiyyatı')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h5 class="panel-title text-semibold">YENİ XƏSTƏ QEYDİYYATI <a class="heading-elements-toggle"><i
                        class="icon-more"></i></a></h5>
            <div class="heading-elements"></div>
        </div>
        <form action="{{ route('admin.patients.store') }}" class="has-feedback" id="form-save" method="post"
            accept-charset="utf-8">
            @csrf
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
                            <input type="text" name="firstName" value="{{ old('firstName') }}" id="firsName"
                                class="form-control" placeholder="Adı">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <input type="text" name="lastName" value="{{ old('lastName') }}" id="lastName"
                                class="form-control" placeholder="Soyadı">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <input type="text" name="fatherName" value="{{ old('fatherName') }}" class="form-control"
                                placeholder="Ata adı">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <input type="text" name="birthday" value="{{ old('birthday') }}" id="birthday"
                                class="form-control datepicker" placeholder="Doğum tarixini seçin" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <input type="text" name="phone" value="{{ old('phone') }}" id="phone"
                                class="form-control" placeholder="Telefon">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group ">
                            <input type="text" name="phone2" value="{{ old('phone2') }}" id="phone2"
                                class="form-control" placeholder="Telefon (əlavə)">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select id="patient_source_id" name="patient_source_id" class="form-control select-search">
                                <option value="">-- Haradan gəlib --</option>
                                @foreach ($sources as $source)
                                    <option value="{{ $source->id }}"
                                        {{ old('patient_source_id') == $source->id ? 'selected' : '' }}>
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
                                <option {{ old('gender') == 'Kişi' ? 'selected' : '' }} value="Kişi">Kişi</option>
                                <option {{ old('gender') == 'Qadın' ? 'selected' : '' }} value="Qadın">Qadın</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group ">
                            <input type="text" name="diagnose" value="{{ old('diagnose') }}" id="diagnose"
                                class="form-control" placeholder="Diaqnoz">
                        </div>
                    </div>

                </div>
                <div class="row text-center gond">
                    <button type="submit" class="btn btn-success gonder">QEYDİYYATA
                        AL</button>
                </div>
            </div>
        </form>
    </div>

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
        });
    </script>
@endsection
