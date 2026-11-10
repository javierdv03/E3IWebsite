import {OrderFrontEnd} from "OrderController";

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

const hamburgerIcon = document.getElementById("openMenu");
const crossIcon = document.getElementById("closeMenu");
const nav = document.getElementById("leftNav");

hamburgerIcon.addEventListener("click", () => {

            crossIcon.style.display = "block";
            hamburgerIcon.style.visibility = "hidden";
            nav.classList.add("open");
            document.body.style.overflowX = "hidden";

});

crossIcon.addEventListener("click", () => {

            crossIcon.style.display = "none";
            hamburgerIcon.style.visibility = "visible";
            nav.classList.remove("open");
            document.body.style.overflowX = "visible";
});


let orderId = document.getElementById("orderId");
let name = document.getElementById("nombre");
let estado = document.getElementById("estado");
let anotacion = document.getElementById("anotacion");
let precio = document.getElementById("precio");
let fecha = document.getElementById("fecha");

let url = new URLSearchParams(window.location.search);
let idPedido = url.get("idPedido");



let promiseFinised = ( async () => {


    let loader = document.getElementById("loader");
    loader.style.display = "flex";

 try
    {

        const order = new OrderFrontEnd({"idPedido": idPedido});


        const result =  await order.executeGetOrder(localStorage.getItem("X-Authenticator"));
  

        switch(result.statusCode)
        {

           case 200:
                
                let orderDetail = result.response;
                let date = new Date(orderDetail[0]["fechaPedido"] * 1000);

                orderDetail[0]["fechaPedido"] = date.toLocaleDateString('es-ES', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: '2-digit'
                                            });

                orderId.textContent = orderDetail[0].idPedidoUsuario;
                name.value = orderDetail[0].NombreProducto;
                precio.value = orderDetail[0].PedidoPrecio + " €";
                fecha.value = orderDetail[0].fechaPedido;
                estado.textContent = orderDetail[0].estado === "no" ? "Sin entregar" : "Entregado";
                estado.classList.add(orderDetail[0].estado === "no" ? "status-red-bg" : "status-green-bg")
                anotacion.value = orderDetail[0].anotacion || "Ninguna";

                
            return;

            
            case 401:
            case 404:    
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
        console.log(SyntaxError)
        markAsError(SyntaxError.message);
        return;
    } finally
    {
        loader.style.display = "none";
    }    

})();