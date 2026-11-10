import { apiAttributes } from "../../Constants.js";
import { RequestMaker } from "../../Components/RequestMaker/RequestMaker.js";

export class VisitorFrontEnd
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

    async executeGetVisitors(xAuth = null)
    {
        let makerInitiator = new RequestMaker(apiAttributes.Dashboard.getVisitors);


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