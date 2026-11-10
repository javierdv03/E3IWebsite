import {CustomerFrontEnd} from "CustomerController";

function insertRows(set)
{
    return `<div class="row-card row-grid"><div class="col-text font-bold"data-label=NIF>${set.NIF}</div><div class="col-text font-bold"data-label=NOMBRE>${set.nombre}</div><div class="col-text font-bold"data-label=APELLIDOS>${set.apellidos}</div><div class=col-action><button class=btn-yellow id=${set.NIF}>MODIFICAR<br>USUARIO</button></div></div>`;
}

const rowSet = document.getElementById("rowSet");
let users = {};

let promiseFinised = ( async () => {


    let loader = document.getElementById("loader");
    loader.style.display = "flex";

 try
    {

        const user = new CustomerFrontEnd({});


        const result =  await user.executeGetCustomers(localStorage.getItem("X-Authenticator"));
  

        switch(result.statusCode)
        {

           case 200:
                users = result.response;

                for(let row of users) rowSet.innerHTML += insertRows(row);

                
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

let btnYellow = document.querySelectorAll(".btn-yellow");

for(let btnSingle of btnYellow)
{
    btnSingle.addEventListener("click", async() => 
    {

        top.location.href = "./modificar?NIF="+btnSingle.getAttribute("id");

    });
}
