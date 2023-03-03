function getOwner(){
    $.ajax({
        url: 'http://localhost/api/index.php/owner',
        type: 'GET',
        success: function(response) {
            if(response.length !=0 ){
                var table = $('#owner-table').DataTable();
                $.each(response, function(index, owner){
                    table.row.add([
                        owner.owner_id,
                        owner.name,
                        owner.lastname,
                        owner.phone,
                        moment(owner.CREATION_DATE).format('DD/MM/YYYY'),
                        "<td class='icons'>"+
                        "<i  class='view_animal fa fa-eye' data-id='"+owner.owner_id+"' aria-hidden='true'></i>"+
                        "<i class='delete-btn fa fa-trash' data-id='"+owner.owner_id+"' aria-hidden='true'></i></td>"
                        
                    ]).draw();
                });
            }
          
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Erreur : ' + textStatus + ' - ' + errorThrown);
        }
    });
}


function newOwner(){

    var formData = $("#form_modal_base").serializeArray();
    var jsonData = formData.reduce(function(obj, field) {
        obj[field.name] = field.value;
        return obj;
    }, {});

    $.ajax({
        type: "POST",
        url: "http://localhost/api/index.php/owner",
        data: JSON.stringify(jsonData),
        contentType: "application/json",
        dataType: "json",

        success: function(data) {

            // Fermer le modal au click
            $('#modal_base').css('display', 'none');
            location.reload(); 
        },
        error: function(jqXHR) {
            $('#mensaje-error').text('Error: ' + jqXHR.status + jqXHR.responseText);
            $('#mensaje-error').css("display","block");
            $('#form_modal_base').after($('#mensaje-error'));

        }
    });
    
}



function deleteOwner(tbody){
    var idOwner = $(tbody).data("id");

    $.ajax({
        url: 'http://localhost/api/index.php/owner/'+idOwner,
        type: 'DELETE',
        success: function(response) {
            tbody.closest("tr").remove();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Erreur : ' + textStatus + ' - ' + errorThrown);
        }
    });
}

function viewmodal(){

    var modal = $("#modal_base");
    var span = $(".close")[0];

    modal.css("display", "block");
    
    span.onclick = function() {
        modal.css("display", "none");
    }
    window.onclick = function(event) {
        if (event.target == modal[0]) {
            modal.css("display", "none");
        }
    }
}