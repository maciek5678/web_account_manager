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
		document.getElementById("balance2").innerHTML="<div class='dates col-12 col-md-6'>Data początkowa</br><input type='date' id='data' ><br/></div>   <div class='dates col-12 col-md-6'> Data końcowa</br><input type='date' id='data' ><br/>  </div></div> <div style='clear:both;'></div>     <div id='incomeTable' class='col-12 col-md-6'> Przychody<br/> <table><tr><td>Data</td> <td>Kwota</td> <td>Typ</td> </tr><tr><td>4</td> <td>5</td> <td>6</td></tr><tr><td>7</td> <td>8</td> <td>9</td></tr></table></div> <div id='expenseTable' class='col-12 col-md-6'>Wydatki<br/><table><tr><td>Data</td> <td>Kwota</td> <td>Typ</td> </tr><tr><td>4</td> <td>5</td> <td>6</td></tr><tr><td>7</td> <td>8</td> <td>9</td></tr></table></div> <div style='clear:both;'>Gratulacje. Świetnie zarządzasz finansami!</div>";
		else
			document.getElementById("balance2").innerHTML="<div id='incomeTable' class='col-12 col-md-6'>Przychody<br/> <table><tr><td>Data</td> <td>Kwota</td> <td>Typ</td> </tr><tr><td>4</td> <td>5</td> <td>6</td></tr><tr><td>7</td> <td>8</td> <td>9</td></tr></table></div> <div id='expenseTable' class='col-12 col-md-6'>Wydatki<br/><table><tr><td>Data</td> <td>Kwota</td> <td>Typ</td> </tr><tr><td>4</td> <td>5</td> <td>6</td></tr><tr><td>7</td> <td>8</td> <td>9</td></tr></table></div> <div style='clear:both;'></div>Uważaj, wpadasz w długi!";

	}

        anychart.onDocumentReady(function() {

  // set the data
  var data = [
     {x: "Jedzenie", value: 2235},
      {x: "Mieszkanie", value: 389},
      {x: "transport", value: 2932},
      {x: "Telekomunikacja", value: 1467},
      {x: "Opieka zdrowotna", value: 540},
      {x: "Ubranie", value: 1910},
      {x: "Higiena", value: 900},
	  {x: "Dzieci", value: 2235},
      {x: "Rozrywka", value: 3892},
      {x: "Wycieczka", value: 2932},
      {x: "Szkolenia", value: 14},
      {x: "Książki", value: 540},
      {x: "Oszczędności", value: 1910},
      {x: "Na złotą jesień, czyli emeryturę", value: 900},
	  {x: "Spłata długów", value: 54},
      {x: "Darowizna", value: 1910},
      {x: "Inne wydatki", value: 900}
  ];

  // create the chart
  var chart = anychart.pie();

  // set the chart title
  chart.title("Struktura wydatków");

  // add the data
  chart.data(data);

  // display the chart in the container
  chart.legend().position("right");
// set items layout
chart.legend().itemsLayout("vertical");
  chart.container('c');
  chart.draw();

});