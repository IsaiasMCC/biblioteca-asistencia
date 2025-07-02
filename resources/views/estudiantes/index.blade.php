@extends('layouts.app')

@push('title', 'Estudiantes')

@section('content_header')
    <h2> Estudiantes </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"> <a href="{{ route('estudiantes.index') }}"> Inicio </a> </li>
    </ol>
@endsection

@push('styles')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
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

            @if (session('error'))
                toastr.error(@json(session('error')), 'Error');
            @endif

            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'excel',
                        title: 'Reporte de Estudiantes',
                        filename: 'reporte-estudiantes'
                    },
                    {
                        extend: 'pdf',
                        title: 'Reporte de Estudiantes',
                        filename: 'reporte-estudiantes'
                    }
                ]
            });

            $(document).on('click', '.deleteEstudianteBtn', function() {
                let estudianteId = $(this).data('id');
                Swal.fire({
                    title: "¿Está seguro de eliminar este estudiante?",
                    text: "Este cambio no se puede revertir",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#1AB394",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, eliminar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/estudiantes/${estudianteId}`,
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
        @can('estudiantes agregar')
            <div class="ml-5 mb-2">
                <a href="{{ route('estudiantes.create') }}" class="btn btn-primary">Agregar Estudiante</a>
            </div>
        @endcan

        <div class="col-lg-12">
            <div class="ibox-content style-tema">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Registro</th>
                                <th>Nombre Usuario</th>
                                <th>Email</th>
                                <th>Carrera</th>
                                <th>Género</th>
                                <th>Estado</th>
                                @canany(['estudiantes editar', 'estudiantes eliminar'])
                                    <th>Acción</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($students as $estudiante)
                                <tr>
                                    <td>{{ $estudiante->id }}</td>
                                    <td>{{ $estudiante->registro }}</td>
                                    <td>{{ $estudiante->user->nombres }} {{ $estudiante->user->apellidos }}</td>
                                    <td>{{ $estudiante->email }}</td>
                                    <td>{{ $estudiante->carrera }}</td>
                                    <td>{{ ucfirst($estudiante->genero) }}</td>
                                    <td>
                                        <p
                                            class="border text-center {{ $estudiante->estado ? 'bg-primary' : 'bg-warning' }}">
                                            {{ $estudiante->estado ? 'Activo' : 'Inactivo' }}
                                        </p>
                                    </td>
                                    @canany(['estudiantes editar', 'estudiantes eliminar'])
                                        <td>
                                            @can('estudiantes editar')
                                                <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn btn-info">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('estudiantes eliminar')
                                                <button class="btn btn-danger deleteEstudianteBtn" data-id="{{ $estudiante->id }}">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
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
