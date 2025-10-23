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

    function updateIcon(showAutoIcon = false) {
        const currentScheme = document.documentElement.style.colorScheme;
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (currentScheme === 'light') {
            lightIcon.style.display = 'block';
            darkIcon.style.display = 'none';
            autoIcon.style.display = 'none';
        } else if (currentScheme === 'dark') {
            lightIcon.style.display = 'none';
            darkIcon.style.display = 'block';
            autoIcon.style.display = 'none';
        } else {
            // Auto mode
            if (showAutoIcon) {
                // Show auto icon when user clicks into auto mode
                lightIcon.style.display = 'none';
                darkIcon.style.display = 'none';
                autoIcon.style.display = 'block';
            } else {
                // On page load, show sun/moon based on system preference
                lightIcon.style.display = prefersDark ? 'none' : 'block';
                darkIcon.style.display = prefersDark ? 'block' : 'none';
                autoIcon.style.display = 'none';
            }
        }
    }

    // Check if user has a preference stored
    const currentTheme = localStorage.getItem('theme');

    // Set initial theme if user has a preference
    if (currentTheme) {
        document.documentElement.style.colorScheme = currentTheme;
    }

    // On page load, don't show auto icon
    updateIcon(false);

    // Toggle theme function (three-state: light → dark → auto)
    function toggleTheme() {
        const currentScheme = document.documentElement.style.colorScheme;

        if (currentScheme === 'light') {
            // Light → Dark
            document.documentElement.style.colorScheme = 'dark';
            localStorage.setItem('theme', 'dark');
            updateIcon(false);
        } else if (currentScheme === 'dark') {
            // Dark → Auto (system preference)
            document.documentElement.style.colorScheme = '';
            localStorage.removeItem('theme');
            updateIcon(true); // Show auto icon when clicking into auto mode
        } else {
            // Auto → Light
            document.documentElement.style.colorScheme = 'light';
            localStorage.setItem('theme', 'light');
            updateIcon(false);
        }

        darkModeToggle.blur();
    }

    // Add click event listener
    darkModeToggle.addEventListener('click', toggleTheme);

    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
        // Only update if user hasn't manually set a preference
        if (!localStorage.getItem('theme')) {
            // Reset to follow system preference
            document.documentElement.style.colorScheme = '';
            updateIcon(false);
        }
    });

})();