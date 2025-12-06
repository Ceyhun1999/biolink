<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/materialicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/additionals.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/general.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/colors.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-layout.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <style>
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            margin: 0;
            vertical-align: middle;
        }

        input[type="checkbox"]:checked {
            accent-color: #1c1d1c;
        }
    </style>
</head>

<body class="navbar-top pace-done sidebar-xs-indicator">
    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>

    <div class="page-container">
        <div class="page-content">
            <div class="sidebar sidebar-main sidebar-fixed">
                <div class="sidebar-content">
                    <div class="sidebar-category sidebar-category-visible">
                        <div class="category-content no-padding mobdarow">

                            <div class="d-flex proff">
                                <div class="yumru">
                                    <img src="{{ $settings?->profile_photo ? Storage::url($settings->profile_photo) : asset('assets/img/no-image.webp') }}" class="yum-sekil">
                                </div>
                                <div class="tab1 bolum d-flex">
                                    <div class="yumr">
                                       <h5>{{ $settings?->profile_fullname ?? 'Ad Soyad' }}</h5>
                                    </div>
                                    <div class="yumr solgun">
                                      <h5>{{ $settings?->profile_specialization ?? 'İxtisas' }}</h5>
                                    </div>
                                </div>
                            </div>

                            <a class="cixis" href="{{ route('admin.logout') }}">Hesabdan
                                çıx</a>
                            <div id="menu-toggle">
                                <div class="xett1"></div>
                                <div class="xett2"></div>
                                <div class="xett3"></div>
                            </div>
                        </div>

                        <ul class="navigation navigation-main navigation-accordion" id="main-menu">
                            <li class="{{ request()->routeIs('admin.patients.create') ? 'active' : '' }} "><a
                                    href="{{ route('admin.patients.create') }}"><i class="icon-user-plus"></i>
                                    <span>Yeni xəstə
                                        qeydiyyatı</span></a></li>
                            <li class="{{ request()->routeIs('admin.patients.index') ? 'active' : '' }}"><a
                                    href="{{ route('admin.patients.index') }}"><i class="icon-users4"></i>
                                    <span>Xəstələrin siyahısı</span></a></li>
                            <li><a href=""><i class="icon-stats-bars2"></i>
                                    <span>Toplu SMS Göndər</span></a></li>
                            <li><a href="#"><i class="icon-stats-bars2"></i> <span>AI
                                        (Süni İntellekt) proqnozlar</span></a></li>
                            <li><a href="#"><i class="icon-stats-bars2"></i>
                                    <span>Statistika / Hesabat</span></a></li>
                            <li class="{{ request()->routeIs('admin.settings.index') ? 'active' : '' }}"><a
                                    href="{{ route('admin.settings.index') }}"><i class="icon-stats-bars2"></i>
                                    <span>Sazlamalar</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="content-wrapper">
                <div class="navbar-collapse collapse yuxari" id="navbar-mobile">
                    <ul class="nav navbar-nav">
                        <li class="dropdown dropdown-user">
                            <div class="loqo"><a href="#"><img src="{{ asset('assets/img/logo.png') }}"
                                        width="150"></a></div>
                        </li>
                    </ul>
                </div>
                <div class="content">

                    @yield('content')

                    <div class="navbar navbar-default navbar-fixed-bt">
                        <ul class="nav navbar-nav no-border visible-xs-block">
                            <li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second"><i
                                        class="icon-circle-up2"></i></a></li>
                        </ul>

                        <div class="navbar-collapse collapse" id="navbar-second">
                            <div class="navbar-text">
                                © 2025. Biolink LLC
                            </div>

                            <div class="navbar-right">
                                <ul class="nav navbar-nav">
                                    <li><a>Yaddaş istifadəsi: 1.09MB</a></li>
                                    <li><a>Açılma müddəti: 0.0449</a></li>
                                    <li><a id="back-to-top"><i class="icon-arrow-up16"></i><span
                                                class="visible-xs-inline-block position-right">Yuxarı</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        var Select2Selects = function() {
            var _componentSelect2 = function() {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                }
                $('.select').select2({
                    minimumResultsForSearch: Infinity
                });
                $('.select-search').select2();

                function iconFormat(icon) {
                    var originalOption = icon.element;
                    if (!icon.id) {
                        return icon.text;
                    }
                    if ($(icon.element).val() == 0) {
                        var $icon = $(icon.element).text();
                    } else {
                        var $icon = '<i class="' + $(icon.element).text() + '"></i>';
                    }
                    return $icon;
                }
                $('.select-icons').select2({
                    templateResult: iconFormat,
                    minimumResultsForSearch: Infinity,
                    templateSelection: iconFormat,
                    escapeMarkup: function(m) {
                        return m;
                    }
                });
            };
            return {
                init: function() {
                    _componentSelect2();
                }
            }
        }();

        var DateTimePickers = function() {
            var _componentDaterange = function() {
                if (!$().daterangepicker) {
                    console.warn('Warning - daterangepicker.js is not loaded.');
                    return;
                }
                $('.datepicker').each(function() {
                    var $input = $(this);
                    if ($input.data('daterangepicker')) {
                        $input.data('daterangepicker').remove();
                    }

                    // Определяем начальную дату: если есть значение в поле, используем его, иначе 2000-01-01
                    // Фиксированная дата нужна, чтобы календарь был инициализирован с годом и можно было выбирать месяц
                    var startDate = $input.val() ? moment($input.val(), 'YYYY-MM-DD') : moment('2000-01-01',
                        'YYYY-MM-DD');

                    $input.daterangepicker({
                        singleDatePicker: true,
                        autoUpdateInput: false,
                        showDropdowns: true,
                        minYear: 1900,
                        maxYear: parseInt(moment().format('YYYY')),
                        startDate: startDate,
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    });
                    $input.on('apply.daterangepicker', function(ev, picker) {
                        $input.val(picker.startDate.format('YYYY-MM-DD'));
                    });
                    $input.on('cancel.daterangepicker', function(ev, picker) {
                        $input.val('');
                    });
                });
            };
            return {
                init: function() {
                    _componentDaterange();
                }
            }
        }();

        var ExtendedFormControls = function() {
            var _componentInputFormatter = function() {
                if (!$().formatter) {
                    console.warn('Warning - formatter.min.js is not loaded.');
                    return;
                }
                $('.format-phone-number').formatter({
                    pattern: '({{ 999 }}) {{ 999 }} - {{ 9999 }}'
                });
                $('.format-date').formatter({
                    pattern: '{{ 99 }}-{{ 99 }}-{{ 9999 }}'
                });
            };
            return {
                init: function() {
                    _componentInputFormatter();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            if (typeof jQuery !== 'undefined') {
                Select2Selects.init();
                DateTimePickers.init();
                ExtendedFormControls.init();
            }

            const menu = document.getElementById("main-menu");
            const menuToggle = document.getElementById("menu-toggle");

            if (menu && menuToggle) {
                if (window.innerWidth <= 768) {
                    menu.style.display = "none";
                } else {
                    menu.style.display = "block";
                }

                menuToggle.addEventListener("click", function() {
                    if (menu.style.display === "none" || menu.style.display === "") {
                        menu.style.display = "block";
                    } else {
                        menu.style.display = "none";
                    }
                });
            }
        });
    </script>
</body>

</html>
