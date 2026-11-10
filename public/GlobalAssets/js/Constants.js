export const apiAttributes = 
{
    rootEndpoint: "api/",
    Auth: 
    {
        specificRegex: 
        {
                "email":/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/,
                "password":/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/,
                "name": /^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+(?:[ -][A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+)*$/,
                "surname": /^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+(?:[ -][A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+)*$/,
                "phone": /^\+34\s[6-9]\d{2}\s\d{3}\s\d{3}$/,
                "NIF": /^([0-9]{8}[A-Z]|[XYZ][0-9]{7}[A-Z])$/,
                "g-recaptcha-response":/^.+$/,
                "2FA": /^\d{3}\s?\d{3}$/,
                "r-password": /^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/,
                "token": /^.+$/
        },

        register: 
        {
            name: "Auth/Register",
            method: "POST",
            expectedResponses: [201, 400, 401, 409],
        },

        login: 
        {
            name: "Auth/Login",
            method: "POST",
            expectedResponses: [200, 401],

        },

        verify2FA:
        {
            name: "Auth/TwoStepVerification",
            method: "POST",
            expectedResponses: [200, 301, 401]
        },

        verifyMail:
        {
            name: "Auth/VerifyEmail",
            method: "POST",
            expectedResponses: [200, 400, 401]
        },

        forgotPass:
        {
            name: "Auth/ForgotPass",
            method: "POST",
            expectedResponses: [200, 401]
        },

        verifyLink:
        {
            name: "Auth/VerifyLink",
            method: "POST",
            expectedResponses: [200, 401]
        }                  
    },

    Dashboard:
    {
        specificRegex:
        {
            "email":/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/,
            "nombre" : /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/,
            "apellidos" : /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/,
            "tipo" : /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/,
            "precio" : /^\d+(\.\d{1,2})?$/,
            "descripcion" : /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,;?!:-]+$/,
            "pk": /^(?:[1-9]|1[0-9]|400)$/,
            "NIF": /^([ABCDEFGHJKLMNPQRSUVW]\d{7}[0-9A-J]|[XYZ0-9]\d{7}[A-Z])$/i,
            "ubicacion": /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚüÜ ,.\-\/ºª]+$/,
            "quienes": /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,;?!:-]+$/,
            "empresas": /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ,]+$/,
            "anotacion":/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,;?!:-]*$/,
            "estado":/^(si|no)$/,
            "idPedido": /^(?:[1-9]|1[0-9]|400)$/,
            "password":/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/,
            "r-password":/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/
        },

        addAdmin:
        {
            name: "Dashboard/AddAdmin",
            method: "POST",
            expectedResponses: [200, 400, 401]            
        },

        addCertificate:
        {
            name: "Dashboard/CreateCert",
            method: "POST",
            expectedResponses: [201, 400, 401]            
        },

        getCertificate:
        {
            name: "Dashboard/GetCert",
            method: "GET",
            expectedResponses: [200, 401]            
        },

        modifyCertificate:
        {
            name: "Dashboard/ModifyCert",
            method: "PATCH",
            expectedResponses: [200, 401]            
        }, 
        
        deleteCertificate:
        {
            name: "Dashboard/DeleteCert",
            method: "DELETE",
            expectedResponses: [200, 401]            
        }, 
        
        getCustomers:
        {
            name: "Dashboard/GetCustomers",
            method: "GET",
            expectedResponses: [200, 401]  
        },

        getCustomer:
        {
            name: "Dashboard/GetCustomer",
            method: "GET",
            expectedResponses: [200, 401]  
        },

        modifyCustomer:
        {
            name: "Dashboard/ModifyCustomer",
            method: "PATCH",
            expectedResponses: [200, 401]  
        }, 

        modifyParam:
        {
            name: "Dashboard/ModifyParam",
            method: "PATCH",
            expectedResponses: [200, 401]  
        },

        getSales:
        {
            name: "Dashboard/GetSales",
            method: "GET",
            expectedResponses: [200, 401]  
        },
        
        getSale:
        {
            name: "Dashboard/GetSale",
            method: "GET",
            expectedResponses: [200, 401, 404]            
        },

        modifySale:
        {
            name: "Dashboard/ModifySale",
            method: "PATCH",
            expectedResponses: [200, 401]            
        },
        
        salesStats:
        {
            name: "Dashboard/SalesStats",
            method: "GET",
            expectedResponses: [200, 401]            
        },

        getVisitors:
        {
            name: "Dashboard/GetVisitors",
            method: "GET",
            expectedResponses: [200, 401]            
        },
    
        getOrders:
        {
            name: "Dashboard/GetOrders",
            method: "GET",
            expectedResponses: [200, 401]            
        },

        getOrder:
        {
            name: "Dashboard/GetOrder",
            method: "GET",
            expectedResponses: [200, 401, 404]            
        },

        editProfile:
        {
            name: "Dashboard/EditProfile",
            method: "PATCH",
            expectedResponses: [200, 400, 401]            
        }                        
    },
    Payment:
    {
        specificRegex:
        {
            "nombre" : /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/,
            "apellidos" : /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/,
            "envioDireccion" : /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s\.,;\-\/ºª#()&]+$/u,
            "envioCiudad" : /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/,
            "envioProvincia" : /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/,
            "envioCP" : /^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/,
            "pagoNombre" : /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/,
            "pagoTarjeta" : /^(?:(?:\d{4}[\s-]){3}\d{4}|3[47]\d{2}[\s-]\d{6}[\s-]\d{5})$/,
            "pagoMes" : /^(0[1-9]|1[0-2])$/,
            "pagoAnio" : /^\d{2}$/,
            "pagoCvv" : /^\d{3,4}$/                        
        },

        doPayment:
        {
            name: "Payment/DoPayment",
            method: "POST",
            expectedResponses: [200, 202, 400, 401]  
        }
    }
}


