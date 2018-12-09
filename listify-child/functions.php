<?php
/**
 * Listify child theme.
 */
function listify_child_styles() {
    wp_enqueue_style( 'listify-child', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'listify_child_styles', 999 );

/** Place any new code below this line */


function create_account(){
  if(!session_id()) {
        session_start();
    }
  if(isset($_POST['uemail'])){
    //You may need some data validation here
  $utype = ( isset($_POST['utype']) ? $_POST['utype'] : '' );
    $fname = ( isset($_POST['fname']) ? $_POST['fname'] : '' );
  $lname = ( isset($_POST['lname']) ? $_POST['lname'] : '' );
  $contactperson = ( isset($_POST['contactperson']) ? $_POST['contactperson'] : '' );
  $contactnumber = ( isset($_POST['contactnumber']) ? $_POST['contactnumber'] : '' );
    $pass = $_POST['upass'];  
    $email = ( isset($_POST['uemail']) ? $_POST['uemail'] : '' );
     $user1 =explode('@',$email);
   
   if($utype=='Customer'){
   $username=$email;
   }
    if($utype=='Business'){
    
   $username=$email;
   }
   
    if (!email_exists( $email ) ) {
       $user_id = wp_create_user( $username, $pass, $email );
       if( !is_wp_error($user_id) ) {
       
     update_user_meta( $user_id, 'first_name', $fname );
         update_user_meta( $user_id, 'last_name', $lname );
    
           //user has been created
           $user = new WP_User( $user_id );
       
      
      if($utype=='Business'){
      
           $user->set_role( 'employer' );

        
     }else{
         
         $user->set_role('customer' );
      
        
     }
     
     
     if($utype=='Business'){
      
      update_user_meta( $user_id, 'billing_phone', $contactnumber);
     update_user_meta( $user_id, 'nickname', $contactperson );
     
       
     }
     
        $user_info = get_userdata($user_id);                                            // gets user data
    $code = md5(time());                                                            // creates md5 code to verify later
    $string = array('id'=>$user_id, 'code'=>$code);                                 // makes it into a code to send it to user via email
    update_user_meta($user_id, 'is_activated', 0);                                  // creates activation code and activation status in the database
    update_user_meta($user_id, 'activationcode', $code);
    
    $url = get_site_url(). '/signup/?p=' .base64_encode( serialize($string));       // creates the activation url
  
        $from = get_option('admin_email');  
        $headers = "MIME-Version: 1.0" . "\r\n";
       $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        $headers .= 'From: '.$from . "\r\n";  
                        $subject = "Account verification Email";  
                        $msg = '<div dir="ltr" style="background-color: rgb(245, 245, 245); margin: 0; padding: 70px 0 70px 0; width: 100%">
  <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
    <tbody>
      <tr>
        <td align="center" valign="top"><div> </div>
          <table border="0" cellpadding="0" cellspacing="0" width="600" style="box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1) !important; background-color: rgb(253, 253, 253); border: 1px solid rgb(220, 220, 220); border-radius: 3px !important">
            <tbody>
              <tr>
                <td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: rgb(85, 125, 161); border-radius: 3px 3px 0 0 !important; color: rgb(255, 255, 255); border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif">
                    <tbody>
                      <tr>
                        <td style="padding: 36px 48px; display: block"><h1 style="color: rgb(255, 255, 255); font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 rgb(119, 151, 180)">Welcome to USEANARCHITECT</h1></td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
              <tr>
                <td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="600">
                    <tbody>
                      <tr>
                        <td valign="top" style="background-color: rgb(253, 253, 253)"><table border="0" cellpadding="20" cellspacing="0" width="100%">
                            <tbody>
                              <tr>
                                <td valign="top" style="padding: 48px 48px 0"><div style="color: rgb(115, 115, 115); font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left">
                                    <p style="margin: 0 0 16px">Thanks for creating an account on USEANARCHITECT. Your username is <strong>'.$username.'</strong>. Your password is <strong>'.$pass.'</strong></p>
                                    <p style="margin: 0 0 16px">Please click  <a href="'.$url.'" rel="noreferrer" style="color: rgb(85, 125, 161); font-weight: normal; text-decoration: underline" target="_blank">here</a> to verify your email address and complete the registration process.</p>
                                      <p style="margin: 0 0 16px">or copy below link and open in browser to verify email<br><a href="'.$url.'" rel="noreferrer" style="color: rgb(85, 125, 161); font-weight: normal; text-decoration: underline" target="_blank">'.$url.'</a></p>
                                  </div></td>
                              </tr>
                            </tbody>
                          </table></td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
              <tr>
                <td align="center" valign="top"><table border="0" cellpadding="10" cellspacing="0" width="600">
                    <tbody>
                      <tr>
                        <td valign="top" style="padding: 0"><table border="0" cellpadding="10" cellspacing="0" width="100%">
                            <tbody>
                              <tr>
                                <td colspan="2" valign="middle" style="padding: 0 48px 48px 48px; border: 0; color: rgb(153, 177, 199); font-family: Arial; font-size: 12px; line-height: 125%; text-align: center"><p>USEANARCHITECT ©<br>
                                    useanarchitect.com.au</p></td>
                              </tr>
                            </tbody>
                          </table></td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
</div>';
    wp_mail( $email, $subject, $msg, $headers ); 
                
               $_SESSION['msg']="<p style='color:green'>Your account has to be Created. Please click the link in the activation email that has been sent to you.</p>";
         
              
           
       } else {
           $_SESSION['msg']="<p style='color:red'>Failed to create account. Please try later.</p>";
       
       }
    }else{
    $_SESSION['msg']="<p style='color:red'>Email Already Exit.</p>";
  }
  }
}
add_action('init','create_account');




add_filter('wp_authenticate_user', function($user) {
    
    if($user->ID !='1'){
    if (get_user_meta($user->ID, 'is_activated', true) == '1' ) {
        return $user;
    }else{
     
    }
    }
}, 10, 2);


//adding custom taxonomy for Sustainable Design Level


function listify_custom_taxonomy() {  
    
    $labels = array(
    'name' => _x( 'Sustainable Design Level', 'taxonomy general name' ),
    'singular_name' => _x( 'Sustainable Design Level', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Sustainable Design Level' ),
    'all_items' => __( 'All Sustainable Design Level' ),
    'parent_item' => __( 'Parent Sustainable Design Level' ),
    'parent_item_colon' => __( 'Parent Sustainable Design Level:' ),
    'edit_item' => __( 'Edit Sustainable Design Level' ), 
    'update_item' => __( 'Update Sustainable Design Level' ),
    'add_new_item' => __( 'Add New Sustainable Design Level' ),
    'new_item_name' => __( 'New Sustainable Design Level Name' ),
    'menu_name' => __( 'Sustainable Design Level' ),
  );
    register_taxonomy(  
        'job_design_level',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces). 
        'job_listing',        //post type name
        array(  
            'hierarchical' => true,  
            'labels' => $labels,  //Display name
            'show_ui' => true,
    'show_admin_column' => false,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'job' ),
        )  
    );  
}  
add_action( 'init', 'listify_custom_taxonomy');


