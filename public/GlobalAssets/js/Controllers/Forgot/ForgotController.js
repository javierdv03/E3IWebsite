import { apiAttributes } from "../../Constants.js";
import { RequestMaker } from "../../Components/RequestMaker/RequestMaker.js";

export class ForgotFrontEnd
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
            
            if(!value.match(apiAttributes.Auth.specificRegex[key])) throw new SyntaxError(key);

        }

        this.sendData = data;

    }


    async executeSendLink()
    {
        let makerInitiator = new RequestMaker(apiAttributes.Auth.forgotPass);


        let bdTransaction  = await makerInitiator.makeATransaction(null, this.sendData);

       if(bdTransaction.error)
       {
            alert("SOMETHING WENT WRONG, CHECK OUT THE CONSOLE LOG!");
            console.error(bdTransaction);
            debugger;
            return;
       }

       return bdTransaction;
    }

    async executeVerifyLink()
    {
        let makerInitiator = new RequestMaker(apiAttributes.Auth.verifyLink);


        let bdTransaction  = await makerInitiator.makeATransaction(null, this.sendData);

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