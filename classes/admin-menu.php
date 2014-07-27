<?php
/**
 * This model creates and adds custom admin menus to Wordpress.
 *
 * Required classes: Database, Encryption, Functions
 *
 * @author Colton James Wiscombe <colton@hazardmediagroup.com>
 * @copyright 2014 Hazard Media Group LLC
 * @version 1.1.1
 */

class Admin_Menu {

	public $settings = array(
		'title' => '',						// Admin menu title (will be converted and used as html ID attr)
		'display_name' => '',				// Admin menu display name in the sidebar nav
		'capability' => 'manage_options',	// Required capability for the admin menu to be displayed to the user
		'view' => NULL,						// Path to the admin menu view (if set to null a default view will be created)
		'defaults' => array(),				// Array of default key/value pairs
		'table' => NULL						// Table array (defined if Admin_Menu is created by a Meta_Box class)
	);

	public function __construct( $arr ) {

		$this->settings = Functions::merge_array( $arr, $this->settings );
		$this->settings['id'] = Functions::str_smash( $this->settings['title'] );
		$this->settings['display_name'] = ( empty( $this->settings['display_name'] ) ) ? $this->settings['title'] : $this->settings['display_name'];
		
		$this->save_default_values();
		$this->wp_hooks();

	}

	protected function save_default_values() {

		extract( $this->settings );

		foreach( $defaults as $name => $value ) {
			if( $name !== 'id' && $name !== 'post_id' ) {
				if( !get_option( $id . '_' . $name ) ) {
					add_option( $id . '_' . $name, $value );
				}
			}
		}

	}

	protected function wp_hooks() {

		// Create the admin menu
		add_action( 'admin_menu', array( &$this, 'setup_admin_menu' ) );

		// Update the admin menu options
		add_action( 'admin_init', array( &$this, 'save_admin_menu' ) );

	}

	public function setup_admin_menu() {

		extract( $this->settings );

		add_options_page( $title, $display_name, $capability, $id, array( &$this, 'setup_admin_menu_view' ) );

	}

	public function setup_admin_menu_view() {

		if( !empty( $view ) ) {
			extract( $this->settings );
			include_once $view;	
		} else {
			$this->default_admin_menu_view();
		}

	}

	public function default_admin_menu_view() {

		extract( $this->settings );
		$prefix = $table['prefix'] . '_';

		echo "<div id='$id' class='wrap'>";
		echo "<h2>$title</h2>";
		echo "<form method='post' action='options-general.php?page=$id'>";

		echo $this->form_fields();
		echo $this->default_buttons();

		echo "</form>";
		echo "</div><!--.wrap-->";

	}

	public function form_fields() {

		extract( $this->settings );
		if( !empty( $table ) ) {

			$s = "<table class='form-table meta-box-form-section'>";
			$s .= "<tbody>";
			foreach( $defaults as $key => $value ) {
				$field_type = $table['structure'][$key][3];
				$label = ( !empty( $table['structure'][$key][5] ) ) ? $table['structure'][$key][5] : NULL;
				$options = ( !empty( $table['structure'][$key][4] ) ) ? $table['structure'][$key][4] : NULL;
				$s .= $this->field( $field_type, $key, $label, NULL, NULL, $options );
			}
			$s .= "</tbody>";
			$s .= "</table>";
			return $s;

		} else {

			$s = "<table class='form-table meta-box-form-section'>";
			$s .= "<tbody>";



			$s .= "</tbody>";
			$s .= "</table>";
			return $s;

		}

	}

	public function default_buttons() {

		$s = "<p class='submit'>";
		$s .= "<input type='submit' name='submit' id='submit' class='button button-primary' value='Save Changes'>";
		$s .= "</p>";
		return $s;

	}

