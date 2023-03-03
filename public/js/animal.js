function getAnimal(ownerId){
    $.ajax({
        url: 'http://localhost/api/index.php/owner/'+ownerId+"/animal",
        type: 'GET',
        success: function(response) {
            if(response.length ==0){
                $('#animal-table').parents('div.dataTables_wrapper').first().hide();
                $('.alert').css("display","block");
               
            }else{
                var table = $('#animal-table').DataTable();
                $.each(response, function(index, animal){
                    table.row.add([
                        animal.animal_id,
                        animal.name_owner,
                        animal.name,
                        animal.type,
                        "<td class='icons'><i class='delete-btn fa fa-trash' data-id='"+animal.animal_id+"' aria-hidden='true'></i></td>"
                        
                    ]).draw();
                });
            }   
           

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Erreur : ' + textStatus + ' - ' + errorThrown);
        }
    });
}

function newAnimal(idCity){
    var formData = $("#form_modal_base").serializeArray();
    var formData = $("#form_modal_base").serializeArray();
    var jsonData = formData.reduce(function(obj, field) {
        if (field.name.indexOf('date') !== -1) {
            obj[field.name]=field.value;
        } else if (!isNaN(parseFloat(field.value))) {
          obj[field.name] = parseFloat(field.value);
        } else {
          obj[field.name] = field.value;
        }
        return obj;
      }, {});

    $.ajax({
            type: "POST",
            url: "http://localhost/api/index.php/owner/"+idCity+"/animal",
            data: JSON.stringify(jsonData),
            contentType: "application/json",
            dataType: "json",
            success: function(data) {
                $('#modal_base').css('display', 'none');
                location.reload(); 
            },
            error: function(jqXHR) {
                $('#mensaje-error').text(jqXHR.responseText);
                $('#mensaje-error').css("display","block");
                $('#form_modal_base').after($('#mensaje-error'));

            }
        });

}

function deleteAnimal(ownerId,idAnimal,tr){

    $.ajax({
    url: 'http://localhost/api/index.php/owner/'+ownerId+"/animal/"+idAnimal,
    type: 'DELETE',
    success: function(response) {
        tr.closest("tr").remove();
    }, 
    error: function(jqXHR) {

    }

})
}

function viewmodal(){

    var modal = $("#modal_base");
            
    // Obtener el elemento <span> que cierra el modal
    var span = $(".close")[0];

    modal.css("display", "block");
    
    // Fermer le modal au click
    span.onclick = function() {
        modal.css("display", "none");
    }

    // Fermer le modal au click dehors du m
    window.onclick = function(event) {
        if (event.target == modal[0]) {
            modal.css("display", "none");
        }
    }
}
