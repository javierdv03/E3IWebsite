import {CustomerFrontEnd} from "CustomerController";

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

let promiseFinised = ( async () => {


    let loader = document.getElementById("loader");
    loader.style.display = "flex";
    
    let url = new URLSearchParams(window.location.search);

    let NIF = url.get("NIF");



 try
    {

        const user = new CustomerFrontEnd({"NIF": NIF});


        const result =  await user.executeGetCustomer(localStorage.getItem("X-Authenticator"));
  

        switch(result.statusCode)
        {

           case 200:

                let userDetails = result.response;

                let name = document.getElementById("name");
                let surname = document.getElementById("surname");

                name.value = userDetails[0].nombre;
                surname.value = userDetails[0].apellidos;

                
            return;

            
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

    }catch(SyntaxError)
    {
        console.error(SyntaxError);
        return;
    } finally
    {
        loader.style.display = "none";
    }    

})();

await promiseFinised;

const submit = document.getElementById("submit");

submit.addEventListener("click", async() => {

    let loader = document.getElementById("loader");
    loader.style.display = "flex";

    let inputs = document.querySelectorAll(".editable");
    let sendInputs = {};

    let url = new URLSearchParams(window.location.search);

    let NIF = url.get("NIF");    

    for(let input of inputs)
    {
        let value = input.value;

        if(value && value != "") sendInputs[input.getAttribute("id")] = value;
        
    }

    try {

        sendInputs["NIF"] = NIF;

        let customer = new CustomerFrontEnd(sendInputs);

        let result = await customer.executeModifyCustomer(localStorage.getItem("X-Authenticator"));
        
        switch(result.statusCode)
        {

           case 200:
                Toastify({
                    text: "Éxito: Has modificado los datos del usuario",
                    duration: 3000,
                    gravity: "top", 
                    position: "right", 
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                    }).showToast();

                
            return;

            
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