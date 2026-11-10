import {ProfileFrontEnd} from "ProfileController";


function markAsError(...ids)
{
    ids = ids[0].split(",");

    for(let id of ids)
    {
        let getItem = document.getElementById(id);

        if(!getItem) getItem = document.getElementsByName(id)[0];

        getItem.classList.add("error");

        document.getElementById(`error-${id}`).style.display = "block";
    }

}

function nodeListToObject(...nodes)
{
    let finalObject = {};

    for(let node of nodes)
    {
        node.classList.remove("error");

        let errorLabel =  document.getElementById(`error-${node.getAttribute("id")}`);

        if(!errorLabel) errorLabel =  document.getElementById(`error-${node.getAttribute("name")}`)

        errorLabel.style.display = "none";
        finalObject[node.getAttribute("name")] = node.value;
    }
    
    return finalObject;
}

let inputs = document.querySelectorAll("input[readonly]");
        
for(let input of inputs)
{
    input.addEventListener("click", () => 
    {
            input.removeAttribute("readonly")
    })
}

const btnSubmit = document.getElementById("submit");
let password = document.getElementById("password");
let rpassword = document.getElementById("r-password");
let errorPass = document.getElementById("error-password");

let flag = false;

password.addEventListener("input", () => {

    errorPass.style.display = password.value != rpassword.value ? "block" : "none";
});

rpassword.addEventListener("input", () => {

    errorPass.style.display = password.value != rpassword.value ? "block" : "none";
});

btnSubmit.addEventListener("click", async (event) => {
    
    event.preventDefault();

    let loader = document.getElementById("loader");
    loader.style.display = "flex";

    inputs = document.querySelectorAll("input:not([readonly]):not([disabled])");

    let idFiltered = Array.from(inputs, el => el.id);

    if(idFiltered.includes("password")) flag = true;

    try
    {

        const profile = new ProfileFrontEnd(nodeListToObject(...inputs));


        const result =  await profile.executeEditProfile(localStorage.getItem("X-Authenticator"));
  

        switch(result.statusCode)
        {

           case 200:
                Toastify({
                    text: "Éxito: Has modificado con éxito tu perfil",
                    duration: 3000,
                    gravity: "top", 
                    position: "right", 
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                    }).showToast();  

                password.value = "";
                rpassword.value = ""; 
                
                setTimeout(()=> {
                        if(flag) 
                            {
                                alert("Por seguridad, al cambiar la contraseña se debe de reiniciar tu sesión.");
                                top.location.href = "../../logout";
                            }
                }, 1500)
            return;

            case 400:
            case 401:
                Toastify({
                    text: "Error: "+ result.response,
                    duration: 3000,
                    gravity: "top", 
                    position: "right", 
                    style: {
                        background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    }
                    }).showToast();
            break;


            default:
              console.error("PANIC MODE! THAT STATUS CODE PROBABLY MEANS THAT'S AN ERROR");
              debugger;
            return;
        }

        throw new Error(idFiltered);

    }catch(SyntaxError)
    {
        markAsError(SyntaxError.message);
        return;
    } finally
    {
        loader.style.display = "none";
    }
    
});