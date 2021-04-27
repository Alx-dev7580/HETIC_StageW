let $submit = document.querySelector('#submitCreate');
let $submit_pass = document.querySelector('#submit_pass');
let $form_profil = document.querySelector('#form_profil');
let $message = document.querySelector(".message");
let $message_pass = document.querySelector(".message-pass");
let $message_profil = document.querySelector(".message-profil");
let $id = document.querySelector("#id");

if($submit){$submit.addEventListener("click", user_create);}
if($submit_pass){$submit_pass.addEventListener("click", update_password);}
if($form_profil){$form_profil.addEventListener("submit", (e)=>{update_profil(e)});}

function message(select, type, old_type, text){
    select.classList.remove('alert');
    select.classList.remove('alert-'+old_type);
    
    select.classList.add('alert');
    select.classList.add('alert-'+type);
    select.innerHTML = text;
}

function valideForm(select){
    let nbError = 0;
    let $input = document.querySelectorAll(select);
    $input.forEach(element => {
        if(element.value.trim()===""){
            element.classList.add("is-invalid");
            nbError++;
        } else{
            element.classList.remove("is-invalid");
        }
    });
    return nbError;

}

function user_create(){

    if(valideForm(".require") !== 0){
        message($message, "danger", "success","Veuillez remplir tous les champs");
    } else {
        var data = {
            "email": document.querySelector('#inputEmail').value.trim()
        };

        
        fetch(urlCreated, 
            {
                method: 'POST',
                body: JSON.stringify({
                    data
                })
            }    
        )
        .then(response => response.json())
        .then(response => {
            var result = response.data;
            if(result.error || result.return !== 'success'){
                message($message, "danger", "success",result.error?result.error:result.return);
                document.querySelector('#inputEmail').classList.add("is-invalid");
            } else {
                message($message, "success", "danger", "utilisateur créé avec succès. Le mot de passe par défaut est : '123456'");
                document.querySelector('#inputEmail').classList.remove("is-invalid");
                document.querySelector('#inputEmail').value="";
            }
        })
        .catch(error => {
            console.log(error);
            message($message, "danger", "success","Erreur sur serveur");
        })
    }
}

function update_password(){

    if(valideForm('.require-pass') !== 0){
        message($message_pass, "danger", "success","Veuillez remplir tous les champs obligatoires");
    } else {
        var $apwd = document.querySelector('#apwd');
        var $npwd = document.querySelector('#npwd');
        var $cpwd = document.querySelector('#cpwd');

        var data = {
            "apwd": $apwd.value.trim(),
            "npwd": $npwd.value.trim(),
            "cpwd": $cpwd.value.trim(),
            "id": $id.value
        };

        if(data.npwd.length < 6){
            message($message_pass, "danger", "success","Le nouveau mot de passe doit avoir au moins 6 caractères");
            $npwd.classList.add("is-invalid");
        } else {
            if(data.npwd !== data.cpwd){
                message($message_pass, "danger", "success","Les mots de passe doivent être identiques");
                $npwd.classList.add("is-invalid");
                $cpwd.classList.add("is-invalid");
            } else {
                $npwd.classList.remove("is-invalid");
                $cpwd.classList.remove("is-invalid"); 

                fetch(urlUpdatePassword, 
                    {
                        method: 'POST',
                        body: JSON.stringify({
                            data
                        })
                    }    
                )
                .then(response => response.json())
                .then(response => {
                    var result = response.data;
                    if(result.error || result.return !== 'success'){
                        message($message_pass, "danger", "success",result.error?result.error:result.return);
                        $apwd.classList.add("is-invalid");
                    } else {
                        message($message_pass, "success","danger","Mot de passe modifié avec succès");
                        $apwd.classList.remove("is-invalid");
                        $apwd.value="";
                        $npwd.value="";
                        $cpwd.value="";
                    }
                })
                .catch(error => {
                    console.log(error);
                    message($message_pass, "danger", "success" ,"Erreur sur serveur");
                })
            }
        }
    }
}

function update_profil(e){
    e.preventDefault();
    if(valideForm(".require") !== 0){
        message($message_profil, "danger", "success","Veuillez remplir tous les champs obligatoires");
    } else {
        var $pseudo = document.querySelector('#pseudo');
        var $photo = document.querySelector('#photo');

        var formData = new FormData(e.target);
        formData.append('id', $id.value);

        fetch(urlUpdateProfil, 
            {
                method: 'POST',
                body: formData
            } 
        )
        .then(response => response.json())
        .then(response => {
            var result = response.data;
            console.log(result);
            if(result.error || result.return !== 'success'){
                message($message_profil, "danger", "success",result.error?result.error:result.return);
                if(!result.error){
                    if(result.return === "ce pseudo est déjà utilisé"){
                        $pseudo.classList.add("is-invalid");
                        $photo.classList.remove("is-invalid");

                    } else {
                        $photo.classList.add("is-invalid");
                        $pseudo.classList.remove("is-invalid");
                    }
                }

            } else {
                message($message_profil, "success", "danger", "Profil modifié avec succès");
                $pseudo.classList.remove("is-invalid");
                $photo.classList.remove("is-invalid");
                $photo.value="";
                setTimeout(() => {
                    document.location.reload();
                }, 4000);
            }
        })
        .catch(error => {
            console.log(error);
            message($message_profil, "danger", "success","Erreur sur serveur");
        })
    }
}