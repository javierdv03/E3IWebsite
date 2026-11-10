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

function insertRows(set)
{
    return `<div class=order-row><div class="font-bold col-product">${set.NombreProducto}</div><div class="font-bold col-price">${set.PedidoPrecio}€</div><div class="col-status text-${set.estado === "no" ? "red" : "green"}">${set.estado === "no" ? "Sin entregar" : "Entregado"}</div><div class="font-bold col-notes">${set.anotacion || "Ninguna"}</div><div class=col-action><button class=btn-detail id=${set.idPedidoUsuario}>DETALLE<br>PEDIDO</button></div></div>`;
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




const rowSet = document.getElementById("rowSet");
let orderSet = {};

let promiseFinised = ( async () => {


    let loader = document.getElementById("loader");
    loader.style.display = "flex";

 try
    {

        const order = new OrderFrontEnd({});


        const result =  await order.executeGetOrders(localStorage.getItem("X-Authenticator"));
  

        switch(result.statusCode)
        {

           case 200:
                orderSet = result.response;

                for(let row of orderSet) rowSet.innerHTML += insertRows(row);

                
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
        console.log(SyntaxError)
        markAsError(SyntaxError.message);
        return;
    } finally
    {
        loader.style.display = "none";
    }    

})();


await promiseFinised;
try
{
    await promiseFinised;

    let btnModify = document.querySelectorAll(".btn-detail");

    for(let btn of btnModify)
    {
        btn.addEventListener("click", () => {

            let id = btn.getAttribute("id");
            top.location.href = "./detalle?idPedido="+id;

        })
    }
}
catch(error)
{
    console.log(error);
}

