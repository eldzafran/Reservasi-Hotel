import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],

  theme: {
    extend: {
      colors: {
        primary: '#0194F3',       // traveloka blue
        'primary-dark': '#0175C0',
        accent: '#FF5C00',        // traveloka orange
        ink: '#0F172A',           // slate-900-ish
      },
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
      },
      boxShadow: {
        soft: '0 8px 24px rgba(2, 6, 23, 0.08)',
      },
    },
  },

  plugins: [forms],
};
