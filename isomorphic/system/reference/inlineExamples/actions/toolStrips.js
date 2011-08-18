isc.ImgButton.create({
    ID: "alignLeft",
    size: 24,
    src: "icons/24/text_align_left.png",
    showRollOver: false,
    showFocused: false,
    actionType: "radio",
    radioGroup: "textAlign"
});
isc.ImgButton.create({
    ID: "alignRight",
    size: 24,
    src: "icons/24/text_align_right.png",
    showRollOver: false,
    showFocused: false,
    actionType: "radio",
    radioGroup: "textAlign"
});
isc.ImgButton.create({
    ID: "alignCenter",
    size: 24,
    src: "icons/24/text_align_center.png",
    showRollOver: false,
    showFocused: false,
    actionType: "radio",
    radioGroup: "textAlign"
});
isc.ImgButton.create({
    ID: "bold",
    size: 24,
    src: "icons/24/text_bold.png",
    showRollOver: false,
    showFocused: false,
    actionType: "checkbox"
});
isc.ImgButton.create({
    ID: "italics",
    size: 24,
    src: "icons/24/text_italics.png",
    showRollOver: false,
    showFocused: false,
    actionType: "checkbox"
});
isc.ImgButton.create({
    ID: "underlined",
    size: 24,
    src: "icons/24/text_underlined.png",
    showRollOver: false,
    showFocused: false,
    actionType: "checkbox"
});

isc.DynamicForm.create({
    ID: "fontSelector",
    showResizeBar:true,
    width:"*", minWidth:50,
    numCols:1,
    fields: [
        {name: "selectFont", showTitle: false, width:"*",
         valueMap: {
            "courier": "<span style='font-family:courier'>Courier</span>",
            "verdana": "<span style='font-family:verdana'>Verdana</span>",
            "times": "<span style='font-family:times'>Times</span>"
         }, defaultValue:"courier" }
    ]    
});

isc.DynamicForm.create({
    ID: "zoomSelector",
    width:"*", minWidth:50,
    numCols:1,
    fields: [
        {name: "selectZoom", showTitle: false, width:"*",
         valueMap: ["50%", "75%", "100%", "150%", "200%", "Fit"],
         defaultValue:"100%" }
    ]
});

isc.ToolStrip.create({
    width: 450, height:24, 
    members: [bold, italics, underlined, 
              "separator",
              alignLeft, alignRight, alignCenter,
              "separator",
              fontSelector, "resizer", zoomSelector]
});
