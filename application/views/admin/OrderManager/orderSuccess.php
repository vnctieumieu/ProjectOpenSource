<div class="col c-12 m-12 l-12">
	<div class="inner__body-card row no-gutters card card-block">
		<div class="col c-12 m-10 m-o-1 l-8 l-o-2">
			<div class="card-body">
				<table class="list-order" id="order-success">
					<tr>
						<th>ID</th>
						<th>Ghi chú</th>
						<th>Bàn</th>
						<th></th>
					</tr>
					<?php foreach ($data as $key => $value): ?>
					<tr>
						<td class="order-id"><?php echo $value['id'] ?></td>
						<td class="order-note"><?php echo $value['note'] ?></td>
						<td class="order-table"><?php echo $value['tableId'] ?></td>
						<td class="btn-done">
							<span class="material-icons done">done</span>
						</td>
					</tr>
					<?php endforeach ?>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	// Duyệt đơn
	document.querySelectorAll('#order-success .btn-done .done').forEach( function(element) {
		element.onclick = function() {
			var parentElement = this.parentElement.parentElement;
			OrderSuccess(parentElement, 'POST');
		}
	});
	function OrderSuccess(parentElement, method) {
		var id = parentElement.querySelector('.order-id').innerText;
		$.ajax({
			url: '/api/Admin/orderSuccess/'+id,
			type: method,
			dataType: 'json'
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

	// update realtime
	var updateArr = <?php echo json_encode($data) ?>; // khởi tạo danh sách hiện có
	for (i in window.realtime){
		clearInterval(window.realtime[i]);
	    delete window.realtime[i];
	}
	window.realtime['orderSuccess'] = setInterval(function() {

		if (!document.getElementById('order-success')) {
			clearInterval(window.realtime['orderSuccess']);
			return false;
		}
		$.ajax({
			url: '/api/Admin/orderSuccess',
			type: 'GET',
			dataType: 'json'
		})
		.done(function(data) {
			// duyệt mảng lấy các phần tử khác mảng khởi tạo
			updateArr.forEach( function(element, index) {
				data.forEach( function(element2, index2) {
					if (element['id'] == element2['id']) {
						data.splice(index2, 1);
					}
				});
			});

			data.forEach( function(value) {
				var html = `<tr>
								<td class="order-id">${value.id}</td>
								<td class="order-note">${value.note}</td>
								<td class="order-table">${value.tableId}</td>
								<td class="btn-done">
									<span class="material-icons done">done</span>
								</td>
							</tr>`;

				$('#order-success').append(html);

				var element = document.querySelector('#order-success tr:last-child');
				element.querySelector('.btn-done span').onclick = function() {
					OrderSuccess(element, 'POST');
				}

			});
			updateArr = updateArr.concat(data);
		})
		.fail(function() {
			ShowMsgModal('Lỗi', 'Vui lòng kiểm tra kết nối mạng', 3, 'danger');
		})
	}, 2000)

</script>