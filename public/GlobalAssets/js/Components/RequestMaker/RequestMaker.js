import {apiAttributes} from "../../Constants.js";

export class RequestMaker
{

    reducedAttr;
    elementsToSend;

    constructor(endpoint)
    {
        this.reducedAttr = endpoint;

        this.elementsToSend = this.reducedAttr.method === 'GET' ? new URLSearchParams() : new FormData();

    }


    unpackItem(httpStatusCode, jsonResponse)
    {

        jsonResponse["error"] = !(this.reducedAttr.expectedResponses.includes(httpStatusCode));
        return jsonResponse;
        
    }


   async makeATransaction(xAuth = null, params = {}) 
    {   
       
        if(typeof params != "object")  return {error: true, reason: params + " do not match it's specifications..." };
            
        const url = "/" + location.pathname.split("/")[1] + "/";
        let APITargetURI = url + apiAttributes.rootEndpoint + this.reducedAttr.name + "?";

        let lastEntryKey = Object.keys(params)[Object.keys(params).length-1];

        for(let [key, value] of Object.entries(params))
        {
           this.elementsToSend.append(key, value);

           if(key === lastEntryKey && this.elementsToSend instanceof URLSearchParams) APITargetURI += this.elementsToSend.toString();
            
        }

        let headersO = {"X-Authenticator": xAuth || null};

        if(["PATCH", "DELETE"].includes(this.reducedAttr.method)) headersO["Content-Type"] ="application/json";


        let req = await fetch(APITargetURI, this.reducedAttr.method != 'GET'
                 ?
                  (
                        {
                            method: this.reducedAttr.method,
                            body: ["PATCH", "DELETE"].includes(this.reducedAttr.method)  ? JSON.stringify(params) : this.elementsToSend,
                            headers: headersO
                            
                        }
                  )
                 :
                  ({headers: xAuth ? {"X-Authenticator": xAuth} : {}})      
        );
            
        return this.unpackItem(req.status, await req.json());
             
    }


}