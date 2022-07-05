			<?php

			$batch = str_pad($row->vis_batch.'',6,'0', STR_PAD_LEFT);
			$serial = str_pad($row->vis_serial.'',6,'0', STR_PAD_LEFT);

			?>
			<tr>
				@if (App\Http\Controllers\LoginController::can_access())
				<td class="nowrap text-left">
					
					<a class="btn btn-primary btn-xs" href="{{ URL::to('/visitors/'.$row->vis_id.'/edit') }}" title="Edit" role="button"><span class="fa fa-pencil"></span></a>
					
					<a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="confirmDialog('Delete this item?', 'Confirm Delete', '{{ URL::to('/visitors/'.$row->vis_id.'/delete') }}');" title="Delete" role="button"><span class="fa fa-trash"></span></a>
					
					@if(App\Http\Controllers\VisitorsController::sign_in($row->vis_id)==false)

					<a class="btn btn-primary btn-xs" href="{{ URL::to('/visitors/'.$row->vis_id.'/signing_in') }}" title="Log-in" role="button" onclick="return confirm('Are you sure you want to register {{$row->vis_fname}} {{$row->vis_lname}} today?')"><span class="fa fa-sign-in"></span></a>

					@else 
					<a class="btn btn-warning btn-xs" href="#" title="Print Barcode" role="button" data-toggle="modal" data-target="#signinEvents{{$row->vis_id}}"><span class="fa fa-barcode"></span></a>
					@endif

					
				</td>
				@endif
				<td class="text-center">{{ $i }}</td>
				<td>{{ $row->vis_code }}</td>
				<td>{{ $row->vis_name }}</td>
				<td>{{ $row->gender_name }}</td>
				<td>{{ $row->vis_designation }}</td>
				<td>{{ $row->vis_company }}</td>
				<td>{{ $row->vis_gsm }}</td>
				<td>{{ $row->vis_email }}</td>
				<td>{{ $row->region_name }}</td>
				<td>{{ $row->class_name }}</td>
				<td>{{ $row->event_title }}</td>
				<td>{{ $row->created_at }}</td>
				<td>{{ $row->vis_day }}</td>
			</tr>

	


			@foreach($rows as $id => $rowmodal)
			<!-- Modal -->
			<div class="modal fade" id="signinEvents{{$rowmodal->vis_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>

							<h5 class="modal-title" id="exampleModalLabel">Registration Booth</h5>

						</div>
						<div class="modal-body-wrapper">
							<div class="modal-body">

								<div id="printThis">
									@foreach($rows->where('vis_id', $rowmodal->vis_id) as $rowBarcode)
									<?php 

									$event = \App\Event::where('event_active', 1)->first();

									$event_title = "";

									if (!$event) {
										$event_title = "No Active Event!!!";
									} else {
										$event_title = $event->event_title;
									}

									$gen = new \Picqer\Barcode\BarcodeGeneratorPNG();

									$naam = '';

									if ($naam == $rowBarcode->vis_name){

										continue;
									}

									$naam = $rowBarcode->vis_name;
									?>
									<center><div class="barcode-wrapper" class="text-center">
										<div class="barcode-center">
											<div class="barcode-vcenter">
												<div class="barcode-header">{{ $event_title }}</div>
												<div class="barcode-subtitle">
													{{ $event->event_desc }}
												</div>                    
												<div class="barcode-name text-nowrap">
													{{ ucwords(strtolower($rowBarcode->vis_fname)) }} {{ ucwords(strtolower($rowBarcode->vis_lname)) }}
												</div>
												<strong>{{ $rowBarcode->vis_company }}</strong>
						                    <!-- <div class="barcode-company">
						                        {{ $row->vis_company }}
						                    </div> -->
						                    <div class="barcode-code"><?php echo '<img src="data:image/png;base64,'.base64_encode($gen->getBarcode($rowBarcode->vis_code, $gen::TYPE_CODE_128)).'">'; ?></div>
						                    <div class="barcode-number">{{ $rowBarcode->vis_code }}</div>
						                </div>
						            </div>
						        </div></center>
						        @endforeach
						    </div>		

						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-warning print" id="btnPrint"><span class="fa fa-barcode"></span> Print Barcode</button>
					</div>
				</div>
			</div>
		</div>



		<script type="text/javascript">
			document.getElementById("btnPrint").onclick = function() {
				printElement(document.getElementById("printThis"));
				window.print();
			}

			function printElement(elem, append, delimiter) {
				var domClone = elem.cloneNode(true);

				var $printSection = document.getElementById("printSection");

				if (!$printSection) {
					var $printSection = document.createElement("div");
					$printSection.id = "printSection";
					document.body.appendChild($printSection);
				}

				if (append !== true) {
					$printSection.innerHTML = "";
				}

				else if (append === true) {
					if (typeof(delimiter) === "string") {
						$printSection.innerHTML += delimiter;
					}
					else if (typeof(delimiter) === "object") {
						$printSection.appendChlid(delimiter);
					}
				}

				$printSection.appendChild(domClone);
			}
		</script>

		<style type="text/css">
			@media screen {
				#printSection {
					display: none;
				}
			}

			@media print {
				body * {
					visibility:hidden;
				}
				#printSection, #printSection * {
					visibility:visible;
				}
				#printSection {
					position:absolute;
					left:0;
					top:0;
				}
			}



		</style>


		@endforeach
