
document.addEventListener("DOMContentLoaded", () => 
{
    inicializarEventos();
});

/* ================= INICIALIZACIÓN ================= */


function inicializarEventos() {

    document.getElementById('envioCP').addEventListener('input', soloNumeros);
    
    // 3. Tarjeta: Lógica de detección y formato
    document.getElementById('pagoTarjeta').addEventListener('input', manejarInputTarjeta);
    
    // 4. Fechas y CVV (Solo números)
    ['pagoMes', 'pagoAnio', 'pagoCvv'].forEach(id => {
        document.getElementById(id).addEventListener('input', soloNumeros);
    });

    // 5. Limpiar errores al escribir
    document.querySelectorAll('input, select').forEach(el => {
        el.addEventListener('input', () => limpiarError(el));
        el.addEventListener('change', () => limpiarError(el));
    });
}



/* ================= LÓGICA DE TARJETAS (ACTUALIZADA) ================= */

function manejarInputTarjeta(e) {
    let input = e.target;
    let valorRaw = input.value.replace(/\D/g, ''); // Limpiamos espacios para analizar

    // A. Detección de Logo (Iluminar arriba)
    detectarMarcaTarjeta(valorRaw);

    // B. Formateo visual (grupos de 4)
    input.value = valorRaw.replace(/(\d{4})(?=\d)/g, '$1 ').substring(0, 19);
}

function detectarMarcaTarjeta(numero) {
    // Referencias a los iconos
    const visa = document.getElementById('icon-visa');
    const master = document.getElementById('icon-mastercard');
    const amex = document.getElementById('icon-amex');
    const discover = document.getElementById('icon-discover'); // Nuevo
    
    const inputIcon = document.getElementById('card-type-indicator');

    // 1. Resetear todos (apagar luz)
    // Usamos 'if(i)' para evitar errores si algún icono no existe en el HTML
    [visa, master, amex, discover].forEach(i => {
        if(i) i.classList.remove('active');
    });
    
    inputIcon.className = "fa-solid fa-credit-card input-icon"; // Icono por defecto

    // 2. Lógica Solicitada: 4=Visa, 5=Master, 3=Amex, 6=Discover
    if (numero.startsWith('4')) {
        if(visa) visa.classList.add('active');
        inputIcon.className = "fa-brands fa-cc-visa input-icon";
    } 
    else if (numero.startsWith('5')) {
        if(master) master.classList.add('active');
        inputIcon.className = "fa-brands fa-cc-mastercard input-icon";
    } 
    else if (numero.startsWith('3')) {
        if(amex) amex.classList.add('active');
        inputIcon.className = "fa-brands fa-cc-amex input-icon";
    } 
    else if (numero.startsWith('6')) { // Nueva lógica Discover
        if(discover) discover.classList.add('active');
        inputIcon.className = "fa-brands fa-cc-discover input-icon";
    }
}

// === CORRECCIÓN IMPORTANTE: ALGORITMO DE LUHN ROBUSTO ===
// (La versión anterior fallaba con los ceros, esta es la correcta estándar)
function esTarjetaValida(numero) {
    // Eliminamos espacios por seguridad
    const n = numero.replace(/\D/g, '');
    
    let suma = 0;
    let debeDuplicar = false; // Empezamos desde el último dígito (check digit), ese NO se duplica

    // Recorremos de derecha a izquierda
    for (let i = n.length - 1; i >= 0; i--) {
        let digito = parseInt(n.charAt(i));

        if (debeDuplicar) {
            digito *= 2;
            if (digito > 9) digito -= 9;
        }

        suma += digito;
        debeDuplicar = !debeDuplicar; // Alternar para el siguiente
    }

    return (suma % 10) === 0;
}

/* ================= VALIDACIÓN FINAL (AL CLICKAR PAGAR) ================= */

function procesarPago() {
    let errores = false;

    // A. Validar Campos Genéricos (data-validate="texto")
    const camposTexto = document.querySelectorAll('[data-validate="texto"]');
    camposTexto.forEach(input => {
        if (input.value.trim().length < 2) {
            mostrarError(input, "Campo obligatorio");
            errores = true;
        }
    });

    // B. Dirección
    const direccion = document.getElementById('envioDireccion');
    if (direccion.value.trim().length < 5) {
        mostrarError(direccion, "La dirección parece incompleta");
        errores = true;
    }


    // E. TARJETA (Validación estricta)
    const tarjetaInput = document.getElementById('pagoTarjeta');
    const numeroTarjeta = tarjetaInput.value.replace(/\s/g, '');
    
    if (numeroTarjeta.length < 13 || !esTarjetaValida(numeroTarjeta)) {
        mostrarError(tarjetaInput, "Número de tarjeta inválido");
        errores = true;
    }

    // F. Fecha y CVV
    const mes = parseInt(document.getElementById('pagoMes').value);
    const anio = parseInt(document.getElementById('pagoAnio').value);
    const cvv = document.getElementById('pagoCvv').value;
    
    const fechaActual = new Date();
    // Obtener año actual en 2 dígitos (ej: 26)
    const anioActualShort = parseInt(fechaActual.getFullYear().toString().slice(-2));
    const mesActual = fechaActual.getMonth() + 1;

    let fechaValida = true;
    if (!mes || !anio || mes < 1 || mes > 12) fechaValida = false;
    if (anio < anioActualShort) fechaValida = false; // Año pasado
    if (anio === anioActualShort && mes < mesActual) fechaValida = false; // Mes pasado este año

    if (!fechaValida) {
        document.getElementById('error-fecha').innerText = "Tarjeta caducada";
        document.getElementById('pagoMes').classList.add('input-error');
        document.getElementById('pagoAnio').classList.add('input-error');
        errores = true;
    }

    if (cvv.length < 3) {
        mostrarError(document.getElementById('pagoCvv'), "CVV incompleto");
        errores = true;
    }

    // RESULTADO
    if (errores) {
        const primerError = document.querySelector('.input-error');
        if(primerError) {
            primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
}

/* ================= UTILIDADES ================= */

function mostrarError(input, mensaje) {
    input.classList.add('input-error');
    let padre = input.closest('.campo-grupo');
    let span = padre.querySelector('.error-msg');
    if (span) span.innerText = mensaje;
}

function limpiarError(input) {
    input.classList.remove('input-error');
    let padre = input.closest('.campo-grupo');
    let span = padre.querySelector('.error-msg');
    if (span) span.innerText = "";
    
    // Limpieza especial para fecha (ya que son dos inputs)
    if(input.id === 'pagoMes' || input.id === 'pagoAnio') {
        document.getElementById('error-fecha').innerText = "";
        document.getElementById('pagoMes').classList.remove('input-error');
        document.getElementById('pagoAnio').classList.remove('input-error');
    }
}

function soloNumeros(e) {
    e.target.value = e.target.value.replace(/[^0-9]/g, '');
}
