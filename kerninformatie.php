<?php
/*
Plugin Name: Kerninformatie
Plugin URI: http://pronamic.eu/wordpress/kerninformatie/
Description: The WordPress Kerninformatie plugin can display answers from the Kerninformatie application.

Version: 0.1
Requires at least: 3.0

Author: Pronamic
Author URI: http://pronamic.eu/

Text Domain: kerninformatie
Domain Path: /languages/

License: GPL
*/

class KerninformatiePlugin {
	/**
	 * The API URL
	 * 
	 * @var string
	 */
	const API_URL = 'http://api.kerninformatie.nl/?questionnairePublicationManager&wsdl';

	////////////////////////////////////////////////////////////

	/**
	 * Client
	 * 
	 * @var SoapClient
	 */
	private static $client;

	////////////////////////////////////////////////////////////

	/**
	 * Bootstrap
	 */
	public static function bootstrap() {
		add_action( 'init', array( __CLASS__, 'init' ) );
		add_action( 'admin_init' ,array( __CLASS__, 'admin_init' ) );
	}

	////////////////////////////////////////////////////////////

	/**
	 * Initialize
	 */
	public static function init() {
		// Text domain
		$relPath = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	
		load_plugin_textdomain( 'kerninformatie', false, $relPath );

		// Shortcodes
		add_shortcode( 'kerninformatie_answers', array( __CLASS__, 'shortcode_answers' ) );
		add_shortcode( 'kerninformatie_scores', array( __CLASS__, 'shortcode_scores' ) );
	}

	////////////////////////////////////////////////////////////

	/**
	 * Admin initialize
	 */
	public static function admin_init() {
		// Section
		add_settings_section(
			'kerninformatie_settings_section' , // $id
			__( 'Kerninformatie', 'kerninformatie' ) , // $title
			array( __CLASS__, 'settings_section' ) , // $callback 
			'general' // $page
		);

		// Fields
		add_settings_field(
			'kerninformatie_username' , // $id
			__( 'Username', 'kerninformatie' ) , // $title
			array( __CLASS__, 'settings_username_field' ) , // $callback 
			'general' , // $page
			'kerninformatie_settings_section' // $section
		);

		add_settings_field(
			'kerninformatie_password' , // $id
			__( 'Password', 'kerninformatie' ) , // $title
			array( __CLASS__, 'settings_password_field' ) , // $callback 
			'general' , // $page
			'kerninformatie_settings_section' // $section
		);

		add_settings_field(
			'kerninformatie_company_id' , // $id
			__( 'Company ID', 'kerninformatie' ) , // $title
			array( __CLASS__, 'settings_company_id_field' ) , // $callback 
			'general' , // $page
			'kerninformatie_settings_section' // $section
		);
 	
		// Settings
		register_setting( 'general', 'kerninformatie_username' );
		register_setting( 'general', 'kerninformatie_password' );
		register_setting( 'general', 'kerninformatie_company_id' );
	}

	public static function settings_section() {
		
	}

	public static function settings_username_field() {
		?><input type="text" class="regular-text" value="<?php form_option( 'kerninformatie_username' ); ?>" id="kerninformatie_username" name="kerninformatie_username" /><?php
	}

	public static function settings_password_field() {
		?><input type="password" class="regular-text" value="<?php form_option( 'kerninformatie_password' ); ?>" id="kerninformatie_password" name="kerninformatie_password" /><?php
	}

	public static function settings_company_id_field() {
		?><input type="text" class="regular-text" value="<?php form_option( 'kerninformatie_company_id' ); ?>" id="kerninformatie_company_id" name="kerninformatie_company_id" /><?php
	}

	////////////////////////////////////////////////////////////

	/**
	 * Get client
	 * 
	 * @return SoapClient
	 */
	public static function get_client() {
		if ( ! isset( self::$client ) ) {
			self::$client = new SoapClient( self::API_URL );
		}

		return self::$client;
	}

	////////////////////////////////////////////////////////////
	
	/**
	 * Shortcode scores
	 * 
	 * @param array $atts
	 */
	public static function shortcode_scores( $atts ) {
		$return = '';
	
		$client = self::get_client();
	
		$username  = get_option( 'kerninformatie_username' );
		$password  = get_option( 'kerninformatie_password' );
		$company_id = get_option( 'kerninformatie_company_id' );
	
		// Scores
		$response = $client->getScores( $username, $password, $company_id );

		$scores = new SimpleXMLElement( $response );

		ob_start();
		include 'templates/scores.php';
		$return = ob_get_clean();

		return $return;
	}
	
	/**
	 * Shortcode answers
	 * 
	 * @param array $atts
	 */
	public static function shortcode_answers( $atts ) {
		extract( shortcode_atts( array(
			'question_id' => 1 ,
			'universal_objects' => array() ,
			'language_id' => 0 , 
			'max_results' => 0 ,
			'sort_random' => true 
		), $atts ) );

		$return = '';

		$client = self::get_client();
	
		$username  = get_option( 'kerninformatie_username' );
		$password  = get_option( 'kerninformatie_password' );
		$company_id = get_option( 'kerninformatie_company_id' );

		// Answers
		$response = $client->getAnswers( 
			$username, $password, $company_id, $question_id, $universal_objects, 
			$language_id, $max_results, $sort_random 
		);

		$answers = new SimpleXMLElement( $response );

		ob_start();
		include 'templates/answers.php';
		$return = ob_get_clean();
	
		return $return;
	}
}

KerninformatiePlugin::bootstrap();
