import {AdminFrontEnd} from "AdminController";


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


const btnSubmit = document.getElementById("submit");

btnSubmit.addEventListener("click", async () => {

    let loader = document.getElementById("loader");
    loader.style.display = "flex";

    try
    {

        const adminMe = new AdminFrontEnd({"email": document.getElementById("email").value });


        const result =  await adminMe.executeAddAdmin(localStorage.getItem("X-Authenticator"));
  

        switch(result.statusCode)
        {

           case 200:
                Toastify({
                    text: "Éxito: Has añadido correctamente al administrador",
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