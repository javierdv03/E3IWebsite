# Specification: Suggester ML Core

**Component:** `Suggester.js`  
**Type:** Logic Controller / Inference Engine  
**Date:** 2025-11-28  
**Model:** Hybrid Markov Chain (Global Frequency + Local Transition)

## 1. Overview
The `Suggester` class acts as the intelligence layer for the navigation system. It predicts the user's next likely action by combining **Global Popularity** (long-term preference) with a **First-Order Markov Chain** (immediate context/transition probability).

## 2. Persistence Model (`Backpack`)
The system state is stored in `localStorage` under the key `"backpack"`.

**JSON Schema:**
```json
{
  "timestamp": "Number (Epoch ms)",
  "lastAction": "String (Action Code, e.g., 'm')",
  "transitionMatrix": {
    "prev_action_code": {
      "next_action_code": "Number (Frequency)"
    }
  }
}
```

**Lifecycle Rules:**
* **TTL (Time To Live):** 24 Hours.
* **Validation:** On instantiation, if `timestamp` is not from the current day, the `backPack` is reset (Daily Wipe).

## 3. Mathematical Model (The "Hybrid Score")

The system ranks potential actions based on a weighted score:

$$Score(a) = W_g \cdot P_{global}(cat_a) + W_l \cdot P_{local}(a | a_{prev})$$

Where:
* $a$: Candidate action.
* $cat_a$: Category belonging to action $a$.
* $a_{prev}$: The action immediately preceding the current state.
* $P_{global}$: Probability derived from `PointDS` (Long-term frequency).
* $P_{local}$: Conditional probability derived from `transitionMatrix` (Context).
* **Weights:**
    * $W_g$ (Global Weight): **0.3** (30%)
    * $W_l$ (Local Weight): **0.7** (70%)

*Rationale: Immediate context (what I just did) is a stronger predictor of the next step than general preference.*

## 4. Core Methods

### 4.1 Initialization
**Method:** `init(domElements)`
* Parses DOM elements looking for `data-text` attributes in the format `"category action_code"`.
* Attaches `click` listeners that trigger the learning mechanism (`recordAction`).

### 4.2 Learning Mechanism
**Method:** `recordAction(category, actionCode)`
1.  **Global Update:** Calls `PointDS.increment(category)`.
2.  **Local Update (Transition):**
    * Retrieves `lastAction` from the backpack.
    * If `lastAction` exists, updates the `transitionMatrix`:
        `matrix[lastAction][currentAction] += 1`
3.  **State Save:** Updates `lastAction` to `currentAction` and persists to LocalStorage.

### 4.3 Inference
**Method:** `predictNext()`
* **Input:** None (reads internal state).
* **Process:**
    1.  Calculates $P_{global}$ for all categories.
    2.  Calculates $P_{local}$ based on the `lastAction` row in the matrix.
    3.  Iterates through `availableOptions`.
    4.  Applies the **Hybrid Score** formula.
* **Output:** Returns the top 3 actions with the highest score.

## 5. Security & Privacy Note (UEBA Context)
* **Data Locality:** All logic executes client-side. No behavioral data is sent to a remote server.
* **Fingerprinting:** This system creates a behavioral fingerprint of the admin. In a security context (UEBA - User and Entity Behavior Analytics), drastic changes in the `transitionMatrix` patterns could theoretically indicate account compromise (anomaly detection), though this feature is out of scope for the current version.