import {PaymentFrontEnd} from "PaymentController";

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

function resetAttributes(nodes)
{
  for(let node of nodes)
  {
        node.classList.remove("error");

        let errorLabel =  document.getElementById(`error-${node.getAttribute("id")}`);

        if(!errorLabel) errorLabel =  document.getElementById(`error-${node.getAttribute("name")}`)

        errorLabel.style.display = "none";

        node.value = node.getAttribute("id") === "phone" ? "+34 " : "";
  }
}

function mostrarErrorBIN() {
    const modal = document.getElementById('modalErrorBin');
    modal.classList.add('is-visible');
    // Bloquear scroll del body para que no se mueva el fondo
    document.body.style.overflow = 'hidden';
}

// Función para CERRAR el modal
function cerrarModalError() {
    const modal = document.getElementById('modalErrorBin');
    modal.classList.remove('is-visible');
    // Restaurar scroll
    document.body.style.overflow = '';
}

// Función para reiniciar el campo de tarjeta (Acción del botón rojo)
function intentarOtraTarjeta() {
    cerrarModalError();
    
    // Aquí pon la lógica para limpiar el input de la tarjeta y poner el foco
    const inputTarjeta = document.querySelector('input[name="pagoTarjeta"]');
    if(inputTarjeta) {
        inputTarjeta.value = ''; 
        inputTarjeta.focus();
        // Opcional: resaltar el borde en rojo
        inputTarjeta.style.borderColor = 'red';
    }
}
document.getElementById('modalErrorBin').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalError();
    }
});

let btnSubmit = document.getElementById("submit");

btnSubmit.addEventListener("click", async (e) => {

    e.preventDefault();

    let loader = document.getElementById("loader-overlay");
    loader.style.display = "flex";

 try
    {

        const inputsInvolved = document.querySelectorAll("input:not(:disabled)");


        const order = new PaymentFrontEnd(nodeListToObject(...inputsInvolved));

        const result =  await order.executeDoPayment(localStorage.getItem("X-Authenticator"));
  

        switch(result.statusCode)
        {

           case 200:
            top.location.href = "./success.php";
            return;
            
            case 202:
                mostrarErrorBIN();
                return;

            case 400:
                alert("Hay algún campo que no has introducido correctamente. ¡Revísalos!");
            return;
            
            case 401:
                top.location.href = "../Auth";
            break;


            default:
              console.error("PANIC MODE! THAT STATUS CODE PROBABLY MEANS THAT'S AN ERROR");
              debugger;
            return;
        }

        throw new Error(Array.from(inputsInvolved, el => el.id));

    }catch(SyntaxError)
    {
        console.log(SyntaxError)
        markAsError(SyntaxError.message);
        return;
    } finally
    {
        loader.style.display = "none";
    }    

});

