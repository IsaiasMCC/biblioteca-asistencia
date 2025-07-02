@extends('layouts.app')

@push('title', 'Horarios')

@section('content_header')
    <h2> Horarios </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"> <a href="{{ route('horarios.index') }}">Inicio</a> </li>
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
            const titleReport = `Reporte de Horarios`;
            const fileName = `reporte-horarios-${today}-${time}`;

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
                    }
                ]
            });

            $(document).on('click', '.deleteHorarioBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: "¿Está seguro de borrar este horario?",
                    text: "Este cambio no se puede revertir",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#1AB394",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/horarios/${id}`,
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
        @can('horarios agregar')
            <div class="ml-5 mb-2">
                <a href="{{ route('horarios.create') }}" class="btn btn-clock btn-primary"> Agregar Horario </a>
            </div>
        @endcan
        <div class="col-lg-12">
            <div class="ibox-content style-tema">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Días</th>
                                <th>Sala</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                                @canany(['horarios editar', 'horarios eliminar'])
                                    <th>Acción</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($horarios as $horario)
                                <tr class="gradeX">
                                    <td>{{ $horario->id }}</td>
                                    <td>
                                        @php
                                            $dias = [];
                                            if ($horario->lunes) {
                                                $dias[] = 'Lunes';
                                            }
                                            if ($horario->martes) {
                                                $dias[] = 'Martes';
                                            }
                                            if ($horario->miercoles) {
                                                $dias[] = 'Miércoles';
                                            }
                                            if ($horario->jueves) {
                                                $dias[] = 'Jueves';
                                            }
                                            if ($horario->viernes) {
                                                $dias[] = 'Viernes';
                                            }
                                            if ($horario->sabado) {
                                                $dias[] = 'Sábado';
                                            }
                                            if ($horario->domingo) {
                                                $dias[] = 'Domingo';
                                            }
                                        @endphp
                                        {{ implode(', ', $dias) }}
                                    </td>
                                    <td>{{ $horario->sala->nombre }}</td>
                                    <td>{{ $horario->hora_inicio }}</td>
                                    <td>{{ $horario->hora_fin }}</td>
                                    @canany(['horarios editar', 'horarios eliminar'])
                                        <td class="text-center">
                                            @can('horarios editar')
                                                <a class="btn btn-info" href="{{ route('horarios.edit', $horario->id) }}">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                            @endcan
                                            @can('horarios eliminar')
                                                <button class="btn btn-danger deleteHorarioBtn" data-id="{{ $horario->id }}">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
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
