<script type="text/javascript" src="scripts/libraries/jszip.js"></script>
<script type="text/javascript" src="scripts/libraries/FileSaver.js"></script>
<script type="text/javascript" src="scripts/libraries/myexcel.js"></script>
<script type="text/javascript">
//------------------------full forms ------------------------------------
function getFullForms(sf){
	var fullform = { 'bct': 'Brake contuinity test',
			'bft': 'Brake feel test',	
			'bpt' : 'Brake power test',
			'lc' : 'Loudly & Clearly',
			'snsn' : 'Station name and Signal',
			'hg' : 'Hand Gesture',
			'st1' : 'While Starting a Train',
			'st2' : 'While Stopping a Train',
			'cts' : 'Conventional loco Trouble Shooting knowledge',
			'pts' : '3 Phase loco Trouble Shooting knowledge'
			};
			sf = sf.toLowerCase();
            if(sf in fullform) return fullform[sf];
            return sf;
}
//------------------------WRITING CODE TO EXPORT DATA TO EXCEL----------
function getCurrentDate(){
			var today  = new Date();
			var current_date = today.toLocaleDateString("en-US");
			return String(current_date);
}
//------------------------USE OF JSON-------------
//-----------------------EXTRACTING DATA----------------
function extractTable(){
var Result = '';
console.log("Starting to extract");
<?php 
if(isset($Jtable)){
if (!empty($Jtable)) { ?>

Result = JSON.parse(JSON.stringify(<?php echo json_encode($Jtable);?>));


console.log("Working");
console.log(Result);
console.log(" NOt Working");
<?php }} ?>
console.log(" NOt Working 1");
return Result;
}
//-----------------------END OF JSON-----------------
//------------------------json to excel--------------
function JSONtoEXCEL(){
	var Result = extractTable();
	var sheet_no = 0;
			var sheet_title = "FootPlate Report";
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
								var h = getFullForms(heading[i]);
								h = h.replace("_"," ").toUpperCase();
								excel.set(sheet_no,i,0,h,myHeadingStyle);
								
						}
			//-----------putting data from array---------------------------------------

					for (var i = 0; i < record.length; i++) {
						    var object = record[i];
						    var j=0;
						    for (property in object) {
						        var value = object[property];
						        value = value.toString().toUpperCase();
						        excel.set(sheet_no,j,i+1,value,myDataStyle);
						        j++;
						    }
						}

						
			//------------------------------------------------------------------------
			excel.generate("Footplate Report "+getCurrentDate()+".xlsx");

}


</script>