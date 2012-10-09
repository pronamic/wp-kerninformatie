<?php

/**
 * Get kerninformatie answers
 * 
 * @param int $question_id question id (1 = general, 2 = accomodation)
 * @param int $universal_objects univeral objects (empty array = all objects)
 * @param int $language_id language id (0 = all languages)
 * @param int $max_results maximum results (0 = all results)
 * @param boolean $sort_random sort random (true = random order)
 */
function kerninformatie_get_answers( $question_id = 1, $universal_objects = array(), $language_id = 0, $max_results = 0, $sort_random = true ) {
	return KerninformatiePlugin::get_answers( $question_id, $universal_objects, $language_id, $max_results, $sort_random );
}
