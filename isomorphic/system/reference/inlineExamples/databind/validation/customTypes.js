isc.DynamicForm.create({
    ID: "boundForm",
    width: 300,
    dataSource: "customTypes"
});

isc.Button.create({
    top: 60,
    title: "Validate",
    click: "boundForm.validate()"
});