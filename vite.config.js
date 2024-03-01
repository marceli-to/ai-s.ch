import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';
const path = require('path');

export default defineConfig({
  resolve: {
    alias: {
      '@' : path.resolve(__dirname, './resources/js/'),
      img: resolve('resources/img'),
      fonts: resolve('resources/css/fonts')
    }
  },
  plugins: [
    vue(),
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/form/forms.js',
      ],
      refresh: true,
    }),
      //vue(),
  ],
});
