/**
 * Dark Mode Toggle Functionality
 * Uses color-scheme CSS property with light-dark() function
 */
(function() {
    'use strict';

    const darkModeToggle = document.querySelector('.dark-mode-toggle');

    if (!darkModeToggle) {
        return;
    }

    // Check if user has a preference stored
    const currentTheme = localStorage.getItem('theme');

    // Set initial theme if user has a preference
    if (currentTheme) {
        document.documentElement.style.colorScheme = currentTheme;
    }

    // Toggle theme function
    function toggleTheme() {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const currentScheme = document.documentElement.style.colorScheme;

        // Determine current effective theme
        let effectiveTheme;
        if (currentScheme) {
            effectiveTheme = currentScheme;
        } else {
            effectiveTheme = prefersDark ? 'dark' : 'light';
        }

        // Toggle to opposite theme
        if (effectiveTheme === 'dark') {
            document.documentElement.style.colorScheme = 'light';
            localStorage.setItem('theme', 'light');
        } else {
            document.documentElement.style.colorScheme = 'dark';
            localStorage.setItem('theme', 'dark');
        }
    }

    // Add click event listener
    darkModeToggle.addEventListener('click', toggleTheme);

    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
        // Only update if user hasn't manually set a preference
        if (!localStorage.getItem('theme')) {
            // Reset to follow system preference
            document.documentElement.style.colorScheme = '';
        }
    });

})();