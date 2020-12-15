<div class="col c-12 m-12 l-12">
	<div class="inner__body-card row no-gutters card card-block">
		<div class="col c-12 m-12 l-12">

			<div class="header-card">
				<div class="header-card__icon material-icons" style="color: #0259e6a3;">info</div>
				<div class="header-card__title">Thông tin sản phẩm</div>
			</div>

			<div class="card-body">
				<ul class="product-list">
					<?php foreach ($productType as $valueType): ?>
						<?php if ($valueType['business'] == 0)
							$style = 'red-color';
						else
							$style = '';
						?>
						<div class="label-group <?php echo $style; ?>" data-typeCode="<?php echo $valueType['code'] ?>">
							<span><?php echo $valueType['typeName'] ?></span>
						</div>
						<?php foreach ($menuData as $value): ?>
						<?php if ($valueType['code'] == $value['typeCode']): ?>
						<li class="product-items" data-group="<?php echo $value['typeCode'] ?>">
							<div class="product__avt">
								<div class="avt-image" style="background-image: url(<?php echo $value['avt'] ?>);" loading="lazy">
									<?php if ($value['itemsNew'] != 0): ?>
									<div class="product-new">New</div>
									<?php endif ?>

									<?php if ($value['bestSeller'] != 0): ?>
									<div class="product-best-seller">
										<i class="material-icons">attach_money</i>
										Bán chạy
									</div>
									<?php endif ?>
								</div>
							</div>
							<div class="product__name" <?php if(!$value['business']) echo 'style="color: red;"' ?>>
								<?php echo $value['name'] ?>
							</div>
							<div class="product__price">
								<?php
									$value['priceCurrent'] = $value['price'];
									if ($value['discount'] != 0) {
										if ($value['discountType'] == 0) {
											$value['priceCurrent'] = $value['priceCurrent']/100*(100-$value['discount']);
										} else {
											$value['priceCurrent'] = $value['priceCurrent']-$value['discount'];
										}
									}
									$value['priceCurrent'] = number_format($value['priceCurrent'], 0, ',', '.');
									$value['price'] = number_format($value['price'], 0, ',', '.');

								?>
								<?php if ($value['discount'] != 0): ?>
								<div class="price-old"><?php echo $value['price'] ?> Đ</div>
								<?php endif ?>
								<div class="price-current"><?php echo $value['priceCurrent'] ?> Đ</div>
							</div>
							<div class="button-box">
								<div class="button-edit material-icons" data-id="<?php echo $value['id'] ?>">edit</div>
								<div class="button-delete material-icons" data-id="<?php echo $value['id'] ?>">delete_forever</div>
							</div>
						</li>
						<?php endif ?>
						<?php endforeach ?>
					<?php endforeach ?>
				</ul>
			</div>
		</div>
		<div class="col c-12 m-12 l-12 test">
			<div class="test-overlay"></div>
		</div>
	</div>
</div>

