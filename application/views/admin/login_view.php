<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đăng nhập</title>
	<link rel="icon" href="/vendor/img/order-food-32.png">
	<link rel="stylesheet" href="/vendor/css/login.css">
</head>
<body>
	<div class="container">
		<div class="form">
			<h2>Đăng nhập</h2>
			<form id="form-login" method="POST">
				<div class="formBox">
					<input type="Text" name="username" placeholder="Tên đăng nhập" required>
				</div>
				<div class="formBox">
					<input type="password" name="password" placeholder="Mật khẩu" required>
				</div>
				<div class="formBox">
					<span class="error-message"></span>
				</div>
				<div class="formBox btnSubmit">
					<input id="btnLogin" type="submit" value="Đăng nhập">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span class="loading">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="18px" height="18px"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 6v3l4-4-4-4v3c-4.42 0-8 3.58-8 8 0 1.57.46 3.03 1.24 4.26L6.7 14.8c-.45-.83-.7-1.79-.7-2.8 0-3.31 2.69-6 6-6zm6.76 1.74L17.3 9.2c.44.84.7 1.79.7 2.8 0 3.31-2.69 6-6 6v-3l-4 4 4 4v-3c4.42 0 8-3.58 8-8 0-1.57-.46-3.03-1.24-4.26z"/></svg>
					</span>
				</div>
			</form>
		</div>
	</div>

	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/js/jquery-3.5.1.min.js"></script>
	<script>
		var input = document.querySelectorAll('.formBox input[name]');
		input.forEach(function(element) {
			element.oninput = function() {
				document.querySelector('.container').style.height = "300px";
				document.querySelector('.error-message').innerHTML = "";
			}
		})
		var btnLogin = document.querySelector('#btnLogin');
		btnLogin.onclick = function(e) {
			e.preventDefault();
			document.querySelector('.loading').style.display = 'unset';
			btnLogin.style.display = 'none';
			$.ajax({
				url: '/api/Login/admin',
				type: 'POST',
				dataType: 'json',
				data: {
					username: document.querySelector('input[name="username"]').value,
					password: document.querySelector('input[name="password"]').value
				},
			})
			.done(function(data) {
				if (data.status === false) {
					var error = '<svg'
						error +='xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" width="14px" height="14px">'
						error +='<path d="M0 0h24v24H0z" fill="none"/>'
						error +='<path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>'
						error +='</svg>Đăng nhập thất bại: '
						error +=data.message;

					document.querySelector('.container').style.height = "350px";
					document.querySelector('.error-message').innerHTML = error;
				} else {
					location.reload();
				}
			})
			.fail(function(data) {
				
			})
			.always(function() {
				document.querySelector('.loading').style.display = "none";
				btnLogin.style.display = 'unset';
				console.log("complete");
			});
			
		}
	</script>
</body>
</html>