function listify_budget_taxonomy() {  
    
    $labels = array(
    'name' => _x( 'Budget Estimate', 'taxonomy general name' ),
    'singular_name' => _x( 'Budget Estimate', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Budget Estimate' ),
    'all_items' => __( 'All Budget Estimate' ),
    'parent_item' => __( 'Parent Budget Estimate' ),
    'parent_item_colon' => __( 'Parent Budget Estimate' ),
    'edit_item' => __( 'Edit Budget Estimate' ), 
    'update_item' => __( 'Update Budget Estimate' ),
    'add_new_item' => __( 'Add New Budget Estimate' ),
    'new_item_name' => __( 'New Budget Estimate' ),
    'menu_name' => __( 'Budget Estimate' ),
  );
    register_taxonomy(  
        'job_budget',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces). 
        'job_listing',        //post type name
        array(  
            'hierarchical' => true,  
            'labels' => $labels,  //Display name
            'show_ui' => true,
    'show_admin_column' => false,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'job' ),
        )  
    );  
}  
add_action( 'init', 'listify_budget_taxonomy');

 
add_filter( 'job_manager_job_listing_data_fields', 'admin_add_duties_field' );
 
function admin_add_duties_field( $fields ) {

  
  
   $fields['_job_year']    = array(
				'label'       => __( 'Year Established', 'wp-job-manager' ),
				'placeholder' => __( 'e.g. "2019"', 'wp-job-manager' ),
				'description' => __( 'Leave this blank if the Year Established is not important.', 'wp-job-manager' ),
			
			);
			
			$fields['_job_register']    = array(
				'label'       => __( 'Registration number', 'wp-job-manager' ),
				'placeholder' =>'',
				'description' => __( 'Leave this blank if the Registration number is not important.', 'wp-job-manager' ),
			
			);
			
		$fields['_job_award']    = array(
				'label'       => __( 'Awards', 'wp-job-manager' ),
				'placeholder' => '',
				'type'        => 'textarea',
				'description' => __( 'Leave this blank if the Awards is not important.', 'wp-job-manager' ),
			
			);
			
			$fields['_company_youtube']    = array(
				'label'       => __( 'Youtube URL', 'wp-job-manager' ),
				'placeholder' => '',
				'description' => __( 'Enter youtube link', 'wp-job-manager' ),
			
			);
				$fields['_company_address']    = array(
				'label'       => __( 'Address', 'wp-job-manager' ),
				'placeholder' => '',
					'type'        => 'textarea',
				'description' => __( 'Enter youtube link', 'wp-job-manager' ),
			
			);
  return $fields;
}

