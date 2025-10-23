/**
 * Dark Mode Toggle Functionality
 * Uses color-scheme CSS property with light-dark() function
 */
(function() {
    'use strict';

    const darkModeToggle = document.querySelector('.dark-mode-toggle');
    const lightIcon = document.querySelector('.light-icon');
    const darkIcon = document.querySelector('.dark-icon');
    const autoIcon = document.querySelector('.auto-icon');

    if (!darkModeToggle) {
        return;
    }

    function updateIcon() {
        const currentScheme = document.documentElement.style.colorScheme;

        lightIcon.style.display = currentScheme === 'light' ? 'block' : 'none';
        darkIcon.style.display = currentScheme === 'dark' ? 'block' : 'none';
        autoIcon.style.display = (!currentScheme || currentScheme === '') ? 'block' : 'none';
    }

    // Check if user has a preference stored
    const currentTheme = localStorage.getItem('theme');

    // Set initial theme if user has a preference
    if (currentTheme) {
        document.documentElement.style.colorScheme = currentTheme;
    }

    updateIcon();

    // Toggle theme function (three-state: light → dark → auto)
    function toggleTheme() {
        const currentScheme = document.documentElement.style.colorScheme;

        if (currentScheme === 'light') {
            // Light → Dark
            document.documentElement.style.colorScheme = 'dark';
            localStorage.setItem('theme', 'dark');
        } else if (currentScheme === 'dark') {
            // Dark → Auto (system preference)
            document.documentElement.style.colorScheme = '';
            localStorage.removeItem('theme');
        } else {
            // Auto → Light
            document.documentElement.style.colorScheme = 'light';
            localStorage.setItem('theme', 'light');
        }

        updateIcon();
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