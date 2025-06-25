import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react-swc'
import path from 'path' // import path module

export default defineConfig({
  plugins: [react()],
  resolve: {
    alias: {
      src: path.resolve(__dirname, 'src'), // enables '@import "src/..."'
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        // You can optionally inject global SCSS variables or mixins here
        additionalData: ``,
      },
    },
  },
})
