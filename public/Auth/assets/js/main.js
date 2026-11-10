import {AuthFrontEnd} from "AuthController";

function nodeListToObject(...nodes)
{
    let finalObject = {};

    for(let node of nodes)
    {
        node.classList.remove("error");

        let errorLabel =  document.getElementById(`error-${node.getAttribute("id")}`);

        if(!errorLabel) errorLabel =  document.getElementById(`error-${node.getAttribute("name")}`)

        errorLabel.style.display = "none";
        finalObject[node.getAttribute("name")] = node.value;
    }
    
    return finalObject;
}

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

function resetAttributes(nodes)
{
  for(let node of nodes)
  {
        node.classList.remove("error");

        let errorLabel =  document.getElementById(`error-${node.getAttribute("id")}`);

        if(!errorLabel) errorLabel =  document.getElementById(`error-${node.getAttribute("name")}`)

        errorLabel.style.display = "none";

        node.value = node.getAttribute("id") === "phone" ? "+34 " : "";
  }
}

function analizarPassword(password) {
    const especiales = "!@#$%^&*";
    let contadorMayusculas = 0;
    let contadorEspeciales = 0;
    let contadorNumeros = 0;

    for (let letra of password) {
        if (letra >= 'A' && letra <= 'Z') contadorMayusculas++;
        else if (letra >= '0' && letra <= '9') contadorNumeros++;
        else if (especiales.includes(letra)) contadorEspeciales++;
    }

    const reglas = {
        longitud: password.length >= 8,
        mayusculas: contadorMayusculas >= 2,
        especiales: contadorEspeciales >= 1, 
        numeros: contadorNumeros >= 2       
    };

    return reglas; 
}



const form = document.getElementById("formEx");
const regBtn = document.getElementById("registerBtn");
const logBtn = document.getElementById("loginBtn");
const title = document.getElementById("title");
const forgotPw = document.getElementById("forgot");
const pwSuggest = document.getElementById("pwDetail");
const pw = document.getElementById("password");
const rPass = document.getElementById("rPassword");
const rPassError = document.getElementById("error-rPassword");
const phone = document.getElementById("phone");
const btnToggle = 
{
  "btnToggle" : pw,
  "btnToggle2": rPass
};
var getContext = form.getAttribute("context");

const regDiv = document.getElementById("registerFields");


const iconOjoAbierto = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
const iconOjoCerrado = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`;

pw.addEventListener("focus", () => { if(getContext != "login") pwSuggest.style.display = "block"; });

pw.addEventListener("blur", () => { pwSuggest.style.display = "none"; });

pw.addEventListener("input", () => {

  let checkValue = analizarPassword(pw.value);

  for(let [id, result] of Object.entries(checkValue))
  {
      document.getElementById(id).style.color = !result ? "red" : "green";
  }

});

for(let [toggler, pwInput] of Object.entries(btnToggle))
{
  let currentToggler = document.getElementById(toggler);
  currentToggler.addEventListener("click", () => 
  {
        let currentStatus = pwInput.getAttribute("type");
        if(currentStatus === "password")
        {
            currentToggler.innerHTML = iconOjoAbierto;
            pwInput.setAttribute("type", "text");
            return;
        }
        currentToggler.innerHTML = iconOjoCerrado;
        pwInput.setAttribute("type", "password");
  })
}

regBtn.addEventListener("click", () => 
{
    resetAttributes(form.querySelectorAll("input.register, input.login"));
    let checkValue = analizarPassword("");
    for(let id of Object.keys(checkValue)) document.getElementById(id).style.color = "red";

    if(getContext === "login")
    {
      title.innerText = "Introduce tus datos personales";
      document.title = "Registro - E3I";
      forgotPw.style.display = "none";
      regDiv.style.display = "block";
      form.setAttribute("context", "register");
      logBtn.textContent = "REGÍSTRATE";
      regBtn.textContent = "INICIAR SESIÓN";
      getContext = form.getAttribute("context");
      return;
    }
      title.innerText = "Iniciar Sesión";
      document.title = "Iniciar Sesión - E3I";
      forgotPw.style.display = "block";
      regDiv.style.display = "none";
      form.setAttribute("context", "login");
      logBtn.textContent = "INICIAR SESIÓN";
      regBtn.textContent = "REGÍSTRATE"; 
      getContext = form.getAttribute("context");

    
});

rPass.addEventListener("input", () => 
{

    rPassError.style.display = rPass.value === pw.value ? "none" : "block";

});

let isBackspace = false;

phone.addEventListener("keydown", (e) => 
{
  isBackspace = e.key === "Backspace";
});

phone.addEventListener("input", () => 
{
    if(isBackspace) return;
    let value = phone.value.replaceAll(' ', '').split("+34");;
    if (value[1].length % 3 === 0 && value[1].length < 9) phone.value += " ";
});


form.addEventListener("submit", async (req) => 
{   
    req.preventDefault();

    let inputsInvolved = form.querySelectorAll( getContext === "login" ? "input.login" : "input.login, input.register");

    let loader = document.getElementById("loader");
    loader.style.display = "flex";

    try
    {

        const authMe = new AuthFrontEnd(nodeListToObject(...inputsInvolved, document.getElementsByName("g-recaptcha-response")[0]));



        const result =  getContext === "login" ? await authMe.executeLogin() : await authMe.executeRegister();
  

        switch(result.statusCode)
        {

           case 200:
           case 201:
            if(result.response.hasOwnProperty("qrCode")) localStorage.setItem("qrCode", result.response.qrCode);

            localStorage.setItem("X-Authenticator", result.response["X-Authenticator"] || result.response);
            localStorage.setItem("timestamp", Date.now());

            top.location.href = "./TwoStepsAuthentication";
            return;

            case 400:
              document.getElementById("error-NIF").style.display = "block";
              window.grecaptcha.reset();
            return;

            case 401:
              console.log(result.response);
            break;

            case 409:
              document.getElementById("error-NIF").style.display = "block";
              document.getElementById("error-email").style.display = "block";
              window.grecaptcha.reset();
            return;

            default:
              console.error("PANIC MODE! THAT STATUS CODE PROBABLY MEANS THAT'S AN ERROR");
              debugger;
            return;
        }


        if(window.grecaptcha) window.grecaptcha.reset();

        throw new Error(Array.from(inputsInvolved, el => el.id));

    }catch(SyntaxError)
    {
        markAsError(SyntaxError.message);
        return;
    } finally
    {
        loader.style.display = "none";
    }
    
    
})