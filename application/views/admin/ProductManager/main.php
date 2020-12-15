<div class="inner__header">
	<div class="inner__title-icon">
		<div class="icon-img material-icons">restaurant_menu</div>
	</div>
	<div class="inner__header-text">
		<div class="inner__header-text-title">
			Quản lý sản phẩm
		</div>
		<div class="inner__header-text-content">
			Quản lý và thay đổi thông tin các sản phẩm
		</div>
	</div>
</div>
<div class="inner__button">
	<div id="CreateProduct" class="btn-load-page btn btn-trans active">
		Thêm sản phẩm
	</div>
	<div id="ShowProduct" class="btn-load-page btn btn-trans">
		Sản phẩm
	</div>
	<div id="ShowProductType" class="btn-load-page btn btn-trans">
		Loại sản phẩm
	</div>
</div>
<div id="inner__body" class="inner__body row" data-body="CreateProduct">
	<!-- include main -->
	<?php include "createProduct.php" ?>

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
					url: '/admin/ProductManager/'+elID,
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