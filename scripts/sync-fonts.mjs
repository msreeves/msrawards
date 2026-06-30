#!/usr/bin/env node
/**
 * Download Notable woff2 for self-hosted fonts (run before vite build).
 */
import { mkdirSync, existsSync } from 'node:fs';
import { writeFileSync } from 'node:fs';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const __dirname = dirname( fileURLToPath( import.meta.url ) );
const themeRoot = resolve( __dirname, '..' );
const fontDir = resolve( themeRoot, 'src/assets/fonts' );
const fontPath = resolve( fontDir, 'notable-latin.ttf' );
const fontUrl =
	'https://fonts.gstatic.com/s/notable/v20/gNMEW3N_SIqx-WX9-HM.ttf';

if ( ! existsSync( fontDir ) ) {
	mkdirSync( fontDir, { recursive: true } );
}

if ( existsSync( fontPath ) ) {
	process.exit( 0 );
}

const res = await fetch( fontUrl );
if ( ! res.ok ) {
	console.error( `sync-fonts: failed to fetch Notable (${res.status})` );
	process.exit( 1 );
}

const buf = Buffer.from( await res.arrayBuffer() );
writeFileSync( fontPath, buf );
console.log( 'sync-fonts: wrote notable-latin.ttf' );
