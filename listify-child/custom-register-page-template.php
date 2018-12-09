<?php
/********* Template Name: Custom Signup Page

*****/
if ( is_user_logged_in() ) {
    wp_redirect(home_url());
}else{
get_header();
?>
<script>
jQuery(document).ready(function(){
jQuery('input[type="radio"]').change(function(){
	var rval= jQuery(this).val();
	if(rval=='Business'){
		jQuery('.businessbox').css('display','block');
		jQuery('.businessbox').append('<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first"><label for="contactnumber">Contact Number <span class="required">*</span></label> <input id="contactnumber" type="text" name="contactnumber" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="Contact Number" required/></p><p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last"><label for="contactperson">Contact Person <span class="required">*</span></label><input id="contactperson" type="text" name="contactperson" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="Enter Contact Person Detail"  required/></p>');
	}else{
		jQuery('.businessbox').css('display','none');
	    jQuery('.businessbox').empty();
	}
});
});
</script>
<style>
.main-reg {padding-bottom: 70px;}
.register-box {width: 48%;
    margin: 0 auto;}
.form-p label {display: block;    line-height: 26px;
    font-size: 14px;
    padding-bottom: 3px;
    font-style: italic;}
.form-p input {width: 100%;}
.form-p, .btn-box {padding: 3px; margin: 0 0 15px;}
.btn-box {margin-top: 25px;}
.ac-type {margin-bottom: 20px;}
.ac-type label {font: 400 18px/29px 'Roboto', trebuchet ms;
    color: #111111;
    margin: 40px 0 0 0;
    display: block;}

.signup-box{background-color: #ffffff;
    box-shadow: inset 0 0 0 1px #ededed;
    border: 0;}
  .signup-box  .content-box-inner{    padding: 40px;}
  .woocommerce form .form-row label, .woocommerce-page form .form-row label {
    display: block;
    line-height: 30px;
}
@media screen and (max-width: 767px) {
.register-box {
    width: 100%;
}	
	
}
</style>
<div 
	<?php
	echo apply_filters(
		'listify_cover',
		'page-cover',
		array( // WPCS: XSS ok.
			'size' => 'full',
		)
	);
	?>
	>
		<h1 class="page-title cover-wrapper">
		<?php
		the_post();
		the_title();
		rewind_posts();
		?>
</h1>
	</div>
	<div id="primary" class="container">
		<div class="row content-area">
        <!-- Main Side -->
       	<main id="main" class="site-main <?php echo esc_attr( listify_job_listing_archive_has_sidebar() ? 'col-md-8' : null ); ?> col-12 job_filters--<?php echo get_theme_mod( 'listing-filters-style', 'content-box' ); ?>" role="main">
          
                   <div class="page type-page status-publish has-post-thumbnail hentry content-box-wrapper signup-box">
				   
            <div id="container" class="content-box-inner">
                 
               <?php if(isset($_SESSION['msg'])){
					   echo $_SESSION['msg'];
					   unset($_SESSION['msg']);
				   }?>
    <form method="post" name="myForm">
	       <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide ac-type"><label for="user_register" style="margin:0px;">Select Account Type</label> <br>
		   <input type="radio"  name="utype" value="Customer" checked> Customer &nbsp; &nbsp; &nbsp;
			<input type="radio"  name="utype" value="Business"> Business Owner
			</p>
     <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">  
	 <label for="user_register">First Name <span class="required">*</span></label> 
	 <input type="text"  name="fname" placeholder="First Name" class="woocommerce-Input woocommerce-Input--text input-text" required/></p>
	 
		<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
		<label for="user_register">Last Name <span class="required">*</span></label>
		<input type="text"  name="lname" placeholder="Last Name" class="woocommerce-Input woocommerce-Input--text input-text" required/></p>
		
      <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first"> 
	  <label for="user_register">Email <span class="required">*</span></label>
	  <input id="email" type="email" name="uemail" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="Your Email" required/></p>
	  <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last"> 
	  <label for="user_register">Password <span class="required">*</span></label>
	  <input id="password" type="password" name="upass" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="Your Password" required/></p>
	  <div class="businessbox" style="display:none;">
	  
	   </div>
	    
        <p><input type="submit" value="Submit" class="woocommerce-Button button"/></p>
    </form>

</div>
             
        </div>
        </main>	
        <!-- /Main Side -->  
        <!-- Sidebar -->
       
        <!-- /Sidebar --> 
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php
get_footer();

}
?>