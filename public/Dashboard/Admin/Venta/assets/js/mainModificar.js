import {SalesFrontEnd} from "SalesController";

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

let name = document.getElementById("nombre");
let estado = document.getElementById("estado");
let anotacion = document.getElementById("anotacion");
let url = new URLSearchParams(window.location.search);
let idPedido = url.get("idPedido");

estado.addEventListener("change", () => {

    let ischecked = estado.checked;

    estado.value = ischecked ? "si" : "no"; 

})

let promiseFinised = ( async () => {


    let loader = document.getElementById("loader");
    loader.style.display = "flex";



 try
    {

        const sales = new SalesFrontEnd({"idPedido": idPedido});


        const result =  await sales.executeGetSale(localStorage.getItem("X-Authenticator"));
  

        switch(result.statusCode)
        {

           case 200:

                let saleDetail = result.response;

                name.value = saleDetail[0].nombre;
                estado.checked = saleDetail[0].estado != "no";
                estado.value = saleDetail[0].estado === "no" ? "no" : "si";
                anotacion.value = saleDetail[0].anotacion || "Ninguna";

                
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
        markAsError(SyntaxError.message);
        return;
    } finally
    {
        loader.style.display = "none";
    }    

})();

await promiseFinised;

let submit = document.getElementById("submit");

submit.addEventListener("click", async () => 
{

try
    {
        const sales = new SalesFrontEnd({"idPedido": idPedido, "estado": estado.value, "anotacion": anotacion.value || "Ninguna"});


        const result =  await sales.executeModifySale(localStorage.getItem("X-Authenticator"));
  

        switch(result.statusCode)
        {

           case 200:

                Toastify({
                        text: "Éxito: Has modificado la venta correctamente.",
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

    }catch(SyntaxError)
    {
        markAsError(SyntaxError.message);
        return;
    } finally
    {
        loader.style.display = "none";
    }    

});