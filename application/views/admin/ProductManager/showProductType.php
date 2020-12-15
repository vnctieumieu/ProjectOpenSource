<div class="col c-12 m-12 l-12">
	<div class="inner__body-card row no-gutters card card-block">
		<div class="col c-12 m-10 m-o-1 l-6 l-o-3">
			<div class="card-body">
				<table id="show-product-type">
					<tr>
						<th>Mã loại</th>
						<th>Tên loại</th>
						<th>Trạng thái</th>
					</tr>
					<?php foreach ($productType as $value): ?>
					<tr>
						<td><?php echo $value['code'] ?></td>
						<td class="typeName"><?php echo $value['typeName'] ?></td>
						<?php
							if ($value['business']) {
								$status = 'Mở bán';
								$color = '#04de08';
							} else {
								$status = 'Đóng';
								$color = '#DA4B4C';
							}
						?>
						<td class="business" data-value="<?php echo $value['business'] ?>" style="color: <?php echo $color ?>"><?php echo $status ?></td>
						<td class="btn-group" data-typeCode="<?php echo $value['code'] ?>" data-typeName="<?php echo $value['typeName'] ?>" data-business="<?php echo $value['business'] ?>">
							<div class="btn-apply material-icons">done</div>
							<div class="btn-cancel material-icons">clear</div>
							<div class="btn-delete material-icons">delete_forever</div>
						</td>
					</tr>
					<?php endforeach ?>
				</table>
				<div class="btn btn-submit" id="btn-add-new">Thêm +</div>
			</div>
		</div>
	</div>
</div>

