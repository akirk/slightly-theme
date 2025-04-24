/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	var container, button, menu, links, lastLink, i, len;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
        openCloseMenu();
	};
    
    function openCloseMenu() {
        if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
    }

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
    lastLink = links[links.length - 1 ];

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Closes the menu if the focus moves forward past the last item in the menu and if nothing in the menu is focused.
	 */
    lastLink.addEventListener('blur', function(){
        window.setTimeout(function(){
            var aNavLinkHasFocus = false;
            for (var i = 0; i < links.length; i++) {
                if (links[i] === document.activeElement) {
                    aNavLinkHasFocus = true;
                }
            }
            if (!aNavLinkHasFocus) {
                openCloseMenu();
            }
        }, 50);
    });

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}
            
			self = self.parentElement;
		}

    }

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );

	// add "copy to clipboard" functionality for the css selector ".copy-code code"
	document.addEventListener('DOMContentLoaded', function() {
		var copyCode = document.querySelectorAll('.copy-code code');
		for (var i = 0; i < copyCode.length; i++) {
			copyCode[i].style.cursor = 'pointer';
			copyCode[i].addEventListener('click', async function( e ) {
				const el = e.target;
				navigator.clipboard.writeText(this.textContent).then(function() {
					var tooltip = document.createElement('div');
					tooltip.textContent = 'Copied!';
					tooltip.style.position = 'absolute';
					tooltip.style.top = ( el.getBoundingClientRect().top - 30) + 'px';
					tooltip.style.left = ( el.getBoundingClientRect().left + 30 )+ 'px';
					tooltip.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
					tooltip.style.color = 'white';
					tooltip.style.padding = '0.2em';
					tooltip.style.borderRadius = '0.2em';
					tooltip.style.zIndex = '1000';
					el.append(tooltip);
					setTimeout(function() {
						tooltip.remove();
					}, 1000);
				});
			});
		}
	});
} )();
