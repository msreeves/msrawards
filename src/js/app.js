/**
 * Theme JS + CSS entry — Vite → dist/app.js / dist/app.css
 * Vanilla modules only (no jQuery). Bootstrap bundled; Fancybox deferred when needed.
 */
import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;

import '../scss/app.scss';
import './filter-tabs.js';
import './scroll-reveal.js';
import './scroll-counter.js';
import './ajax.js';
import './mobile-nav.js';

function msrawardsLoadDeferredModules() {
	if (document.querySelector('[data-fancybox="gallery"]')) {
		import('./fancybox-init.js');
	}
}

if ('requestIdleCallback' in window) {
	requestIdleCallback(msrawardsLoadDeferredModules, { timeout: 2500 });
} else {
	document.addEventListener('DOMContentLoaded', msrawardsLoadDeferredModules);
}
