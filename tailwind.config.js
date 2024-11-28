/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.vue"],
  theme: {
    extend: {
      colors: {
        primary: "#a06544",
        secondary: "#86887a",
        border: "#D9C1B4",
      },
      boxShadow: {
        "custom-brown":
          "0 4px 6px -1px rgba(160, 101, 68, 0.2), 0 2px 4px -1px rgba(160, 101, 68, 0.1)",
      },
      zIndex: {
        '60': '60',
        '70': '70',
      },
    },
  },
  plugins: [],
};
