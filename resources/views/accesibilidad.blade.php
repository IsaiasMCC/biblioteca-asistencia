@extends('layouts.app')

@push('title', 'Inicio')

@section('content_header', 'Accesibilidad')
@section('breadcrum')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Home</a>
    </li>
    <li class="breadcrumb-item active">
        <strong>Accesibilidad</strong>
    </li>
@endsection
@section('style')

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(".touchspin1").TouchSpin({
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white'
            });
        });
    </script>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content style-tema">
                <div class="row">
                    <div class="col-md-4">
                        <p class="font-bold input-label">
                            Tamaño de fuente
                        </p>
                        <input class="touchspin1" type="text" value="14" name="demo1">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
