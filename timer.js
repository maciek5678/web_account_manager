	
	

	function pobierzDate()
	{
	
		var dzisiaj=new Date();
		
	var dzien=dzisiaj.getDate();
	if(dzien<10)
		dzien="0"+dzien;
	var miesiac=dzisiaj.getMonth()+1;
	if(miesiac<10)
		miesiac="0"+miesiac;
	var rok=dzisiaj.getFullYear();
if(rok<10)
		rok="0"+rok;
	
	document.getElementById("data").value= rok+"-"+miesiac+"-"+dzien;
	
	}
	

	

	
	
	function changeDate(selectObject)
	{
		var value = selectObject.value;  

		
		if(value=="unusual")
		document.getElementById("balance3").innerHTML="<div class='dates col-12 col-md-6'>Data początkowa</br><input type='date' id='data' name='datapocz'><br/></div>   <div class='dates col-12 col-md-6'> Data końcowa</br><input type='date' id='data' name='datakonc'><br/>  </div></div> <div style='clear:both;'>";
else
	document.getElementById("balance3").innerHTML="";
			
	}


	
	

	


	
	
	

        anychart.onDocumentReady(function() {

  // set the data
var data = [
  {x: "A", value:'transport'},
  {x: "B", value: 7.5},
  {x: "C", value: 1},
  {x: "D", value: 2},
  {x: "E", value: 3}
];

// create a chart and set the data
chart = anychart.pie(data);

// set the container id
chart.container("c");

// initiate drawing the chart
chart.draw();

	

});


