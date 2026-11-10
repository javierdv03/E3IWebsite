# Specification: Point Data Structure (PointDS)

**Component:** `PointDS.js`  
**Type:** Data Structure / Utility  
**Date:** 2025-11-28  
**Context:** Global Frequency Analysis for Suggester System

## 1. Overview
The `PointDS` class is responsible for tracking the **Global Popularity** of system categories. It acts as a persistent counter that operates independently of the user's immediate context (session flow). Ideally, it represents the "general behavior" of the user over time.

## 2. Data Structures

### 2.1 `collisionalMap`
A `Map` object used to store frequency counts.
* **Key (`String`):** The root category identifier (e.g., `'admin'`, `'sales'`, `'cert'`).
* **Value (`Number`):** The total cumulative clicks.

**Initialization Strategy:**
To implement **Laplace Smoothing** (preventing zero-probability issues), the map is initialized with a base count of `1` for all known categories.

```javascript
// Initial State Concept
Map {
  'admin': 1,
  'cert': 1,
  'customers': 1,
  'innerOptions': 1,
  'sales': 1
}
```

## 3. Functional Requirements

### 3.1 Increment Logic
**Method:** `increment(key)`
* **Input:** Category key (`String`).
* **Behavior:**
    1.  Validates if the key exists in the map.
    2.  Increments the associated value by `1`.


### 3.2 Retrieval Logic (Top K)
**Method:** `getTop(k)`
* **Input:** Number of top elements to retrieve (`k`, default: 3).
* **Behavior:**
    1.  Converts the Map entries to an Array.
    2.  Sorts the Array in descending order based on value.
    3.  Slices the first `k` elements.
* **Output:** Array of keys (e.g., `['sales', 'cert', 'admin']`).

### 3.3 Probability Normalization
**Method:** `getProbabilities()`
* **Purpose:** Converts raw counts into a probability distribution ($P_{global}$) for use in the weighted algorithm.
* **Formula:**
    $$P(c_i) = \frac{count(c_i)}{\sum_{j=1}^{N} count(c_j)}$$
* **Output:** Object `{ category: probability_float }`.

## 4. Complexity Analysis
* **Space Complexity:** $O(N)$ where $N$ is the number of categories.
* **Time Complexity (Write):** $O(1)$.
* **Time Complexity (Read):** $O(N \log N)$ due to sorting. Since $N$ is small (approx 5-10), this is negligible.