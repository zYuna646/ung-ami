/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        "color-primary-100": "#FCDCCF",
        "color-primary-200": "#FAB1A1",
        "color-primary-300": "#F27C70",
        "color-primary-400": "#E54C4B",
        "color-primary-500": "#D41728",
        "color-primary-600": "#B6102E",
        "color-primary-700": "#980B31",
        "color-primary-800": "#7A0731",
        "color-primary-900": "#650430",
        "color-success-100": "#E2FAD5",
        "color-success-200": "#C1F5AC",
        "color-success-300": "#91E17D",
        "color-success-400": "#64C457",
        "color-success-500": "#2D9E29",
        "color-success-600": "#1D8723",
        "color-success-700": "#147121",
        "color-success-800": "#0D5B1E",
        "color-success-900": "#074B1C",
        "color-info-100": "#CAF1FC",
        "color-info-200": "#98DDF9",
        "color-info-300": "#62BFED",
        "color-info-400": "#3B9DDC",
        "color-info-500": "#0570C6",
        "color-info-600": "#0356AA",
        "color-info-700": "#02408E",
        "color-info-800": "#012D72",
        "color-info-900": "#00205F",
        "color-warning-100": "#FCF5C9",
        "color-warning-200": "#F9E995",
        "color-warning-300": "#EED45F",
        "color-warning-400": "#DEBB37",
        "color-warning-500": "#C99A00",
        "color-warning-600": "#AC8000",
        "color-warning-700": "#906700",
        "color-warning-800": "#745000",
        "color-warning-900": "#604000",
        "color-danger-100": "#FCE6D1",
        "color-danger-200": "#FAC8A4",
        "color-danger-300": "#F2A074",
        "color-danger-400": "#E67951",
        "color-danger-500": "#D6421D",
        "color-danger-600": "#B82915",
        "color-danger-700": "#9A150E",
        "color-danger-800": "#7C090B",
        "color-danger-900": "#66050F"
      },
    },
  },
  plugins: [],
}