<div class="col c-12 m-12 l-12">
	<div class="inner__body-card row no-gutters card card-block">
		<div class="col c-12 m-10 m-o-1 l-6 l-o-3">
			<div class="card-body">
				<form id="form-create-product">
					<div class="label-group">
						<span>Thông tin sản phẩm</span>
					</div>
					<div class="form-group">
						<label>Tên sản phẩm</label>
						<input name="name" type="text" placeholder="Cà phê đen" required>
					</div>
					<div class="form-group-select">
						<label>Loại sản phẩm:</label>
						<select name="typeCode">
							<option value="">--- Chọn loại sản phẩm ---</option>
							<?php foreach ($productType as $value): ?>
							<option value="<?php echo $value['code'] ?>"><?php echo $value['typeName'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group">
						<label>Ảnh đại diện</label>
						<input name="avt" id="fileAvt" type="file" required>
					</div>
					<div class="form-group">
						<label>Giá bán</label>
						<input name="price" type="text" placeholder="10000" required>
					</div>
					<div class="form-group" style="margin-top: 15px">
						<input type="submit" class="btn btn-submit" value="Thêm sản phẩm">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	// Click thêm sản phẩm
	document.getElementById('form-create-product').addEventListener('submit', function(e) {
		e.preventDefault();
		// var form = $(this);
		var formElement = this;
		var formData = new FormData(this);
		// Gửi data nhập (không lấy dữ liệu file)
		// Lấy ra files
        var file_data = $('#fileAvt').prop('files')[0];
        // lấy ra kiểu file
        var type = file_data.type;
        // lấy ra đuôi file
        var duoi_file = file_data.name.split(".").pop();
        // Xét kiểu file được upload
        var match = ["image/gif", "image/png", "image/jpg", "image/jpeg"];
        // kiểm tra kiểu file
        if (type == match[0] || type == match[1] || type == match[2] || type == match[3]) {
        	// Thêm sản phẩm
        	$.ajax({
				url: '/api/Admin/product',
				type: 'POST',
				dataType: 'json',
				processData: false,
		        contentType: false,
				data: formData,
			})
			.done(function(res){
				if (res.status == true) {
					ShowMsgModal('Thành công!', 'Thêm <b>' + formElement.querySelector('input[name="name"]').value +'</b> thành công', 4, 'success');

					// reset value input
            		formElement.querySelectorAll('input[name]').forEach( function(element) {
						element.value = "";
					});
					// formElement.querySelector('select[name="typeCode"] option').selected = 'selected';
				} else {
            		ShowMsgBox('Lỗi!', res.message, 'OK', 'fail');
            	}
			})
			.fail(function() {
            	ShowMsgModal('Thất bại!', 'Tên sản phẩm <b>đã tồn tại</b>', 4, 'danger');
            });
        } else {
    		ShowMsgBox('Lỗi!', 'Chỉ được upload ảnh', 'OK', 'fail');
    	}
	})
</script>