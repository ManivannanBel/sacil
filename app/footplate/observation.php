<div class="panel-heading">
		<h4 class="panel-title">Observations</h4>
	</div>
		<div class="panel-body" align="center">
			
			
				<table>
					<tr>
						<td><input type="hidden"  class = "form-control" name="trans_id" <?php if($id_set==1){
						$temp_id = $_SESSION['idu'];
						echo "value='$temp_id'";}  ?>/></td>
					</tr>
					<tr id="enabledisableRadio">
						<td colspan='2'><input type="radio" name="enable_disable" value="Disable"> Not Required
						<input type="radio" name="enable_disable" value="Enable" checked> Required</td>
					</tr>
					<tr id="clr1">
						<th>1.</th>
						<th>Brake contuinity test</th>
						<td><input type="number"
						id="obs1" name="obs1"  placeholder="0-10"  min="0" max="11" <?php if($id_set==1) echo "value='$bct'";?>></td>
					</tr>
					<tr id="clr1">
						<th>2.</th>
						<th>Brake feel test</th>
						<td><input type="number" name="obs2" id="obs2" class="form-control" placeholder="0-10"  min="0" max="11" <?php if($id_set==1) echo "value='$bft'"; ?>/></td>
					</tr>
					<tr id="clr1">
						<th>3.</th>
						<th>Brake power test</th>
						<td><input type="number" name="obs3" id="obs3" class="form-control" placeholder="0-10"  min="0" max="11" <?php if($id_set==1) echo "value='$bpt'"; ?>/></td>
					</tr>

					<tr><th colspan="3"><i>Calling out of Signal</i></th></tr>
					<tr id="clr2">
						<th>4.</th>
						<th>Loudly & Clearly</th>
						<td><input type="number" name="obs4" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$lc'"; ?>/></td>
					</tr>
					<tr id="clr2">
						<th>5.</th>
						<th>Station name and Signal</th>
						<td><input type="number" name="obs5" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$snsn'"; ?>/></td>
					</tr> 
					<tr id="clr2">
						<th>6.</th>
						<th>Hand Gesture</th>
						<td><input type="number" name="obs6" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$hg'"; ?>></td>
					</tr>
					<tr id="clr2">
						<th>7. </th>
						<th>Caution Aspects with speed restrictions</th>
						<td><input type="number" name="obs19" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$caution_aspect'"; ?>></td>
					</tr>
					<tr><th colspan="3"><i>Busy setting Bag, Personal belongings etc</i></th></th></th></tr>
					<tr id="clr3">
						<th>8. </th>
						<th>While Starting a Train</th>
						<td><input type="number" name="obs7" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$st1'"; ?>></td>
					</tr>
					<tr id="clr3">
						<th>9. </th>
						<th>While Stopping a Train</th>
						<td><input type="number" name="obs8" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$st2'"; ?>></td>
					</tr>
					<tr id="clr1">
						<th>10. </th>
						<th>Stopping train at adequate distance of DANGER signal</th>
						<td><input type="number" name="obs9" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$red'"; ?>></td>
					</tr>
					<tr id="clr1">
						<th>11. </th>
						<th>Alertness of crew</th>
						<td><input type="number" name="obs10" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$alertness'"; ?>></td>
					</tr>
					<tr id="clr1">
						<th>12. </th>
						<th>Observing Caution order & PSR speeds</th>
						<td><input type="number" name="obs11" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$caution_order'"; ?>></td>
					</tr>
					<tr id="clr1">
						<th>13. </th>
						<th>Picking up of attacking speed</th>
						<td><input type="number" name="obs12" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$attacking'"; ?>></td>
					</tr>
					<tr id="clr1">
						<th>14. </th>
						<th>Notching UP technique</th>
						<td><input type="number" name="obs13" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$up_technique'"; ?>></td>
					</tr>
					<tr id="clr1">
						<th>15. </th>
						<th>Braking Technique</th>
						<td><input type="number" name="obs14" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$brake'"; ?>></td>
					</tr>
					<tr id="clr1">
						<th>16. </th>
						<th>SPAD prevention knowledge</th>
						<td><input type="number" name="obs15" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$spad'"; ?>></td>
					</tr>
					<tr id="clr1">
						<th>17. </th>
						<th>VCD Acknowledgement</th>
						<td><input type="number" name="obs16" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$vcd'"; ?>></td>
					</tr>
					<tr id="clr1">
						<th>18. </th>
						<th>Conventional loco Trouble Shooting knowledge</th>
						<td><input type="number" name="obs17" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$cts'"; ?>></td>
					</tr>
					<tr id="clr1">
						<th>19. </th>
						<th>3 Phase loco Trouble Shooting knowledge</th>
						<td><input type="number" name="obs18" class="form-control" placeholder="0-10"  min="0" max="10" <?php if($id_set==1) echo "value='$pts'"; ?>></td>
					</tr>

				</table>	
				
	<?php
		if($id_set==1){
	?>
	<input type="submit" name="UpdateRecord" value="Update" class="btn btn-success"></input>
	<input type="submit" name="DeleteRecord" value="Delete" class="btn btn-danger"></input>
	<?php
		unset($_SESSION['idu']);
		$id_set = 0;
	}else{
	?>
	<input type="submit" name="SaveRecord" value="Save" class="btn btn-success"></input>
	<?php 
		}
		
	 ?>
	
	</div>


	