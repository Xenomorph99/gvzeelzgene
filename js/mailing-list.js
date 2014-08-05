$('#mailing-list-form').on('submit', function(e) {
	e.preventDefault;
	var data = {
		action: 'save',
		email: $('#mailing-list-form-email').val()
	};
	console.log(data);
	$.ajax({
		url: $('#mailing-list-form').data('api'),
		method: 'POST',
		data: data,
		error: function() {
			alert('An Error Has Occured');
		},
		success: function(resp) {
			alert(resp.message);
		}
	});
});