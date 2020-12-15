<div class="col c-12 m-12 l-12">
	<div class="inner__body-card row no-gutters card card-block">
		<div class="col c-12 m-12 l-12">
			<div class="card-body">
				<table id="show-account">
					<tr>
						<th>username</th>
						<th>email</th>
						<th>Số điện thoại</th>
						<th>Họ và tên</th>
						<th>Chức vụ</th>
						<th>Ngày tạo</th>
						<th></th>
					</tr>
					<?php foreach ($dataAccount as $key => $value): ?>
						<?php if (!($value['id'] == $this->session->userdata('id'))): ?>
						<tr data-id="<?= $value['id'] ?>" <?= $value['active'] ? '' : 'style="color: red"'	?>>
							<td><?= $value['username'] ?></td>
							<td><?= $value['email'] ?></td>
							<td><?= $value['phoneNumber'] ?></td>
							<td><?= $value['firstName'].' '.$value['lastName'] ?></td>
							<td><?= $value['role'] ?></td>
							<td><?= date('d/m/Y', strtotime($value['dateCreate'])) ?></td>
							<td class="btn-group" >
								<div class="btn-edit material-icons">edit</div>
							</td>
						</tr>
						<?php endif ?>
					<?php endforeach ?>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="edit-account hidden">
	<div class="overlay"></div>
	<div class="inner__body-card row no-gutters card card-block">
		<div class="form-box col c-12 m-6 l-4 m-o-3 l-o-4">
			<div class="header-card">
				<div class="header-card__icon material-icons" style="color: #00DA59">edit</div>
				<div class="header-card__title">Cập nhật tài khoản</div>
				<div class="close-tab material-icons">highlight_off
				</div>
			</div>

			<div class="card-body">
				<form id="form-update-account" method="post">
					<input type="text" name="productID" hidden>
					<div class="form-group">
						<label>Tên tài khoản</label>
						<input name="username" type="text" value="admin" disabled>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input name="email" type="email" placeholder="admin@ssm.com" required>
					</div>
					<div class="form-group">
						<label>Số điện thoại</label>
						<input name="phoneNumber" type="text" placeholder="033574xxxx" required>
					</div>
					<div class="row no-gutters">
						<div class="col c-12 m-5 l-6">
							<div class="form-group first-name">
								<label for="formGroupExampleInput">Họ và tên lót</label>
								<input name="firstName" type="text" class="form-control" placeholder="Nguyễn Văn" required>
							</div>
						</div>
						<div class="col c-12 m-5 m-o-2 l-5 l-o-1">
							<div class="form-group">
								<label for="formGroupExampleInput">Tên</label>
								<input name="lastName" type="text" class="form-control" placeholder="A" required>
							</div>
						</div>
					</div>

					<div class="form-group-select" style="margin-top: 1rem;">
						<label>Chức vụ</label>
						<select name="role">
							<?php foreach ($role as $value): ?>
							<option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="form-group-select">
						<label>Trạng thái: </label>
						<select name="active">
							<option value="1">Kích hoạt</option>
							<option value="0">Vô hiệu hóa</option>
						</select>
					</div>


					<div class="form-group" style="margin-top: 15px">
						<input type="submit" class="btn btn-submit" value="Cập nhật tài khoản">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		document.querySelector('.edit-account .overlay').addEventListener('click', function() {
			document.querySelector('.edit-account').classList.add('hidden');
			document.querySelector('body').style.overflow = 'unset';
		})
		document.querySelector('.edit-account .close-tab').addEventListener('click', function() {
			document.querySelector('.edit-account').classList.add('hidden');
			document.querySelector('body').style.overflow = 'unset';
		})

		let elementEdit;
		let dataRole = JSON.parse('<?= json_encode($role)?>');
		document.querySelectorAll('.btn-edit').forEach( function(element, index) {
			element.onclick = function() {
				document.querySelector('body').style.overflow = 'hidden';
				elementEdit = element.parentElement.parentElement;
				$.ajax({
					url: '/api/Admin/accountAdmin/'+elementEdit.getAttribute('data-id'),
					type: 'GET',
					dataType: 'json'
				})
				.done(function(data) {
					if (typeof data.status === 'undefined') {
						let formEdit = document.getElementById('form-update-account');
						formEdit.querySelector('input[name="username"]').value = data.username;
						formEdit.querySelector('input[name="email"]').value = data.email;
						formEdit.querySelector('input[name="phoneNumber"]').value = data.phoneNumber;
						formEdit.querySelector('input[name="firstName"]').value = data.firstName;
						formEdit.querySelector('input[name="lastName"]').value = data.lastName;
						formEdit.querySelector(`select[name="role"] option[value="${data.roleId}"]`).selected = true;
						formEdit.querySelector(`select[name="active"] option[value="${data.active}"]`).selected = true;

						document.querySelector('.edit-account').classList.remove('hidden');
					}
				})
				.fail(function() {
					ShowMsgModal('Lỗi!', 'Không kết nối được máy chủ!!', 4, 'danger');
				});
			}
		});

		document.getElementById('form-update-account').onsubmit = function(event) {
			event.preventDefault();
			let formData = new FormData(this);
			$.ajax({
				url: '/api/Admin/accountAdmin/'+elementEdit.getAttribute('data-id'),
				type: 'POST',
				dataType: 'json',
				processData: false,
				contentType: false,
				data: formData
			})
			.done(function(data) {
				if (data.status) {
					elementEdit.querySelector('td:nth-child(2)').innerText = data.data.email
					elementEdit.querySelector('td:nth-child(3)').innerText = data.data.phoneNumber
					elementEdit.querySelector('td:nth-child(4)').innerText = data.data.firstName+data.data.lastName
					let roleName;
					for (value of dataRole) {
						if (value.id == data.data.role) {
							roleName = value.name;
						}
					}
					elementEdit.querySelector('td:nth-child(5)').innerText = roleName;

					if (data.data.active == '1') {
						elementEdit.style.color = '#000';
					} else {
						elementEdit.style.color = '#f00';
					}
					ShowMsgModal('Thành công!', data.message, 4);
					document.querySelector('body').style.overflow = 'unset';
					document.querySelector('.edit-account').classList.add('hidden');
				} else {
					ShowMsgModal('Thất bại!', data.message, 4, 'danger');
				}
			})
			.fail(function() {
				ShowMsgModal('Lỗi!', 'Không kết nối được máy chủ!!', 4, 'danger');
			});
			
		}
	});
</script>