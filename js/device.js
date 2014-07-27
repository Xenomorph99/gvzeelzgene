/**
 * Definition of the Device object which controls all
 * functionality related specifically to the user's device.
 *
 * @require jquery.js
 */
var Device = {

	/**
	 * Define device variables and their default values
	 *
	 * @since Device 1.0
	 */
	type: 'desktop', // desktop, tablet, phone
	width: 0,
	height: 0,
	scrollTop: 0,

	/**
	 * Initialization function - Let's Get Everything Started!
	 *
	 * @since Device 1.0
	 */
	init: function() {

		// Set initial device values
		this.setDeviceType();
		this.setDimentions();
		this.setScrollTop();

		// Update dimentions on browser resize
		$(window).resize(function() {
			Device.setDimentions();
		});

		// Update the scrollTop value on page scroll
		$(window).scroll(function() {
			Device.setScrollTop();
		});

	},

	/**
	 * Set the device type (desktop, tablet, phone).
	 *
	 * @use Device.init()
	 * @since Device 1.0
	 */
	setDeviceType: function() {

		// Define variables
		var deviceType = navigator.userAgent.toLowerCase();

		// Determine the device type
		if(deviceType.match(/(iphone|ipod|ipad|android|blackberry)/)) {
			if(deviceType.match(/(ipad)/)) {
				this.type = 'tablet';
				this.setViewport(this.type);
			} else {
				this.type = 'phone';
				this.setViewport(this.type);
			}
		} else {
			this.type = 'desktop';
			this.setViewport(this.type);
		}

	},

	/**
	 * Set the HTML viewport attributes based upon device type.
	 *
	 * @use Device.setDeviceType()
	 * @since Device 1.0
	 */
	setViewport: function(deviceType) {

		switch(deviceType) {
			case 'tablet':
				//$body.append('<meta name="viewport" content="initial-scale=1, maximum-scale=1">');
				break;
			case 'phone':
				//$body.append('<meta name="viewport" content="initial-scale=0.5, maximum-scale=0.5">');
				break;
			default:
				// Do Nothing
		}

	},

	/**
	 * Set the device's height and width dimentions based on the
	 * size of the browser window viewing the site.
	 *
	 * @use Device.init()
	 * @since Device 1.0
	 */
	setDimentions: function() {

		// Set the width and height values
		this.width = $(window).width();
		this.height = $(window).height();

	},

	/**
	 * Set the scrollTop value based on the current number of
	 * pixels down the page the user has scrolled.
	 *
	 * @use Device.init()
	 * @since Device 1.0
	 */
	setScrollTop: function() {

		// Set the scrollTop value
		this.scrollTop = $(window).scrollTop();

	}

// END - Device object
};

$(function() {
	// Initiate the Device object
	Device.init();
});