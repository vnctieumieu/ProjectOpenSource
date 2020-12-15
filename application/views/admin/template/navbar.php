<div class="app-header">
	<div class="app-header__logo">
		<div class="logo-src">
			<img src="/vendor/img/order-food-64.png" width="48px">
			<span>SSM <span style="font-size: 14px;">Manager</span></span>
		</div>
		<div class="header__pane showbar">
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>

	<div class="app-header__content">
		<div class="content-left">
			<!-- <div class="header-setting">setting</div> -->
		</div>
		<div class="content-right">
			<div class="header-user">
				<div class="user-avt">
					<div class="user-pane">
						<div class="user__logo material-icons">
							account_circle
						</div>
						<div class="arrow-down"></div>
					</div>
					<div class="user-silebar">
						<ul>
							<!-- <li class="lidebar-items">Thông tin cá nhân</li> -->
							<li class="lidebar-items" id="btnChangePwd">Đổi mật khẩu</li>
							<li class="lidebar-items" id="btnLogout">Đăng xuất</li>
						</ul>
					</div>
				</div>
				<div class="user__info">
					<div class="user-name"><?php echo $this->session->userdata('firstName') . " " . $this->session->userdata('lastName') ?></div>
					<div class="user-level"><?php echo $this->session->userdata('roleName'); ?></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="edit-password hidden">
	<div class="overlay"></div>
	<div class="inner__body-card row no-gutters card card-block">
		<div class="form-box col c-12 m-6 l-4 m-o-3 l-o-4">
			<div class="header-card">
				<div class="header-card__icon material-icons" style="color: #cc0000">lock</div>
				<div class="header-card__title">Đổi mật khẩu</div>
				<div class="close-tab material-icons">highlight_off
				</div>
			</div>

			<div class="card-body">
				<form id="form-change-password" method="post">
					<div class="form-group">
						<label>Mật khẩu cũ</label>
						<input name="password_old" class="password" type="password" required>
					</div>
					<div class="form-group">
						<label>Mật khẩu mới</label>
						<input name="password_new" class="password" type="password" required>
					</div>
					<div class="form-group">
						<label>Nhập lại mật khẩu</label>
						<input name="password_retype" class="password" type="password" required>
					</div>

					<div class="form-group-select" style="cursor: pointer; display: inline-flex;" id="btn-show-pwd">
						<input type="checkbox" style="width: 16px; height: 16px; cursor: pointer;">
						<span style="margin-left: 10px; font-weight: 200; user-select: none;">Hiển thị mật khẩu</span>
					</div>

					<div class="form-group" style="margin-top: 15px">
						<input type="submit" class="btn btn-submit" value="Đổi mật khẩu">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		document.getElementById('btnChangePwd').onclick = function() {
			this.parentElement.parentElement.parentElement.querySelector('.user-pane').classList.remove('active');
			document.querySelector('body').style.overflow = 'hidden';
			document.querySelector('.edit-password').classList.remove('hidden');
		}

		document.querySelector('.edit-password .overlay').addEventListener('click', function() {
			document.querySelector('.edit-password').classList.add('hidden');
			document.querySelector('body').style.overflow = 'unset';
		})
		document.querySelector('.edit-password .close-tab').addEventListener('click', function() {
			document.querySelector('.edit-password').classList.add('hidden');
			document.querySelector('body').style.overflow = 'unset';
		})

		// xử lý checkbox show pass
		document.getElementById('btn-show-pwd').onclick = function() {
			let parentElement = this.parentElement;
			if (this.querySelector('input[type="checkbox"]').checked) {
				this.querySelector('input[type="checkbox"]').checked = false;
				parentElement.querySelectorAll('input.password').forEach( function(element, index) {
					element.type = 'password';
				});
			} else {
				this.querySelector('input[type="checkbox"]').checked = true;
				parentElement.querySelectorAll('input.password').forEach( function(element, index) {
					element.type = 'text';
				});
			}
		}
		document.querySelector('#form-change-password input[type="checkbox"]').onclick = function(e) {
			e.stopPropagation();
			let parentElement = this.parentElement.parentElement;
			if (!this.checked) {
				parentElement.querySelectorAll('input.password').forEach( function(element, index) {
					element.type = 'password';
				});
			} else {
				parentElement.querySelectorAll('input.password').forEach( function(element, index) {
					element.type = 'text';
				});
			}
		}

		document.getElementById('form-change-password').onsubmit = function(event) {
			event.preventDefault();

			let formData = new FormData(this);

			$.ajax({
				url: '/api/Admin/changePwdAdmin',
				type: 'POST',
				dataType: 'json',
				processData: false,
				contentType: false,
				data: formData,
			})
			.done(function(data) {
				if (data.status) {
					ShowMsgModal('Thành công!', data.message, 4);
					document.querySelector('body').style.overflow = 'unset';
					document.querySelector('.edit-password').classList.add('hidden');
				} else {
					ShowMsgModal('Thất bại!', data.message, 4, 'danger');
				}
			})
			.fail(function() {
				ShowMsgModal('Lỗi!', 'Không kết nối được máy chủ!!', 4, 'danger');
			});
			
		}

		document.querySelector('#form-change-password input[name="password_retype"]').oninput = function() {
			let pwdElement = document.querySelector('#form-change-password input[name="password_new"]');
			
			if (pwdElement.value == this.value) {
				pwdElement.classList.remove('fail');
				this.classList.remove('fail');
				pwdElement.classList.add('success');
				this.classList.add('success');
			} else {
				pwdElement.classList.remove('success');
				this.classList.remove('success');
				pwdElement.classList.add('fail');
				this.classList.add('fail');
			}
		}

		document.querySelector('#form-change-password input[name="password_new"]').oninput = function() {
			let pwdElement = document.querySelector('#form-change-password input[name="password_retype"]');
			
			if (pwdElement.value) {
				if (pwdElement.value == this.value) {
					pwdElement.classList.remove('fail');
					this.classList.remove('fail');
					pwdElement.classList.add('success');
					this.classList.add('success');
				} else {
					pwdElement.classList.remove('success');
					this.classList.remove('success');
					pwdElement.classList.add('fail');
					this.classList.add('fail');
				}
			}
		}
	})
</script>