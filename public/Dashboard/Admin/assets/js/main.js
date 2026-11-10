import { sugInstiator } from "SuggesterSingleton";
import { SalesFrontEnd } from "SalesController";
import { VisitorFrontEnd } from "VisitorController";

// ESTA CLASE SÓLAMENTE SE DEBE DE USAR EN SINCRONÍA CON EL IMPORTMAP!

const recommendedOptionsBtnCollection = document.getElementsByClassName("commonBtn");

//Procesamos los nodos top!
let bestThree = sugInstiator.predictNext();

// Iniciamos un proceso de ingeniería inversa para escribir las opciones con sus vínculos :P
 // en orden de prioridad, of course
 let findItem, constructItem;

for(let i = 0; i < recommendedOptionsBtnCollection.length; i++)
{
    constructItem = bestThree[i].category + " " + bestThree[i].action;
    findItem = document.querySelectorAll(`a[data-text="${constructItem}"]`);
    let cloneItem = findItem[0].cloneNode(true);
    cloneItem.style.color = "black";
    cloneItem.style.width = "100%";
    recommendedOptionsBtnCollection[i].innerHTML = '';
    recommendedOptionsBtnCollection[i].appendChild(cloneItem);

}

let salesPercentage = document.getElementById("salesPercent"); 
let realSalesPercentage = salesPercentage.children[0];
let salesValue = document.getElementById("salesData");
let lastWeekSales = document.getElementById("lastWSales");

let visPercentage = document.getElementById("viPercent"); 
let realViPercentage = visPercentage.children[0];
let viValue = document.getElementById("viData");
let lastWeekVi = document.getElementById("lastWVi");

let promiseFinised = ( async () => {


    let loader = document.getElementById("loader");
    loader.style.display = "flex";

 try
    {

        const sales = new SalesFrontEnd({});
        const visitors = new VisitorFrontEnd({});


        const result =  await sales.executeSalesStats(localStorage.getItem("X-Authenticator"));
        const resultVis = await visitors.executeGetVisitors(localStorage.getItem("X-Authenticator"));
  

        switch(result.statusCode)
        {

           case 200:

            salesValue.textContent = result.response.estaSemana;
            realSalesPercentage.textContent = result.response.porcentaje + "%";
            lastWeekSales.textContent = result.response.semanaPasada;
            salesPercentage.classList.add(result.response.porcentaje > 0 ? "benefit" : "drawback");

                
            break;

            
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

        switch(resultVis.statusCode)
        {

           case 200:

            viValue.textContent = resultVis.response.thisWeek;
            realViPercentage.textContent = resultVis.response.percentage + "%";
            lastWeekVi.textContent = resultVis.response.lastWeek;
            visPercentage.classList.add(resultVis.response.percentage > 0 ? "benefit" : "drawback");

                
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
        console.error(SyntaxError.message);
        return;
    } finally
    {
        loader.style.display = "none";
    }    

})();