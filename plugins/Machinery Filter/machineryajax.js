/**************************************************************************************/
function setVariables(){
	
			//removes the fade in class after button is pressed
/************************  setvariables() *****************************/
/**************************************************************************************/
	
//set variables run on button push and sort select
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
			// var sortby = document.getElementById('sortby').value;
			var sortby = "";
			
	
		
		//Variables are sent to machineryajax function
		machineryajax(
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




jQuery(document).ready(function( $ ) {
/**************************************************************************************/
/************************  myDropdown() *****************************/
/**************************************************************************************/

	// *****************TRIGGERS THAT MAKE THE mydropdown function RUN	
	$('#divisions').on('change', function() {
  myDropdown();
});	

function myDropdown(){

//*******************now get the value of divisions
var divisionstr = document.getElementById('divisions').value;
///// only run this if divisions is not set to 'all'

if (divisionstr == 'all'){
	//do nothing if division is 'all'
	}
else{
	
////*****************put spinner up while processing	
$fmachineryresponse ='<p style="text-align:center"><img src="/wp-content/plugins/machinery-filter/assets/Spinner.gif" style="height:30px;width:30px;"/>';
document.getElementById("machinerytype-section").innerHTML = $fmachineryresponse;
document.getElementById("manufacturer-section").innerHTML = $fmachineryresponse;

//**********************now add an ajax call that gets data from mydropdown.php

var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function() {
    if (xhr.readyState === 4){
       document.getElementById('machinerytype-section').innerHTML = xhr.responseText;
	   $('select').selectpicker();
	   $('#machinerytype').on('change', function() {
		  setVariables();
		});
    }
};
xhr.open('GET', '/wp-content/plugins/machinery-filter/mydropdown.php?ajax=ajax&div=' + divisionstr);
xhr.send();



//**********************now add an ajax call that gets data from mydropdown.php

var zhr = new XMLHttpRequest();
zhr.onreadystatechange = function() {
    if (zhr.readyState === 4){
       document.getElementById('manufacturer-section').innerHTML = zhr.responseText;
	   $('select').selectpicker();
	   $('#manufacturer').on('change', function() {
		  setVariables();
		});
		$('#machinerytype').on('change', function() {
						  myManudrop();
								});	
    }
};
zhr.open('GET', '/wp-content/plugins/machinery-filter/mydropdownmanu.php?ajax=ajax&div=' + divisionstr);
zhr.send();


}
}



/**************************************************************************************/
/************************  myManuDrop() *****************************/
/**************************************************************************************/

// *****************TRIGGER THAT MAKES THE mymanudrop function RUN
	
							$('#machinerytype').on('change', function() {
						  myManudrop();
								});	
								
								function myManudrop(){
								
								//*******************now get the value of divisions
								var machstr = document.getElementById('machinerytype').value;
								///// only run this if divisions is not set to 'all'
									
								if (machstr === 'all' || machstr === "") {
									//do nothing if division is 'all'
									}
								else{
								//	alert(machstr);
								/////  cleanup machstr - remove ampersands and brackets, spaces to hyphens and set to lower	case
						machstr = machstr.replace("& ", '');
						machstr = machstr.replace("(", '');	
						machstr = machstr.replace(")", '');		
						machstr = machstr.replace(/\s+/g, '-');
						
						machstr = machstr.toLowerCase();
								//alert(machstr);
									
									////*****************put spinner up while processing	
								$fmacresponse ='<p style="text-align:center"><img src="/wp-content/plugins/machinery-filter/assets/Spinner.gif" style="height:30px;width:30px;"/>';
								document.getElementById("manufacturer-section").innerHTML = $fmacresponse;
								
								//**********************now add an ajax call that gets data from mydmanutwo.php
								
								var bhr = new XMLHttpRequest();
								bhr.onreadystatechange = function() {
									if (bhr.readyState === 4){
									   document.getElementById('manufacturer-section').innerHTML = bhr.responseText;
									   $('select').selectpicker();
									   $('#manufacturer').on('change', function() {
										  setVariables();
										});
									}
								};
								bhr.open('GET', '/wp-content/plugins/machinery-filter/mydmanutwo.php?ajax=ajax&mach=' + machstr);
								bhr.send();
									
								}
								}
								
						

/**************************************************************************************/
/************************  toggle the buttons() *****************************/
/**************************************************************************************/


//Toggle the buttons visually by adding/removing class
$( ".filter-button" ).click(function() {
  $( this ).toggleClass( "selected" );
});




// TRIGGERS THAT MAKE THE MAIN FUNCTION RUN

//on load


$(window).on('load', function() {
	
		//Adds a message while the query is being processed
			document.getElementById("machinery-filter-response").innerHTML = '<div class="col-md-12"><p style="text-align:center"><img src="/wp-content/plugins/machinery-filter/assets/Spinner.gif" /></p></div>';
			
			//set values

			var used = '';


			var stockOffer = '';
	
			var exhire = '';
	
			var exdemo = '';
		
			
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
			var sortby = "";
			
			
	 		machineryajax(
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
});


//send variables on button change
$('#used,#stockOffer,#exhire,#exdemo').click(function(){
  setVariables();
});

//send variables on change
$('#divisions,#machinerytype,#manufacturer,#clock,#year,#min-value,#max-value,.noUi-origin').on('change', function() {
  setVariables();
});

//send variables on mouseout for the price ranges
/*$('.slider-section').on('mouseout', function() {
  setVariables();
});*/

//Send variables via ajax only when button is pressed	
$("#btnSubmit").click(function(){

	setVariables();
		
    }); 
	
	$("#btnMore").click(function(){
	setVariables();
    });
	

	
});



// JavaScript Document

function machineryajax(usedstr, stockOfferstr, exhirestr, exdemostr , divisionsstr, machinerytypestr, manufacturerstr, clockstr, yearstr, sliderMinstr, sliderMaxstr, sortbystr){
$mystring = " ";
//Used for testing variable values

$mystring += "<p>Ajax variables</p> ";
$mystring += "<p>used string is ";
$mystring +=  usedstr;
$mystring += "</p><p> stockOffer string is ";
$mystring +=  stockOfferstr;
$mystring += "</p><p> exhire string is ";
$mystring +=  exhirestr;
$mystring += "</p><p> exdemo string is ";
$mystring +=  exdemostr;
$mystring += "</p><p> divisions string is ";
$mystring +=  divisionsstr;
$mystring += "</p><p> machinerytype string is ";
$mystring +=  machinerytypestr;
$mystring += "</p><p> manufacturer string is ";
$mystring +=  manufacturerstr;
$mystring += "</p><p> clock string is ";
$mystring +=  clockstr;
$mystring += "</p><p> year string is ";
$mystring +=  yearstr;
$mystring += "</p><p> sliderMin string is ";
$mystring +=  sliderMinstr;
$mystring += "</p><p>sliderMax string is ";
$mystring +=  sliderMaxstr;
$mystring += "</p><p> sortby string is ";
$mystring +=  sortbystr;
$mystring += "</p>";

console.log( $mystring );


 /*if (divisionsstr.length == 0) { 
        document.getElementById("machinery-filter-response").innerHTML = $mystring;
        return;
    } else {*/

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
	 xmlhttp.open("GET", "/wp-content/plugins/machinery-filter/getdata.php?ajax=ajax&used=" + usedstr + "&stockOffer=" + stockOfferstr + "&exhire=" + exhirestr + "&exdemo=" + exdemostr + "&divisions=" + divisionsstr + "&machinerytype=" + machinerytypestr + "&manufacturer=" + manufacturerstr + "&clock=" + clockstr + "&year=" + yearstr + "&sliderMin=" + sliderMinstr + "&sliderMax=" + sliderMaxstr + "&sortby=" + sortbystr, true);
	 //alert("getdata.php?ajax=ajax&used=" + usedstr + "&stockOffer=" + stockOfferstr + "&exhire=" + exhirestr + "&exdemo=" + exdemostr + "&divisions=" + divisionsstr + "&machinerytype=" + machinerytypestr + "&manufacturer=" + manufacturerstr + "&clock=" + clockstr + "&year=" + yearstr + "&sliderMin=" + sliderMinstr + "&sliderMax=" + sliderMaxstr + "&sortby=" + sortbystr");
        xmlhttp.send();
		
		   




}
