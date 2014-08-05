<?php

$s = '<form id="mailing-list-form" class="mailing-list-form" method="POST" data-api="' . get_template_directory_uri() . '/api/mailing-list.php">';
$s .= '<input id="mailing-list-form-email" type="text" placeholder="Email" required>';
$s .= '<input id="mailing-list-form-submit" type="submit" value="Subscribe">';
$s .= '<script src="' . get_template_directory_uri() . '/js/mailing-list.js"></script>';
$s .= '</form>';