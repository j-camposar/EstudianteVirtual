$.material.init();
Survey.defaultBootstrapMaterialCss.navigationButton = "btn btn-green";
Survey.defaultBootstrapMaterialCss.rating.item = "btn btn-default my-rating";
Survey.StylesManager.applyTheme("bootstrapmaterial");

var json = { 
    locale: "es",
    pages: [
        {questions: [
            { type: "matrix", name: "Course", isRequired: true, title: "Dimensión: Curso de Capacitación",
                columns: [{ value: 1, text: "1" }, 
                          { value: 2, text: "2" }, 
                          { value: 3, text: "3" }, 
                          { value: 4, text: "4" }, 
                          { value: 5, text: "5" }],
                rows: [{ value: "a", isRequired: true, text: "Considero que los contenidos tratados en el curso son de aporte al desempeño laboral de los participantes" }, 
                       { value: "b", isRequired: true, text: "Los contenidos entregados en el curso son concordantes con la realidad" },
                       { value: "c", isRequired: true, text: "La forma de entrega general del curso fue" }]},
            { type: "matrix", name: "Commerce", title: "Dimensión: Comercialización",
                columns: [{ value: 1, text: " 1 " }, 
                          { value: 2, text: " 2 " }, 
                          { value: 3, text: " 3 " }, 
                          { value: 4, text: " 4 " }, 
                          { value: 5, text: " 5 " }],
                rows: [{ value: "d", isRequired: true, text: "Considero que de parte de mi área u empresa se entregó la información real y fidedigna del curso." }, 
                       { value: "e", isRequired: true, text: "El lugar fue apropiado" }
                       ]},           
            { type: "matrix", name: "Services", isRequired: true, title: "Dimensión: Servicios",
                columns: [{ value: 1, text: "1" }, 
                          { value: 2, text: "2" }, 
                          { value: 3, text: "3" }, 
                          { value: 4, text: "4" }, 
                          { value: 5, text: "5" }],
                rows: [{ value: "f", isRequired: true, text: "El proceso de la relatoría fue eficiente." }, 
                       { value: "g", isRequired: true, text: "El curso fue adecuado, cordial y puntual." },
                       { value: "h", isRequired: true, text: "La información entregada fue adecuada." }]},
            { type: "matrix", name: "Compromise", isRequired: true, title: "Dimensión: Compromiso",
                columns: [{ value: 1, text: "1" }, 
                          { value: 2, text: "2" }, 
                          { value: 3, text: "3" }, 
                          { value: 4, text: "4" }, 
                          { value: 5, text: "5" }],
                rows: [{ value: "i", isRequired: true, text: "Considero que mi empresa ha mantenido una relación de compromiso con el proceso educativo de nosotros los trabajadores." }, 
                       { value: "j", isRequired: true, text: "Considero que mi empresa ha considerado y atendido las necesidades, la organización y los participantes para este curso." },
                       { value: "k", isRequired: true, text: "Considero que mi empresa es y ha actuado de forma responsable con el servicio entregado." },
                       { value: "l", isRequired: true, text: "Considero que el relator demostró compromiso con lo entregado" }]},
            { type: "comment", name: "comment", 
                       title: "Comentarios Generales (Opcional)"},            
            { type: "text", name: "company", 
                       title: "Empresa (Opcional)"},
            { type: "text", name: "name", 
                       title: "Nombre (Opcional)"}
            
        ]},
        { questions: [
            
        ]}
    ],
completedHtml: "<p><h4>Gracias por Participar de la encuesta.</h4></p>"
};

window.survey = new Survey.Model(json);

survey
     .onComplete
     .add(function(result) { 
         document
         .querySelector('#surveyResult')
         
         localStorage["surveys"] = localStorage["surveys"] +"\\"+ JSON.stringify(result.data, null, 3);
         Swal.fire(
            'Encuesta Completada',
            'Gracias por participar en la encuesta!',
            'success'
        ).then((result) => {
            window.location.href = "index.html";
            });
    });


$("#surveyElement").Survey({ 
    model: survey 
});;
                    