$('#user_input_autocomplete_address').autocomplete({
    source : function(request, response){
    $.ajax({
            url : 'https://api-adresse.data.gouv.fr/search/?q='+ $('#user_input_autocomplete_address').val() ,
            dataType : 'json',
                
            success : function(data){
                response($.map(data.features, function(objet){
                    console.log(objet.properties.label);
                    return objet.properties.label; // on retourne cette forme de suggestion
                }));
            }
        });
    }
});