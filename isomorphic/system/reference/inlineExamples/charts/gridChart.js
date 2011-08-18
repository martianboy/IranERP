// generate a random data set
//----------------------------------------
var months = [
    {name:"jun", title:"Jun", longTitle:"June"},
    {name:"jul", title:"Jul", longTitle:"July"},
    {name:"aug", title:"Aug", longTitle:"August"},
    {name:"sep", title:"Sep", longTitle:"September"},
    {name:"oct", title:"Oct", longTitle:"October"},
    {name:"nov", title:"Nov", longTitle:"November"},
    {name:"dec", title:"Dec", longTitle:"December"}
];
var salesData=[], numProducts = 4;
for (var i=0; i<numProducts; i++) {
    salesData[i] = {product:"Product "+(String.fromCharCode(65+i))};
    var minSales = Math.round(Math.random()*8000) + 2000, // 2k-10k
        maxVariance = minSales/3; // up to 33% of min value for this product
    for (var j=0; j<months.length; j++) {
        salesData[i][months[j].name] = Math.round(Math.random()*maxVariance) + minSales;
    }
}

// show a grid view
//----------------------------------------
isc.ListGrid.create({
    ID:"salesDataGrid",
    leaveScrollbarGap:false, height:108,
    canEdit:true, editEvent:'click', 
    
    // editing a cell triggers an update of the chart
    cellChanged:"salesDataGrid.updateChart()",
    updateChart : function (props) {
        // store chart configuration
        if (props) this.chartProps = props;

        // if there's already a chart, destroy it
        if (this.lastChart) this.lastChart.destroy();

        // generate chart
        this.lastChart = this.chartData("product", null, null, this.chartProps);
    
        // show it
        theLayout.addMember(this.lastChart, 1);
    },

    // fields (columns) are the same as the chart categories (months), plus an extra column
    // up front to display the series names
    fields:[{name:"product", title:"Product", canEdit:false}].concat(months),
    // Show custom styling for the non-editable field.
    // Use the "Dark" set of styles
    alternateRecordStyles:false,
    getCellStyle : function (record, rowNum, colNum) {
        var styleName = this.Super("getCellStyle", arguments);
        if (this.getFieldName(colNum) == "product") styleName += "Dark";        
        return styleName;
    },

    data:salesData
});

// allow dynamic chart changing
//----------------------------------------
isc.DynamicForm.create({
    ID:"chartSelector",
    items : [ 
        { name:"chartType", title:"Chart Type", type:"select", 
          valueMap: ["Bar","Column","Line","Area", "Doughnut"],
          defaultValue:"Column", changed:"salesDataGrid.updateChart({chartType: value})" }
    ]
});

// overall layout
//----------------------------------------
isc.VLayout.create({
    ID:"theLayout",
    width:"100%", height:600, membersMargin:20,
    members:[salesDataGrid, chartSelector]
});

salesDataGrid.updateChart();


