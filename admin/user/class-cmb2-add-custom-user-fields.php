<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class TheTeamEstoniaSection {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'estonia_team_admin_menu' ) );
		add_action( 'after_setup_theme', array( $this, 'include_class_templates' ) );
		add_action( 'personal_options_update', array( $this, 'save_extra_user_profile_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_extra_user_profile_fields' ) );
		add_action('user_register', array( $this, 'save_extra_user_profile_fields' ) );
		add_action( 'show_user_profile', array( $this, 'extra_user_profile_fields' ) );
		add_action( 'edit_user_profile', array( $this,'extra_user_profile_fields' ) );
		add_action( "user_new_form", array( $this, "extra_user_profile_fields" ) );
	}


	function include_class_templates(){
		require get_template_directory() . '/class-team-profile-section.php';
		require get_template_directory() . '/class-team-latvia-section.php';
		require get_template_directory() . '/class-team-lithunia-section.php';
		require get_template_directory() . '/class-team-poland-section.php';
		require get_template_directory() . '/class-team-deparment-section.php';
		require get_template_directory() . '/class-team-member-profile.php';

	}



	function extra_user_profile_fields( $user ) { ?>
	    <h3><?php _e("Extra profile information", "blank"); ?></h3>

	    <table class="form-table">
	    <tr>
	        <th><label for="dateofbirth"><?php _e("Date of birth"); ?></label></th>
	        <td>
	            <input type="text" name="dateofbirth" id="dateofbirth" value="<?php echo esc_attr( get_the_author_meta( 'dateofbirth', $user->ID ) ); ?>" class="regular-text" /><br />
	            <span class="dateofbirth"><?php _e("Please enter your date of birth."); ?></span>
	        </td>
	    </tr>
	    <tr>
	        <th><label for="country"><?php _e("Country"); ?></label></th>
					<td>
						 <select name="country" id="country" >
								 <option value="estonia" <?php selected( 'estonia', get_the_author_meta( 'country', $user->ID ) ); ?>>Estonia</option>
								 <option value="latvia" <?php selected( 'latvia', get_the_author_meta( 'country', $user->ID ) ); ?>>Latvia</option>
								 <option value="lithunia" <?php selected( 'lithunia', get_the_author_meta( 'country', $user->ID ) ); ?>>Lithunia</option>
								 <option value="poland" <?php selected( 'poland', get_the_author_meta( 'country', $user->ID ) ); ?>>Poland</option>
						 </select>
				 </td>
	    </tr>
	    <tr>
	    <th><label for="department"><?php _e("Department"); ?></label></th>
					 <td>
	            <select name="department" id="department" >
	                <option value="board" <?php selected( 'board', get_the_author_meta( 'department', $user->ID ) ); ?>>The Board</option>
	                <option value="sales" <?php selected( 'sales', get_the_author_meta( 'department', $user->ID ) ); ?>>Sales and Marketing</option>
									<option value="finance" <?php selected( 'finance', get_the_author_meta( 'department', $user->ID ) ); ?>>Finance and Marketing</option>
	            </select>
	        </td>
	    </tr>
			<tr>
			<th><label for="jobtitle"><?php _e("Job Title"); ?></label></th>
					<td>
							<input type="text" name="jobtitle" id="jobtitle" value="<?php echo esc_attr( get_the_author_meta( 'jobtitle', $user->ID ) ); ?>" class="regular-text" /><br />
							<span class="jobtitle"><?php _e("Please enter your job title."); ?></span>
					</td>
			</tr>
			<tr>
			<th><label for="phone"><?php _e("Phone"); ?></label></th>
					<td>
							<input type="text" name="phone" id="phone" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" class="regular-text" /><br />
							<span class="phone"><?php _e("Please enter your phone."); ?></span>
					</td>
			</tr>
			<tr>
			<th><label for="description"><?php _e("Description"); ?></label></th>
					<td>
							<input type="textarea" rows="4" cols="50" name="description" id="description" value="<?php echo esc_attr( get_the_author_meta( 'description', $user->ID ) ); ?>" class="regular-text" />
							<span class="description"><?php _e("Please enter your description."); ?></span>
					</td>
			</tr>
			<tr>
			<th><label for="areasofresponsibility"><?php _e("Areas Of Responsibility"); ?></label></th>
					<td>
							<input type="text" name="areasofresponsibility" id="areasofresponsibility" value="<?php echo esc_attr( get_the_author_meta( 'areasofresponsibility', $user->ID ) ); ?>" class="regular-text" /><br />
							<span class="areas of responsibility"><?php _e("Please enter your areas of responsibility."); ?></span>
					</td>
			</tr>
			<tr>
			<th><label for="atinbanksince"><?php _e("At inbank since"); ?></label></th>
					<td>
							<input type="text" name="atinbanksince" id="department" value="<?php echo esc_attr( get_the_author_meta( 'atinbanksince', $user->ID ) ); ?>" class="regular-text" /><br />
							<span class="atinbanksince"><?php _e("Please enter your at inbank since."); ?></span>
					</td>
			</tr>

	    </table>
	<?php }


	function save_extra_user_profile_fields( $user_id ) {
	    if ( !current_user_can( 'edit_user', $user_id ) ) {
	        return false;
	    }
	    update_user_meta( $user_id, 'dateofbirth', $_POST['dateofbirth'] );
	    update_user_meta( $user_id, 'country', $_POST['country'] );
	    update_user_meta( $user_id, 'department', $_POST['department'] );
			update_user_meta( $user_id, 'jobtitle', $_POST['jobtitle'] );
			update_user_meta( $user_id, 'phone', $_POST['phone'] );
			update_user_meta( $user_id, 'description', $_POST['description'] );
			update_user_meta( $user_id, 'areasofresponsibility', $_POST['areasofresponsibility'] );
			update_user_meta( $user_id, 'atinbanksince', $_POST['atinbanksince'] );
			update_usermeta( $user_id, 'gender', $_POST['gender'] );


	}

	function estonia_team_admin_menu() {
		add_menu_page(
			'The Estonia Team',
			'The Estonia Team',
			'manage_options',
			'the_estonia_team_page_slug',
			array(
				$this,
				'estonia_settings_page'
			)
		);
	}

	function  estonia_settings_page() { ?>

    <div class="wrap about-wrap">
    <h1 class="text-center" ><?php _e( 'The Estonia Team' ); ?></h1>
		<h2 class="nav-tab-wrapper">
			<a href="<?php  echo esc_url(admin_url('admin.php?page=the_estonia_team_page_slug') );  ?>" class="nav-tab ">
				<?php _e( 'Estonia' ); ?>
			</a><a href="<?php  echo esc_url(admin_url('admin.php?page=the_latvia_team_page_slug') );  ?>" class="nav-tab">
				<?php _e( 'Latvia' ); ?>
			</a><a href="<?php  echo esc_url(admin_url('admin.php?page=the_lithunia_team_page_slug') );  ?>" class="nav-tab">
				<?php _e( 'Lithunia' ); ?>
			</a><a href="<?php  echo esc_url(admin_url('admin.php?page=the_poland_team_page_slug') );  ?>" class="nav-tab">
				<?php _e( 'Poland' ); ?>
			</a>
		</h2>

		<div class="col-lg-12" >
			 <?php new TeamDeparmentSection('The board', 'estonia', 'board'); ?>
		</div>
		<div class="col-lg-12" >
			 <?php new TeamDeparmentSection('Sales & Marketing', 'estonia', 'sales'); ?>
		</div>
 		<div class="col-lg-12" >
			 <?php new TeamDeparmentSection('Finance & Risk', 'estonia', 'finance'); ?>
		</div>
		<?php



        }
}

new TheTeamEstoniaSection;
