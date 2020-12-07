@extends('layouts.admin')

@section('title', 'Lista de Pedidos')

@section('links')
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/custom_dt_html5.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/dt-global_style.css') }}">
<link href="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/admins/vendor/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/admins/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="row layout-top-spacing">

	<div class="col-12 layout-spacing">
		<div class="statbox widget box box-shadow">
			<div class="widget-header">
				<div class="row">
					<div class="col-xl-12 col-md-12 col-sm-12 col-12">
						<h4>Lista de Pedidos</h4>
					</div>                 
				</div>
			</div>
			<div class="widget-content widget-content-area shadow-none">

				<div class="row">
					<div class="col-12">

						<div class="table-responsive mb-4 mt-4">
							<table class="table table-hover table-normal">
								<thead>
									<tr>
										<th>#</th>
										<th>Usuario</th>
										<th>Total</th>
										<th>Pago</th>
										<th>Estado</th>
										<th>Fecha</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									@foreach($orders as $order)
									<tr>
										<td>{{ $num++ }}</td>
										<td>{{ $order->user()->withTrashed()->first()->name." ".$order->user()->withTrashed()->first()->lastname }}</td>
										<td>{{ "$".number_format($order->total, 2, ",", ".") }}</td>
										<td>{!! statePayment($order->payment->state) !!}</td>
										<td>{!! stateOrder($order->state) !!}</td>
										<td>{{ $order->created_at->format("d-m-Y H:i a") }}</td>
										<td>
											<div class="btn-group" role="group">
												<a href="{{ route('pedidos.show', ['slug' => $order->slug]) }}" class="btn btn-primary btn-sm bs-tooltip" title="Ver Pedido"><i class="fa fa-eye"></i></a>
												@if($order->state!=0)
												<button type="button" class="btn btn-danger btn-sm bs-tooltip" title="Rechazar" onclick="deactiveOrder('{{ $order->slug }}')"><i class="fa fa-times"></i></button>
												@endif
												@if($order->state!=1)
												<button type="button" class="btn btn-success btn-sm bs-tooltip" title="Confirmar" onclick="activeOrder('{{ $order->slug }}')"><i class="fa fa-check"></i></button>
												@endif
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>                                        
				</div>

			</div>
		</div>
	</div>

</div>

<div class="modal fade" id="deactiveOrder" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres rechazar este pedido?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formDeactiveOrder">
					@csrf
					@method('PUT')
					<button type="submit" class="btn btn-primary">Rechazar</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="activeOrder" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres confirmar este pedido?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formActiveOrder">
					@csrf
					@method('PUT')
					<button type="submit" class="btn btn-primary">Confirmar</button>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/table/datatable/datatables.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/jszip.min.js') }}"></script>    
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/buttons.print.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/custom-sweetalert.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection