# Especificación Técnica: Núcleo ML Suggester

**Componente:** `Suggester.js`  
**Tipo:** Controlador Lógico / Motor de Inferencia  
**Fecha:** 28-11-2025  
**Modelo:** Cadena de Markov Híbrida (Frecuencia Global + Transición Local)

## 1. Visión General
La clase `Suggester` actúa como la capa de inteligencia para el sistema de navegación. Predice la siguiente acción probable del usuario combinando la **Popularidad Global** (preferencia a largo plazo) con una **Cadena de Markov de Primer Orden** (contexto inmediato/probabilidad de transición).

## 2. Modelo de Persistencia (`Backpack`)
El estado del sistema se almacena en `localStorage` bajo la clave `"backpack"`.

**Esquema JSON:**
```json
{
  "timestamp": "Number (Epoch ms)",
  "lastAction": "String (Código de Acción, ej: 'm')",
  "transitionMatrix": {
    "codigo_accion_previa": {
      "codigo_accion_siguiente": "Number (Frecuencia)"
    }
  }
}
```

**Reglas de Ciclo de Vida:**
* **TTL (Tiempo de Vida):** 24 Horas.
* **Validación:** Al instanciar, si el `timestamp` no pertenece al día actual, el `backPack` se reinicia (Limpieza Diaria).

## 3. Modelo Matemático ("Puntuación Híbrida")

El sistema clasifica las acciones potenciales basándose en una puntuación ponderada:

$$Score(a) = W_g \cdot P_{global}(cat_a) + W_l \cdot P_{local}(a | a_{prev})$$

Donde:
* $a$: Acción candidata.
* $cat_a$: Categoría perteneciente a la acción $a$.
* $a_{prev}$: La acción inmediatamente precedente al estado actual.
* $P_{global}$: Probabilidad derivada de `PointDS` (Frecuencia a largo plazo).
* $P_{local}$: Probabilidad condicional derivada de `transitionMatrix` (Contexto).
* **Pesos (Weights):**
    * $W_g$ (Peso Global): **0.3** (30%)
    * $W_l$ (Peso Local): **0.7** (70%)

*Justificación: El contexto inmediato (lo que acabo de hacer) es un predictor más fuerte del siguiente paso que la preferencia general.*

## 4. Métodos Principales

### 4.1 Inicialización
**Método:** `init(domElements)`
* Analiza (parses) elementos del DOM buscando atributos `data-text` en el formato `"categoria codigo_accion"`.
* Adjunta escuchadores `click` que activan el mecanismo de aprendizaje (`recordAction`).

### 4.2 Mecanismo de Aprendizaje
**Método:** `recordAction(category, actionCode)`
1.  **Actualización Global:** Llama a `PointDS.increment(category)`.
2.  **Actualización Local (Transición):**
    * Recupera `lastAction` de la mochila.
    * Si existe `lastAction`, actualiza la `transitionMatrix`:
        `matrix[lastAction][currentAction] += 1`
3.  **Guardado de Estado:** Actualiza `lastAction` a `currentAction` y persiste en LocalStorage.

### 4.3 Inferencia
**Método:** `predictNext()`
* **Entrada:** Ninguna (lee estado interno).
* **Proceso:**
    1.  Calcula $P_{global}$ para todas las categorías.
    2.  Calcula $P_{local}$ basado en la fila de `lastAction` en la matriz.
    3.  Itera a través de `availableOptions`.
    4.  Aplica la fórmula de **Puntuación Híbrida**.
* **Salida:** Retorna las 3 acciones superiores con la puntuación más alta.

## 5. Nota de Seguridad y Privacidad (Contexto UEBA)
* **Localidad de Datos:** Toda la lógica se ejecuta del lado del cliente. No se envían datos de comportamiento a un servidor remoto.
* **Huella Digital (Fingerprinting):** Este sistema crea una huella de comportamiento del administrador. En un contexto de seguridad (UEBA - User and Entity Behavior Analytics), cambios drásticos en los patrones de la `transitionMatrix` podrían teóricamente indicar un compromiso de la cuenta (detección de anomalías), aunque esta característica está fuera del alcance de la versión actual.