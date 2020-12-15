<div class="col c-12 m-12 l-12">
	<div class="inner__body-card row no-gutters card card-block">
		<div class="col c-12 m-10 m-o-1 l-8 l-o-2">
			<div class="card-body">
				<table class="list-order" id="order-offline">
					<tr>
						<th>ID</th>
						<th>Giá</th>
						<th>Bàn</th>
						<th></th>
					</tr>
					<?php foreach ($data as $key => $value): ?>
					<tr>
						<td class="order-id"><?php echo $value['id'] ?></td>
						<?php $value['pricePayment'] = number_format($value['pricePayment'], 0, ',', '.'); ?>
						<td class="order-price"><?php echo $value['pricePayment'] ?></td>
						<td class="order-table"><?php echo $value['tableId'] ?></td>
						<td class="btn-done order-btn">
							<!-- <span class="material-icons info" style="background-color: #2973D7;">info</span> -->
							<span class="material-icons done">done</span>
							<span class="material-icons remove" style="background-color: #EF5350;">delete_forever</span>
						</td>
					</tr>
					<?php endforeach ?>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	// Duyệt đơn
	document.querySelectorAll('.list-order .btn-done .done').forEach( function(element) {
		element.onclick = function() {
			var parentElement = this.parentElement.parentElement;
			OrderOffline(parentElement, 'POST');
		}
	});

	// Hủy đơn
	document.querySelectorAll('.list-order .btn-done .remove').forEach( function(element) {
		element.onclick = function() {
			var parentElement = this.parentElement.parentElement;
			var id = parentElement.querySelector('.order-id').innerText;
			ShowInputBox({
				title: 'Lý do hủy đơn '+id,
				selectOption: {
								'Khách hàng yêu cầu hủy đơn': 'Khách hàng yêu cầu hủy đơn',
								'Không có khách hàng tại bàn': 'Không có khách hàng tại bàn',
								'input': 'Khác'
							},
				func: function(value) {
					$.ajax({
						url: '/api/Admin/cancelOrderOffline/'+id,
						type: 'POST',
						dataType: 'json',
						data: {reason: value}
					})
					.done(function(data) {
						if (data.status) {
							parentElement.remove();
							ShowMsgModal('Thành công', data.message);
						} else {
							ShowMsgModal('Thất bại', data.message, 3, 'danger');
						}
					})
					.fail(function() {
						ShowMsgModal('Lỗi', 'Kiểm tra kết nối mạng', 3, 'danger');
					})
				}
			});
		}
	});

	function OrderOffline(parentElement, method) {
		var id = parentElement.querySelector('.order-id').innerText;
		$.ajax({
			url: '/api/Admin/orderOffline/'+id,
			type: method,
			dataType: 'json'
		})
		.done(function(data) {
			if (data.status) {
				updateArr.forEach( function(element, index) {
					if (element['id'] == id)
						updateArr.splice(index, 1);
				});
				parentElement.remove();
				ShowMsgModal('Thành công', data.message);
			} else {
				ShowMsgModal('Thất bại', data.message, 3, 'danger');
			}
		})
		.fail(function() {
			ShowMsgModal('Lỗi', 'Kiểm tra kết nối mạng', 3, 'danger');
		})
	}


	// update realtime
	var updateArr = <?php echo json_encode($data) ?>;
	for (i in window.realtime){
		clearInterval(window.realtime[i]);
	    delete window.realtime[i];
	}
	window.realtime['orderOffline'] = setInterval(function() {
		if (!document.getElementById('order-offline')) {
			clearInterval(window.realtime['orderOffline']);
			return false;
		}
		$.ajax({
			url: '/api/Admin/orderOffline',
			type: 'GET',
			dataType: 'json'
		})
		.done(function(data) {
			updateArr.forEach( function(element, index) {
				data.forEach( function(element2, index2) {
					if (element['id'] == element2['id']) {
						data.splice(index2, 1);
					}
				});
			});

			data.forEach( function(value) {
				var price = formatMoney(value.pricePayment);
				var html = `<tr>
							 	<td class="order-id">${value.id}</td>
							 	<td class="order-price">${price}</td>
							 	<td class="order-table">${value.tableId}</td>
							 	<td class="btn-done order-btn">
							 		<span class="material-icons info" style="background-color: #2973D7;">info</span>
									<span class="material-icons done">done</span>
							 		<span class="material-icons remove" style="background-color: #EF5350;">delete_forever</span>
							 	</td>
							</tr>`;

				$('#order-offline').append(html);

				var element = document.querySelector('#order-offline tr:last-child');
				element.querySelector('.btn-done .done').onclick = function() {
					OrderOffline(element, 'POST');
				}

				element.querySelector('.btn-done .remove').onclick = function() {
					var id = element.querySelector('.order-id').innerText;
					ShowInputBox({
						title: 'Lý do hủy đơn '+id,
						selectOption: {
										'Khách hàng yêu cầu hủy đơn': 'Khách hàng yêu cầu hủy đơn',
										'Không có khách hàng tại bàn': 'Không có khách hàng tại bàn',
										'input': 'Khác'
									},
						func: function(value) {
							$.ajax({
								url: '/api/Admin/cancelOrderOffline/'+id,
								type: 'POST',
								dataType: 'json',
								data: {reason: value}
							})
							.done(function(data) {
								if (data.status) {
									element.remove();
									ShowMsgModal('Thành công', data.message);
								} else {
									ShowMsgModal('Thất bại', data.message, 3, 'danger');
								}
							})
							.fail(function() {
								ShowMsgModal('Lỗi', 'Kiểm tra kết nối mạng', 3, 'danger');
							})
						}
					});
				}

			});
			updateArr = updateArr.concat(data);
		})
		.fail(function() {
			ShowMsgModal('Lỗi', 'Vui lòng kiểm tra kết nối mạng', 3, 'danger');
		})
	}, 2000)

	function formatMoney(number) {
	    number+='';
	    var dem = 1;
	    var temp = [];
	    var length = number.length;
	    var int = parseInt(number);
	    for (i = 0; i < length; i++) {
	        if (Math.floor(int/1000) > 0) {
	            int = Math.floor(int/1000);
	            temp.push(number.substring(length-(3*dem), length-(3*(dem-1))));
	            dem++;
	        } else {
	            temp.push(int);
	            break;
	        }
	    }
	    var result = "";
	    for (i = temp.length-1; i > -1; i--) {
	        result += temp[i];
	        if (i != 0) {
	            result += ".";
	        }
	    }
	    return result;
	}
</script>