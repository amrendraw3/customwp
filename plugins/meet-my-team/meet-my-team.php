<?php
/**
 * Meet My Team
 *
 * Ever needed to display a lot of team members but you find it too lengthy to put into a single page? Meet My Team solves that problem by providing an intuitive interface that allows
 *	you to add your team members and display their information in a modal! Sounds great?
 *
 * @package   Meet My Team
 * @author    Aaron Lee <aaron.lee@buooy.com>
 * @license   GPL-2.0+
 * @link      http://buooy.com
 * @copyright 2014 Buooy
 *
 * Plugin Name:       Meet My Team
 * Plugin URI:        http://wordpress.org/support/plugin/meet-my-team
 * Description:       Ever needed to display a lot of team members but you find it too lengthy to put into a single page? Meet My Team solves that problem by providing an intuitive interface that allows you to add your team members and display their information in a modal! Sounds great?
 * Version:           1.2.2
 * Author:            Aaron Lee
 * Author URI:        http://buooy.com
 * Text Domain:       meet-my-team-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-meet-my-team.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-meet-my-team.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace Meet_My_Team with the name of the class defined in
 *   `class-meet-my-team.php`
 */
register_activation_hook( __FILE__, array( 'Meet_My_Team', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Meet_My_Team', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace Meet_My_Team with the name of the class defined in
 *   `class-meet-my-team.php`
 */
add_action( 'plugins_loaded', array( 'Meet_My_Team', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-meet-my-team-admin.php` with the name of the plugin's admin file
 * - replace Meet_My_Team_Admin with the name of the class defined in
 *   `class-meet-my-team-admin.php`
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-meet-my-team-admin.php' );
	add_action( 'plugins_loaded', array( 'Meet_My_Team_Admin', 'get_instance' ) );

}