add_filter( 'submit_job_form_fields', 'frontend_add_experience_field' );
 
function frontend_add_experience_field( $fields ) {
    
  $fields['job']['job_year'] = array(
						'label'       => __( 'Year Established', 'wp-job-manager' ),
						'type'        => 'text',
						'required'    => true,
						'placeholder' => '',
						'priority'    => 4,
					);
					
	$fields['job']['job_register'] = array(
						'label'       => __( 'Registration number', 'wp-job-manager' ),
						'type'        => 'text',
						'required'    => true,
						'placeholder' => '',
						'priority'    => 4,
					);
					
					
$fields['job']['job_design'] = array(
						'label'       => __( 'Sustainable Design Level', 'wp-job-manager' ),
						'type'        => 'term-multiselect',
						'required'    => true,
						'placeholder' => __( 'Choose Sustainable Design Level', 'wp-job-manager' ),
						'priority'    => 6,
						'default'     => '',
						'taxonomy'    => 'job_design_level',
					);
					
$fields['job']['job_budget']     =array(
						'label'       => __( 'Budget Estimate', 'wp-job-manager' ),
						'type'        => 'term-multiselect',
						'required'    => true,
						'placeholder' => __( 'Choose Budget Estimate', 'wp-job-manager' ),
						'priority'    => 7,
						'default'     => '',
						'taxonomy'    => 'job_budget',
					);
					
$fields['job']['job_award']    = array(
						'label'       => __( 'Awards', 'wp-job-manager' ),
						'type'        => 'text',
						'required'    => true,
						'placeholder' => '',
						'priority'    => 8,
					);
$fields['job']['company_youtube']    = array(
						'label'       => __( 'Youtube URL', 'wp-job-manager' ),
						'type'        => 'text',
						'required'    => true,
						'placeholder' => '',
						'priority'    => 8,
					);
					
$fields['job']['company_address']    = array(
						'label'       => __( 'Address', 'wp-job-manager' ),
						'type'        => 'textarea',
						'required'    => true,
						'placeholder' => '',
						'priority'    => 8,
					);
  return $fields;
}




add_action( 'job_manager_job_filters_search_jobs_end', 'filter_by_budget_field' );
function filter_by_budget_field() {
    	if ( ! empty( $_GET['search_budget'] ) ) {
			$budget = sanitize_text_field( $_GET['search_budget'] );
		}
    	    $args = array(
       'hide_empty'             => false,
       'fields'                 => 'id=>name',
   );
	
			  $job_budget = get_terms('job_budget', $args);
		
	?>
	<div class="search_categories">
                  <label for="search_location"><?php _e( 'Budget', 'jobify' ); ?></label>
              <span class="select job-manager-category-dropdown-wrapper">
               <select class="job-manager-filter" name="search_budget" id="search_budget">
               <option value=""><?php _e( 'Select Budget', 'jobify' ); ?></option>

               <?php

                   foreach ($job_budget as $loc_key => $loc_val ) {
                       if(isset($budget) && $budget==$loc_key){
                           $selected="selected";
                       }else{
                           $selected='';
                       }
                   echo "<option value='".$loc_key."' ".$selected.">".$loc_val."</option>";
                   }
               ?>
               </select>
               </span>
               </div>
	<?php
}

add_action( 'job_manager_job_filters_search_jobs_end', 'filter_by_design_level_field' );
function filter_by_design_level_field() {
    		if ( ! empty( $_GET['search_design_level'] ) ) {
			$design = sanitize_text_field( $_GET['search_design_level'] );
		}
    	    $args = array(
       'hide_empty'             => false,
       'fields'                 => 'id=>name',
   );
	
			  $job_design_level = get_terms('job_design_level', $args);
		
	?>
	<div class="search_categories">
                  <label for="search_location"><?php _e( ' Sustainable Design Level', 'jobify' ); ?></label>
              <span class="select job-manager-category-dropdown-wrapper">
               <select class="job-manager-filter" name="search_design_level" id="search_design_level">
               <option value=""><?php _e( 'Select Sustainable Design Level', 'jobify' ); ?></option>

               <?php

                   foreach ($job_design_level as $loc_key => $loc_val ) {
                        if(isset($design) && $design==$loc_key){
                           $selected="selected";
                       }else{
                           $selected='';
                       }
                       
                   echo "<option value='".$loc_key."' ".$selected.">".$loc_val."</option>";
                   }
               ?>
               </select>
               </span>
               </div>
	<?php
}

