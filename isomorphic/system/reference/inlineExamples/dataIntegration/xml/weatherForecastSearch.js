isc.VLayout.create({
	width: "100%",
	height: "100%",
	members: [

isc.SearchForm.create({
	ID: "searchForm",
	wsdlLoaded: function () {
		isc.clearPrompt();
	    var service = isc.WebService.get("http://ws.cdyne.com/WeatherWS/");
		if (service == null) {
			isc.warn("WSDL not currently available from service (tried "
					+"http://ws.cdyne.com/WeatherWS/Weather.asmx?wsdl)");
		}
    
        // bind the SearchForm to a DataSource representing the operation inputs
		this.setDataSource(service.getInputDS("GetCityForecastByZIP"));

        // bind the ListGrid to a DataSource that will show selected operation outputs
        var results = isc.DataSource.create({
            serviceNamespace : service.serviceNamespace,
            xmlNamespaces: {cdyne:"http://ws.cdyne.com/WeatherWS/"},
            wsOperation : "GetCityForecastByZIP",
            recordName:"Forecast",
            fields : [
                { name:"Date", type:"date", align:"left" },
                { name:"Desciption" },
                { name:"MorningLow", valueXPath:"cdyne:Temperatures/cdyne:MorningLow", width: 80},
                { name:"DaytimeHigh", valueXPath:"cdyne:Temperatures/cdyne:DaytimeHigh", width: 80 }
            ]
        });
        searchResults.setDataSource(results);
	}
	
}),

isc.IButton.create({
	title: "Search",
	click: "searchResults.fetchData(searchForm.getValuesAsCriteria())"
}),

isc.ListGrid.create({
	ID: "searchResults",
    fixedRecordHeights:false,
    showAllRecords:true
})

]
});

isc.showPrompt("Loading WSDL from http://ws.cdyne.com/WeatherWS/Weather.asmx?wsdl");
isc.XMLTools.loadWSDL("http://ws.cdyne.com/WeatherWS/Weather.asmx?wsdl", "searchForm.wsdlLoaded()");