<div class="edit-product hidden">
	<div class="overlay"></div>
	<div class="inner__body-card row no-gutters card card-block">
		<div class="form-box col c-12 m-6 l-4 m-o-3 l-o-4">
			<div class="header-card">
				<div class="header-card__icon material-icons" style="color: #e84393">edit</div>
				<div class="header-card__title">Sửa sản phẩm</div>
				<div class="close-tab material-icons">highlight_off
				</div>
			</div>

			<div class="card-body">
				<form id="form-update-product" method="post">
					<input type="text" name="productID" hidden>
					<div class="form-group">
						<label>Tên sản phẩm</label>
						<input name="name" type="text" placeholder="Cà phê đen" required>
					</div>
					<div class="form-group-select">
						<label>Loại sản phẩm</label>
						<select name="typeCode">
							<option value="">--- Chọn loại sản phẩm ---</option>
							<?php foreach ($productType as $value): ?>
							<option value="<?php echo $value['code'] ?>"><?php echo $value['typeName'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group">
						<label>Ảnh đại diện</label>
						<input name="avt" id="fileAvt" type="file">
					</div>
					<div class="form-group">
						<img class="img-preview" src="/uploads/menu/image_not_supported.svg">
					</div>
					<div class="form-group">
						<label>Giá bán</label>
						<input name="price" type="text" placeholder="10000" required>
					</div>
					<div class="row no-gutters">
						<div class="col c-6 m-6 l-6">
							<div class="form-group-select">
								<label>Sản phẩm mới</label>
								<select name="itemsNew">
									<option value="0">OFF</option>
									<option value="1">ON</option>
								</select>
							</div>
						</div>
						<div class="col c-6 m-6 l-6">
							<div class="form-group-select">
								<label>Bán chạy</label>
								<select name="bestSeller">
									<option value="0">OFF</option>
									<option value="1">ON</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Giảm giá</label>
						<input name="discount" type="text" placeholder="15" required>
					</div>
					<div class="form-group-select">
						<label>Loại giảm giá</label>
						<select name="discountType">
							<option value="0">Phần trăm</option>
							<option value="1">Giá tiền</option>
						</select>
					</div>
					<div class="form-group-select">
						<label>Trạng thái: </label>
						<select name="business">
							<option value="0">Đóng</option>
							<option value="1">Mở bán</option>
						</select>
					</div>


					<div class="form-group" style="margin-top: 15px">
						<input type="submit" class="btn btn-submit" value="Cập nhật sản phẩm">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script defer>
	document.querySelector('.edit-product .overlay').addEventListener('click', function() {
		document.querySelector('.edit-product').classList.add('hidden');
		document.querySelector('body').style.overflow = 'unset';
	})
	document.querySelector('.edit-product .close-tab').addEventListener('click', function() {
		document.querySelector('.edit-product').classList.add('hidden');
		document.querySelector('body').style.overflow = 'unset';
	})

	var formUpdate = document.getElementById('form-update-product');
	var editData = {element:"", typeCode: "", image: "", id: ""};
	formUpdate.addEventListener('submit', function (e) {
		e.preventDefault();
		var form_data = new FormData();
		if ($('#fileAvt').val() != "") {
			form_data.append('file', $('#fileAvt').prop('files')[0]);
		}

		// form_data.append('id', formUpdate.querySelector('input[name="productID"]').value);
		formUpdate.querySelectorAll('input[name]').forEach(function(element) {
			form_data.append(element.getAttribute('name'), element.value);
		});

		formUpdate.querySelectorAll('select').forEach(function(element) {
			var name = element.getAttribute('name');
			form_data.append(name, element.value);
		});
		form_data.append('image-src', editData.image);
		form_data.append('image-update', formUpdate.querySelector('#fileAvt').value);

		var productID = this.querySelector('input[name="productID"]').value;

		$.ajax({
			url: '/api/Admin/product/'+productID,
			type: 'POST',
			dataType: 'json',
			processData: false,
        	contentType: false,
			data: form_data
		})
		.done(function(data) {
			if (data.status == true) {
				ShowMsgModal('Thành công!', data.message, 4);
				// Nếu loại sản phẩm không thay đổi
				var dataRes = data.data;
				if (editData.typeCode == dataRes.typeCode) {
					updateProductInfo_Ajax(form_data, dataRes);
				} else { // Nếu loại sản phẩm thay đổi
					// Xóa element hiện tại
					editData.element.remove();

					// Thêm element vào cuối loại đổi sang
					var lastElement = Array.from(document.querySelectorAll('li[data-group="'+dataRes.typeCode+'"]')).pop();
					var content = '<li class="product-items" data-group="'+dataRes.typeCode+'">';
						// Ảnh
						content += '<div class="product__avt">';
						content +=		'<div class="avt-image" style="background-image: url('+dataRes.avt+');">';
						content += 		'</div>';
						content += '</div>';
						// Tên
						content += '<div class="product__name"></div>';
						// Giá
						content += '<div class="product__price"></div>';
						// 2 nút
						content += '<div class="button-box">'
						content += '<div class="button-edit material-icons" data-id="'+editData.id+'">edit</div>';
						content += '<div class="button-delete material-icons" data-id="'+editData.id+'">delete_forever</div>';
						content += '</div>';

						content +='</li>';
					// Nếu không có element cuối
					if (!lastElement) {
						var labelElement = document.querySelector('.label-group[data-typecode="'+dataRes.typeCode+'"]');
						editData.element = $(content).insertAfter(labelElement)[0];
					} else {
						editData.element = $(content).insertAfter(lastElement)[0];
					}
					updateProductInfo_Ajax(form_data, dataRes);

					editData.element.querySelector('.button-edit').onclick = function() {
						fEdit(this);
					}
					editData.element.querySelector('.button-delete').onclick = function() {
						fDelete(this);
					}
				}
			} else {
				ShowMsgModal('Thất bại!', data.message, 4, 'danger');
			}
		})
		.fail(function(data) {
			ShowMsgModal('Fail!', 'Lỗi không xác định', 4, 'danger');
		})
		.always(function() {
			document.querySelector('.edit-product').classList.add('hidden');
			document.querySelector('body').style.overflow = 'unset';
		});
		
	})

	function updateProductInfo_Ajax(form_data, data) {
		// Nếu thay ảnh khác thì tải lại ảnh
		if (form_data.get('image-update') != "") {
			$.get('/'+data.avt, function() {
				editData.element.querySelector('.avt-image').setAttribute('style', 'background-image: url('+data.avt+')');
			})
		}
		
		// check product new
		var productNew = editData.element.querySelector('.product-new');
		if (productNew) {
			if (data.itemsNew == 0) {
				productNew.remove();
			}
		} else if (data.itemsNew != 0) {
			editData.element.querySelector('.avt-image').innerHTML += '<div class="product-new">New</div>';
		}

		// check product best seller
		var bestSeller = editData.element.querySelector('.product-best-seller');
		if (bestSeller) {
			if (data.bestSeller == 0) {
				bestSeller.remove();
			}
		} else if (data.bestSeller != 0) {
			editData.element.querySelector('.avt-image').innerHTML += '<div class="product-best-seller"><i class="material-icons">attach_money</i>Bán chạy</div>';
		}

		// cập nhật lại tên
		editData.element.querySelector('.product__name').innerText = data.name;
		if (data.business == false)
			editData.element.querySelector('.product__name').style.color = "red";
		else
			editData.element.querySelector('.product__name').style.color = '';

		// Cập nhật giá
		var priceElement = editData.element.querySelector('.product__price');
		priceElement.innerHTML = "";
		// nếu có giảm giá
		var price_old = formatMoney(data.price);
		if (data.discount != 0) {
			// format giá tiền
			priceElement.innerHTML += '<div class="price-old">'+price_old+' Đ</div>';
			if (data.discountType != 0) {
				var price_current = parseInt(data.price) - parseInt(data.discount);
			} else {
				var price_current = parseInt(data.price)/100*(100-parseInt(data.discount));
			}
			price_current = formatMoney(price_current+'');
			priceElement.innerHTML += '<div class="price-current">'+price_current+' Đ</div>';
		} else {
			priceElement.innerHTML += '<div class="price-current">'+price_old+' Đ</div>';
		}
	}

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

	// Chọn tệp ảnh mới thì cập nhật hình ảnh preview
	var src = document.getElementById('fileAvt');
	var target = formUpdate.querySelector('.img-preview');
	function showImage(src,target) {
		var fr=new FileReader();
		// when image is loaded, set the src of the image where you want to display it
		fr.onload = function(e) { target.src = this.result; };
		src.addEventListener("change",function() {
			// fill fr with image data    
			fr.readAsDataURL(src.files[0]);
		});
	}
	showImage(src, target);


	// 2 nút edit + delete
	var btnEdit = document.querySelectorAll('.button-edit');
	btnEdit.forEach(function(el) {
		el.onclick = function() {
			fEdit(this);
		}
	})

	var btnDelete = document.querySelectorAll('.button-delete');
	btnDelete.forEach(function(el) {
		el.onclick = function() {
			fDelete(this);
		}
	});

	function fEdit(element) {
		var productID = element.getAttribute('data-id');
		editData.id = productID;
		editData.element = element.parentElement.parentElement;
		$.ajax({
			url: '/api/Admin/product/'+productID,
			type: 'GET',
			dataType: 'json'
		})
		.done(function(data) {
			if (typeof data.status === 'undefined') {
				formUpdate.querySelector('input[name="productID"]').value = data.id;
				formUpdate.querySelector('input[name="name"]').value = data.name;
				formUpdate.querySelector('.img-preview').setAttribute('src', data.avt);
				editData.image = data.avt;
				formUpdate.querySelector('input[name="price"]').value = data.price;
				formUpdate.querySelector('input[name="discount"]').value = data.discount;
				formUpdate.querySelector('#fileAvt').value = "";

				formUpdate.querySelectorAll('select[name="typeCode"] option').forEach( function(element) {
					if (element.value == data.typeCode) {
						element.selected = true;
						editData.typeCode = data.typeCode;
					} else {
						element.removeAttribute('selected');
					}
				});
				formUpdate.querySelectorAll('select[name="itemsNew"] option').forEach( function(element) {
					if (element.value == data.itemsNew) {
						element.selected = true;
					} else {
						element.removeAttribute('selected');
					}

				});
				formUpdate.querySelectorAll('select[name="bestSeller"] option').forEach( function(element) {
					if (element.value == data.bestSeller) {
						element.selected = true;
					} else {
						element.removeAttribute('selected');
					}

				});
				formUpdate.querySelectorAll('select[name="discountType"] option').forEach( function(element) {
					if (element.value == data.discountType) {
						element.selected = true;
					} else {
						element.removeAttribute('selected');
					}

				});
				formUpdate.querySelectorAll('select[name="business"] option').forEach( function(element) {
					if (element.value == data.business) {
						element.selected = true;
						let selectElement = element.parentElement;
						if (data.business == true)
							selectElement.style.color = "green";
						else
							selectElement.style.color = "red";

						selectElement.onchange = function() {
							if (this.value == false)
								selectElement.style.color = "red";
							else
								selectElement.style.color = "green";
						}
					} else {
						element.removeAttribute('selected');
					}

				});
				document.querySelector('.edit-product').classList.remove('hidden');
				document.querySelector('body').style.overflow = 'hidden';
			}
		});
	};

	function fDelete(element) {
		var productID = element.getAttribute('data-id');
		var parentElement = element.parentElement.parentElement;
		$.ajax({
			url: '/api/Admin/product/'+productID,
			type: 'DELETE',
			dataType: 'json'
		})
		.done(function(data) {
			if (data.status == true) {
				parentElement.remove();
				ShowMsgModal('Thành công!', data.message, 4);
			} else {
				// ShowMsgModal('Thất bại!', data.message, 4, 'danger');
				ShowMsgBox('Thất bại!', data.message, 'OK', 'fail')
			}
		})
		.fail(function(data) {
			ShowMsgModal('Error!', 'Lỗi không xác định!!', 4, 'danger');
		})
		.always(function() {
			// console.log("complete");
		});
	}
	

	
</script>