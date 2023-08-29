/** @type {import('tailwindcss').Config} */
module.exports = {
	darkMode: "class",
	theme: {
		colors: {
			coffee: {
				100: "hsl(26, 100%, 50%)",
				300: "hsl(26, 100%, 30%)",
				600: "hsl(26, 100%, 20%)",
				800: "hsl(26, 100%, 15%)",
				900: "hsl(26, 100%, 12%)",
				950: "#291200"
			}
		}
	},
	content: [
		"./assets/**/*.{html,js,tsx}",
		"./templates/**/*.html.twig",
		"./node_modules/flowbite/**/*.js"
	],
	theme: {
		extend: {}
	},
	plugins: [require("flowbite/plugin")]
};
