<div id="left_menu">

	<div class="menu_header"> &nbsp; </div>
    <ul class="menu_body">
	  <li><a href="{$BASE_URL}admin/credits.php" target="_self" >Credits</a></li>    
      <li><a href="{$BASE_URL}logout/" target="_self" >Logout </a></li>
    </ul>
    
    <div class="menu_header">List Management</div>
	<ul class="menu_body">
    	<li><a href="{$BASE_URL}admin/manage_listings.php">Manage Listing</a></li>
		<li><a href="{$BASE_URL}admin/job_approve_list.php">Approved Listing</a></li>
		<li><a href="{$BASE_URL}admin/job_rejected_list.php">Rejected Listing</a></li>
		<li><a href="{$BASE_URL}admin/job_pending_list.php">Pending Listing</a></li>
		<!-- <li><a href="{$BASE_URL}admin/new_job.php">Post Job</a></li> -->
        <li><a href="{$BASE_URL}admin/job_overview.php">Overview</a></li>
	</ul>

	<div class="menu_header">Users</div>
	<ul class="menu_body">
		<div class="menu_min_header">Job Seeker</div>
			<ul class="menu_body_body">
                <li><a href="{$BASE_URL}admin/manage_employee.php">Manage Employee's</a></li>
                <li><a href="{$BASE_URL}admin/manage_employee_pending.php">Profiles for Approval</a></li>
                <li><a href="{$BASE_URL}admin/manage_employee_active.php">Active Users</a></li>
                <li><a href="{$BASE_URL}admin/manage_employee_deactive.php">Deactivate Users</a></li>
                 <li><a href="{$BASE_URL}admin/new_employee.php">Add a New Employee</a></li>
			</ul>
		<div class="menu_min_header">Employer</div>
			<ul class="menu_body_body">
                <li><a href="{$BASE_URL}admin/manage_employer.php">Manage Employer's</a></li>
                <li><a href="{$BASE_URL}admin/employer_pending.php">Profiles for Approval</a></li>
                <li><a href="{$BASE_URL}admin/manage_employer_active.php">Active Users</a></li>
                <li><a href="{$BASE_URL}admin/manage_employer_deactive.php">Deactivate Users</a></li>
                <!-- <li><a href="{$BASE_URL}admin/#">Pending user</a></li> -->
                <li><a href="{$BASE_URL}admin/new_employer.php">Add a New Employer</a></li>
			</ul>

		<!-- <li><a href="{$BASE_URL}admin/#">Overview</a></li>
		<li><a href="{$BASE_URL}admin/#">Mailing</a></li> -->
	</ul>

	<div class="menu_header">Management</div>
       	<!-- 
        <div class="menu_min_header">Add</div>
        <ul class="menu_body">
            <li><a href="{$BASE_URL}admin/add_category.php">Add Category</a></li>
            <li><a href="{$BASE_URL}admin/add_job_type.php">Add Job Type</a></li>
            <li><a href="{$BASE_URL}admin/add_job_status.php">Add Job Status</a></li>
            <li><a href="{$BASE_URL}admin/add_education.php">Add Job Education</a></li>
            <li><a href="{$BASE_URL}admin/add_career_degree.php">Add Career Degree</a></li>
            <li><a href="{$BASE_URL}admin/add_year_experience.php">Add Year Experience</a></li>
            <li><a href="{$BASE_URL}admin/add_city.php">Add City</a></li>
        </ul>
        -->
        <ul class="menu_body">
            <li><a href="{$BASE_URL}admin/view_category.php">Category</a></li>
            <li><a href="{$BASE_URL}admin/view_job_type.php">Job Type</a></li>
            <li><a href="{$BASE_URL}admin/view_job_status.php">Job Status</a></li>
            <li><a href="{$BASE_URL}admin/view_education.php">Job Education</a></li>
            <li><a href="{$BASE_URL}admin/view_career_degree.php">Career Degree</a></li>
            <li><a href="{$BASE_URL}admin/view_year_experience.php">Year Experience</a></li>
            <!-- <li><a href="{$BASE_URL}admin/view_city.php">City</a></li> -->
        </ul>
		
       <a href="{$BASE_URL}admin/manage_pages.php">Manage Pages</a> <br />
       <!-- <a href="{$BASE_URL}admin/email_templates.php">Email Templates</a> -->
       
	<div class="menu_header">Localities</div>
        <ul class="menu_body">
            <li><a href="{$BASE_URL}admin/load_cities.php">Cities File</a></li>
            <li><a href="{$BASE_URL}admin/load_counties.php">Counties File</a></li>
            <li><a href="{$BASE_URL}admin/load_states.php">States</a></li>
        </ul>


	<div class="menu_header">Financial</div>
	<ul class="menu_body">
		<li><a href="{$BASE_URL}admin/payment_modules.php">Payment Modules</a></li>
	</ul>
    {*
	<div class="menu_header">Payments</div>
	<ul class="menu_body">
		<li><a href="{$BASE_URL}admin/setting.php?id=6">Paypal</a></li>
	</ul>
*}
	<div class="menu_header">System Configuration</div>
	<ul class="menu_body">
        <li><a href="{$BASE_URL}admin/change_password.php">Admin Password</a></li>
        <li><a href="{$BASE_URL}admin/seo.php">SEO</a></li>
        <li><a href="{$BASE_URL}admin/setting.php">System Settings</a></li>
	</ul>
        
	<div class="menu_header">Packages</div>
	<ul class="menu_body">
        <li><a href="{$BASE_URL}admin/new_package.php">Add Package</a></li>
        <li><a href="{$BASE_URL}admin/list_packages.php">List of Packages</a></li>
        <!--  <li><a href="{$BASE_URL}admin/#">Active Packages</a></li> -->
	</ul>

</div>
