document.addEventListener('DOMContentLoaded', function() {
  	// mini menu user
	var btnUser = document.querySelector('.user-pane');
	btnUser.onclick = function() {
		this.classList.toggle('active');
	}

  	// Logout
	document.getElementById('btnLogout').onclick = function() {
		$.ajax({
			url: './api/Logout',
			type: 'POST',
			dataType: 'json'
		})
		.done(function() {
			// window.location = "/admin/Login";
			location.reload();
		})
		.fail(function() {
			console.error("error");
		})
	}

	// Nút ẩn/hiện slide bar
	var btnActiveSlideBar = document.querySelector('.header__pane');
	var slideBarElement = document.querySelector('.app-slidebar');
	var appMain = document.querySelector('.app-main__outer');

	btnActiveSlideBar.onclick = function() {
		if (this.classList.contains('showbar')) {
			this.classList.remove('showbar');
			this.classList.add('hidebar');
			// document.querySelector('body').style.overflowX = 'unset';
			slideBarElement.classList.add('hidebar');
			setTimeout(function() {
				appMain.classList.add('full-width');
			}, 700);
		} else {
			appMain.classList.remove('full-width', 'mobile');
			// appMain.classList.remove('full-width');
			// document.querySelector('body').style.overflowX = 'hidden';
			setTimeout(function() {
				btnActiveSlideBar.classList.remove('hidebar');
				btnActiveSlideBar.classList.add('showbar');
				slideBarElement.classList.remove('hidebar');
			}, 200);
		}
	}

	// Slide bar
	var btnSlideBar = document.querySelectorAll('.nav-menu__title.dropdown-mm');
	// click menu có menu con
	btnSlideBar.forEach(function(el) {
		el.addEventListener('click', function() {
			var parentElement = this.parentElement;
			var miniMenu = parentElement.querySelector('.mini-menu');
			if (miniMenu.clientHeight) {
				miniMenu.style.height = 0;
			} else {
				miniMenu.style.height = (parentElement.querySelector('.mm-collapse').clientHeight + 3) + "px";
			}
			this.querySelector('.nav-menu__title-icon').classList.toggle('active');
		})
	})

	// click Menu không mini menu hoặc item menu con
	var slideBarActive = document.querySelectorAll('.nav-menu__title.slidebar-btn');
	var miniMenuItems = document.querySelectorAll('.mm-collapse li');
	slideBarActive.forEach( function(el) {
		el.addEventListener('click', function() {
			slideBarActive.forEach( function(element) {
				element.classList.remove('active');
			});
			miniMenuItems.forEach( function(element) {
				element.classList.remove('active');
			});
			this.classList.add('active');
		})
	});
	miniMenuItems.forEach(function(el) {
		el.addEventListener('click', function() {
			slideBarActive.forEach( function(element) {
				element.classList.remove('active');
			});
			miniMenuItems.forEach( function(element) {
				element.classList.remove('active');
			});
			this.classList.add('active');
		})
	})
	$.ajaxPrefilter(function(options, original_Options, jqXHR) { 
	    options.async = true; 
	}); 

	var appMainBody = document.getElementById('app-main__inner');
	document.querySelectorAll('.nav-menu__title.slidebar-btn').forEach( function(element, index) {
		element.addEventListener('click', function() {
			var elID = this.getAttribute('id');
			if (appMainBody.getAttribute('data-inner') != elID) {
				document.querySelector('.loading-app-main').classList.remove('hidden');
				$.ajax({
					url: '/admin/'+elID,
					type: 'GET',
					dataType: 'html'
				})
				.done(function(data) {
					$('#app-main__inner').html(data);
					appMainBody.setAttribute('data-inner', elID);
				})
				.fail(function(data) {
					// console.log(data);
				})
				.always(function() {
					document.querySelector('.loading-app-main').classList.add('hidden');
				});
			}
		})
	});

	// document.addEventListener("load", function(){
 //    	document.querySelector('.loading-page').classList.add('hidden');
	// });
	// $(window).load(function() {
	// 	document.querySelector('.loading-page').classList.add('hidden');
	// })
	document.addEventListener('readystatechange', function(event) { 
	    // When window loaded ( external resources are loaded too- `css`,`src`, etc...) 
	    if (event.target.readyState === "complete") {
	    	document.querySelector('.loading-page').classList.add('hidden');   
	    }
	});
},false);