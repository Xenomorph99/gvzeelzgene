<?php
/**
 * Mailing list subscription form
 *
 * @version 1.0
 */

?>
<form id="mailing-list-form" class="mailing-list-form" action="" method="POST" data-api="<?php echo get_template_directory_uri() . '/api/mailing-list.php'; ?>">
	<input id="mailing-list-form-action" class="action" type="hidden" name="action" value="save">
	<input id="mailing-list-form-email" class="email" type="text" name="email" value="" placeholder="Email" required>
	<input id="mailing-list-form-submit" type="submit" value="Subscribe">
</form>
<script>
$(function() {
	$('#mailing-list-form').on('submit', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).data('api'),
			type: 'POST',
			dataType: 'json',
			data: $(this).serialize(),
			error: function() {
				alert('Could not save email address.  Try again later.');
			},
			success: function(resp) {
				if(resp.status === 'success') {
					alert(resp.message)
				} else {
					alert(resp.message);
				}
			}
		});
	});
});
</script>
