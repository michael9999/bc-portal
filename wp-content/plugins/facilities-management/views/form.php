<form class='validate' id='fm_createuser' name='fm_createuser' method='post' enctype='multipart/form-data' action=''>
<table class='form-table'>
	<tbody><tr class='form-field form-required'>
		<th scope='row'><label for='user_login'>Username <span class='description'>(required)</span></label></th>
		<td><input type='text' aria-required='true' value='' id='user_login' name='user_login'>
		<input type='hidden' value='fm_add' class='code' id='fm_add' name='fm_add'></td>
	</tr>
	<!--<tr class='form-field'>
		
		
	</tr>-->	
	<tr class='form-field form-required'>
		<th scope='row'><label for='email'>E-mail <span class='description'>(required)</span></label></th>
		<td><input type='text' value='' id='email' name='email' required></td>
	</tr>
	<tr class='form-field'>
		<th scope='row'><label for='first_name'>First Name </label></th>
		<td><input type='text' value='' id='first_name' name='first_name' ></td>
	</tr>
	<tr class='form-field'>
		<th scope='row'><label for='last_name'>Last Name </label></th>
		<td><input type='text' value='' id='last_name' name='last_name' ></td>
	</tr>
	<tr class='form-field'>
		<th scope='row'><label for='url'>Website</label></th>
		<td><input type='text' value='' class='code' id='url' name='url'></td>
	</tr>
<tr>
<th>
<label for='fac_comp_name'>Company name</label></th>
<td>
<input type='text' value='' class='regular-text' id='fac_comp_name' name='fac_comp_name'>	 					
<br>
	<span class='description'>Name of provider</span>
</td>
</tr>		
		
<!-- end -->

		<tr>
			<th>
				<label for='fac_user_type'>
				Service provider?				</label>
			</th>
			<td>
				
				
				<select id='fac_user_type' name='fac_user_type' type='text'>
				<option class='regular-text' value=''>
				</option>
				<option value='yes'>Yes</option>
  				<option value='no'>No</option>	
					
				</select> 
					
			
			
			</td>
		</tr>

<!-- Type of provider -->
		
	<tr>
			<th>
				<label for='fac_provider_profession'>
				Profession			</label>
			</th>
			<td>
				
				
				<select id='fac_provider_profession' name='fac_provider_profession' type='text'>
				<option class='regular-text' value='electrician'>
				electrician</option>
				<option value='plumber'>plumber</option>
  				<option value='painter'>painter</option>	
				<option value='electrician'>electrician</option>
				<option value='heating-aircon'>aircon-heating</option>
				<option value='stationery'>stationery</option>	
				</select> 
			
			
			
			
			
			</td>
		</tr>	
		
<!-- company description -->		
		
		<tr>
<th>
<label for='fac_service_description'>Description of services</label></th>
<td>
<textarea class='regular-text' id='fac_service_description' name='fac_service_description'></textarea><br>
<span class='description'>Please enter a description of the services provided by this company</span>
</td>
</tr><!-- field ends here -->
		
<!-- telephone -->			

<tr>
<th>
<label for='fac_telephone'>Telephone number</label></th>
<td>
<input type='text' value='' class='regular-text' id='fac_telephone' name='fac_telephone'>
<br>
<span class='description'>Please add a telephone number</span>
</td>
</tr>		
		
<!-- mobile nb -->			

<tr>
<th>
<label for='fac_mobile'>Mobile number</label></th>
<td>
<input type='text' value='' class='regular-text' id='fac_mobile' name='fac_mobile'>
<br>
<span class='description'>mobile telephone number</span>
</td>
</tr>		

<!-- address -->		
		
		<tr>
<th>
<label for='fac_address'>Address</label></th>
<td>
<textarea class='regular-text' id='fac_address' name='fac_address'></textarea><br>
	<span class='description'>Please enter an address</span>
</td>
</tr>

	<!-- contract -->		
		
		<tr>

<th><label for='file'>Filename</label></th>
<td>					
<input id='cname' name='filename' minlength='2' type='text' required />	
</td>		
		
</tr>
<tr>		
<th><label for='fac_contract'>Contract</label></th>
<td>
<input type='file' name='files[]' multiple required />
<!--<input type='file' required='' multiple='' name='uploadedfile'>	-->
<br>
	<span class='fac_contract'>Upload scan of contract</span>
</td>
</tr>		
		
		
	</tbody></table>

<p class='submit'><input type='submit' value='Add New User ' class='button button-primary' id='sub' name='createuser'></p>
</form>