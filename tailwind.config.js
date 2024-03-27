/** @type {import('tailwindcss').Config} */
let tailwindcss=require("tailwindcss")

module.exports = {
  content: [],
  theme: {
    extend: {},
  },
  plugins: [
    tailwindcss('./tailwind.config.js'),
    require('postcss-import'),
    require('autoprefixer')
  ],
}

