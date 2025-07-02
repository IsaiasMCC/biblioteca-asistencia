@extends('layouts.app')

@push('title', 'Salas')

@section('content_header')
    <h2> Salas </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"> <a href={{ route('salas.index') }}> Inicio</a> </li>
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
            const titleReport = `Reporte de Usuarios`;
            const fileName = `reporte-usuarios-${today}-${time}`;
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

            $(document).on('click', '.deleteSalaBtn', function() {
                let salaId = $(this).data('id');
                Swal.fire({
                    title: "Esta seguro de borrar esta sala?",
                    text: "Este cambio no se puede revertir",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#1AB394",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/salas/${salaId}`,
                            type: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                toastr.success(response.message, 'Éxito');
                                location.reload();
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
        @can('salas agregar')
            <div class="ml-5 mb-2">
                <a href="{{ route('salas.create') }}" type="button" class="btn btn-clock btn-primary"> Agregar Sala </a>
            </div>
        @endcan
        <div class="col-lg-12">
            <div class="ibox-content style-tema">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead class="text-center">
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Capacidad</th>
                                <th>Ubicación</th>
                                <th>Estado</th>
                                @canany(['salas editar', 'salas eliminar'])
                                    <th>Acción</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($salas as $sala)
                                <tr class="gradeX" data-id="{{ $sala->id }}">
                                    <td>{{ $sala->id }}</td>
                                    <td>{{ $sala->nombre }} </td>
                                    <td>{{ $sala->capacidad }} </td>
                                    <td>{{ $sala->ubicacion }}</td>
                                    <td>
                                        <p class="border text-center {{ $sala->estado ? 'bg-primary' : 'bg-warning' }}">
                                            {{ $sala->estado ? 'Activo' : 'Inactivo' }}
                                        </p>
                                    </td>
                                    @canany(['salas editar', 'salas eliminar'])
                                        <td class="text-center">
                                            @can('salas editar')
                                                <a class="btn btn-info" href="{{ route('salas.edit', $sala->id) }}"> <i
                                                        class="fa fa-pencil" aria-hidden="true"></i> </a>
                                            @endcan

                                            @can('salas eliminar')
                                                <button class="btn btn-danger deleteSalaBtn" data-id="{{ $sala->id }}">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
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
