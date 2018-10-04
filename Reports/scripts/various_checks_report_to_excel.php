<script type="text/javascript" src="scripts/libraries/jszip.js"></script>
<script type="text/javascript" src="scripts/libraries/FileSaver.js"></script>
<script type="text/javascript" src="scripts/libraries/myexcel.js"></script>
<script type="text/javascript">

//--------------------------------------------------------------------------------
function getCurrentDate(){
			var today  = new Date();
			var current_date = today.toLocaleDateString("en-US");
			return String(current_date);
		}
//-------------------WRITING THE ENTIRE REPORT TO EXCEL-------------------------------
function extractJSON_from_entire_report(){
		var Result = '';
		<?php 
		if(isset($jrec)){
		if (!empty($jrec)) {?>
		/*Result = JSON.parse('<?php echo json_encode($jrec);  ?>');
		Result = JSON.stringify('<?php echo  json_encode($jrec);?>');
		Result = Result.escapeSpecialChars();
		Result = JSON.parse(Result); */
		Result = JSON.parse(JSON.stringify(<?php echo  json_encode($jrec);?>));
		<?php }} ?>
		return Result;
}


function write_Entire_Report_Excel(){
	var Result = extractJSON_from_entire_report();
	writeJSONtoEXCEL(Result, "Various Checks Summary");

}

//-------------------other functions for individual reports of various checks-----------
function write_Individual_Report_Excel(){
var Result = '';
<?php 
if(isset($records)){
if (!empty($records)) {?>
//Result = JSON.parse('<?php echo json_encode($jResult);  ?>');
Result = JSON.parse(JSON.stringify(<?php echo  json_encode($jResult);?>));
	/*Result = JSON.stringify('<?php echo  json_encode($jResult);?>');
		Result = Result.escapeSpecialChars();
		Result = JSON.parse(Result);*/
//-----------------------------------------
console.log(Result);
var h = Result["headings"];
console.log(h);
var r = Result["record"];
for(var i =0;i<r.length;i++){
	console.log(r[i]);
}

writeJSONtoEXCEL(Result,"Individual Check");
<?php }} ?>
return Result;
}
//---------------Writing json to excel-----------------------------------------------------
function writeJSONtoEXCEL(Result, topic){
	var sheet_no = 0;
			var sheet_title = topic;
			var excel = $JExcel.new("Calibri light 10 #333333");
			excel.set( {sheet:sheet_no,value:sheet_title } );
			
			var heading = Result["headings"];
			var record  = Result["record"];
			var myHeadingStyle = excel.addStyle({
						font: "Calibri 13 #454550 B"
					});
			var myDataStyle = excel.addStyle({
						font: "Century 10 #000000"
					});

			//------------putting heading into excel-----------------------------------
					for(var i = 0; i<heading.length;i++){
								var h = heading[i].toString().toUpperCase();
								h = h.replace("_"," ");
								excel.set(sheet_no,i,0,h,myHeadingStyle);
								
						}
			//-----------putting data from array---------------------------------------

						for(var i = 0; i<record.length;i++){
							for(var j =0; j<record[i].length;j++){
								var rec = record[i][j].toString().toUpperCase();
								excel.set(sheet_no,j,i+1,rec,myDataStyle);
								}
						}
			//------------------------------------------------------------------------
			excel.generate(topic+getCurrentDate()+".xlsx");
}

</script>