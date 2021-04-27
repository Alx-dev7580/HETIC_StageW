let $submit = document.querySelector('#submit');
let $message = document.querySelector(".message");

$submit.addEventListener("click", user_login);

function message(type, text){
    $message.classList.add('alert');
    $message.classList.add('alert-'+type);
    $message.innerHTML = text;
}

function user_login(){
    let nbError = 0;
    let $input = document.querySelectorAll(".require");

    $input.forEach(element => {
        if(element.value.trim()===""){
            element.classList.add("is-invalid");
            nbError++;
        } else{
            element.classList.remove("is-invalid");
        }
    });

    if(nbError !== 0){
        message("danger","Veuillez remplir tous les champs");
    } else {
        var data = {
            "email": document.querySelector('#inputEmail').value.trim(), 
            "password": document.querySelector('#inputPassword').value.trim()
        };

        
        fetch(urlLogin, 
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
                message("danger",result.error?result.error:result.return);
                if(result.return === "Le format de l'email est incorrect"){
                    document.querySelector('#inputEmail').classList.add("is-invalid");
                }
            } else {
                location.href = "?p=dashboard";
            }
            console.log(response);
        })
        .catch(error => {
            console.log(error);
            message("danger","Erreur sur serveur");
        })
    }
}