$( document ).ready(function() {
    get_contact();
});


function switch_view(thing1,thing2){
    $('#'+thing1+'_button').hide();
    $('#'+thing2+'_button').show();
    $('#'+thing2+'_view').slideUp();
    $('#'+thing1+'_view').slideDown();
}

function switch_thing(thing1,thing2){
    $('#'+thing1).hide();
    $('#'+thing2).show();
}

function sort_contact(liste_name){
    alert('Sorting lists to show :'+liste_name);
}

function add_contact(){  
    new_nom_empty=$('#new_nom').val()=='';
    new_prenom_empty=$('#new_prenom').val()=='';
    if (new_nom_empty || new_prenom_empty){
       alert('Les champs nom et prenoms sont obligatoires'); 
        
    }
    else{
        $.ajax({
            url : "/SymfonyC/web/app_dev.php/ajouter/", 
            type : "POST",
            cache: false,
            dataType: 'json',
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            data : { 
                new_nom : $('#new_nom').val(),
                new_prenom : $('#new_prenom').val(),
                new_tel : $('#new_tel').val(),
                new_email : $('#new_email').val(),
                new_adresse : $('#new_adresse').val(),
                new_website : $('#new_website').val(),

            }, 
            success : function(json) {   
                $('#list_contact_view').prepend(json.list);
                $('#card_view').prepend(json.carte);
                $('#all_contact_modal').prepend(json.modale);
                $('#alert_add_contact').hide();
                $('#modale_new').modal('hide');
            },
            error : function(xhr,errmsg,err) {
                $('#alert_add_contact').show(); 
            }
        });
    }       
    
}

function edit_contact(id_contact){  
    new_nom_empty=$('#new_nom_'+id_contact).val()=='';
    new_prenom_empty=$('#new_prenom_'+id_contact).val()=='';
    if (new_nom_empty || new_prenom_empty){
       alert('Les champs nom et prenoms sont obligatoires'); 
    }
    else{
        $.ajax({
            url : "/SymfonyC/web/app_dev.php/modifier/", 
            type : "POST",
            cache: false,
            dataType: 'json',
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            data : { 
                id_contact : id_contact,
                new_nom : $('#new_nom_'+id_contact).val(),
                new_prenom : $('#new_prenom_'+id_contact).val(),
                new_tel : $('#new_tel_'+id_contact).val(),
                new_email : $('#new_email_'+id_contact).val(),
                new_adresse : $('#new_adresse_'+id_contact).val(),
                new_website : $('#new_website_'+id_contact).val(),

            }, 
            success : function(json) {   
                if(json.is_ok){
                    $('#modale_'+id_contact).modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('#carte_contact_'+id_contact).remove();
                    $('#list_contact_'+id_contact).remove();
                    $('#modale_'+id_contact).remove(); 
                    $('#list_contact_view').prepend(json.list);
                    $('#card_view').prepend(json.carte);
                    $('#all_contact_modal').prepend(json.modale);
                    $('#modale_'+id_contact).modal('show');
                    alert("Modifications enregistrées !") 
                }
            },
            error : function(xhr,errmsg,err) {
                alert("Erreur lors de la modification du contact.") 
            }
        });
    }       
    
}


function remove_contact(id_contact){
    var r = confirm("Voulez vous vraiment supprimer ce contact ?");
    if (r){
    $.ajax({
        url : "/SymfonyC/web/app_dev.php/supprimer/", 
        type : "POST",
        cache: false,
        dataType: 'json',
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        data : { 
            id_contact :id_contact,
        }, 
        success : function(json) {   
            if(json.is_ok){
                $('#carte_contact_'+id_contact).remove();
                $('#list_contact_'+id_contact).remove();
                $('#modale_'+id_contact).remove();  
            }
        },
        error : function(xhr,errmsg,err) {
           alert("Erreur lors de la suppression du contact.") 
        }
     }); 
    }
    else{return false;}
}

function get_contact(liste=false){ 
    if (!liste){liste='NULL';}
    $.ajax({
        url : "/SymfonyC/web/app_dev.php/get/", 
        type : "POST",
        cache: false,
        dataType: 'json',
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        data : { 
            liste :liste,
        }, 
        success : function(json) {   
            $('#list_contact_view').html(json.list);
            $('#card_view').html(json.carte);
            $('#all_contact_modal').html(json.modale); 
        },
        error : function(xhr,errmsg,err) {
           alert("Erreur lors du chargement des contacts.") 
        }
     }); 
}

function remove_list(list_name){
    alert('Removed :'+list_name);
}

//list management
function is_in_list(liste_name,id_user){
    
    
    
  return false;  
}
function remove_from_list(liste_name,id_user){
    
    
    return true; 
}

function add_to_list(liste_name,id_user,auto_add=-1){
    alr_in_list=is_in_list(liste_name,id_user)
    if(auto_add!=-1){
        add=auto_add;
    }else{
        add=$('#list_'+id_user+'_'+liste_name).prop('checked');
    }
    //Ajout a la liste
    if (add && !alr_in_list){
        alert('Added '+id_user+' to list: '+liste_name);
        if (liste_name=='fav'){
            a=0;
        }
    }
    
    //Suppression de la liste
    if (!add && alr_in_list){
        alert('removed '+id_user+' from list: '+liste_name);
    }
    
}