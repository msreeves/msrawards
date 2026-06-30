/**
 * Close mobile offcanvas after in-panel navigation.
 */
document.addEventListener('DOMContentLoaded', function () {
	var panel = document.getElementById('msrAwardsMobileNav');
	if (!panel || typeof bootstrap === 'undefined') {
		return;
	}

	var desktop = window.matchMedia('(min-width: 992px)');

	panel.querySelectorAll('a[href]').forEach(function (link) {
		link.addEventListener('click', function () {
			if (desktop.matches) {
				return;
			}
			var instance = bootstrap.Offcanvas.getInstance(panel);
			if (instance) {
				instance.hide();
			}
		});
	});
});
