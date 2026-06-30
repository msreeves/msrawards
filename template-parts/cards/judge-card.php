<?php
/**
 * Judge archive card (award panel listing).
 *
 * @package msrawards
 */

get_template_part(
	'template-parts/cards/nominee-card',
	null,
	array(
		'show_award_terms' => true,
	)
);
