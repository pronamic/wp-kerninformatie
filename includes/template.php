<?php

function kerninformatie_get_answers( $question_id = 1, $universal_objects = array(), $language_id = 0, $max_results = 0, $sort_random = true ) {
	return KerninformatiePlugin::get_answers( $question_id, $universal_objects, $language_id, $max_results, $sort_random );
}
