# Especificación Técnica: Point Data Structure (PointDS)

**Componente:** `PointDS.js`  
**Tipo:** Estructura de Datos / Utilidad  
**Fecha:** 28-11-2025  
**Contexto:** Análisis de Frecuencia Global para el Sistema Sugeridor

## 1. Visión General
La clase `PointDS` es responsable de rastrear la **Popularidad Global** de las categorías del sistema. Actúa como un contador persistente que opera independientemente del contexto inmediato del usuario (flujo de sesión). Idealmente, representa el "comportamiento general" del usuario a lo largo del tiempo.

## 2. Estructuras de Datos

### 2.1 `collisionalMap`
Un objeto `Map` utilizado para almacenar conteos de frecuencia.
* **Clave (`String`):** El identificador raíz de la categoría (ej: `'admin'`, `'sales'`, `'cert'`).
* **Valor (`Number`):** El total acumulado de clicks.

**Estrategia de Inicialización:**
Para implementar el **Suavizado de Laplace** (evitando problemas de probabilidad cero), el mapa se inicializa con un conteo base de `1` para todas las categorías conocidas.

```javascript
// Concepto del Estado Inicial
Map {
  'admin': 1,
  'cert': 1,
  'customers': 1,
  'innerOptions': 1,
  'sales': 1
}
```

## 3. Requisitos Funcionales

### 3.1 Lógica de Incremento
**Método:** `increment(key)`
* **Entrada:** Clave de categoría (`String`).
* **Comportamiento:**
    1.  Valida si la clave existe en el mapa.
    2.  Incrementa el valor asociado en `+1`.


### 3.2 Lógica de Recuperación (Top K)
**Método:** `getTop(k)`
* **Entrada:** Número de elementos superiores a recuperar (`k`, por defecto: 3).
* **Comportamiento:**
    1.  Convierte las entradas del Mapa a un Array.
    2.  Ordena el Array en orden descendente basado en el valor.
    3.  Recorta (slice) los primeros `k` elementos.
* **Salida:** Array de claves (ej: `['sales', 'cert', 'admin']`).

### 3.3 Normalización de Probabilidad
**Método:** `getProbabilities()`
* **Propósito:** Convierte conteos brutos en una distribución de probabilidad ($P_{global}$) para su uso en el algoritmo ponderado.
* **Fórmula:**
    $$P(c_i) = \frac{count(c_i)}{\sum_{j=1}^{N} count(c_j)}$$
* **Salida:** Objeto `{ categoria: probabilidad_float }`.

## 4. Análisis de Complejidad
* **Complejidad Espacial:** $O(N)$ donde $N$ es el número de categorías.
* **Complejidad Temporal (Escritura):** $O(1)$.
* **Complejidad Temporal (Lectura):** $O(N \log N)$ debido al ordenamiento. Dado que $N$ es pequeño (aprox. 5-10), esto es despreciable.