import { PointDS } from "../PointDS/PointDS.js";

export class Suggester {
    availableOptions = 
    {
        admin: ["a"], 
        cert: ["r", "m"],  
        customers: ["l", "m"], 
        innerOptions: ["s"], 
        sales: ["l"] 

    };
    static PointStacker; 
    backPack;
    
    constructor() 
    {
        const stored = JSON.parse(localStorage.getItem("backpack"));
        const isToday = stored && new Date(stored.timestamp).getDate() === new Date().getDate();

        this.backPack = isToday ? stored : {
            lastAction: null, // Solo necesitamos la INMEDIATA anterior para la transición
            transitionMatrix: {}, // Aquí guardamos el aprendizaje: { "m": { "s": 5, "l": 1 } }
            categoryClicks: {admin: 1, cert: 1, customers: 1, innerOptions: 1, sales: 1},
            timestamp: new Date().getTime()
        };

        Suggester.PointStacker = new PointDS(this.backPack.categoryClicks);

        this.debugOperatibility();
    }

    init(tags) {
        tags.forEach(tag => {
            const [category, actionCode] = tag.getAttribute("data-text").split(" "); 
            
            tag.addEventListener("click", () => {
                this.recordAction(category, actionCode);
            });
        });
    }

    recordAction(category, actionCode) 
    {    
        Suggester.PointStacker.increment(category);
        this.backPack.categoryClicks[category] += 1;
        
        const prev = this.backPack.lastAction; 
        const current = actionCode;            

        if (prev) 
        {
            if (!this.backPack.transitionMatrix[prev]) this.backPack.transitionMatrix[prev] = {};
            
            const count = this.backPack.transitionMatrix[prev][current] || 0;
            this.backPack.transitionMatrix[prev][current] = count + 1;
        }


        this.backPack.lastAction = current;
        this.saveBackpack();
    }

 
   predictNext() 
    {
        const lastAction = this.backPack.lastAction;
        const globalProbs = Suggester.PointStacker.getProbabilities(); 
        

        let localProbs = {};
        if (lastAction && this.backPack.transitionMatrix[lastAction]) 
        {
            const transitions = this.backPack.transitionMatrix[lastAction];
            const totalTrans = Object.values(transitions).reduce((a, b) => a + b, 0);
            for (let act in transitions) localProbs[act] = transitions[act] / totalTrans;
        }


        let candidates = [];
        

        for (let [cat, actions] of Object.entries(this.availableOptions)) {
            let catWeight = globalProbs[cat] || 0; 
            
            actions.forEach(act => {
                let transWeight = localProbs[act] || 0; 
                

                let finalScore = (catWeight * 0.3) + (transWeight * 0.7);
                
                candidates.push({
                    category: cat,
                    action: act,
                    score: finalScore
                });
            });
        }

        
        return candidates.sort((a, b) => b.score - a.score).slice(0, 3);
    }
    
    saveBackpack() {
        localStorage.setItem("backpack", JSON.stringify(this.backPack));
    }
    
    debugOperatibility()
    {
        let idTimeOut;

        setInterval(() => {
            console.log("Contenido de backpack: ", this.backPack);
            console.log("Candidatos siguientes: ", this.predictNext());

            if(!idTimeOut)
            {
                idTimeOut = setTimeout(() => {
                        console.clear();
                        console.log(idTimeOut);
                        clearTimeout(idTimeOut);
                        idTimeOut = undefined;
                }, 10000);
            }

        }, 3500);
    }
}