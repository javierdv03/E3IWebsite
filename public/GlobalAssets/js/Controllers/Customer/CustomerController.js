import { apiAttributes } from "../../Constants.js";
import { RequestMaker } from "../../Components/RequestMaker/RequestMaker.js";

export class CustomerFrontEnd
{
    sendData;

    constructor(data)
    {
        if(typeof data != 'object') 
        {
            throw new Error("Data is not whitin is bound!");
        }

        for(let [key, value] of Object.entries(data))
        {
            if(!value || value == '' || value == ' ') delete data[key];
            
            if(!value.match(apiAttributes.Dashboard.specificRegex[key])) throw new SyntaxError(key);

        }

        this.sendData = data;

    }


    async executeGetCustomers(xAuth = null)
    {
        let makerInitiator = new RequestMaker(apiAttributes.Dashboard.getCustomers);


        let bdTransaction  = await makerInitiator.makeATransaction(xAuth, this.sendData);

       if(bdTransaction.error)
       {
            alert("SOMETHING WENT WRONG, CHECK OUT THE CONSOLE LOG!");
            console.error(bdTransaction);
            debugger;
            return;
       }

       return bdTransaction;
    }

    async executeGetCustomer(xAuth = null)
    {
        let makerInitiator = new RequestMaker(apiAttributes.Dashboard.getCustomer);


        let bdTransaction  = await makerInitiator.makeATransaction(xAuth, this.sendData);

       if(bdTransaction.error)
       {
            alert("SOMETHING WENT WRONG, CHECK OUT THE CONSOLE LOG!");
            console.error(bdTransaction);
            debugger;
            return;
       }

       return bdTransaction;
    }

    async executeModifyCustomer(xAuth = null)
    {
        let makerInitiator = new RequestMaker(apiAttributes.Dashboard.modifyCustomer);


        let bdTransaction  = await makerInitiator.makeATransaction(xAuth, this.sendData);

       if(bdTransaction.error)
       {
            alert("SOMETHING WENT WRONG, CHECK OUT THE CONSOLE LOG!");
            console.error(bdTransaction);
            debugger;
            return;
       }

       return bdTransaction;
    }    

}