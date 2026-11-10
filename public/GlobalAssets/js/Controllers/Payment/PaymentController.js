import { apiAttributes } from "../../Constants.js";
import { RequestMaker } from "../../Components/RequestMaker/RequestMaker.js";

export class PaymentFrontEnd
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
            
            if(!value.match(apiAttributes.Payment.specificRegex[key])) throw new SyntaxError(key);

        }

        this.sendData = data;

    }


    async executeDoPayment(xAuth = null)
    {
        let makerInitiator = new RequestMaker(apiAttributes.Payment.doPayment);


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