add_action( 'job_manager_job_filters_search_jobs_end', 'filter_by_awards_field' );
function filter_by_awards_field() {
    	if ( ! empty( $_GET['search_awards'] ) ) {
			$awards = sanitize_text_field( $_GET['search_awards'] );
		}
	?>
	<div class="search_categories">
		<label for="search_categories"><?php _e( 'Awards', 'wp-job-manager' ); ?></label>
		<span class="select job-manager-category-dropdown-wrapper">
		    <select name="search_awards" id="search_awards" class="job-manager-filter" >
<option value=""><?php _e( 'Select Awards', 'wp-job-manager' ); ?></option>	
	<option value="Yes" <?php if(isset($awards) && $awards=='Yes'){ echo "selected";}?>><?php _e( 'Yes', 'wp-job-manager' ); ?></option>
	<option  value="No" <?php if(isset($awards) && $awards=='No'){ echo "selected";}?>><?php _e( 'No', 'wp-job-manager' ); ?></option>
</select></span>
	</div>
	<?php
}
/**
 * This code gets your posted field and modifies the job search query
 */
add_filter( 'job_manager_get_listings', 'filter_by_awards_field_query_args', 10, 2 );
function filter_by_awards_field_query_args( $query_args, $args ) {
	if ( isset( $_POST['form_data'] ) ) {
		parse_str( $_POST['form_data'], $form_data );
		// If this is set, we are filtering by salary
		if ( ! empty( $form_data['search_awards'] ) ) {
			$selected_range = sanitize_text_field( $form_data['search_awards'] );
			switch ( $selected_range ) {
				case 'Yes' :
					$query_args['meta_query'][] = array(
						'key'     => '_job_award',
						'value' => '',
                         'compare' => '!='
					);
				break;
				case 'No' :
					$query_args['meta_query'][] = array(
						'key'     => '_job_award',
						'value'   => ''
						
					);
				break;
				default :
					$query_args['meta_query'][] = array(
						'key'     => '_job_award',
						'value'   => ''
					);
				break;
			}
			// This will show the 'reset' link
			add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
		}
	}
	return $query_args;
}



add_filter( 'job_manager_get_listings', 'filter_by_budget_field_query_args', 10, 2 );
function filter_by_budget_field_query_args( $query_args, $args ) {
	if ( isset( $_POST['form_data'] ) ) {
		parse_str( $_POST['form_data'], $form_data );
	
		if ( ! empty( $form_data['search_budget'] ) ) {
			$selected_range = sanitize_text_field( $form_data['search_budget'] );
		
			$query_args= array(

        'post_type' => 'job_listing',
        'post_status' => 'publish',
        
        'tax_query' => array(
            array(
              'taxonomy' => 'job_budget',
              'field' => 'term_id',
              'terms' => $selected_range
            )
        )
    );
		/*
					$query_args['tax_query'][] = array(
				'taxonomy' => 'job_budget',
				'field'    => 'slug',
				'terms'    => $selected_range,
			);
			*/
			
			// This will show the 'reset' link
			add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
		}
	}
	return $query_args;
}



add_filter( 'job_manager_get_listings', 'filter_by_design_field_query_args', 10, 2 );
function filter_by_design_field_query_args( $query_args, $args ) {
	if ( isset( $_POST['form_data'] ) ) {
		parse_str( $_POST['form_data'], $form_data );
	
		if ( ! empty( $form_data['search_design_level'] ) ) {
			$selected_design = sanitize_text_field( $form_data['search_design_level'] );
		
			$query_args= array(

        'post_type' => 'job_listing',
        'post_status' => 'publish',
        
        'tax_query' => array(
            array(
              'taxonomy' => 'job_design_level',
              'field' => 'term_id',
              'terms' => $selected_design
            )
        )
    );
		/*
					$query_args['tax_query'][] = array(
				'taxonomy' => 'job_budget',
				'field'    => 'slug',
				'terms'    => $selected_range,
			);
			*/
			
			// This will show the 'reset' link
			add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
		}
	}
	return $query_args;
}
