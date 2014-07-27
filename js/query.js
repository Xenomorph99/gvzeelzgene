/**
 * Definition of the Query object which controlls functionality related
 * to values passed in the URL query string.
 *
 * @require jquery.js
 */
var Query = {

	/**
	 * Initialization Function - Let's Get Everything Started!
	 *
	 * @since Query 1.0
	 */
	init: function() {

		// Do Nothing

	},

	/**
	 * Function that retrieves the value of a specific query parameter from
	 * the URL.
	 *
	 * @since Query 1.0
	 *
	 * @param query parameter key
	 * @return associated value, else an empty string
	 */
	value: function(queryKey) {

		var key = queryKey.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regexS = "[\\?&]" + key + "=([^&#]*)";
		var regex = new RegExp(regexS);
		var results = regex.exec(window.location.search);
		if(results === null) {
			return "";
		} else {
			return decodeURIComponent(results[1].replace(/\+/g, " "));
		}

	}

// END - Query object
};

$(function() {
	// Initiate the Query object
	Query.init();
});