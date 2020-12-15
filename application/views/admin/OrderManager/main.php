<div class="inner__header">
	<div class="inner__title-icon">
		<div class="icon-img material-icons">list_alt</div>
	</div>
	<div class="inner__header-text">
		<div class="inner__header-text-title">
			Quản lý đơn đặt hàng
		</div>
		<div class="inner__header-text-content">
			Quản lý các đơn đặt hàng
		</div>
	</div>
</div>
<div class="inner__button">
	<?php $role = $this->session->userdata('role');
	if ($role == 3) {
		echo '<div id="OrderWait" class="btn-load-page btn btn-trans active">Chưa thanh toán</div>';
		echo '<div id="OrderSuccess" class="btn-load-page btn btn-trans">Pha chế xong</div>';
	}
	if ($role == 2)
		echo '<div id="OrderDone" class="btn-load-page btn btn-trans">Đã thanh toán</div>';
	?>
</div>
<div id="inner__body" class="inner__body row" data-body="OrderWait">
	<!-- include main -->
	<?php
	if ($role == 3)
		include "orderWait.php";
	else if ($role == 2)
		include "orderDone.php";
	?>

</div>

<script>

	<?php if ($role == 2): ?>
		document.getElementById('OrderDone').classList.add('active');
		document.getElementById('inner__body').setAttribute('data-body', 'OrderDone');
	<?php endif ?>


	var btnLoadPage = document.querySelectorAll('.btn-load-page');
	var bodyElement = document.querySelector('.inner__body');
	btnLoadPage.forEach( function(element, index) {
		element.addEventListener('click', function() {
			var elID = this.getAttribute('id');
			var el = this;
			if (bodyElement.getAttribute('data-body') != elID) {
				document.querySelector('.loading-app-main').classList.remove('hidden');
				$.ajax({
					url: '/admin/OrderManager/'+elID,
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