	public function field( $type, $key, $label = NULL, $id = NULL, $title = NULL, $options = array() ) {

		$field = '';
		$id = ( isset( $id ) ) ? $id : $this->settings['id'] . '-' . $key;
		$label = ( isset( $label ) ) ? $label : ucwords( $key );
		$name = $this->settings['id'] . '_' . $key;
		$value = stripslashes( get_option( $this->settings['id'] . '_' . $key, $this->settings['defaults'][$key] ) );

		switch( $type ) {
			case 'text' :

				$field .= "<tr>";
				$field .= "<th scope='row'><label for='$id'>$label</label></th>";
				$field .= '<td><input type="' . $type . '" id="' . $id . '" name="' . $name . '" value="' . $value . '"></td>';
				$field .= "</tr>";

				break;
			case 'number' :

				$field .= "<tr>";
				$field .= "<th scope='row'><label for='$id'>$label</label></th>";
				$field .= '<td><input type="' . $type . '" id="' . $id . '" name="' . $name . '" value="' . $value . '"></td>';
				$field .= "</tr>";

				break;
			case 'password' :

				$field .= "<tr>";
				$field .= "<th scope='row'><label for='$id'>$label</label></th>";
				$field .= '<td><input type="' . $type . '" id="' . $id . '" name="' . $name . '" value="' . $value . '"></td>';
				$field .= "</tr>";

				break;
			case 'email' :

				$field .= "<tr>";
				$field .= "<th scope='row'><label for='$id'>$label</label></th>";
				$field .= '<td><input type="' . $type . '" id="' . $id . '" name="' . $name . '" value="' . $value . '"></td>';
				$field .= "</tr>";

				break;
			case 'url' :

				$field .= "<tr>";
				$field .= "<th scope='row'><label for='$id'>$label</label></th>";
				$field .= '<td><input type="' . $type . '" id="' . $id . '" name="' . $name . '" value="' . $value . '"></td>';
				$field .= "</tr>";

				break;
			case 'tel' :

				$field .= "<tr>";
				$field .= "<th scope='row'><label for='$id'>$label</label></th>";
				$field .= '<td><input type="' . $type . '" id="' . $id . '" name="' . $name . '" value="' . $value . '"></td>';
				$field .= "</tr>";

				break;
			case 'textarea' :

				$field .= "<tr>";
				$field .= "<th scope='row'><label for='$id'>$label</label></th>";
				$field .= '<td><textarea id="' . $id . '" name="' . $name . '" rows="10" cols="50">' . $value . '</textarea>';
				$field .= "</tr>";

				break;
			case 'select' :

				$field .= "<tr>";
				$field .= "<th scope='row'><label for='$id'>$label</label></th>";
				$field .= "<td><select id='$id' name='$name'>";
				foreach( $options as $option_value => $option_label ) {
					$selected = ( $option_value === $value ) ? " selected='selected'" : "";
					$field .= "<option value='$option_value'$selected>$option_label</option>";
				}
				$field .= "</select></td>";
				$field .= "</tr>";

				break;
			case 'checkbox' :

				$checked = ( $value ) ? " checked='checked'" : "";
				$field .= "<tr>";
				$field .= "<th scope='row'>$title</label></th>";
				$field .= "<td><fieldset>";
				$field .= "<legend class='screen-reader-text'>$title</legend>";
				$field .= "<label for='$id'><input type='hidden' id='hidden-$id' name='$name' value='$value'><input type='$type' id='$id'$checked>&nbsp;$label</label>";
				$field .= "</fieldset></td>";
				$field .= "</tr>";

				break;
			case 'radio' :

				$field .= "<tr>";
				$field .= "<th scope='row'>$title</label></th>";
				$field .= "<td><fieldset>";
				$field .= "<legend class='screen-reader-text'>$title</legend>";
				foreach( $options as $option_value => $option_label ) {
					$checked = ( $option_value === $value ) ? " checked='checked'" : "";
					$field .= "<label title='$value'><input type='$type' name='$name' value='$option_value'$checked><span>$option_label</span></label><br>";
				}
				$field .= "</fieldset></td>";
				$field .= "</tr>";

				break;
			case 'hidden' :

				$field .= "<input type='$type' name='$name' value='$value'>";

				break;
		}

		return $field;

	}

	public function save_admin_menu() {

		extract( $this->settings );

		foreach( $defaults as $name => $value ) {
			if( isset( $_POST[$id.'_'.$name] ) ) {
				update_option( $id . '_' . $name, $_POST[$id.'_'.$name] );
			}
		}

	}

}