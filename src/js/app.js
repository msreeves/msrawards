/**
 * Theme JS + CSS entry — Vite → dist/app.js / dist/app.css
 * Vanilla modules only (no jQuery). Bootstrap + Fancybox bundled (Phase 19).
 */
import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;

import '../scss/app.scss';
import './filter-tabs.js';
import './scroll-reveal.js';
import './scroll-counter.js';
import './fancybox-init.js';
import './ajax.js';
import './mobile-nav.js';
