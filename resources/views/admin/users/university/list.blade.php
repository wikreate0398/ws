@extends('layouts.admin')
 
@section('content') 
	<div class="row">
		<div class="col-md-12" style="margin-bottom: 20px;">
			<a href="/{{ $method }}/add/" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Добавить</a>
		</div>

	   	<div class="col-md-12">  
	      	<table class="table table-striped table-bordered table-hover" style="margin: 0; margin-top: -1px;">
	      		<thead>
	      			<tr>
	      				<th style="width: 30%;">Название</th>
	      				<th>E-mail</th>
	      				<th>Дата регистрации</th>
	      				<th style="text-align: center;">Подтверждение <br> Аккаунта</th>
	      				<th style="white-space: nowrap; text-align: center;"><i class="fa fa-cogs" aria-hidden="true"></i></th>
	      			</tr>
	      		</thead>
	      		<tbody>
	      			@foreach($data as $user)
	      			<tr>
	      				<td>{{ $user['university']['full_name'] }}</td>
	      				<td>{{ $user['email'] }}</td>
	      				<td>{{ date('d.m.Y H:i', strtotime($user['created_at'])) }}</td>
	      				<td style="text-align: center;">
	      					@if($user['confirm'] == 1)
	      						<span class="badge badge-success">
	      							{{ date('d.m.Y H:i', strtotime($user['created_at'])) }}
	      						</span> 

	      					@else
	      						<span class="badge badge-danger" data-toggle="modal" href="#confirmModal{{ $user['id'] }}" style="cursor: pointer;">
	      							Не подтвержден
	      						</span>

	      						<div id="confirmModal{{ $user['id'] }}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
								   <div class="modal-dialog">
								      <div class="modal-content">
								         <div class="modal-header">
								            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								            <h4 class="modal-title">Подтвердить операцию</h4>
								         </div>
								         <div class="modal-body">
								            <p>
								               <h4>Подтвердить</h4>
								               <input type="checkbox" 
						          		       class="make-switch" data-size="mini" {{ !empty($user['confirm']) ? 'checked' : '' }} 
						          		       data-on-text="<i class='fa fa-check'></i>" 
						          		       data-off-text="<i class='fa fa-times'></i>" 
						          		       onchange="Ajax.buttonView(this, '{{ $table }}', '{{ $user["id"] }}', 'confirm')"> 
								            </p>
								         </div>
								         <div class="modal-footer" style="text-align: left;">
								            <button type="button" data-dismiss="modal" class="btn default">Закрыть</button> 
								         </div>
								      </div>
								   </div>
								</div>
	      					@endif
	      				</td>

	      				<td style="white-space: nowrap; text-align: center;">

							<div class="btn-group">
								<button class="grey-salt btn btn-xs dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
									<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu" style="min-width: 250px;">
									<li>
										<a style="" href="/{{ $method }}/{{ $user['id'] }}/edit/">
											<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
											Редактировать
										</a>
									</li>
									<li>
										<div class="drop-item">
											<span>
												<i class="fa fa-check-square-o" aria-hidden="true"></i> Активировать
											</span>
											<input type="checkbox"
												   style="margin-top: 5px;"
												   class="make-switch" data-size="mini" {{ !empty($user['activate']) ? 'checked' : '' }}
												   data-on-text="<i class='fa fa-check'></i>"
												   data-off-text="<i class='fa fa-times'></i>"
												   onchange="Ajax.buttonView(this, '{{ $table }}', '{{ $user["id"] }}', 'activate')">
										</div>
									</li>
									<li>

										<div class="drop-item">
											<span>
												<i class="fa fa-star-o" aria-hidden="true"></i> Рекомендуемые
											</span>
											<input type="checkbox"
												   style="margin-top: 5px;"
												   class="make-switch" data-size="mini" {{ !empty($user['featured']) ? 'checked' : '' }}
												   data-on-text="<i class='fa fa-check'></i>"
												   data-off-text="<i class='fa fa-times'></i>"
												   onchange="Ajax.buttonView(this, '{{ $table }}', '{{ $user["id"] }}', 'featured')">
										</div>
									</li>
									<li class="divider">
									</li>
									<li>
										<a data-toggle="modal" href="#deleteModal_{{ $table }}_{{ $user['id'] }}">
											<i class="fa fa-trash-o" aria-hidden="true"></i>
											Удалить
										</a>
									</li>
								</ul>
							</div>

			            	<!-- Modal -->
			            		@include('admin.utils.delete', ['id' => $user['id'], 'table' => $table])
			           		<!-- Modal --> 

	      				</td>
	      			</tr>
	      			@endforeach
	      		</tbody>
	      	</table>
	   	</div>
	</div> 
@stop