<script>
	// click để hiện sửa
	document.querySelectorAll('#show-product-type tr:nth-child(n+2)').forEach( function(element) {
		element.addEventListener('dblclick', function() {
			fEdit(this);
		})
		element.addEventListener('contextmenu', function(e) {
			e.preventDefault();
			fEdit(this);
		})
	});

	function fEdit(element) {
		// Cột tên
		var htmlName = '<input type="text" value="'+element.querySelector('.btn-group').getAttribute('data-typeName')+'">'
		element.querySelector('.typeName').innerHTML = htmlName;

		// CỘt trạng thái
		if (element.querySelector('.btn-group').getAttribute('data-business') != 0) {
			var htmlBusiness = '<select name="business"><option value="1" selected>Mở bán</option><option value="0">Đóng</option></select>';
		} else {
			var htmlBusiness = '<select name="business"><option value="1">Mở bán</option><option value="0" selected>Đóng</option></select>';
		}
		element.querySelector('.business').innerHTML = htmlBusiness;


		element.querySelector('.typeName').style.padding = '5px';
		element.querySelector('.business').style.padding = '5px';
		element.querySelector('.btn-apply').style.display = 'block';
		element.querySelector('.btn-cancel').style.display = 'block';
		element.querySelector('.btn-delete').style.display = 'none';
	}

	// Sửa loại sản phẩm
	document.querySelectorAll('#show-product-type .btn-apply').forEach( function(element) {
		element.addEventListener('click', function(e) {
			e.stopPropagation();
			editApply(this);
		})
		element.addEventListener('dblclick', function(e) {
			e.stopPropagation();
		})
		element.addEventListener('contextmenu', function(e) {
			e.stopPropagation();
		})
	});

	function editApply(element) {
		var parentElement = element.parentElement.parentElement;

		var code = parentElement.querySelector('.btn-group').getAttribute('data-typeCode');
		var typeNameValue = parentElement.querySelector('.typeName input').value;
		var businessValue = parentElement.querySelector('.business select').value;
		$.ajax({
			url: '/api/Admin/productType/'+code,
			type: 'POST',
			dataType: 'json',
			data: {
				typeName: typeNameValue,
				business: businessValue
			},
		})
		.done(function(data) {
			if (data.status != 0) {
				// Cập nhật giá trị cột tên
				parentElement.querySelector('.typeName').innerText = typeNameValue;
				parentElement.querySelector('.btn-group').setAttribute('data-typeName', typeNameValue);

				// Cập nhật giá trị cột Trạng thái
				parentElement.querySelector('.btn-group').setAttribute('data-business', businessValue);
				if (businessValue != 0) {
					businessValue = 'Mở bán';
					parentElement.querySelector('.business').style.color = "#04de08";
				} else {
					businessValue = 'Đóng';
					parentElement.querySelector('.business').style.color = "#DA4B4C";
				}
				parentElement.querySelector('.business').innerText = businessValue;


				parentElement.querySelector('.typeName').style.padding = '8px';
				parentElement.querySelector('.business').style.padding = '8px';
				parentElement.querySelector('.btn-apply').style.display = 'none';
				parentElement.querySelector('.btn-cancel').style.display = 'none';
				parentElement.querySelector('.btn-delete').style.display = 'block';


				ShowMsgModal('Thành công!', data.message, 4);
			} else {
				ShowMsgModal('Thất bại!', data.message, 4, 'danger');
			}

		})
		.fail(function() {
			ShowMsgModal('Lỗi!', 'Tên loại đã tồn tại', 4, 'danger');
		})
	}

	document.querySelectorAll('#show-product-type .btn-cancel').forEach( function(element) {
		element.addEventListener('click', function(e) {
			e.stopPropagation();
			editCanel(this);
		})
		element.addEventListener('dblclick', function(e) {
			e.stopPropagation();
		})
		element.addEventListener('contextmenu', function(e) {
			e.stopPropagation();
		})
	});

	function editCanel(element) {
		var parentElement = element.parentElement.parentElement;
		parentElement.querySelector('.typeName').innerText = element.parentElement.getAttribute('data-typeName');

		if (element.parentElement.getAttribute('data-business') != 0)
			parentElement.querySelector('.business').innerText = 'Mở bán';
		else {
			parentElement.querySelector('.business').innerText = 'Đóng';
		}

		parentElement.querySelector('.typeName').style.padding = '8px';
		parentElement.querySelector('.business').style.padding = '8px';
		parentElement.querySelector('.btn-apply').style.display = 'none';
		parentElement.querySelector('.btn-cancel').style.display = 'none';
		parentElement.querySelector('.btn-delete').style.display = 'block';
	}

	// Xóa sản phẩm
	document.querySelectorAll('#show-product-type .btn-delete').forEach( function(element) {
		element.addEventListener('click', function(e) {
			e.stopPropagation();
			editDelete(this);
		})
		element.addEventListener('dblclick', function(e) {
			e.stopPropagation();
		})
		element.addEventListener('contextmenu', function(e) {
			e.stopPropagation();
		})
	});

	function editDelete(element) {
		// var element = element;
		var code = element.parentElement.getAttribute('data-typeCode');

		$.ajax({
			url: '/api/Admin/productType/'+code,
			type: 'DELETE',
			dataType: 'json'
		})
		.done(function(data) {
			if (data.status) {
				element.parentElement.parentElement.remove();
				ShowMsgModal('Thành công!', data.message, 4);
			}
			else
				// ShowMsgModal('Thất bại!', data.message, 4, 'danger');
				ShowMsgBox('Thất bại!', data.message, 'OK', 'fail')
		})
		.fail(function() {
			ShowMsgModal('Lỗi!', 'Có lỗi xảy ra, vui lòng reload lại trang', 4, 'danger');
		})
	}

	// Thêm loại sản phẩm
	document.getElementById('btn-add-new').onclick = function() {
		var html = '<tr>';
			html += '<td style="padding: 5px"><input type="text"></td>';
			html += '<td class="typeName" style="padding: 5px"><input type="text"></td>';
			html += '<td class="business" style="padding: 5px"><select>';
			html += '<option value="1">Mở bán</option>';
			html += '<option value="0">Đóng</option>';
			html += '</select></td>';
			html += '<td class="btn-group">';
			html += '<div class="btn-apply material-icons" style="display: block;">done</div>';
			html += '<div class="btn-cancel material-icons" style="display: block;">clear</div>';
			html += '<div class="btn-delete material-icons" style="display: none;">delete_forever</div>';
			html += '</td>';
			html += '</tr>';
		$('#show-product-type').append(html);
		var element = document.querySelector('#show-product-type tr:last-child');


		element.querySelector('.btn-apply').onclick = function() {
			var code = element.querySelector('td input').value;
			code = code.replaceAll(" ", "");
			var typeName = element.querySelector('td.typeName input').value;
			var business = element.querySelector('td.business select').value;

			$.ajax({
				url: '/api/Admin/productType',
				type: 'POST',
				dataType: 'json',
				data: {
					code: code,
					typeName: typeName,
					business: business
				},
			})
			.done(function(data) {
				if (data.status) {
					element.querySelectorAll('td').forEach(function(el){
						el.removeAttribute('style');
					})
					element.querySelector('td').innerText = code;
					element.querySelector('.typeName').innerText = typeName;
					if (business != 0) {
						business = 'Mở bán';
						element.querySelector('.business').style.color = "#04de08";
					} else {
						business = 'Đóng';
						element.querySelector('.business').style.color = "#DA4B4C";
					}
					element.querySelector('.business').innerText = business;

					element.querySelector('.btn-group').setAttribute('data-typeCode', code);
					element.querySelector('.btn-group').setAttribute('data-typeName', typeName);
					element.querySelector('.btn-group').setAttribute('data-business', business);
					// sự kiện edit
					element.addEventListener('dblclick', function() {
						fEdit(this);
					})
					element.addEventListener('contextmenu', function(e) {
						e.preventDefault();
						fEdit(this);
					})

					var btnApply = element.querySelector('.btn-apply');
					var btnCancel = element.querySelector('.btn-cancel');
					var btnDelete = element.querySelector('.btn-delete');
					btnApply.style.display = 'none';
					btnCancel.style.display = 'none';
					btnDelete.style.display = 'block';

					// button Apply
					btnApply.onclick = function(e) {
						e.stopPropagation();
						editApply(this);
					}
					btnApply.addEventListener('dblclick', function(e) {
						e.stopPropagation();
					})
					btnApply.addEventListener('contextmenu', function(e) {
						e.stopPropagation();
					})

					// button Cancel
					btnCancel.onclick = function(e) {
						e.stopPropagation();
						editCanel(this);
					}
					btnCancel.addEventListener('dblclick', function(e) {
						e.stopPropagation();
					})
					btnCancel.addEventListener('contextmenu', function(e) {
						e.stopPropagation();
					})

					// button Delete
					btnDelete.onclick = function(e) {
						e.stopPropagation();
						editDelete(this);
					}
					btnDelete.addEventListener('dblclick', function(e) {
						e.stopPropagation();
					})
					btnDelete.addEventListener('contextmenu', function(e) {
						e.stopPropagation();
					})

					ShowMsgModal('Thành công!', data.message, 4);
				} else {
					ShowMsgModal('Thất bại!', data.message, 4, 'danger');
				}
			})
			.fail(function() {
				ShowMsgModal('Lỗi!', 'Mã hoặc tên đã tồn tại', 4, 'danger');
			})
			
		}

		element.querySelector('.btn-cancel').onclick = function() {
			element.remove();
		}
	}

</script>