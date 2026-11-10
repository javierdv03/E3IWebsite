import {CertificateFrontEnd} from "CertificateController";


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


const btnSubmit = document.getElementById("submit");


let getAllInput = document.querySelectorAll("input, textarea");

for(let input of getAllInput)
{
    input.addEventListener("input", (iN) => 
    {
        const idInput = input.getAttribute("id");

        document.getElementById(idInput + "-mirror").textContent = iN.target.value;


    } );
}


btnSubmit.addEventListener("click", async () => {

    let loader = document.getElementById("loader");
    loader.style.display = "flex";

    try
    {

        const cert = new CertificateFrontEnd(nodeListToObject(...getAllInput));


        const result =  await cert.executeAddCertificate(localStorage.getItem("X-Authenticator"));
  

        switch(result.statusCode)
        {

           case 201:
                Toastify({
                    text: "Éxito: Has creado el certificado",
                    duration: 3000,
                    gravity: "top", 
                    position: "right", 
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                    }).showToast();  
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

        throw new Error(Array.from(inputsInvolved, el => el.id));

    }catch(SyntaxError)
    {
        markAsError(SyntaxError.message);
        return;
    } finally
    {
        loader.style.display = "none";
    }
    
});