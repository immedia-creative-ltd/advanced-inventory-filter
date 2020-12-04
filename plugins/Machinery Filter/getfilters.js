// JavaScript Document
$(document).ready ( function(){
	
	
	//the main function is called mySortby
	
	//before we run it we need to get some variable values to pass to it
	
	
	function setValues(){
		$("#machinery-filter-response").removeClass('fadeIn');
		//Adds a message while the query is being processed
			document.getElementById("machinery-filter-response").innerHTML = '<div class="col-md-12"><p style="text-align:center"><img src="/wp-content/plugins/machinery-filter/assets/Spinner.gif" /></p></div>';
	
	//set values
			if ( $('#used').hasClass( "selected" ) ) {
				var used = $('#used').attr('name');
			} else {
				var used = '';
			}


			if ( $('#stockOffer').hasClass( "selected" ) ) {
				var stockOffer = $('#stockOffer').attr('name');
			} else {
				var stockOffer = '';
			}
			
			if ( $('#exhire').hasClass( "selected" ) ) {
				var exhire = $('#exhire').attr('name');
			} else {
				var exhire = '';
			}
			
			if ( $('#exdemo').hasClass( "selected" ) ) {
				var exdemo = $('#exdemo').attr('name');
			} else {
				var exdemo = '';
			}
			
			
			//set division value
			var divisions = document.getElementById('divisions').value;
			
			
			//set machinerytype values and combine values to send to getdata
			var machinerytype = [];
			$.each($("#machinerytype option:selected"), function(){   
			var machtype = $(this).val();
			machtype = escape(machtype);
			//console.log(type);
            machinerytype.push(machtype);
            machinerytype.join();
			});

			//set manufacturer values and combine values to send to getdata
			var manufacturer = [];
			$.each($("#manufacturer option:selected"), function(){   
			var manu = $(this).val();
			manu = escape(manu);			
            manufacturer.push(manu);
            manufacturer.join();
			});
			
			var clock = document.getElementById('clock').value;
			
			var year = document.getElementById('year').value;
			
			//set value and convert to simple integar
			var sliderMin = document.getElementById('sliderMin').innerHTML;
			var sliderMin = Number(sliderMin.replace(/[^0-9.-]+/g,""));
			
			//set value and convert to simple integar
			var sliderMax = document.getElementById('sliderMax').innerHTML;
			var sliderMax = Number(sliderMax.replace(/[^0-9.-]+/g,""));
			
			//get sortby value
			 var sortby = document.getElementById('sortby').value;
		
			
	//ok, variables set, now send them to mysortby
	
	//Variables are sent to machineryajax function
		mySortby(
			used,
			stockOffer,
			exhire,
			exdemo,
			divisions,
			machinerytype,
			manufacturer,
			clock,
			year,
			sliderMin,
			sliderMax,
			sortby
		
		);	
	
	}
	//end of setvalues function
	
	

function mySortby(usedstr, stockOfferstr, exhirestr, exdemostr , divisionsstr, machinerytypestr, manufacturerstr, clockstr, yearstr, sliderMinstr, sliderMaxstr, sortbystr){
	
	
	console.log ("function mySortby running");
	 
	 
	console.log (usedstr + "," + stockOfferstr + "," + exhirestr + "," + exdemostr  + "," + divisionsstr + "," + machinerytypestr + "," + manufacturerstr + "," + clockstr + "," + yearstr + "," + sliderMinstr + ","+ sliderMaxstr + "," + sortbystr);		
	 var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {

	var response = this.responseText;
	//catch if no results are got from query
	if (response.indexOf('machinery-filter-col') > -1)
	{
		document.getElementById("machinery-filter-response").innerHTML = response;
	} else {
		document.getElementById("machinery-filter-response").innerHTML = 'No results to display, try refining your search.';
	}
 
  //fade in list for effect
  $("#machinery-filter-response").addClass('fadeIn');
 return;
			}
 
		}
	 xmlhttp.open("GET", "/wp-content/plugins/machinery-filter/getfilters.php?ajax=ajax&used=" + usedstr + "&stockOffer=" + stockOfferstr + "&exhire=" + exhirestr + "&exdemo=" + exdemostr + "&divisions=" + divisionsstr + "&machinerytype=" + machinerytypestr + "&manufacturer=" + manufacturerstr + "&clock=" + clockstr + "&year=" + yearstr + "&sliderMin=" + sliderMinstr + "&sliderMax=" + sliderMaxstr + "&sortby=" + sortbystr, true);
	
        xmlhttp.send();
			
}

$('#sortby').on('change', function() {
	setValues();
});	

});	