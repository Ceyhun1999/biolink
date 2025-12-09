@extends('admin.layouts.default')
@section('title', 'Xəstələrin siyahısı')
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading d-flex">
            <h5 class="panel-title">XƏSTƏLƏR</h5>
            <div class="heading-elements">
                <form action="{{ route('admin.patients.index') }}" class="heading-form pull-right" method="get"
                    accept-charset="utf-8">
                    <div class="form-group has-feedback" style="position: relative;">
                        <input type="search" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Axtar" autocomplete="search">
                        <button type="submit"
                            style="background: transparent; border: none; position: absolute; right: 0; top: 0; height: 100%; padding: 0 15px; cursor: pointer; z-index: 10;">
                            <i class="icon-search4 text-size-base text-muted"></i>
                        </button>
                    </div>
                    @if (request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    @if (request('direction'))
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                    @endif
                </form>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-responsive table-striped table-hover table-xxs">
            <thead>
                <tr>
                    <th style="width:1px;">
                        <input type="checkbox" id="select-all"
                            onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
                    </th>
                    <th class="column_id">
                        <a href="{{ request()->fullUrlWithQuery([
                            'sort' => 'id',
                            'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc',
                        ]) }}"
                            class="text-dark" style="text-decoration: none;">
                            ID <i class="icon-menu-open pull-right"></i>
                        </a>
                    </th>
                    <th class="column_firstname">
                        <a href="{{ request()->fullUrlWithQuery([
                            'sort' => 'firstName',
                            'direction' => request('sort') === 'firstName' && request('direction') === 'asc' ? 'desc' : 'asc',
                        ]) }}"
                            class="text-dark" style="text-decoration: none;">
                            Adı <i class="icon-menu-open pull-right"></i>
                        </a>
                    </th>
                    <th class="column_lastname">
                        <a href="{{ request()->fullUrlWithQuery([
                            'sort' => 'lastName',
                            'direction' => request('sort') === 'lastName' && request('direction') === 'asc' ? 'desc' : 'asc',
                        ]) }}"
                            class="text-dark" style="text-decoration: none;">
                            Soyadı <i class="icon-menu-open pull-right"></i>
                        </a>
                    </th>
                    <th class="column_fathername">
                        <a href="{{ request()->fullUrlWithQuery([
                            'sort' => 'fatherName',
                            'direction' => request('sort') === 'fatherName' && request('direction') === 'asc' ? 'desc' : 'asc',
                        ]) }}"
                            class="text-dark" style="text-decoration: none;">
                            Ata adı <i class="icon-menu-open pull-right"></i>
                        </a>
                    </th>
                    <th class="column_sex">
                        <a href="{{ request()->fullUrlWithQuery([
                            'sort' => 'gender',
                            'direction' => request('sort') === 'gender' && request('direction') === 'asc' ? 'desc' : 'asc',
                        ]) }}"
                            class="text-dark" style="text-decoration: none;">
                            Cins <i class="icon-menu-open pull-right"></i>
                        </a>
                    </th>
                    <th class="column_source">
                        <a href="{{ request()->fullUrlWithQuery([
                            'sort' => 'source',
                            'direction' => request('sort') === 'source' && request('direction') === 'asc' ? 'desc' : 'asc',
                        ]) }}"
                            class="text-dark" style="text-decoration: none;">
                            Referans <i class="icon-menu-open pull-right"></i>
                        </a>
                    </th>
                    <th class="column_birthday">
                        <a href="{{ request()->fullUrlWithQuery([
                            'sort' => 'birthday',
                            'direction' => request('sort') === 'birthday' && request('direction') === 'asc' ? 'desc' : 'asc',
                        ]) }}"
                            class="text-dark" style="text-decoration: none;">
                            Yaş <i class="icon-menu-open pull-right"></i>
                        </a>
                    </th>
                    <th class="column_diagnose">
                        <a href="{{ request()->fullUrlWithQuery([
                            'sort' => 'diagnose',
                            'direction' => request('sort') === 'diagnose' && request('direction') === 'asc' ? 'desc' : 'asc',
                        ]) }}"
                            class="text-dark" style="text-decoration: none;">
                            Diaqnoz <i class="icon-menu-open pull-right"></i>
                        </a>
                    </th>
                    <th class="column_phone">
                        <a href="{{ request()->fullUrlWithQuery([
                            'sort' => 'phone',
                            'direction' => request('sort') === 'phone' && request('direction') === 'asc' ? 'desc' : 'asc',
                        ]) }}"
                            class="text-dark" style="text-decoration: none;">
                            Telefon <i class="icon-menu-open pull-right"></i>
                        </a>
                    </th>
                    <th class="column_created_at">
                        <a href="{{ request()->fullUrlWithQuery([
                            'sort' => 'created_at',
                            'direction' => request('sort') === 'created_at' && request('direction') === 'asc' ? 'desc' : 'asc',
                        ]) }}"
                            class="text-dark" style="text-decoration: none;">
                            Qeydiyyat tarixi <i class="icon-menu-open pull-right"></i>
                        </a>
                    </th>
                    <th style="width:auto;"><i class="icon-menu7"></i></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($patients as $patient)
                    <tr>
                        <td class="column_checkbox">
                            <input type="checkbox" name="selected[]" value="">
                        </td>
                        <td class="column_id">{{ $patient->id }}</td>
                        <td class="column_firstName">{{ $patient->firstName }}</td>
                        <td class="column_lastName">{{ $patient->lastName }}</td>
                        <td class="column_fatherName">{{ $patient->fatherName }}</td>
                        <td class="column_sex">{{ $patient->gender }}</td>
                        <td class="column_status">{{ $patient->patientSource?->name }}</td>
                        <td class="column_birthday">{{ $patient->age }}</td>
                        <td class="column_diagnose">{{ $patient->diagnose }}</td>
                        <td class="column_phone">{{ $patient->phone }}</td>
                        <td class="column_created_at">{{ $patient->created_at }}</td>
                        <td class="column_action">
                            <ul class="icons-list">
                                <li><a class="btn btn-default"
                                        href="{{ route('admin.patients.edit', ['patient' => $patient->id]) }}">Redaktə
                                        et</a></li>
                            </ul>
                        </td>
                    </tr>
                @empty
                    <div class="alert alert-secondary" role="alert">
                        Pasient sayı 0.
                    </div>
                @endforelse
            </tbody>
        </table>

        <div class="panel-footer">
            <a class="heading-elements-toggle"><i class="icon-more"></i></a>
            <div class="">
                <span class="heading-left-element p-10">
                    <div class="btn-group bootstrap-select"><button type="button"
                            class="btn dropdown-toggle btn-default btn-xs saylar" data-toggle="dropdown" role="button"
                            title="100"><span class="filter-option pull-left">100</span>&nbsp;<span
                                class="bs-caret"><span class="caret"></span></span></button>
                        <div class="dropdown-menu open" role="combobox">
                            <ul class="dropdown-menu inner" role="listbox" aria-expanded="false">
                                <li data-original-index="0"><a tabindex="0" class="" data-tokens="null"
                                        role="option" aria-disabled="false" aria-selected="false"><span
                                            class="text">10</span><span
                                            class="glyphicon glyphicon-ok check-mark"></span></a></li>
                                <li data-original-index="1"><a tabindex="0" class="" data-tokens="null"
                                        role="option" aria-disabled="false" aria-selected="false"><span
                                            class="text">20</span><span
                                            class="glyphicon glyphicon-ok check-mark"></span></a></li>
                                <li data-original-index="2"><a tabindex="0" class="" data-tokens="null"
                                        role="option" aria-disabled="false" aria-selected="false"><span
                                            class="text">50</span><span
                                            class="glyphicon glyphicon-ok check-mark"></span></a></li>
                                <li data-original-index="3" class="selected"><a tabindex="0" class=""
                                        data-tokens="null" role="option" aria-disabled="false"
                                        aria-selected="true"><span class="text">100</span><span
                                            class="glyphicon glyphicon-ok check-mark"></span></a></li>
                                <li data-original-index="4"><a tabindex="0" class="" data-tokens="null"
                                        role="option" aria-disabled="false" aria-selected="false"><span
                                            class="text">200</span><span
                                            class="glyphicon glyphicon-ok check-mark"></span></a></li>
                            </ul>
                        </div><select name="per_page" class="bootstrap-select" data-style="btn-default btn-xs saylar"
                            tabindex="-98">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100" selected="selected">100</option>
                            <option value="200">200</option>
                        </select>
                    </div>

                </span>

            </div>
        </div>


    </div>
@endsection
