<div class="inner__header">
	<div class="inner__title-icon">
		<div class="icon-img material-icons">loyalty</div>
	</div>
	<div class="inner__header-text">
		<div class="inner__header-text-title">
			Quản lý mã giảm giá
		</div>
		<div class="inner__header-text-content">
			Quản lý các mã giảm giá của cửa hàng
		</div>
	</div>
</div>

<div id="inner__body" class="inner__body row" data-body="CreateProduct">
	<div class="col c-12 m-12 l-12">
		<div class="inner__body-card row no-gutters card card-block">
			<div class="col c-12 m-12 l-10 l-o-1">
				<div class="card-body">
					<table id="show-voucher">
						<tr>
							<th>Code</th>
							<th>Content</th>
							<th>Value</th>
							<th>Count</th>
							<th>Time Start</th>
							<th>Time End</th>
							<th></th>
						</tr>
						<?php foreach ($data as $value): ?>
							<?php if ($value['code'] != ""): ?>
								<tr data-id="<?php echo $value['id'] ?>">
									<td class="text-center"><?php echo $value['code'] ?></td>
									<td class="text-left w50"><?php echo $value['content'] ?></td>
									<td class="text-center"><?php echo $value['discountValue']; echo $value['discountType']==0?'%':'đ'; ?></td>
									<td class="text-center"><?php echo $value['count']; ?></td>
									<td class="text-center time"><?php echo date("d/m/Y", $value['timeStart']); ?></td>
									<td class="text-center time"><?php echo date("d/m/Y", $value['timeEnd']); ?></td>
									<td class="btn-group">
										<div class="btn-edit material-icons">edit</div>
									</td>
								</tr>
							<?php endif ?>
						<?php endforeach ?>
					</table>
					<div class="btn btn-submit" id="btn-add-new">Thêm +</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="form-add-voucher hidden">
	<div class="overlay"></div>
	<div class="inner__body-card row no-gutters card card-block">
		<div class="form-box col c-12 m-6 l-4 m-o-3 l-o-4">
			<div class="header-card">
				<div class="header-card__icon material-icons" style="color: #2ed573">add_box</div>
				<div class="header-card__title">Thêm mã khuyến mãi</div>
				<div class="close-tab material-icons">highlight_off
				</div>
			</div>

			<div class="card-body">
				<form id="form-voucher" method="post" data-action="">
					<input type="text" name="voucherId" hidden>
					<div class="form-group">
						<label>Mã</label>
						<input name="code" type="text" placeholder="CHRISTMAS" required>
					</div>
					<div class="form-group">
						<label>Mô tả</label>
						<input name="content" type="text" placeholder="Giảm giá 50% cho chương trình giáng sinh" required>
					</div>
					<div class="form-group">
						<label>Số lượng</label>
						<input name="count" type="text" placeholder="100" required>
					</div>
					<div class="form-group">
						<label>Giảm giá</label>
						<input name="discountValue" type="text" placeholder="10" required>
					</div>
					<div class="form-group-select">
						<label>Loại giảm giá</label>
						<select name="discountType">
							<option value="0">Phần trăm (%)</option>
							<option value="1">Giá tiền (VNĐ)</option>
						</select>
					</div>
					<div class="form-group">
						<label>Thời gian bắt đầu</label>
						<input name="timeStart" type="date" max="3000-12-31" required>
					</div>
					<div class="form-group">
						<label>Thời gian kết thúc</label>
						<input name="timeEnd" type="date" max="3000-12-31" required>
					</div>

					<div class="form-group" style="margin-top: 15px">
						<input type="submit" class="btn btn-submit" value="Thêm mã">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	var formBox = document.querySelector('.form-add-voucher');
	var form = document.getElementById('form-voucher');
	document.querySelector('.form-add-voucher .close-tab').onclick = function() {
		formBox.classList.add('hidden');
	}
	document.querySelector('.form-add-voucher .overlay').onclick = function() {
		formBox.classList.add('hidden');
	}

	document.getElementById('btn-add-new').onclick = function() {
		form.querySelector('[name="voucherId"]').value = "";
		form.querySelector('[name="code"]').value = "";
		form.querySelector('[name="content"]').value = "";
		form.querySelector('[name="count"]').value = "";
		form.querySelector('[name="discountValue"]').value = "";
		form.querySelector('[name="discountType"]').value = "0";
		form.querySelector('[name="timeStart"]').value = "";
		form.querySelector('[name="timeEnd"]').value = "";

		form.querySelector('[type="submit"]').value = "Thêm mã";

		formBox.classList.remove('hidden');
		formBox.querySelector('input[name="code"]').removeAttribute('disabled');
		form.setAttribute('data-action', '/api/Admin/voucher');
	}

	document.querySelectorAll('#show-voucher .btn-edit').forEach( function(element) {
		element.onclick = function() {
			btnEdit(this.parentElement.parentElement);
		}
	});

	function btnEdit(parentElement) {
		$.ajax({
			url: '/api/Admin/voucher/'+parentElement.getAttribute('data-id'),
			type: 'GET',
			dataType: 'json'
		})
		.done(function(data) {
			var timeStart = new Date(data.timeStart*1000);
			var timeEnd = new Date(data.timeEnd*1000);
			timeStart = timeStart.getFullYear()+'-'+(timeStart.getMonth() < 9 ? '0'+(timeStart.getMonth()+1) : timeStart.getMonth()+1)+'-'+(timeStart.getDate() < 10 ? '0'+timeStart.getDate() : timeStart.getDate());
			timeEnd = timeEnd.getFullYear()+'-'+(timeEnd.getMonth() < 9 ? '0'+(timeEnd.getMonth()+1) : timeEnd.getMonth()+1)+'-'+(timeEnd.getDate() < 10 ? '0'+timeEnd.getDate() : timeEnd.getDate());
			form.querySelector('[name="voucherId"]').value = data.id;
			form.querySelector('[name="code"]').value = data.code;
			form.querySelector('[name="content"]').value = data.content;
			form.querySelector('[name="count"]').value = data.count;
			form.querySelector('[name="discountValue"]').value = data.discountValue;
			form.querySelector('[name="discountType"]').value = data.discountType;
			form.querySelector('[name="timeStart"]').value = timeStart;
			form.querySelector('[name="timeEnd"]').value = timeEnd;

			form.querySelector('[type="submit"]').value = "Sửa voucher";

			formBox.classList.remove('hidden');
			formBox.querySelector('input[name="code"]').setAttribute('disabled', true);
			form.setAttribute('data-action', '/api/Admin/voucher/'+data.id);
		})
		.fail(function() {
			ShowMsgModal('Lỗi mạng', 'Vui lòng kiếm tra kết nối mạng', 3, 'danger');
		})
	}

	form.onsubmit = function(e) {
		e.preventDefault();

		var url = this.getAttribute('data-action');
		if (this.querySelector('input[name="voucherId"]').value) {
			var idVoucher = this.querySelector('input[name="voucherId"]').value;
		}
		var data = {
				code: this.querySelector('[name="code"]').value,
				content: this.querySelector('[name="content"]').value,
				count: this.querySelector('[name="count"]').value,
				discountValue: this.querySelector('[name="discountValue"]').value,
				discountType: this.querySelector('[name="discountType"]').value,
				timeStart: this.querySelector('[name="timeStart"]').value,
				timeEnd: this.querySelector('[name="timeEnd"]').value,
			};

		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: data
		})
		.done(function(res) {
			if (res.status) {
				ShowMsgModal('Thành công', res.message, 3);
				formBox.classList.add('hidden');
				
				var timeStart = new Date(Date.parse(data.timeStart));
				var timeEnd = new Date(Date.parse(data.timeEnd));
				timeStart = (timeStart.getDate() < 10 ? '0'+timeStart.getDate() : timeStart.getDate())+'/'+(timeStart.getMonth() < 9 ? '0'+(timeStart.getMonth()+1) : timeStart.getMonth()+1)+'/'+timeStart.getFullYear();
				timeEnd = (timeEnd.getDate() < 10 ? '0'+timeEnd.getDate() : timeEnd.getDate())+'/'+(timeEnd.getMonth() < 9 ? '0'+(timeEnd.getMonth()+1) : timeEnd.getMonth()+1)+'/'+timeEnd.getFullYear();
				if (idVoucher) {
					var voucherElements = document.querySelectorAll('#show-voucher tr');
					voucherElements.forEach( function(element) {
						if (element.getAttribute('data-id') == idVoucher) {
							element.querySelector('td:nth-child(1)').innerText = data.code;
							element.querySelector('td:nth-child(2)').innerText = data.content;
							element.querySelector('td:nth-child(3)').innerText = data.discountValue+(data.discountType == 0?'%':'đ');
							element.querySelector('td:nth-child(4)').innerText = data.count;
							element.querySelector('td:nth-child(5)').innerText = timeStart;
							element.querySelector('td:nth-child(6)').innerText = timeEnd;
							return true;
						}
					});
				} else {
					var html = `<tr data-id="${res.id}">
									<td class="text-center">${data.code}</td>
									<td class="text-left w50">${data.content}</td>
									<td class="text-center">${data.discountValue}${data.discountType == 0?'%':'đ'}</td>
									<td class="text-center">${data.count}</td>
									<td class="text-center time">${timeStart}</td>
									<td class="text-center time">${timeEnd}</td>
									<td class="btn-group">
										<div class="btn-edit material-icons">edit</div>
									</td>
								</tr>`;
					$('#show-voucher').append(html);
					document.querySelector('#show-voucher tr:last-child .btn-edit').onclick = function() {
						btnEdit(this.parentElement.parentElement);
					}
				}

			} else {
				ShowMsgModal('Thất bại', res.message, 3, 'danger');
			}
		})
		.fail(function() {
			ShowMsgModal('Lỗi mạng', 'Vui lòng kiếm tra kết nối mạng', 3, 'danger');
		})		
	}
</script>