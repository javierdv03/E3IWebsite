import {CertificateFrontEnd} from "CertificateController";



function nodeListToObject(...nodes)
{
    let finalObject = {};

    for(let node of nodes)
    {
        finalObject[node.getAttribute("name").split("-")[0]] = node.value;
    }
    
    return finalObject;
}

function insertRows(set)
{
    return `<div class="row-card">  <div class="data-row row-grid"><div class=col-id data-label=ID>${set.idProducto}</div><div class=col-text data-label=TIPO><input readonly class=input-pill id=tipo-${set.idProducto} name=tipo-${set.idProducto} value=${set.tipo}></div><div class=col-input data-label=NOMBRE><input readonly class=input-pill id=nombre-${set.idProducto} name=nombre-${set.idProducto} value=${set.nombre}></div><div class=col-input data-label=PRECIO><input readonly class="input-pill centered-text" id=precio-${set.idProducto} name=precio-${set.idProducto}  value=${set.precio}></div><div class=col-input data-label=DESCRIPCIÓN><input readonly class="input-pill centered-text" id=descripcion-${set.idProducto} name=descripcion-${set.idProducto}  value=${set.descripcion}></div><div class=col-actions data-label=ACCIÓN><button class="btn-action btn-modify"id=${set.idProducto}>M</button> <button class="btn-action btn-delete"id=${set.idProducto}>E</button></div></div></div>`;
}

const rowSet = document.getElementById("rowSet");
let certs = {};

let promiseFinised = ( async () => {


    let loader = document.getElementById("loader");
    loader.style.display = "flex";

 try
    {

        const cert = new CertificateFrontEnd({});


        const result =  await cert.executeGetCertificate(localStorage.getItem("X-Authenticator"));
  

        switch(result.statusCode)
        {

           case 200:
                certs = result.response;

                for(let row of certs) rowSet.innerHTML += insertRows(row);

                
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

try
{
    await promiseFinised;

    let btnModify = document.querySelectorAll(".btn-modify");
    let btnDelete = document.querySelectorAll(".btn-delete");

    for(let modify of btnModify)
    {
        
        let parentElement = modify.parentNode.parentElement;
        let inputs = parentElement.querySelectorAll("input");
        
        for(let input of inputs)
        {
            input.addEventListener("click", () => {
                input.removeAttribute("readonly")
            })
        }

        modify.addEventListener("click",  async () => 
        {
            let loader = document.getElementById("loader");
                loader.style.display = "flex";

            try
                {

                    parentElement = modify.parentNode.parentElement;
                
                    let pk = parentElement.querySelector(".col-id").textContent;

                    let toSend = nodeListToObject(...parentElement.querySelectorAll("input:not([readonly])"));
                    toSend["pk"] = pk;

                    const cert = new CertificateFrontEnd(toSend);


                    const result =  await cert.executeModifyCertificate(localStorage.getItem("X-Authenticator"));
            

                    switch(result.statusCode)
                    {

                    case 200:

                            Toastify({
                                text: "Éxito: Has modificado el certificado correctamente",
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
                                text: "Error: Hay un error en la escritura",
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
                    alert("La sintaxis del campo: " + SyntaxError.message + " no es correcta.");
                    return;
                } finally
                {
                    loader.style.display = "none";
                }    

    
        });
    
    };

    for(let deleteB of btnDelete)
    {
        deleteB.addEventListener("click",  async () => 
        {
            
            let loader = document.getElementById("loader");
            loader.style.display = "flex";            

            let parentElement = deleteB.parentNode.parentElement;
                
            let pk = parentElement.querySelector(".col-id").textContent;

            try
                {
                    const cert = new CertificateFrontEnd({"pk": pk});


                    const result =  await cert.executeDeleteCertificate(localStorage.getItem("X-Authenticator"));
            

                    switch(result.statusCode)
                    {

                    case 200:

                            Toastify({
                                text: "Éxito: Has eliminado el certificado correctamente",
                                duration: 3000,
                                gravity: "top", 
                                position: "right", 
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                }
                                }).showToast();
                            
                                parentElement.parentElement.remove();

                            
                        return;

                        
                        case 401:
                            Toastify({
                                text: "Error: Hay un error en la escritura",
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
                    alert("La sintaxis del campo: " + SyntaxError.message + " no es correcta.");
                    return;
                } finally
                {
                    loader.style.display = "none";
                } 

        });
    }  


}
catch(exp)
{
    console.error(exp);
    debugger;
}



/*


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

*/