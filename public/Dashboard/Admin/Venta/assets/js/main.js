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

function insertRows(set)
{
    return `<div class=table-row><div class="col col-user">${set.NIF}</div><div class="col col-prod"><strong>${set.nombreProducto}</strong></div><div class="col col-price"><strong>${set.precio} €</strong></div><div class="col col-status status-${set.estado === "no" ? "red" : "green"}">${set.estado === "no" ? "Sin entregar" : "Entregado"}</div><div class="col col-notes">${set.anotacion || "Ninguna"}</div><div class="col col-date">${set.fechaPedido}</div><div class="col col-action"><button class=btn-detail id=${set.idPedido}>DETALLE<br>VENTA</button></div></div>`;
}

const rowSet = document.getElementById("rowSet");
let salesSet = {};

let promiseFinised = ( async () => {


    let loader = document.getElementById("loader");
    loader.style.display = "flex";

 try
    {

        const sales = new SalesFrontEnd({});


        const result =  await sales.executeGetSales(localStorage.getItem("X-Authenticator"));
  

        switch(result.statusCode)
        {

           case 200:
                salesSet = result.response;

                for(let row of salesSet)
                {
                     let date = new Date(row["fechaPedido"] * 1000);
                     row["fechaPedido"] = date.toLocaleDateString('es-ES', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: '2-digit'
                                            });
                     rowSet.innerHTML += insertRows(row);
                }

                
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