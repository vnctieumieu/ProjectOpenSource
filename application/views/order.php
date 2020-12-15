<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/vendor/img/order-food-32.png">
    <title>SSM Order</title>
    <link rel="stylesheet" href="/vendor/css/order.css">
    <link rel="stylesheet" href="/vendor/css/grid.css">
</head>
<body>
    <div class="container">
        <header class="grid">
            <div class="header">
                <div class="header_navbar">
                    <a href="/" class="header_navbar-iconlink">
                        <img class = "iconlink-logo"src="/vendor/img/logo.png" alt="">
                        <span class ="iconlink-name">SSM</span>
                    </a>
                    <div class="header_navbar-cart">
                        <span class="cart-icon material-icons-outlined">shopping_cart</span>
                        <span class="cart-amount">0</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-body">
            <div id="address" class="container-review" data-table="<?php echo $table ?>">
                <img class="review-picture" src="/uploads/store/store_1.jpg" alt="">
                <span class="review-id">Bàn: <?php echo $table ?></span>
                <div class="review-address-box">
                    <span class="review-address">Địa chỉ: 180 Cao Lỗ, phường 4, quận 8, TP.HCM</span>
                </div>
            </div>
            <!-- Phần sản phẩm -->
            <div class="container-productlist">
                <!-- Một loại sản phẩm -->
                <?php foreach ($productType as $valueType): ?>
                <?php if ($valueType['business'] != 0): ?>
                <div class="produclist-item">
                    <!-- Tiểu đề loại sản phẩm -->
                    <div class="produclist-item-typename"><?php echo $valueType['typeName'] ?></div>
                    <!-- 1 sản phẩm -->
                    <?php foreach ($product as $value): ?>
                    <?php if ($valueType['code'] == $value['typeCode'] && $value['business'] == true): ?>
                    <div class="product">
                        <div class="product-id" hidden><?php echo $value['id'] ?></div>
                        <div class="product-picture">
                            <img src="<?php echo $value['avt']; ?>" alt="" loading="lazy">
                            <?php if ($value['itemsNew'] != 0): ?>
                            <span class="banner-new">New</span>
                            <?php endif ?>
                            <?php if ($value['bestSeller'] != 0): ?>
                            <span class="banner-hot">Hot</span>
                            <?php endif ?>
                        </div>
                        <div class="product-info">
                            <div class="product-name"><?php echo $value['name'] ?></div>
                            <!-- <div class="product-review">Một sản phẩm tuyệt vời uống vào cười suốt năm kkkkk</div> -->

                            <div class="product-price-buy">
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
                                <span class="product-oldprice"><?php echo $value['price'] ?></span>
                                <?php endif ?>
                                <span class="product-price"><?php echo $value['priceCurrent'] ?></span>
                            </div>
                            <div class="button-groups">
                                <div class="product-add">Thêm</div>
                                <div class="amount-groups">
                                    <span class="amount-sub material-icons">remove</span>
                                    <span class="amount-number">
                                        1
                                    </span>
                                    <span class="amount-sum material-icons">add</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <?php endforeach ?>
                </div>
                <?php endif ?>
                <?php endforeach ?>
            </div>
            <div class="cart-outer">
                <div class="container-cart">
                    <i class="material-icons-outlined" style="margin-right: 8px;">shopping_cart</i>Có <span class="cart-amount" style="margin: 0px 4px;">0</span> sản phẩm trong giỏ hàng               
                </div>
            </div>

        </div>

        <div class="cart-main hidden">
            <div class="cart-box">
                <div class="cart-header">
                    <span class="btn-back material-icons">arrow_back</span>
                    <h4 class="title">Giỏ hàng</h4>
                </div>
                <div class="cart-body">
                    <ul class="cart-list"></ul>
                    <div class="cart-price-all"><b style="margin-right: 15px;">TỔNG:</b>0 Đ</div>
                    <div class="cart-coupon">
                        <input type="text" placeholder="Mã giảm giá">
                        <div id="btn-apply-coupon" class="btn-apply-coupon">Áp dụng</div>
                    </div>
                    <div class="cart-price-discount">Khuyến mãi: <i style="margin-left: 15px;">0</i> Đ</div>
                    <div class="cart-price-pay"><b style="margin-right: 15px;">THANH TOÁN:</b>0 Đ</div>
                </div>
                <div class="cart-note">
                    <span>Ghi chú:</span>
                    <div class="textarea">
                        <textarea rows="3" placeholder="Ghi lưu ý cho nhân viên"></textarea>
                    </div>
                </div>
            </div>
            <div class="pay-group">
                <div class="btn-pay-online">Thanh toán ví momo</div>
                <div class="btn-pay-offline">Thanh toán tiền mặt</div>
            </div>
        </div>
    </div>

    <div class="message-box" id="message-box">
        <div class="message-box__overlay"></div>
        <div class="message-body">
            <h2 class="message-body__title"></h2>
            <div class="message-body__content"></div>
            <div class="message-body__button btn"></div>
        </div>
    </div>

    <script  type="text/javascript" src="/vendor/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="/vendor/js/msgBox.js"></script>
    <script type="text/javascript" src="/vendor/js/forge.all.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded",function(){
            var urlMomo = 'https://test-payment.momo.vn/gw_payment/transactionProcessor';
            // Giỏ hàng {'product-id': 'amount'}
            var cart = {};
            var cartProduct = new Array();
            var cartDiscount = [];
            cartDiscount['id'] = 0;
            cartDiscount['code'] = "";
            cartDiscount['type'] = 0;
            cartDiscount['value'] = 0;
            cartDiscount['price'] = 0;
            var cartPrice_old = 0;
            var cartPrice_current = 0;
            // Số lượng giỏ hàng
            var amountAll = 0;
            var cartHeaderElement = document.querySelector('.header_navbar-cart');
            var cartHAmount = cartHeaderElement.querySelector('.cart-amount');
            var cartBottomElement = document.querySelector('.cart-outer');
            var cartBAmount = cartBottomElement.querySelector('.cart-amount');
            var cartElement = document.querySelector('.cart-main');

            document.querySelectorAll('.product').forEach( function(element) {
                // click Thêm sản phẩm
                element.querySelector('.product-add').onclick = function() {
                    this.style.display = 'none';
                    element.querySelector('.amount-groups').style.display = 'flex';

                    cart[element.querySelector('.product-id').innerText] = 1;
                    amountAll += 1;
                    cartHAmount.innerText = amountAll;
                    cartBAmount.innerText = amountAll;
                    cartBottomElement.style.display = 'flex';
                }

                // Click trừ số lượng
                element.querySelector('.amount-sub').onclick = function() {
                    cart[element.querySelector('.product-id').innerText] -= 1;
                    amountAll -= 1;
                    cartHAmount.innerText = amountAll;
                    cartBAmount.innerText = amountAll;
                    if (amountAll < 1) {
                        cartBottomElement.style.display = 'none';
                    }
                    if (cart[element.querySelector('.product-id').innerText] < 1) {
                        this.parentElement.style.display = 'none';
                        element.querySelector('.product-add').style.display = 'flex';
                        delete cart[element.querySelector('.product-id').innerText];
                    } else {
                        element.querySelector('.amount-number').innerText = cart[element.querySelector('.product-id').innerText];
                    }
                }
                // Click thêm số lượng
                element.querySelector('.amount-sum').onclick = function() {
                    cart[element.querySelector('.product-id').innerText] += 1;
                    amountAll += 1;
                    cartHAmount.innerText = amountAll;
                    cartBAmount.innerText = amountAll;
                    element.querySelector('.amount-number').innerText = cart[element.querySelector('.product-id').innerText];
                }
            });

            // click giỏ hàng
            document.querySelector('.header_navbar-cart').onclick = function() {
                fCart();
            }

            document.querySelector('.container-cart').onclick = function() {
                fCart();
            }

            function fCart() {
                if (amountAll > 0) {
                    $.ajax({
                        url: '/api/V1/product',
                        type: 'GET',
                        dataType: 'json'
                    })
                    .done(function(data) {
                        cartProduct = [];
                        cartPrice_old = 0;
                        cartElement.querySelector('ul').innerHTML = "";
                        for (value in cart) {
                            data.forEach( function(val) {
                                if (value == val['id']) {
                                    cartProduct.push({'id': val['id'], 'amount': cart[value]});

                                    var price = val['price'];
                                    if (val['discount'] != 0) {
                                        if (val['discountType'] == 0) { // Phần trăm
                                            price = price/100*(100-val['discount']);
                                        } else { // Giá tiền
                                            price = price-val['discount'];
                                        }
                                    }
                                    price = price*cart[value];
                                    cartPrice_old += price;

                                    var html = '<li class="cart-items">';
                                        html += '<span class="material-icons items-remove" data-id="'+val['id']+'">delete</span>';
                                        html += '<span class="items-amount"><span>'+cart[value]+'</span></span>';
                                        html += '<span class="items-content">'+val['name']+'</span>';
                                        html += '<span class="items-price">'+formatMoney(price)+'</span>';
                                        html += '</li>';

                                    // cartElement.querySelector('ul').innerHTML += html;
                                    $(".cart-main ul").append(html);
                                    // add sự kiện cho nút xóa sản phẩm khỏi giỏ hàng
                                    cartElement.querySelector('ul li:last-child .items-remove').onclick = function() {
                                        var parentElement = this.parentElement;
                                        var removeElement = this;
                                        var IdElement = this.getAttribute('data-id');

                                        // sử lý đơn giá
                                        data.forEach( function(dataValue, index) {
                                            if (IdElement == dataValue['id']) {
                                                var price = dataValue['price'];
                                                if (dataValue['discount'] != 0) {
                                                    if (dataValue['discountType'] == 0) { // Phần trăm
                                                        price = price/100*(100-dataValue['discount']);
                                                    } else { // Giá tiền
                                                        price = price-dataValue['discount'];
                                                    }
                                                }
                                                price = price*cart[IdElement];
                                                cartPrice_old -= price;

                                                // Cập nhật lại giá
                                                var money = calcMoney(cartPrice_old, cartDiscount['type'], cartDiscount['value']);
                                                cartDiscount['price'] = money['discountValue'];
                                                cartPrice_current = money['price_current'];

                                                cartElement.querySelector('.cart-price-all').innerHTML = '<b style="margin-right: 15px;">TỔNG:</b>'+formatMoney(cartPrice_old)+' Đ'
                                                cartElement.querySelector('.cart-price-discount i').innerText = formatMoney(money['discountValue']);
                                                cartElement.querySelector('.cart-price-pay').innerHTML = '<b style="margin-right: 15px;">THANH TOÁN:</b>'+formatMoney(cartPrice_current)+' Đ';
                                            }
                                        });


                                        // Cập nhật số lượng giỏ hàng
                                        amountAll -= parentElement.querySelector('.items-amount span').innerText;
                                        cartHAmount.innerText = amountAll;
                                        cartBAmount.innerText = amountAll;

                                        // Xóa bỏ sản phẩm khỏi giỏ hàng
                                        delete cart[this.getAttribute('data-id')];
                                        
                                        document.querySelectorAll('.product').forEach( function(productEl) {
                                            if (productEl.querySelector('.product-id').innerText == IdElement) {
                                                productEl.querySelector('.amount-groups').style.display = 'none';
                                                productEl.querySelector('.product-add').style.display = 'flex';
                                                productEl.querySelector('.amount-groups .amount-number').innerText = '1';
                                            }
                                        });

                                        cartProduct.forEach(function(cartProductEl, index) {
                                            if (cartProductEl.id == IdElement) {
                                                cartProduct.splice(index, 1);
                                            }
                                        });

                                        if (amountAll < 1) {
                                            // ẩn thanh giỏ hàng ở dưới
                                            cartBottomElement.style.display = 'none';
                                            // ẩn giao diện giỏ hàng
                                            cartElement.classList.add('hidden');
                                            document.querySelector('body').style.overflowY = 'scroll';
                                        }
                                        parentElement.remove();
                                    }
                                }
                            });
                        }

                        var money = calcMoney(cartPrice_old, cartDiscount['type'], cartDiscount['value']);
                        cartDiscount['price'] = money['discountValue'];
                        cartPrice_current = money['price_current'];

                        cartElement.querySelector('.cart-price-all').innerHTML = '<b style="margin-right: 15px;">TỔNG:</b>'+formatMoney(cartPrice_old)+' Đ'
                        cartElement.querySelector('.cart-price-discount i').innerText = formatMoney(money['discountValue']);
                        cartElement.querySelector('.cart-price-pay').innerHTML = '<b style="margin-right: 15px;">THANH TOÁN:</b>'+formatMoney(cartPrice_current)+' Đ';
                    })                    

                    cartElement.classList.remove('hidden');
                    document.querySelector('body').style.overflowY = 'hidden';
                }
            }

            // Click áp dụng mã khuyến mãi
            document.getElementById('btn-apply-coupon').onclick = function() {
                var parentElement = this.parentElement;
                $.ajax({
                    url: '/api/Order/voucher',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        code: parentElement.querySelector('input').value
                    },
                })
                .done(function(data) {
                    if (data.status) {
                        var money = calcMoney(cartPrice_old, data.discountType, data.discountValue);
                        cartDiscount['id'] = data.id;
                        cartDiscount['code'] = data.code;
                        cartDiscount['type'] = data.discountType;
                        cartDiscount['value'] = data.discountValue;
                        cartDiscount['price'] = money['discountValue'];
                        cartPrice_current = money['price_current'];

                        cartElement.querySelector('.cart-price-all').innerHTML = '<b style="margin-right: 15px;">TỔNG:</b>'+formatMoney(cartPrice_old)+' Đ'
                        cartElement.querySelector('.cart-price-discount i').innerText = formatMoney(money['discountValue']);
                        cartElement.querySelector('.cart-price-pay').innerHTML = '<b style="margin-right: 15px;">THANH TOÁN:</b>'+formatMoney(cartPrice_current)+' Đ';
                    } else {
                        ShowMsgBox('Lỗi', data.message, 'OK', 'fail');
                    }
                })
                .fail(function() {
                    ShowMsgBox('Lỗi mạng', 'Kiểm tra kết nối mạng', 'OK', 'fail');
                })                
            }

            function calcMoney(price_current, discountType, discountValue) {
                var data = new Array();
                data['price_old'] = price_current;
                if (discountValue == 0) {
                    data['discountValue'] = 0;
                    data['price_current'] = price_current;
                } else if (discountType == 1) {
                    data['price_current'] = price_current-discountValue;
                    if (data['price_current'] < 0){
                        data['discountValue'] = price_current;
                        data['price_current'] = 0;
                    } else {
                        data['discountValue'] = discountValue;
                    }
                } else {
                    data['discountValue'] = price_current/100*discountValue;
                    data['price_current'] = price_current-data['discountValue'];
                }

                return data;
            }

            // click nút quay lại trên giỏ hàng
            document.querySelector('.cart-main .btn-back').onclick = function() {
                cartElement.classList.add('hidden');
                document.querySelector('body').style.overflowY = 'scroll';
            }

            // Thanh toán Online
            document.querySelector('.btn-pay-online').onclick = function() {
                var id = new Date().getTime();
                var orderId = 'MM'+id;
                $.ajax({
                    url: '/api/Order/onlinePayment',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        product: cartProduct,
                        priceOrder: cartPrice_old,
                        priceDiscount: cartDiscount['price'],
                        pricePayment: cartPrice_current,
                        note: cartElement.querySelector('textarea').value,
                        table: document.getElementById('address').getAttribute('data-table'),
                        voucher: cartDiscount['id']
                    },
                })
                .done(function(data) {
                    if (data.status) {
                        var returnUrl = location.origin+'/order?TableId=<?php echo $table; ?>';
                        var data = `partnerCode=MOMOMAIA20201023&accessKey=QhKbvZbIzH3tmPIc&requestId=${orderId}&amount=${cartPrice_current}&orderId=${orderId}&orderInfo=Thanh toan hoa don&returnUrl=${returnUrl}&notifyUrl=${returnUrl}&extraData=Smart Sales Manager`;
                        var hmac = forge.hmac.create();
                        hmac.start('sha256', "dlqrE3Jjn0a9DvoDOEfqu3lh60kwFicb");
                        hmac.update(data);  
                        var hashText = hmac.digest().toHex();
                        var json = {"accessKey": "QhKbvZbIzH3tmPIc","partnerCode": "MOMOMAIA20201023","requestType": "captureMoMoWallet","notifyUrl": returnUrl, "returnUrl": returnUrl, "orderId": orderId, "amount": cartPrice_current+'', "orderInfo": "Thanh toan hoa don", "requestId": orderId+'', "extraData": "Smart Sales Manager", "signature": hashText+''};
                        $.ajax({
                            url: urlMomo,
                            type: 'POST',
                            dataType: 'json',
                            data: JSON.stringify(json),
                        })
                        .done(function(data) {
                            if (data.errorCode === 0) {
                                location.href = data.payUrl;
                            }
                        })
                    } else {
                        ShowMsgBox('Thất bại', data.message, 'OK', 'fail');
                    }
                })
                .fail(function() {
                    ShowMsgBox('Lỗi', 'Kiểm tra kết nối mạng', 'OK', 'fail');
                })
            }

            // Thanh toán Offline
            document.querySelector('.btn-pay-offline').onclick = function() {
                var orderId = new Date().getTime();
                $.ajax({
                    url: '/api/Order/offline',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: orderId,
                        product: cartProduct,
                        priceOrder: cartPrice_old,
                        priceDiscount: cartDiscount['price'],
                        pricePayment: cartPrice_current,
                        note: cartElement.querySelector('textarea').value,
                        table: document.getElementById('address').getAttribute('data-table'),
                        voucher: cartDiscount['id']
                    },
                })
                .done(function(data) {
                    if (data.status) {
                        ShowMsgBox('Thành công', data.message, 'OK');
                    } else {
                        ShowMsgBox('Thất bại', data.message, 'OK', 'fail');
                    }
                })
                .fail(function() {
                    ShowMsgBox('Lỗi', 'Kiểm tra kết nối mạng', 'OK', 'fail');
                })
            }


            // sử lý đã thanh toán
            <?php if (isset($momo)): ?>
                function checkPayment() {
                    var data = `partnerCode=MOMOMAIA20201023&accessKey=QhKbvZbIzH3tmPIc&requestId=<?php echo $momo['requestId'] ?>&orderId=<?php echo $momo['orderId'] ?>&requestType=transactionStatus`;
                    var hmac = forge.hmac.create();  
                    hmac.start('sha256', "dlqrE3Jjn0a9DvoDOEfqu3lh60kwFicb");
                    hmac.update(data);  
                    var hashText = hmac.digest().toHex();
                    var json = {
                        "partnerCode": "MOMOMAIA20201023",
                        "accessKey": "QhKbvZbIzH3tmPIc",
                        "requestId": '<?php echo $momo['requestId'] ?>',
                        "orderId": '<?php echo $momo['orderId'] ?>',
                        "requestType": "transactionStatus",
                        "signature": hashText+''};
                    $.ajax({
                        url: urlMomo,
                        type: 'POST',
                        dataType: 'json',
                        data: JSON.stringify(json),
                    })
                    .done(function(data) {
                        if (data.errorCode === 0) {
                            var id = data.orderId.substring(2);
                            $.ajax({
                                url: '/api/Order/online/'+id,
                                type: 'POST',
                                dataType: 'json'
                            })
                            .done(function(data) {
                                if (data.status) {
                                    ShowMsgBox('Thành công', data.message, 'OK');
                                } else {
                                    ShowMsgBox('Thất bại', data.message, 'OK', 'fail');
                                }
                            })
                            .fail(function() {
                                ShowMsgBox('Lỗi', 'Kiểm tra kết nối mạng', 'OK', 'fail');
                            })
                        }
                    })
                    .fail(function() {
                        ShowMsgBox('Thất bại', 'Thanh toán thất bại', 'OK', 'fail');
                    })
                }
                checkPayment();
            <?php endif ?>

        }, false);

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
    </script>
</body>
</html>