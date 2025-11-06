import { defineConfig } from 'vite';
import nette from '@nette/vite-plugin';
import { fileURLToPath, URL } from 'node:url'
import { resolve, dirname } from 'node:path'


export default defineConfig({
	plugins: [
		nette({
			entry: 'main.js',
		}),
	],
	resolve: {
		alias: {
			'~bootstrap': resolve(dirname(fileURLToPath(import.meta.url)), 'node_modules/bootstrap'),
			'@': fileURLToPath(new URL('./src', import.meta.url))
		},
		extensions: [
			'.js',
			'.json',
			'.jsx',
			'.mjs',
			'.ts',
			'.tsx',
			'.vue',
		],
	},
	build: {
		emptyOutDir: true,
	},

	css: {
		preprocessorOptions: {
			scss: {
			silenceDeprecations: [
				'import',
				'mixed-decls',
				'color-functions',
				'global-builtin',
			],
			},
		},		
		devSourcemap: true,
	},
	
});
