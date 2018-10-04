<div class="panel-heading">
	<h4 class="panel-title">Foot Plate Inspection</h4>
</div>
<div class="panel-body" align="">	
		<table name = "footplateinspectiont1" >
	        <tr>			
			<td><input type="hidden"  class = "form-control" name="trans_id" <?php if($id_set==1){
				$temp_id = $_SESSION['idu'];
			echo "value='$temp_id'";}  ?>/></td>
		</tr>
	        <tr>
				<th>Date: </th>
				<td><input type="date" name="footplateinspectiondate" class="form-control" width="45" <?php if($id_set==1) echo "value='$date'"; ?> /></td>
			</tr>	
	        <tr>
				<th>Loco No: </th>
				<td><input type="number" name="footplateinspectionlocono" placeholder = "Loco No"class="form-control" <?php if($id_set==1) echo "value='$locono'"; ?> /></td>
			</tr>	
	        <tr>
				<th>Train No: </th>
				<td><input type="text" name="footplateinspectiontrainno" placeholder = "Train No"class="form-control"<?php if($id_set==1) echo "value='$trainno'"; ?> /></td>
			</tr>
	        <tr>
				<th>From: </th>
				<td><input type="text" name="footplateinspectionfrom" placeholder = "From"class="form-control"<?php if($id_set==1) echo "value='$from'"; ?> /></td>
			</tr>
	        <tr>
				<th>To: </th>
				<td><input type="text" name="footplateinspectionto" placeholder = "To"class="form-control"<?php if($id_set==1) echo "value='$to'"; ?> /></td>
			</tr>
	        <tr>
				<th>LPs Name: </th>
				<td><input type="text" name="footplateinspectionlpsname" placeholder = "LPs Name"class="form-control" <?php if($id_set==1) echo "value='$lpsname'"; ?> /></td>
			</tr>
	        <tr>
				<th>LPs CMS ID: </th>
				<td><input type="text" name="footplateinspectionlpscmsid" placeholder = "LPs CMS ID"class="form-control" <?php if($id_set==1) echo "value='$lpscmsid'"; ?> /></td>
			</tr>
	        <tr>
				<th>Safety Cat:</th>
				<td><select name="footplateinspectionsafetycat" class="form-control">
						  <?php /*code to write here */?>
						  <?php if($id_set==1){

						  	echo "<option value='$safetycat' selected>$safetycat</option>";
						  }
						  ?> 
						  <option disabled<?php if($id_set!=1){echo "selected";}?> value> -- SAFETY CAT -- </option>
						  <option value="A">A</option>
	                      <option value="B">B</option>
	                      <option value="C">C</option>
				</select>
			</td>
			</tr>
	        <tr>
				<th>ALPs Name: </th>
				<td><input type="text" name="footplateinspectionalpsname" placeholder = "ALPs Name" class="form-control" <?php if($id_set==1) echo "value='$alpsname'"; ?> /></td>
			</tr>
	        <tr>
				<th>ALPs CMS ID: </th>
				<td><input type="text" name="footplateinspectionalpscmsid" placeholder = "ALPs CMS ID" class="form-control" <?php if($id_set==1) echo "value='$alpscmsid'"; ?> /></td>
			</tr>
	        <tr>
				<th>Departure: </th>
				<td><input type="datetime-local" name="footplateinspectiondeparture" placeholder = "Departure" class="form-control" <?php if($id_set==1) echo "value='$departure'"; ?> /></td>
			</tr>
	        <tr>
				<th>Arrival: </th>
				<td><input type="datetime-local" name="footplateinspectiondarrival" placeholder = "Arrival" class="form-control" <?php if($id_set==1) echo "value='$arrival'"; ?> /></td>
			</tr>
		</table>
		<div class="spacing-for-button">
	
	<button class="btn btn-primary"onclick="hideshow();return false;" id="mytoggle">OBSERVATION</button>
<input type="submit" value="Display" class="btn btn-warning" name="modify" id="btndisplay">
</div>
</div>

