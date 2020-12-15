<div class="inner__header">
	<div class="inner__title-icon">
		<div class="icon-img material-icons">people_alt</div>
	</div>
	<div class="inner__header-text">
		<div class="inner__header-text-title">
			Quản lý tài khoản
		</div>
		<div class="inner__header-text-content">
			Tạo và thay đổi thông tin các tài khoản trong hệ thống
		</div>
	</div>
</div>
<div class="inner__button">
	<div id="CreateAccount" class="btn-load-page btn btn-trans active">
		Tạo tài khoản
	</div>
	<div id="ShowAccount" class="btn-load-page btn btn-trans">
		Tài khoản admin
	</div>
</div>
<div id="inner__body" class="inner__body row" data-body="CreateAccount">
	<?php include 'createAccount.php'; ?>
</div>

<script>
	var btnLoadPage = document.querySelectorAll('.btn-load-page');
	var bodyElement = document.querySelector('.inner__body');
	btnLoadPage.forEach( function(element, index) {
		element.addEventListener('click', function() {
			var elID = this.getAttribute('id');
			var el = this;
			if (bodyElement.getAttribute('data-body') != elID) {
				document.querySelector('.loading-app-main').classList.remove('hidden');
				$.ajax({
					url: '/admin/AccountManager/'+elID,
					type: 'GET',
					dataType: 'html'
				})
				.done(function(data) {
					btnLoadPage.forEach( function(element, index) {
						element.classList.remove('active');
					});
					el.classList.add('active');
					$('#inner__body').html(data);
					bodyElement.setAttribute('data-body', elID);
				})
				.fail(function(data) {
					ShowMsgBox('Fail!', 'Chức năng đang được phát triển', 'OK', 'fail');
				})
				.always(function() {
					document.querySelector('.loading-app-main').classList.add('hidden');
				});
			}
		})
	});
</script>