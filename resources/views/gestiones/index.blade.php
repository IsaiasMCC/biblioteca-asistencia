@extends('layouts.app')

@push('title', 'Gestiones')

@section('content_header')
    <h2> Gestiones </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"> <a href={{ route('gestiones.index') }}> Inicio</a> </li>
    </ol>
@endsection

@push('styles')
    {{-- TABLA --}}
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    {{-- TABLA --}}
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    {{-- MODAL DE PREGUNTA --}}
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                positionClass: "toast-top-right",
                timeOut: 2000,
                progressBar: true,
            };

            @if (session('success'))
                toastr.success(@json(session('success')), 'Éxito');
            @endif

            @if (session('update'))
                toastr.success(@json(session('update')), 'Éxito');
            @endif

            @if (session('error'))
                toastr.error(@json(session('error')), 'Error');
            @endif

            const now = new Date();
            const today = now.toLocaleDateString('es-BO').replace(/\//g, '-');
            const time = now.toLocaleTimeString('es-BO', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
            const titleReport = `Reporte de Gestiones`;
            const fileName = `reporte-gestiones-${today}-${time}`;
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'excel',
                        title: titleReport,
                        filename: fileName
                    },
                    {
                        extend: 'pdf',
                        title: titleReport,
                        filename: fileName
                    },
                    {
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]

            });

            $(document).on('click', '.deleteRoleBtn', function() {
                let roleId = $(this).data('id');
                Swal.fire({
                    title: "Esta seguro de borrar este rol?",
                    text: "Este cambio no se puede revertir",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#1AB394",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ url('gestiones') }}/${roleId}`,
                            type: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: "Eliminado!",
                                    text: response.message,
                                    icon: "success"
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                let res = JSON.parse(xhr.responseText);
                                toastr.error(res.message, 'Error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

@section('content')
    <div class="row">

        @can('gestiones agregar')
            <div class="ml-5 mb-2">
                <a href="{{ route('gestiones.create') }}" type="button" class="btn btn-clock btn-primary"> Agregar Gestión </a>
            </div>
        @endcan
        <div class="col-lg-12">
            <div class="ibox-content style-tema">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead class="">
                            <tr>
                                <th>Id</th>
                                <th>Año</th>
                                <th>Semestre</th>
                                @canany(['gestiones editar', 'gestiones eliminar'])
                                    <th>Acción</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($gestions as $gestion)
                                <tr class="gradeX" data-id="{{ $gestion->id }}">
                                    <td>{{ $gestion->id }}</td>
                                    <td>{{ $gestion->anio }}</td>
                                    <td>{{ $gestion->semestre }}</td>
                                    @canany(['gestiones permisos', 'gestiones editar', 'gestiones eliminar'])
                                        <td class="text-center">
                                            @can('gestiones editar')
                                                <a class="btn btn-info" href="{{ route('gestiones.edit', $gestion->id) }}"> <i
                                                        class="fa fa-pencil" aria-hidden="true"></i> </a>
                                            @endcan

                                            @can('gestiones eliminar')
                                                <button class="btn btn-danger deleteRoleBtn" data-id="{{ $gestion->id }}"> <i
                                                        class="fa fa-trash-o" aria-hidden="true"></i> </button>
                                            @endcan
                                        </td>
                                    @endcanany
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
