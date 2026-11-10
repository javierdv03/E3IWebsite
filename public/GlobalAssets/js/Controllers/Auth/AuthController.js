import { apiAttributes } from "../../Constants.js";
import { RequestMaker } from "../../Components/RequestMaker/RequestMaker.js";

export class AuthFrontEnd
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



   async executeRegister()
    {

        let makerInitiator = new RequestMaker(apiAttributes.Auth.register);

        let bdTransaction  = await makerInitiator.makeATransaction(null, this.sendData);

       if(bdTransaction.error)
       {
            alert("SOMETHING WENT TERRIBLE WRONG, CHECK OUT THE CONSOLE LOG!");
            console.error(bdTransaction);
            debugger;
            return;
       }

       return bdTransaction;

    }

    async executeLogin()
    {

        let makerInitiator = new RequestMaker(apiAttributes.Auth.login);


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

    async executeVerify2Fa(xAuth = null)
    {
        let makerInitiator = new RequestMaker(apiAttributes.Auth.verify2FA);


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


    async executeVerifyMail()
    {
        let makerInitiator = new RequestMaker(apiAttributes.Auth.verifyMail);


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