#!/usr/bin/env node
/**
 * Assert that every place this plugin states its version agrees.
 *
 * WordPress reads the plugin header, wordpress.org reads readme.txt's
 * "Stable tag", and tooling reads package.json. When they drift, the plugin
 * ships one version while the release metadata claims another. This has
 * happened repeatedly here, so it is checked in CI rather than by eye.
 *
 * Exits non-zero, listing every source and its value, when they disagree.
 */
import fs from 'node:fs';
import path from 'node:path';

const root = process.cwd();
const sources = [];

// package.json
const pkg = JSON.parse(fs.readFileSync(path.join(root, 'package.json'), 'utf8'));
sources.push({ file: 'package.json', field: 'version', value: pkg.version });

// The main plugin file is the top-level .php carrying a Plugin Name header.
const phpFiles = fs.readdirSync(root).filter((f) => f.endsWith('.php'));
let mainPhp = null;
for (const file of phpFiles) {
	const head = fs.readFileSync(path.join(root, file), 'utf8').slice(0, 4096);
	if (/^\s*\*?\s*Plugin Name\s*:/im.test(head)) {
		mainPhp = file;
		const match = head.match(/^\s*\*?\s*Version\s*:\s*(\S+)\s*$/im);
		sources.push({
			file,
			field: 'Version header',
			value: match ? match[1] : null,
		});
		break;
	}
}
if (!mainPhp) {
	console.error('No plugin file with a "Plugin Name" header found.');
	process.exit(1);
}

// readme.txt casing is inconsistent across these repos. A missing readme is
// recorded as a null source rather than skipped, so renaming or dropping it
// fails this check instead of quietly removing WordPress.org release metadata
// from the things being validated.
const readme = fs.readdirSync(root).find((f) => f.toLowerCase() === 'readme.txt');
if (!readme) {
	sources.push({ file: 'readme.txt', field: 'Stable tag', value: null });
} else {
	const head = fs.readFileSync(path.join(root, readme), 'utf8').slice(0, 4096);
	const match = head.match(/^\s*Stable tag\s*:\s*(\S+)\s*$/im);
	sources.push({ file: readme, field: 'Stable tag', value: match ? match[1] : null });
}

// A version constant, if the plugin defines one.
const constHead = fs.readFileSync(path.join(root, mainPhp), 'utf8');
const constMatch = constHead.match(/define\(\s*'([A-Z0-9_]*_VER)'\s*,\s*'([^']+)'\s*\)/);
if (constMatch) {
	sources.push({ file: mainPhp, field: constMatch[1], value: constMatch[2] });
}

const missing = sources.filter((s) => !s.value);
const values = [...new Set(sources.filter((s) => s.value).map((s) => s.value))];

for (const s of sources) {
	console.log(`  ${s.value ?? '(not found)'}\t${s.file} — ${s.field}`);
}

if (missing.length) {
	console.error(`\nCould not read a version from: ${missing.map((m) => `${m.file} (${m.field})`).join(', ')}`);
	process.exit(1);
}

if (values.length > 1) {
	console.error(`\nVersion mismatch: found ${values.join(', ')}. All sources must agree.`);
	process.exit(1);
}

console.log(`\nAll version sources agree on ${values[0]}.`);
