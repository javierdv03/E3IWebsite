<?php
/**
 * @package Constants
 */
const EXPECTEDAPIFLOWS = [

    "Invoker" => [
      "Invoker/Status" => 
      [
           "Method" => "GET",
           "Params" => ["ExpectedMaxCount" => 0, "ExpectedMinCount" => 0, "MandatoryParams" => [], "OptionalParams" => []],
           "Controller" => ["App\\Controllers\\Invoker\\InvokerController", "status"],
           "Context" => "invoker",
           "Critical" => True
      ]

   ],

    "Auth" => [
      "Auth/Login" => 
      [
           "Method" => "POST",
           "Params" => 
           [
            "ExpectedMaxCount" => 3, "ExpectedMinCount" => 3, 
             "MandatoryParams" => 
               [
                  "email" => "/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/",
                  "password" => "/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/",
                  "g-recaptcha-response" => "/^.*$/"
               ], 
               "OptionalParams" => []
           ],
           "Controller" => ["App\\Controllers\\Auth\\AuthController", "login"],
           "Critical" => False
      ],

      "Auth/Register" => 
      [
           "Method" => "POST",
           "Params" => 
           [
           "ExpectedMaxCount" => 7, "ExpectedMinCount" => 7, 
           "MandatoryParams" => 
            [
               "NIF" => "/^([ABCDEFGHJKLMNPQRSUVW]\d{7}[0-9A-J]|[XYZ0-9]\d{7}[A-Z])$/i",
               "name" => "/^[a-zA-ZÁ-ÿ\x{00f1}\x{00d1}]+(\s*[a-zA-ZÁ-ÿ\x{00f1}\x{00d1}]*)*[a-zA-ZÁ-ÿ\x{00f1}\x{00d1}]+$/u",
               "surname" => "/^[a-zA-ZÁ-ÿ\x{00f1}\x{00d1}]+(\s*[a-zA-ZÁ-ÿ\x{00f1}\x{00d1}]*)*[a-zA-ZÁ-ÿ\x{00f1}\x{00d1}]+$/u",
               "phone" => "/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]+$/",
               "email" => "/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/",
               "password" => "/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/",
               "g-recaptcha-response" => "/.*/"
            ], 
            "OptionalParams" => []
           ],
           "Controller" => ["App\\Controllers\\Auth\\AuthController", "register"],
           "Critical" => false
      ],
      "Auth/TwoStepVerification" => 
      [
           "Method" => "POST",
           "Params" => 
           [
           "ExpectedMaxCount" => 2, "ExpectedMinCount" => 2, 
           "MandatoryParams" => 
            [
               "2FA" => "/^\d{3}\s?\d{3}$/",
               "g-recaptcha-response" => "/.*/"
            ], 
            "OptionalParams" => []
           ],
           "Controller" => ["App\\Controllers\\Auth\\AuthController", "AuthenticatorVerify"],
           "Context" => "2FA",
           "Critical" => True
      ],
      "Auth/VerifyEmail" => 
      [
           "Method" => "POST",
           "Params" => 
           [
           "ExpectedMaxCount" => 1, "ExpectedMinCount" => 1, 
           "MandatoryParams" => 
            [
               "token" => "/^[\w-]+\.[\w-]+\.[\w-]+$/"
            ], 
            "OptionalParams" => []
           ],
           "Controller" => ["App\\Controllers\\EmailVerification\\EmailVerificationController", "verifyEmail"],
           "Context" => "EmailVerification",
           "Critical" => False
      ],   

      "Auth/ForgotPass" => 
      [
           "Method" => "POST",
           "Params" => 
           [
           "ExpectedMaxCount" => 2, "ExpectedMinCount" => 2, 
           "MandatoryParams" => 
            [
               "email" => "/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/",
               "g-recaptcha-response" => "/.*/"
            ], 
            "OptionalParams" => []
           ],
           "Controller" => ["App\\Controllers\\EmailVerification\\EmailVerificationController", "forgotPass"],
           "Context" => "forgotPass",
           "Critical" => False
      ], 
      
      "Auth/VerifyLink" => 
      [
           "Method" => "POST",
           "Params" => 
           [
           "ExpectedMaxCount" => 3, "ExpectedMinCount" => 3, 
           "MandatoryParams" => 
            [
               "password" => "/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/",
               "r-password" => "/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/",
               "token" => "/.*/"
            ], 
            "OptionalParams" => []
           ],
           "Controller" => ["App\\Controllers\\EmailVerification\\EmailVerificationController", "verifyLink"],
           "Context" => "forgotPass",
           "Critical" => False
      ],      
   ],

   "Dashboard" => [

         "Dashboard/CreateCert" =>
         [
           "Method" => "POST",
           "Params" => 
           [
           "ExpectedMaxCount" => 4, "ExpectedMinCount" => 4, 
           "MandatoryParams" => 
            [
               "nombre" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/",
               "tipo" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/",
               "precio" => "/^\d+(\.\d{1,2})?$/",
               "descripcion" => "/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,;?!:-]+$/"
            ], 
            "OptionalParams" => []
           ],
           "Controller" => ["App\\Controllers\\Certificates\\CertificateController", "createCertificate"],
           "Context" => "admin",
           "Critical" => True            
         ],

         "Dashboard/ModifyCert" =>
         [
           "Method" => "PATCH",
           "Params" => 
           [
           "ExpectedMaxCount" => 5, "ExpectedMinCount" => 1, 
           "OptionalParams" => 
            [
               "nombre" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/",
               "tipo" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/",
               "precio" => "/^\d+(\.\d{1,2})?$/",
               "descripcion" => "/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,;?!:-]+$/"
            ], 
            "MandatoryParams" => 
            [
               "pk" => "/^(?:[1-9]|1[0-9]|400)$/"
            ]
           ],
           "Controller" => ["App\\Controllers\\Certificates\\CertificateController", "modifyCertificate"],
           "Context" => "admin",
           "Critical" => True            
         ],   

         "Dashboard/DeleteCert" =>
         [
           "Method" => "DELETE",
           "Params" => 
           [
           "ExpectedMaxCount" => 1, "ExpectedMinCount" => 1, 
           "MandatoryParams" => 
            [
               "pk" => "/^(?:[1-9]|1[0-9]|400)$/"
            ], 
            "OptionalParams" => []
           ],
           "Controller" => ["App\\Controllers\\Certificates\\CertificateController", "deleteCertificate"],
           "Context" => "admin",
           "Critical" => True            
         ],

         "Dashboard/GetCert" =>
         [
           "Method" => "GET",
           "Params" => 
           [
           "ExpectedMaxCount" => 0, "ExpectedMinCount" => 0, 
           "MandatoryParams" => [], 
            "OptionalParams" => []
           ],
           "Controller" => ["App\\Controllers\\Certificates\\CertificateController", "getCertificate"],
           "Context" => "admin",
           "Critical" => True            
         ],         

         "Dashboard/AddAdmin" =>
         [
           "Method" => "POST",
           "Params" => 
           [
           "ExpectedMaxCount" => 1, "ExpectedMinCount" => 1, 
           "MandatoryParams" => 
            [
               "email" => "/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/"
            ], 
            "OptionalParams" => []
           ],
           "Controller" => ["App\\Controllers\\Admin\\AdminController", "addAdmin"],
           "Context" => "admin",
           "Critical" => True            
         ],  
         "Dashboard/GetCustomers" =>
         [
           "Method" => "GET",
           "Params" => 
           [
           "ExpectedMaxCount" => 0, "ExpectedMinCount" => 0, 
           "MandatoryParams" => 
            [
               
            ], 
            "OptionalParams" => []
           ],
           "Controller" => ["App\\Controllers\\Customer\\CustomerController", "getCustomers"],
           "Context" => "admin",
           "Critical" => True            
         ],

         "Dashboard/GetCustomer" =>
         [
           "Method" => "GET",
           "Params" => 
           [
           "ExpectedMaxCount" => 1, "ExpectedMinCount" => 1, 
           "MandatoryParams" => 
            [
                  "NIF" => "/^([ABCDEFGHJKLMNPQRSUVW]\d{7}[0-9A-J]|[XYZ0-9]\d{7}[A-Z])$/i"
            ], 
            "OptionalParams" => []
           ],
           "Controller" => ["App\\Controllers\\Customer\\CustomerController", "getCustomer"],
           "Context" => "admin",
           "Critical" => True            
         ],
         
         "Dashboard/ModifyCustomer" =>
         [
           "Method" => "PATCH",
           "Params" => 
           [
           "ExpectedMaxCount" => 5, "ExpectedMinCount" => 1, 
           "OptionalParams" => 
            [
               "nombre" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/",
               "apellidos" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/",
               "email" => "/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/",
               "telefono" => "/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]+$/"
            ], 
            "MandatoryParams" => 
            [
               "NIF" => "/^([ABCDEFGHJKLMNPQRSUVW]\d{7}[0-9A-J]|[XYZ0-9]\d{7}[A-Z])$/i"
            ]
           ],
           "Controller" => ["App\\Controllers\\Customer\\CustomerController", "modifyCustomer"],
           "Context" => "admin",
           "Critical" => True            
         ],
         "Dashboard/ModifyParam" =>
         [
           "Method" => "PATCH",
           "Params" => 
           [
           "ExpectedMaxCount" => 5, "ExpectedMinCount" => 0, 
           "OptionalParams" => 
            [
               "ubicacion" => "/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚüÜ ,.\-\/ºª]+$/",
               "quienes" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/",
               "email" => "/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/",
               "telefono" => "/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]+$/",
               "empresas" => "/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ,]+$/"
            ], 
            "MandatoryParams" => 
            [
            ]
           ],
           "Controller" => ["App\\Controllers\\Param\\ParamController", "modifyParam"],
           "Context" => "admin",
           "Critical" => True            
         ],

         "Dashboard/GetSales" =>
         [
           "Method" => "GET",
           "Params" => 
           [
           "ExpectedMaxCount" => 0, "ExpectedMinCount" => 0, 
           "OptionalParams" => 
            [
            ], 
            "MandatoryParams" => 
            [
            ]
           ],
           "Controller" => ["App\\Controllers\\Sales\\SalesController", "getSales"],
           "Context" => "admin",
           "Critical" => True            
         ], 

         "Dashboard/ModifySale" =>
         [
           "Method" => "PATCH",
           "Params" => 
           [
           "ExpectedMaxCount" => 3, "ExpectedMinCount" => 1, 
           "OptionalParams" => 
            [
               "estado" => "/^(si|no)$/",
               "anotacion" => "/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,;?!:-]*$/"
            ], 
            "MandatoryParams" => 
            [
               "idPedido" => "/^(?:[1-9]|1[0-9]|400)$/"
            ]
           ],
           "Controller" => ["App\\Controllers\\Sales\\SalesController", "modifySale"],
           "Context" => "admin",
           "Critical" => True            
         ],
         
         "Dashboard/GetSale" =>
         [
           "Method" => "GET",
           "Params" => 
           [
           "ExpectedMaxCount" => 1, "ExpectedMinCount" => 1, 
           "OptionalParams" => 
            [
            ], 
            "MandatoryParams" => 
            [
               "idPedido" => "/^(?:[1-9]|1[0-9]|400)$/"
            ]
           ],
           "Controller" => ["App\\Controllers\\Sales\\SalesController", "getSale"],
           "Context" => "admin",
           "Critical" => True            
         ],

         "Dashboard/SalesStats" =>
         [
           "Method" => "GET",
           "Params" => 
           [
           "ExpectedMaxCount" => 0, "ExpectedMinCount" => 0, 
           "OptionalParams" => 
            [
            ], 
            "MandatoryParams" => 
            [
               
            ]
           ],
           "Controller" => ["App\\Controllers\\Sales\\SalesController", "salesStats"],
           "Context" => "admin",
           "Critical" => True            
         ], 
         
         "Dashboard/GetVisitors" =>
         [
           "Method" => "GET",
           "Params" => 
           [
           "ExpectedMaxCount" => 0, "ExpectedMinCount" => 0, 
           "OptionalParams" => 
            [
            ], 
            "MandatoryParams" => 
            [
               
            ]
           ],
           "Controller" => ["App\\Controllers\\Visitor\\VisitorController", "getVisitors"],
           "Context" => "admin",
           "Critical" => True            
         ],

         "Dashboard/UpdateVisitors" =>
         [
           "Method" => "POST",
           "Params" => 
           [
           "ExpectedMaxCount" => 0, "ExpectedMinCount" => 0, 
           "OptionalParams" => 
            [
            ], 
            "MandatoryParams" => 
            [
            ]
           ],
           "Controller" => ["App\\Controllers\\Visitor\\VisitorController", "updateVisitors"],
           "Context" => "admin",
           "Critical" => True            
         ],
         
         "Dashboard/GetOrders" =>
         [
           "Method" => "GET",
           "Params" => 
           [
           "ExpectedMaxCount" => 0, "ExpectedMinCount" => 0, 
           "OptionalParams" => 
            [
            ], 
            "MandatoryParams" => 
            [
            ]
           ],
           "Controller" => ["App\\Controllers\\Order\\OrderController", "getOrders"],
           "Context" => "user",
           "Critical" => True            
         ],
         "Dashboard/GetOrder" =>
         [
           "Method" => "GET",
           "Params" => 
           [
           "ExpectedMaxCount" => 1, "ExpectedMinCount" => 1, 
           "OptionalParams" => 
            [
            ], 
            "MandatoryParams" => 
            [
               "idPedido" => "/^(?:[1-9]|1[0-9]|400)$/"
            ]
           ],
           "Controller" => ["App\\Controllers\\Order\\OrderController", "getOrder"],
           "Context" => "user",
           "Critical" => True            
         ],

         "Dashboard/EditProfile" =>
         [
           "Method" => "PATCH",
           "Params" => 
           [
           "ExpectedMaxCount" => 4, "ExpectedMinCount" => 0, 
           "OptionalParams" => 
            [
               "nombre" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/",
               "apellidos" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/",
               "password" => "/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/",
               "r-password" => "/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/"               
            ], 
            "MandatoryParams" => 
            [
            ]
           ],
           "Controller" => ["App\\Controllers\\Profile\\ProfileController", "modifyProfile"],
           "Context" => "user",
           "Critical" => True            
         ],                                
      ],

   "Payment" => [

         "Payment/DoPayment" =>
         [
           "Method" => "POST",
           "Params" => 
           [
           "ExpectedMaxCount" => 9, "ExpectedMinCount" => 9, 
           "MandatoryParams" => 
            [
               "envioDireccion" => "/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s\.,;\-\/ºª#()&]+$/u",
               "envioCiudad" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/",
               "envioProvincia" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/",
               "envioCP" => "/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/",
               "pagoNombre" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/",
               "pagoTarjeta" => "/^(?:(?:\d{4}[\s-]){3}\d{4}|3[47]\d{2}[\s-]\d{6}[\s-]\d{5})$/",
               "pagoMes" => "/^(0[1-9]|1[0-2])$/",
               "pagoAnio" => "/^\d{2}$/",
               "pagoCvv" => "/^\d{3,4}$/"
            ], 
            "OptionalParams" => []
           ],
           "Controller" => ["App\\Controllers\\Payment\\PaymentController", "makePayment"],
           "Context" => "user",
           "Critical" => True            
         ]
   ]      
];

