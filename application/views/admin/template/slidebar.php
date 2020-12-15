<div class="app-slidebar">
	<div class="app-slidebar__inner">
		<ul class="nav-menu">
			<?php if ($this->session->userdata('role') == 1): ?>
			<li>
				<div id="DashBoardManager" class="nav-menu__title slidebar-btn active">
					<div class="nav-menu__title-name">
						<div class="icon-menu material-icons">dashboard</div>
						Thống kê
					</div>
				</div>
			</li>
			<li>
				<div id="AccountManager" class="nav-menu__title slidebar-btn">
					<div  class="nav-menu__title-name">
						<div class="icon-menu material-icons">people_alt</div>
						Quản lý tài khoản
					</div>
				</div>
			</li>
			<li>
				<div id="ProductManager" class="nav-menu__title slidebar-btn">
					<div  class="nav-menu__title-name">
						<div class="icon-menu material-icons">restaurant_menu</div>
						<span>Quản lý sản phẩm</span>
					</div>
				</div>
			</li>
			<li>
				<div id="VoucherManager" class="nav-menu__title slidebar-btn">
					<div  class="nav-menu__title-name">
						<div class="icon-menu material-icons">loyalty</div>
						<span>Quản lý mã giảm giá</span>
					</div>
				</div>
			</li>
			<!-- qr code -->
			<li>
				<div id="QrCode" class="nav-menu__title slidebar-btn">
					<div  class="nav-menu__title-name">
						<div class="icon-menu material-icons">qr_code_2</div>
						<span>QR Code</span>
					</div>
				</div>
			</li>
			<?php endif ?>

			<?php if ($this->session->userdata('role') != 1): ?>
			<li>
				<div id="OrderManager" class="nav-menu__title slidebar-btn active">
					<div  class="nav-menu__title-name">
						<div class="icon-menu material-icons">list_alt</div>
						<span>Đơn đặt hàng</span>
					</div>
				</div>
			</li>
			<?php endif ?>

			<!-- <li>
				<div class="nav-menu__title dropdown-mm">
					<div class="nav-menu__title-name">
						<div class="icon-menu material-icons">menu_book</div>
						Menu 1
					</div>
					<div class="nav-menu__title-icon"></div>
				</div>
				<div class="mini-menu">
					<ul class="mm-collapse">
						<li><a>mini menu 1</a></li>
						<li><a>mini menu 2</a></li>
						<li><a>mini menu 3</a></li>
					</ul>
				</div>
			</li>
			<li>
				<div class="nav-menu__title dropdown-mm">
					<div class="nav-menu__title-name">
						<div class="icon-menu material-icons">menu_book</div>
						Menu 1
					</div>
					<div class="nav-menu__title-icon"></div>
				</div>
				<div class="mini-menu">
					<ul class="mm-collapse">
						<li><a>mini menu 1</a></li>
						<li><a>mini menu 2</a></li>
						<li><a>mini menu 3</a></li>
					</ul>
				</div>
			</li>
			<li>
				<div class="nav-menu__title slidebar-btn">
					<div class="nav-menu__title-name">
						<div class="icon-menu material-icons">menu_book</div>
						DashBoard
					</div>
				</div>
			</li>
			<li>
				<div class="nav-menu__title dropdown-mm">
					<div class="nav-menu__title-name">
						<div class="icon-menu material-icons">menu_book</div>
						Menu 1
					</div>
					<div class="nav-menu__title-icon"></div>
				</div>
				<div class="mini-menu">
					<ul class="mm-collapse">
						<li><a>mini menu 1</a></li>
						<li><a>mini menu 2</a></li>
						<li><a>mini menu 3</a></li>
					</ul>
				</div>
			</li>
			<li>
				<div class="nav-menu__title dropdown-mm">
					<div class="nav-menu__title-name">
						<div class="icon-menu material-icons">menu_book</div>
						Menu 1
					</div>
					<div class="nav-menu__title-icon"></div>
				</div>
				<div class="mini-menu">
					<ul class="mm-collapse">
						<li><a>mini menu 1</a></li>
						<li><a>mini menu 2</a></li>
						<li><a>mini menu 3</a></li>
					</ul>
				</div>
			</li>
			<li>
				<div class="nav-menu__title dropdown-mm">
					<div class="nav-menu__title-name">
						<div class="icon-menu material-icons">menu_book</div>
						Menu 1
					</div>
					<div class="nav-menu__title-icon"></div>
				</div>
				<div class="mini-menu">
					<ul class="mm-collapse">
						<li><a>mini menu 1</a></li>
						<li><a>mini menu 2</a></li>
						<li><a>mini menu 3</a></li>
					</ul>
				</div>
			</li>
			<li>
				<div class="nav-menu__title dropdown-mm">
					<div class="nav-menu__title-name">
						<div class="icon-menu material-icons">menu_book</div>
						Menu 1
					</div>
					<div class="nav-menu__title-icon"></div>
				</div>
				<div class="mini-menu">
					<ul class="mm-collapse">
						<li><a>mini menu 1</a></li>
						<li><a>mini menu 2</a></li>
						<li><a>mini menu 3</a></li>
					</ul>
				</div>
			</li> -->
		</ul>
	</div>
</div>