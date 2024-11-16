module.exports = {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
      "./node_modules/flowbite/**/*.js"
    ],
    theme: {
      extend: {
        colors: {
          // primary: '#112143',
          primary: '#fff',
          // secondary: '#071739',
          secondary: '#f9f9f9',
            common:'#838B76'
        }
      },
    },
    plugins: [
        require('flowbite/plugin')
    ],
  }