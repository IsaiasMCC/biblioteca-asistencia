@extends('layouts.app')

@push('title', 'Credenciales')

@section('content_header')
    <h2>Credenciales</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('credenciales.index') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Credenciales</li>
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

            $('.dataTables-credenciales').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'excel',
                        title: 'Listado de Credenciales'
                    },
                    {
                        extend: 'pdf',
                        title: 'Listado de Credenciales'
                    }
                ]
            });

            $(document).on('click', '.deleteBtn', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1AB394',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/credenciales/${id}`,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                toastr.success(res.message, 'Éxito');
                                location.reload();
                            },
                            error: function(xhr) {
                                toastr.error(xhr.responseJSON.message, 'Error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

@section('content')
    @can('credenciales agregar')
        <div class="row mb-3 ml-1">
            <a href="{{ route('credenciales.create') }}" class="btn btn-primary">Agregar Credencial</a>
        </div>
    @endcan

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content style-tema">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-credenciales">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Fecha Emisión</th>
                                <th>Fecha Expiración</th>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th>Gestión</th>
                                <th>Estado</th>
                                @canany(['credenciales editar', 'credenciales eliminar'])
                                    <th>Acción</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($credenciales as $credencial)
                                <tr>
                                    <td>{{ $credencial->id }}</td>
                                    <td>{{ $credencial->codigo }}</td>
                                    <td>{{ $credencial->fecha_emicion }}</td>
                                    <td>{{ $credencial->fecha_expiracion }}</td>
                                    <td>{{ $credencial->usuario->nombres ?? 'N/A' }}
                                        {{ $credencial->usuario->apellidos ?? 'N/A' }}</td>
                                    <td>{{ $credencial->usuario->role->name ?? 'N/A' }}
                                    <td>{{ $credencial->gestion->anio ?? 'N/A' }} -
                                        {{ $credencial->gestion->semestre ?? '' }}</td>
                                    <td>
                                        <span class="badge {{ $credencial->estado ? 'badge-primary' : 'badge-warning' }}">
                                            {{ $credencial->estado ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    @canany(['credenciales editar', 'credenciales eliminar', 'credenciales credencial'])
                                        <td>
                                            @can('credenciales credencial')
                                                <a href="{{ route('credenciales.show', $credencial->id) }}"
                                                    class="btn btn-secondary btn-sm">
                                                    <i class="fa fa-id-card-o"></i>
                                                </a>
                                            @endcan
                                            @can('credenciales editar')
                                                <a href="{{ route('credenciales.edit', $credencial->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('credenciales eliminar')
                                                <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $credencial->id }}">
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
