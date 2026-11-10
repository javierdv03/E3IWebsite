export class PointDS {
    collisionalMap; 

    constructor(prebuilt) 
    {
        this.collisionalMap = new Map(Object.entries(!prebuilt ? {admin: 1, cert: 1, customers: 1, innerOptions: 1, sales: 1} : prebuilt));
    }

    increment(key) 
    {
        if (!this.collisionalMap.has(key)) return;
        this.collisionalMap.set(key, this.collisionalMap.get(key) + 1);
     
    }

    getTop(k = 3) 
    {
        
        return [...this.collisionalMap.entries()]
            .sort((a, b) => b[1] - a[1]) // Orden descendente
            .slice(0, k)
            .map(entry => entry[0]); // Devolvemos solo las keys
    }
    
   
    getProbabilities() 
    {
        const total = [...this.collisionalMap.values()].reduce((a, b) => a + b, 0);
        let probs = {};
        for (let [key, val] of this.collisionalMap) {
            probs[key] = val / total;
        }
        return probs;
    }
}