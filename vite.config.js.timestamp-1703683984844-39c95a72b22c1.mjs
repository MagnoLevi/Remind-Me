// vite.config.js
import { defineConfig } from "file:///C:/projects/remind_me/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/projects/remind_me/node_modules/laravel-vite-plugin/dist/index.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/css/base_styles.css",
        "resources/js/app.js"
      ],
      refresh: true
    })
  ],
  server: {
    open: true,
    origin: "http://127.0.0.1:8000/"
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxwcm9qZWN0c1xcXFxyZW1pbmRfbWVcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXHByb2plY3RzXFxcXHJlbWluZF9tZVxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzovcHJvamVjdHMvcmVtaW5kX21lL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSBcInZpdGVcIjtcbmltcG9ydCBsYXJhdmVsIGZyb20gXCJsYXJhdmVsLXZpdGUtcGx1Z2luXCI7XG5cbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gICAgcGx1Z2luczogW1xuICAgICAgICBsYXJhdmVsKHtcbiAgICAgICAgICAgIGlucHV0OiBbXG4gICAgICAgICAgICAgICAgXCJyZXNvdXJjZXMvY3NzL2FwcC5jc3NcIixcbiAgICAgICAgICAgICAgICBcInJlc291cmNlcy9jc3MvYmFzZV9zdHlsZXMuY3NzXCIsXG4gICAgICAgICAgICAgICAgXCJyZXNvdXJjZXMvanMvYXBwLmpzXCJcbiAgICAgICAgICAgIF0sXG4gICAgICAgICAgICByZWZyZXNoOiB0cnVlLFxuICAgICAgICB9KSxcbiAgICBdLFxuICAgIHNlcnZlcjoge1xuICAgICAgICBvcGVuOiB0cnVlLFxuICAgICAgICBvcmlnaW46IFwiaHR0cDovLzEyNy4wLjAuMTo4MDAwL1wiLFxuICAgIH0sXG59KTtcblxuXG4vLyBpbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tICd2aXRlJztcbi8vIGltcG9ydCBsYXJhdmVsLCB7IHJlZnJlc2hQYXRocyB9IGZyb20gJ2xhcmF2ZWwtdml0ZS1wbHVnaW4nO1xuXG4vLyBleHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuLy8gICAgIHBsdWdpbnM6IFtcbi8vICAgICAgICAgbGFyYXZlbCh7XG4vLyAgICAgICAgICAgICBpbnB1dDogW1xuLy8gICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvY3NzL2FwcC5jc3MnLFxuLy8gICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvYXBwLmpzJyxcbi8vICAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2NoYXJhY3Rlcl9jcmVhdGlvbi5qcycsXG4vLyAgICAgICAgICAgICBdLFxuLy8gICAgICAgICAgICAgcmVmcmVzaDogW1xuLy8gICAgICAgICAgICAgICAgIC4uLnJlZnJlc2hQYXRocyxcbi8vICAgICAgICAgICAgICAgICAnYXBwL0h0dHAvTGl2ZXdpcmUvKionLFxuLy8gICAgICAgICAgICAgXSxcbi8vICAgICAgICAgfSksXG4vLyAgICAgXSxcbi8vIH0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUF1UCxTQUFTLG9CQUFvQjtBQUNwUixPQUFPLGFBQWE7QUFFcEIsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDeEIsU0FBUztBQUFBLElBQ0wsUUFBUTtBQUFBLE1BQ0osT0FBTztBQUFBLFFBQ0g7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLE1BQ0o7QUFBQSxNQUNBLFNBQVM7QUFBQSxJQUNiLENBQUM7QUFBQSxFQUNMO0FBQUEsRUFDQSxRQUFRO0FBQUEsSUFDSixNQUFNO0FBQUEsSUFDTixRQUFRO0FBQUEsRUFDWjtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
