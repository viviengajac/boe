<script>
const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");
const grid = document.getElementById("grid");
const ctxGrid = grid.getContext("2d");
//canvas.width = window.innerWidth;
//canvas.height = window.innerHeight;
let gridSizes = 600;
canvas.width = gridSizes;
canvas.height = gridSizes;
grid.width = gridSizes;
grid.height = gridSizes;
document.documentElement.style.setProperty("--gridSize", gridSizes + "px");
const gridLineWidth = 3;
const gridShadowBlur = 32;
const gridBorderSize = 0;
let gridColor = "hsla(180, 100%, 50%, .75)";
let uiColor = "hsl(120, 225, 25)";
//const pathStartGradient =  ctxGrid.createLinearGradient(0, 0, 50, 0);
        //const gradient = ctxGrid.createLinearGradient(0, 0, canvas.width, 0);
//pathStartGradient.addColorStop(0, "hsl(120, 100%, 50%)");
//pathStartGradient.addColorStop(0.5, "hsl(180, 0%, 0%)");
//pathStartGradient.addColorStop(1, "hsl(0, 100%, 50%)");
        //ctxGrid.strokeStyle = pathWayColor;
//const pathStartColor = "green";
let pathStartColor = "green";
let pathFinishColor = "red";
const pathColor = "hsl(180, 100%, 35%)";
const pathWayColor = "#000";
const cellulesArray = [];
let cellSize = 0;
let towerId = 0;

const mobsHpNext = document.getElementById("mobsHpNext");
const mobsSpeedNext = document.getElementById("mobsSpeedNext");
const mobsTypeNext = document.getElementById("mobsTypeNext");

const selectedItemName = document.getElementById("selected-item-name");
const itemName = document.getElementById("itemName");
const itemCost = document.getElementById("itemCost");
const selectedItemDatas = document.getElementById("selected-item-data");
const selectedItemId = document.getElementById("selectedTowerId");
const selectedItemStats = document.getElementById("selected-item-stats");
const selectedItemDesc = document.getElementById("selected-item-desc");
const selectedItemLevel = document.getElementById("selected-item-level");
const selectedItemDamage = document.getElementById("selected-item-damage");
const selectedItemRadius = document.getElementById("selected-item-radius");
const selectedItemHeal = document.getElementById("selected-item-heal");
const selectedTowerKills = document.getElementById("selectedTowerKills");
const selectedTowerDamage = document.getElementById("selectedTowerDamage");
const selectedTowerHeals = document.getElementById("selectedTowerHeals");
const selectedTowerHealing = document.getElementById("selectedTowerHealing");
const selectedTowerValue = document.getElementById("selectedTowerValue");
const selectedTowerEffectiveCost = document.getElementById("selectedTowerEffectiveCost");
const selectedItemOptions = document.getElementById("selectedItemOptions");
const confirmButton = document.getElementById("confirmButton");
const quitButton = document.getElementById("quitButton");

const towersRadiusBase = 75;
let selectedTower;

let maxLoopers = 20;

let totalMobsBox = document.getElementById("totalMobs");
let totalMobs = 0;
let mobsKilledBox = document.getElementById("mobsKilled");
let mobsKilled = 0;
let mobsHealedBox = document.getElementById("mobsHealed");
let mobsHealed = 0;
let loopersBox = document.getElementById("loopers");
let loopers = 0;
let mobsAlive = 0;
const towersCounterBox = document.querySelectorAll('[id^="towerCount"]');
let towersCounter = [0, 0, 0, 0, 0];

// traduction
const elementsName = [
    ["ice", "water", "fire", "lightning", "dark"],
    ["glace", "eau", "feu", "foudre", "sombre"]
];
const staticTranslations = [
    [
        "score data", "towers", "credits", /* "credits multiplier" */"total", "last wave", "credits", "new tower", "cost", "nb", "ice", "water", "fire", "lightning", "dark", "select a map then click on start", "level", "radius", "damage", "healing", "kills", "damage done", "heals", "heals done", "value", "effective cost", "hover an upgrade", "wave", "hp", "speed", "element", "left", "danger level", "next wave", "hp", "speed", "element", "left", "top scores", "player name", "wave", "mobs data", "total", "killed", "healed", "loopers", "maps list", "towers inventory", "settings", "interface color", "text color", "game language", "game summary", "final score", "last wave", "confirm", "cancel", "victory", "defeat", "reset", "launch wave", "stats for tower #", "tower #", "cooldown", "second", "level up", "add 1 level to the tower", "demolition", "destroy the tower", "warning : no refund", "level up tower", "upgrade tower", "start", "quit", "wave"
    ], // english
    [
        
        "données du score", "tours", "crédits", /* "multiplicateur de crédits" */ "total", "dernière vague", "crédits", "nouvelle tour", "coût", "nb", "glace", "eau", "feu", "foudre", "sombre", "choisissez une carte puis cliquer sur démarrer", "niveau", "portée", "dégats", "soins", "tués", "dégats faits", "soignés", "soins faits", "valeur", "coût effectif", "survolez une amélioration", "vague", "pv", "vitesse", "élément", "restants", "niveau danger", "prochaine vague", "pv", "vitesse", "élément", "restants", "meilleurs scores", "nom joueur", "vague", "données des mobs", "total", "tués", "soignés", "boucleurs", "liste des cartes", "inventaire des tours", "réglages", "couleur de l'interface", "couleur du texte", "langue du jeu", "résumé partie", "score final", "dernière vague", "confirmer", "annuler", "victoire", "défaite", "rejouer", "lancer vague", "stats pour tour #", "tour #", "recharge", "seconde", "niveau supérieur", "ajoute 1 niveau à la tour", "démolition", "détruit la tour", "attention : aucun remboursement", "niveau supérieur tour", "amélioration tour", "démarrer", "quitter", "vague"
    ] // fr
];
const guildelineTranslations = [
    [
        "select a map then click on start", "click on a new tower", "place the tower on the grid", "click on a new tower\r\n\r\nor\r\n\r\nselect a tower on the grid\r\n\r\nor\r\n\r\nclick on launch wave", "not enough credits", "click on launch wave"
    ],
    [
        "choisissez une carte puis cliquer sur démarrer", "cliquez sur une nouvelle tour", "placez la tour dans la grille", "cliquez sur une nouvelle tour\r\n\r\nou\r\n\r\nsélectionnez une tour dans la grille\r\n\r\nou\r\n\r\ncliquez sur lancer vague", "crédits insuffisants", "cliquez sur lancer vague"
    ]
];
let gameLanguage = 1; // 0 = en; 1 = fr;
// j'ai ajouté le préfixe "text" à l'id de tous les éléments html qui comportent un texte statique
const toTranslate = document.querySelectorAll('[id^="text"]');
//console.log(toTranslate);
function updateLanguage() {
    for (let i = 0; i < toTranslate.length; i++) {    
        toTranslate[i].textContent = staticTranslations[gameLanguage][i];
    }    
    confirmButton.textContent = quitButton.textContent = staticTranslations[gameLanguage][toTranslate.length + 17];
    quitButton.textContent = quitButton.textContent = staticTranslations[gameLanguage][toTranslate.length + 18];
    for (let i = 0; i < elementsName.length; i++) {

        document.documentElement.style.setProperty("--tow0", elementsName[gameLanguage][i]);
    }
}
updateLanguage();

const mouse = {
    x: null,
    y: null
}

class Cellule {
    constructor(x, y, cellSize, id, towerId, towerType) {
        this.x = x,
        this.y = y,
        this.cellSize = cellSize,
        this.gridX = Math.floor(this.x / cellSize),
        this.gridY = Math.floor(this.y / cellSize),
        this.cellId = id,
        this.isLocked = false,
        this.hasTower = false,
        this.towerId = null,
        this.towerType = towerType
    }
    draw() {
        ctxGrid.clearRect(this.x, this.y, this.cellSize, this.cellSize);
        //console.log("cellule.draw() ctxGrid.lineWidth= "+ctxGrid.lineWidth+" ;shadowBlur= "+ctxGrid.shadowBlur);
        //console.log("this.x= "+this.x);
        //console.log("this.gridX= "+this.gridX+" ;this.gridY= "+this.gridY);
        //ctx.fillStyle = "white";
        //ctx.fillRect(this.x, this.y, this.cellSize, this.cellSize);
        ctxGrid.shadowColor = gridColor;
        ctxGrid.strokeStyle = gridColor;
        ctxGrid.shadowBlur = gridShadowBlur;
        ctxGrid.lineWidth = gridLineWidth;
        ctxGrid.strokeRect(this.x, this.y, this.cellSize, this.cellSize);
        if (this.hasTower) {
            //console.log("type= "+types[this.towerType]+" ;waveSettings= "+waveSettings);
            ctxGrid.shadowBlur = 16;
            ctxGrid.lineWidth = 4;
            ctxGrid.fillStyle = "hsla("+types[this.towerType]+", 100%, 50%, .1)";
            ctxGrid.strokeStyle = "hsl("+types[this.towerType]+", 100%, 50%)";
            ctxGrid.shadowColor = "hsl("+types[this.towerType]+", 100%, 50%)";
            ctxGrid.fillRect(this.x + 4, this.y + 4, this.cellSize - 8, this.cellSize - 8);
            ctxGrid.strokeRect(this.x + 4, this.y + 4, this.cellSize - 8, this.cellSize - 8);
        }
    }
    onClick() {
        // place une tour dans la grille
        if (this.isLocked == false && userHasPickedTower == true) {
            //console.log("b "+ this.gridX +" "+ this.gridY +" "+this.cellId);
            //console.log("THIS= "+this.x+" "+this.y);
            ctx.clearRect(this.x, this.y, this.cellSize, this.cellSize);
            //ctx.strokeStyle = "white";
            //ctx.strokeRect(this.x, this.y, this.cellSize, this.cellSize);
            let cellCenterX = this.x + cellSize / 2;
            let cellCenterY = this.y + cellSize / 2;
            let radius = towersRadiusBase + (10 * pickedTowerType);
            let damage = 1 + pickedTowerType;
            let color = wavesSettings[pickedTowerType][1];
            let cost = towersCost[pickedTowerType];
            //console.log(cellCenterX);
            score -= cost;
            if (animationIsOn) {
                updateWarningBuffer();
            }
            bufferScore = score;
            bufferScoreBox.textContent = bufferScore.toLocaleString("en-US");
            towersScore += cost;
            towersScoreBox.textContent = towersScore.toLocaleString("en-US");
            //console.log("appel de checkScore()");
            checkScore();
            document.documentElement.style.setProperty("--scoreUpdateColor", "rgb(200, 25, 25)");
            scoreUpdateBoxUpdate("-", cost);
            scoreBox.textContent = score.toLocaleString("en-US");
            bufferScoreBox.textContent = score.toLocaleString("en-US");
            let tower = new Tower(cellCenterX, cellCenterY, radius, damage, color, towerId, pickedTowerType, this.cellId);
            cellulesArray[this.cellId].towerId = towerId;
            cellulesArray[this.cellId].towerType = pickedTowerType;
            towerId++;
            towers.push(tower);
            tower.updateOptions();
            tower.draw();
            this.isLocked = true;
            this.hasTower = true;
            towersCounter[pickedTowerType]++;
            towersCounterBox[pickedTowerType].textContent = towersCounter[pickedTowerType];
            updateGrid();
        }
        else if (this.hasTower) {
            //console.log("clic sur tower "+this.towerId);
            //console.log(towers);
            if (userHasPickedTower) {
                let towerImage = document.getElementById("towerImage");
                towerImage.remove();
                window.removeEventListener("mousemove", positionTower);
                userHasPickedTower = false;
                //console.log("appel de checkScore()");
                checkScore();
            }
            if (selectedTower) {
                selectedTower.isSelected = false;
                selectedTower = false;
            }
            if (towers[this.towerId]) { //sélectionne une tour dans la grille
                //console.log("tower existe");
                //console.log(this);
                if (resetDisplay) {
                    clearTimeout(resetDisplay);
                }
                selectedTower = towers[this.towerId];
                selectedTower.isSelected = true;
                //console.log("appel de selectedTower.updateOptions()");
                selectedTower.updateOptions();
                selectedTower.checkOptionsCost();
                displayDatas(this.towerId, false);
                window.addEventListener("mousemove", hoverOptions);
                guideline.textContent = guildelineTranslations[gameLanguage][3];
            }
            //selectedTower = towers[this.towerId];
            //displayDatas(this.towerId, false);
            //selectedTower.isSelected = true;
            if (!animationIsOn) {
                drawContext();
            }
        }
        else {
            if (selectedTower) {
                selectedTower.isSelected = false;
                selectedTower = false;
            }
            selectedItemName.style.opacity = 0;
            selectedItemDatas.style.opacity = 0;
            selectedItemId.style.opacity = 0;
            selectedItemStats.style.opacity = 0;
            selectedItemDesc.style.opacity = 1;
            //selectedItemDesc.style.pointerEvents = "all";
            selectedItemOptions.style.opacity = 0;
            selectedItemOptions.style.pointerEvents = "none";
            hideTooltip();
            window.removeEventListener("mousemove", hoverOptions);
            //console.log(this.cellId+" is locked");
            if (!animationIsOn) {
                drawContext();
            }
        }
    }
}

let towerDiv;
let towerImageRadius;
let resetDisplay = false;
function createTower() {
    towerDiv = document.createElement("div");
    towerDiv.setAttribute("id", "towerImage");
    towerImageRadius = (75 + (10 * pickedTowerType)) / 600 * gridSizes;
    let towerColorHSL = types[pickedTowerType];
    let towerColor = "hsla(" + towerColorHSL + ", 100%, 50%, .15)";
    document.documentElement.style.setProperty('--pickedTowerDotColor', "hsla(" + towerColorHSL + ", 100%, 50%, .75)");
    //console.log("event "+mouse.x);
    document.body.appendChild(towerDiv);
    setTimeout(() => {
        towerDiv.style.borderColor = "hsla(" + towerColorHSL + ", 100%, 50%, .85)";
        towerDiv.style.background = towerColor;
        towerDiv.style.width = towerImageRadius * 2 + "px";
        towerDiv.style.height = towerImageRadius * 2 + "px";
        towerDiv.style.left = mouse.x - towerImageRadius + "px";
        //console.log("scrollY= "+scrollY);
        towerDiv.style.top = mouse.y - towerImageRadius + scrollY + "px";
        towerDiv.style.opacity = 1;
    }, 10);
}
function positionTower(e) {
    //console.log("mouse = "+mouse.x+" "+mouse.y);
    //console.log("e.target = "+e.offsetX+" "+e.offsetY);
    //console.log("e.id = "+e.target.id);
    //console.log("e = "+e.x+" "+e.y);
    let towerImage = document.getElementById("towerImage");
    let towerImageRadius = (75 + (10 * pickedTowerType)) / 600 * gridSizes;
    let towerColorHSL = types[pickedTowerType];
    let towerColor = "hsla(" + towerColorHSL + ", 100%, 50%, .15)";
    document.documentElement.style.setProperty('--pickedTowerDotColor', "hsla(" + towerColorHSL + ", 100%, 50%, .75)");
    towerImage.style.borderColor = "hsla(" + towerColorHSL + ", 100%, 50%, .85)";
    towerImage.style.background = towerColor;
    towerImage.style.width = towerImageRadius * 2 + "px";
    towerImage.style.height = towerImageRadius * 2 + "px";
    //console.log("radius= "+towerImageRadius);
    if (e.target.id == "canvas" && e.offsetX >= 0 && e.offsetX <= canvas.width && e.offsetY >= 0 && e.offsetY <= canvas.height) {
        let cellX = Math.floor(e.offsetX / cellSize) * cellSize;
        let cellY = Math.floor(e.offsetY / cellSize) * cellSize;
        let cellId;
        cellId = cellSize * cellY + cellX;
        let cellCenterX = cellX + cellSize / 2;
        let cellCenterY = cellY + cellSize / 2;
        //console.log("coord:" +cellX+" "+cellY);
        //console.log(cellCenterX+ " "+cellCenterY);
        let towerX;
        if (window.innerWidth > canvas.width * 2) {
            towerX = (window.innerWidth - canvas.width) / 2 + cellCenterX - towerImageRadius + "px";
        }
        else {
            towerX = canvas.width / 2 + cellCenterX - towerImageRadius + "px";
        }
        let towerY;
        if (window.innerHeight > canvas.height * 1.5) {
            towerY = (window.innerHeight - canvas.height) / 2 + cellCenterY - towerImageRadius + "px";
        }
        else {
            towerY = canvas.height / 4 + cellCenterY - towerImageRadius + "px";
        }
        //console.log("coordTower:" +towerX+" "+towerY);
        //towerImage.style.marginLeft = (window.innerWidth - canvas.width) / 2 + "px";
        //console.log("PX= "+(window.innerWidth - canvas.width) / 2);
        towerImage.style.left = towerX;
        towerImage.style.top = towerY;
    }
    else {
        //console.log(e.x);
        towerImage.style.left = e.x - towerImageRadius + "px";
        towerImage.style.top = e.y - towerImageRadius + scrollY + "px";
    }
}

selectedItemName.style.opacity = 0;
selectedItemDatas.style.opacity = 0;
selectedItemId.style.opacity = 0;
selectedItemStats.style.opacity = 0;
let userHasPickedTower = false;
let pickedTowerType = false;
const guideline = document.getElementById("textGuideline");
function pickTower(towerType) {
    //console.log("userHasPickTower= "+userHasPickedTower);
    //console.log(selectedTower);

    if (userHasPickedTower == true) {
        if (towerType == pickedTowerType) {
            //console.log("1");
            let box = document.getElementById("pick"+towerType);
            if (score < towersCost[towerType]) {
                box.style.background = "rgba(200, 25, 25, .75)";
                box.style.boxShadow = "0 0 15px rgba(200, 25, 25, .75)";
            }
            else {
                box.style.background = "rgba(25, 200, 25, .75)";
                box.style.boxShadow = "0 0 15px rgba(25, 200, 25, .75)";
            }
           // box.style.background = "rgba(255, 25, 25, .75)";
            userHasPickedTower = false;
            if (waveNumber > 0)
                guideline.textContent = guildelineTranslations[gameLanguage][3];
            else
                guideline.textContent = guildelineTranslations[gameLanguage][1];
            let towerDiv = document.getElementById("towerImage");
            towerDiv.remove();
            clearDatas();
            window.removeEventListener("mousemove", positionTower);
        }
        else {
            //towerDiv.style.opacity =  0;
            let previousBox = document.getElementById("pick"+pickedTowerType);
            //console.log(score+" "+ towersCost[towerType]);
            if (score < towersCost[pickedTowerType]) {
                //console.log("ZZ");
                previousBox.style.background = "rgba(200, 25, 25, .75)";
                previousBox.style.boxShadow = "0 0 15px rgba(200, 25, 25, .75)";
            }
            else {
                userHasPickedTower = false;
                guideline.textContent = guildelineTranslations[gameLanguage][3];
                let towerDiv = document.getElementById("towerImage");
                towerDiv.remove();
                clearDatas();
                window.removeEventListener("mousemove", positionTower);
                //console.log("YY");
                previousBox.style.background = "rgba(25, 200, 25, .75)";
                previousBox.style.boxShadow = "0 0 15px rgba(25, 200, 25, .75)";
            }
            if (score >= towersCost[towerType]) {
                let box = document.getElementById("pick"+towerType);
                box.style.background = "hsla(" + types[towerType] + ", 100%, 50%, .75)";
                box.style.boxShadow = "0 0 15px hsla(" + types[towerType] + ", 100%, 50%, .75)";
                userHasPickedTower = true
                pickedTowerType = towerType;
                createTower(towerType);
                window.addEventListener("mousemove", positionTower);
                guideline.textContent = guildelineTranslations[gameLanguage][2];
                // on doit changer l'aspect du div towerImage pour correspondre à la nouvelle tour sélectionnée
                let towerImageRadius = (75 + (10 * pickedTowerType)) / 600 * gridSizes;
                //console.log("radius= "+towerImageRadius);
                let towerColorHSL = types[pickedTowerType];
                let towerColor = "hsla(" + towerColorHSL + ", 100%, 50%, .15)";
                towerDiv.style.borderColor = "hsla(" + towerColorHSL + ", 100%, 50%, .85)";
                document.documentElement.style.setProperty('--pickedTowerDotColor', "hsla(" + towerColorHSL + ", 100%, 50%, .75)");
                towerDiv.style.background = towerColor;
                towerDiv.style.width = towerImageRadius * 2 + "px";
                towerDiv.style.height = towerImageRadius * 2 + "px";
                //console.log("radius= "+towerImageRadius);
                //console.log("scrollY= "+scrollY);
                setTimeout(() => {
                    towerDiv.style.left = mouse.x - towerImageRadius + "px";
                    towerDiv.style.top = mouse.y - towerImageRadius + scrollY + "px";
                    towerDiv.style.opacity =  1;
                }, 10);
                displayDatas(towerType, true);
            }
            else {
                //console.log("proc");
                guideline.textContent = guildelineTranslations[gameLanguage][4];
                if (resetDisplay) {
                    clearTimeout(resetDisplay);
                }
                resetDisplay = setTimeout(() => {
                    selectedItemName.style.opacity = 0;
                    selectedItemDatas.style.opacity = 0;
                    selectedItemId.style.opacity = 0;
                    selectedItemStats.style.opacity = 0;
                    if (waveNumber > 1) {
                        guideline.textContent = guildelineTranslations[gameLanguage][3];
                    }
                    else {
                        guideline.textContent = guildelineTranslations[gameLanguage][1];
                    }
                }, 3000);
                displayDatas(towerType, true);
            }
        }
    }
    else {
        if (score >= towersCost[towerType]) {
            //console.log("2 "+towersCost[towerType]);
            if (resetDisplay) {
                clearTimeout(resetDisplay);
            }
            userHasPickedTower = true;
            selectedItemDesc.style.opacity = 1;
            guideline.textContent = guildelineTranslations[gameLanguage][2];
            pickedTowerType = towerType;
            createTower(towerType);
            window.addEventListener("mousemove", positionTower);
            let box = document.getElementById("pick"+towerType);
            box.style.backgroundColor = "hsla(" + types[towerType] + ", 100%, 50%, .75)";
            box.style.boxShadow = "0 0 15px hsla(" + types[towerType] + ", 100%, 50%, .75)";
            displayDatas(pickedTowerType, true);
            if (selectedTower) {
                selectedTower.isSelected = false;
                selectedTower = false;
                selectedItemId.style.opacity = 0;
                selectedItemStats.style.opacity = 0;
                selectedItemOptions.style.opacity = 0;
                selectedItemOptions.style.pointerEvents = "none";
                if (!animationIsOn) {
                    drawContext();
                }
            }
        }
        else {
            //console.log("3; resetDisplay= "+resetDisplay);
            if (selectedTower) {
                selectedTower.isSelected = false;
                selectedTower = false;
            }
            if (!animationIsOn) {
                drawContext();
            }
            guideline.textContent = guildelineTranslations[gameLanguage][4];
            selectedItemOptions.style.opacity = 0;
            selectedItemId.style.opacity = 0;
            selectedItemStats.style.opacity = 0;
            selectedItemDesc.style.opacity = 1;
            if (resetDisplay) {
                clearTimeout(resetDisplay);
            }
            resetDisplay = setTimeout(() => {
                selectedItemName.style.opacity = 0;
                selectedItemDatas.style.opacity = 0;
                //console.log("waveNumber= "+waveNumber);
                if (waveNumber > 1) {
                    guideline.textContent = guildelineTranslations[gameLanguage][3];
                }
                else {
                    guideline.textContent = guildelineTranslations[gameLanguage][1];
                }
            }, 3000);
            //console.log("appel de displayDatas() "+towerType);
            displayDatas(towerType, true);
        }
        //console.log("BBB "+selectedTower);
    }
    //console.log(userHasPickedTower);
}
function destroyTower() {
    if (selectedTower) {
        //towers.delete(selectedTower.towerId);
        cellulesArray[selectedTower.cellId].hasTower = false;
        cellulesArray[selectedTower.cellId].isLocked = false;
        delete towers[selectedTower.towerId];
        towersCounter[selectedTower.towerType]--;
        towersCounterBox[selectedTower.towerType].textContent = towersCounter[selectedTower.towerType];
        clearDatas();
        window.removeEventListener("mousemove", hoverOptions);
        updateGrid();
        if (!animationIsOn) {
            drawContext();
        }
    }
}

const optionLevelUp = document.getElementById("optionLevelUp");
const levelUpCost = document.getElementById("levelUpCost");
const optionSpec1 = document.getElementById("optionSpec1");
const optionSpec1Cost = document.getElementById("spec1Cost");
const optionSpec2 = document.getElementById("optionSpec2");
const optionSpec2Cost = document.getElementById("spec2Cost");
const optionDestroy = document.getElementById("optionDestroy");
const mobsLeft = document.getElementById("mobsLeft");
const towersSummary = document.getElementById("towersSummary");
const towers = [];
let optionsCost = [
    [optionLevelUp, 0],
    [optionSpec1, 0],
    [optionSpec2, 0],
];
// effects[nom, description, valeur, durée]
/* const effects = [
    ["Cold Shot", "Slows down target by 10% for 2 seconds", 10, 2],
    ["Water Flood", "Drowns target for 2 seconds making it sensitive to electricity. Damages taken from electric towers multiplied by 50%", 50, 2],
    ["Pyromania", "Burns target for"+ this.damage / 2 +"damages in 2 seconds every 2 seconds", this.damage / 2, 2],
    ["Thunderbolt", "Shocks target every 5 seconds, causing it to stop then slowly recover its move speed", 0, 5],
    ["Vampirism", "Drains target life, turning the damages done to credits"]
]; */

let shotTime = 0;
class Tower {
    constructor(x, y, radius, damage, color, towerId, towerType, cellId) {
        this.x = x,
        this.y = y,
        this.towerType = towerType,
        this.value = towersCost[towerType],
        this.effectiveCost = towersCost[towerType],
        this.radius = radius / 600 * gridSizes,
        this.baseDamage = damage,
        this.damage = damage,
        this.color = color,
        this.baseColor = this.color,
        this.level = 1,
        this.hasTarget = false,
        this.target = null,
        this.targetDistance = 0,
        this.towerId = towerId,
        this.cellId = cellId,
        this.isSelected = false,
        this.optionLevelUpCost = null,
        this.optionSpec1Cost = null,
        this.hasOptionSpec1 = false,
        this.optionSpec1Effect = null,
        this.optionSpec1IsOnCoolDown = false,
        this.optionSpec2Cost = null,
        this.hasOptionSpec2 = false,
        this.optionSpec2Effect = null,
        this.optionSpec2IsOnCoolDown = false,
        this.speedMultiplier = 0,
        this.slowDuration = 0,
        this.burnMultiplier = 0,
        this.burnTickInterval = 0,
        this.effects = [],
        this.killsCount = 0,
        this.damageDone = 0,
        this.healsCount = 0,
        this.healingDone = 0,
        this.damageMultiplier = 1,
        this.healMultiplier = 1
        /* this.effects = [
            [["Cold Shot", "Slows down target by 10% for 2 seconds", 10, 2],["Cold Shot BIS", "BIS Slows down target by 10% for 2 seconds", 10, 2]],
            [["Water Flood", "Drowns target for 2 seconds making it sensitive to electricity. Damages taken from electric towers multiplied by 50%", 50, 2],[]],
            [["Pyromania", "Burns target for"+ this.damage / 2 +"damages in 2 seconds every 2 seconds", this.damage / 2, 2],[]],
            [["Thunderbolt", "Shocks target every 5 seconds, causing it to stop then slowly recover its move speed", 0, 5],[]],
            [["Vampirism", "Drains target life, turning the damages done to credits"],[]]
        ] */
    }
    updateOptions() { // [nom, description, valeur, durée effet, temps de recharge, url icone] *** FAIT: [0][0];[0][1];[2][0]
        let singOrPlur;
        switch(this.towerType) {
            case 0:
                this.speedMultiplier = 0.25;
                this.effectDuration = 30;
                this.effectCooldown = 45;

                if (this.effectCooldown / (fps / 4) < 2) {
                    singOrPlur = "";
                }
                else {
                    singOrPlur = "s";
                }
                this.effects = [
                    [
                        ["freezing", "slows down target movement speed by "+ (100 - this.speedMultiplier * 100 )+"% for "+ this.effectDuration / (fps / 4) +" second" + singOrPlur, this.speedMultiplier, this.effectDuration, this.effectCooldown, "url(./image/ice_crystal.png)"],
                        ["ice mastery", "damage up by 100%, heal reduced by 75%", "url(./image/mastery_frost.png)"]
                    ],
                    [
                        ["congélation", "réduit la vitesse de déplacement de la cible de "+ (100 - this.speedMultiplier * 100 )+"% pendant "+ this.effectDuration / (fps / 4) +" seconde" + singOrPlur],
                        ["maîtrise du givre", "dégats augmentés de 100%, soins réduits de 75%"]
                    ]
                ];
            break;
            case 1:
                this.speedMultiplier = 0.5;
                this.burnMultiplier = 1;
                this.effectDuration = 60;
                this.effectCooldown = 90;
                if (this.effectDuration / (fps / 4) < 2) {
                    singOrPlur = "";
                }
                else {
                    singOrPlur = "s";
                }
                this.effects = [
                    [
                        ["flooding", "ice & water mobs : slows down target movement speed by "+ (100 - this.speedMultiplier * 100 )+"%\r\n\r\nfire and lightning mobs : deal damage equal to "+this.level * this.burnMultiplier +"% of target's current health\r\n\r\nno effect on dark mobs\r\n\r\nduration : " + this.effectDuration / (fps / 4) +" second" + singOrPlur, this.speedMultiplier, this.effectDuration, this.effectCooldown, "url(./image/water_drop.png)"],
                        ["water mastery", "damage up by 100%, heal reduced by 75%", "url(./image/mastery_water.png)"]
                    ],
                    [
                        ["inondation", "mobs de glace et d'eau : réduit la vitesse de déplacement de la cible de "+ (100 - this.speedMultiplier * 100 )+"%\r\n\r\nmobs de feu et de foudre : inflige des dégats à hauteur de "+ this.level * this.burnMultiplier +"% des points de vie actuels de la cible\r\n\r\npas d'effet sur les mobs sombres\r\n\r\ndurée : " + this.effectDuration / (fps / 4) +" seconde" + singOrPlur, this.speedMultiplier, this.effectDuration, this.effectCooldown, "url(./image/water_drop.png)"],
                        ["maîtrise de l'eau", "dégats augmentés de 100%, soins réduits de 75%"]
                    ]
                ];
            break;
            case 2:
                //console.log("tower2 spec1  ="+this.effectDuration / (fps / 4) / 2);
                this.burnMultiplier = 2;
                this.effectDuration = 60;
                this.effectCooldown = 90;
                if (this.effectDuration / (fps / 4) < 2) {
                    singOrPlur = "";
                }
                else {
                    singOrPlur = "s";
                }
                this.effects = [
                    [
                        ["combustion", "burns the target, dealing damage equal to "+this.level * this.burnMultiplier +"% of their current hit points over "+this.effectDuration/(fps/4)+" second" + singOrPlur + "\r\n\r\nno effect on fire mobs", this.damage * 20, this.effectDuration, this.effectCooldown, "url(./image/fire_flame.png)"],
                        ["fire mastery", "damage up by 100%, heal reduced by 75%", "url(./image/mastery_fire.png)"]
                    ],
                    [
                        ["combustion", "brûle la cible, lui infligeant des dégats à hauteur de "+ this.level * this.burnMultiplier +"% de ses points de vie actuels en "+ this.effectDuration / (fps / 4) +" seconde" + singOrPlur+ "\r\n\r\npas d'effet sur les mobs de feu", this.damage * 20, this.effectDuration, this.effectCooldown, "url(./image/fire_flame.png)"],
                        ["maîtrise du feu", "dégats augmentés de 100%, soins réduits de 75%"]
                    ]
                ];
            break;
            case 3:
                this.speedMultiplier = 0.01;
                this.effectDuration = 30;
                this.effectCooldown = 90;
                if (this.effectDuration / (fps / 4) < 2) {
                    singOrPlur = "";
                }
                else {
                    singOrPlur = "s";
                }
                this.effects = [
                    [
                        ["shock", "shocks target, causing it to stop for "+ this.effectDuration / (fps / 4) +" second"+ singOrPlur, this.speedMultiplier, this.effectDuration, this.effectCooldown, "url(./image/lightning_lightning.png)"],
                        ["lightning mastery", "damage up by 100%, heal reduced by 75%", "url(./image/mastery_lightning.png)"]
                    ],
                    [
                        ["électrocution", "électrocute la cible, la faisant s'arrêter pendant "+ this.effectDuration / (fps / 4) +" seconde"+ singOrPlur, this.speedMultiplier, this.effectDuration, this.effectCooldown, "url(./image/lightning_lightning.png)"],
                        ["maîtrise de la foudre", "dégats augmentés de 100%, soins réduits de 75%"]
                    ]
                ];
            break;
            case 4:
                this.effects = [
                    [
                        ["assimilation", "drains target life, turning the damage done to credits", null, null, null, "url(./image/dark_dark.png)"],
                        ["dark mastery", "damage up by 100%, heal reduced by 75%", "url(./image/mastery_dark.png)"]
                    ],
                    [
                        ["assimilation", "draine la vie de la cible, transformant les dégats infligés en crédits", null, null, null, "url(./image/dark_dark.png)"],
                        ["sombre maîtrise", "dégats augmentés de 100%, soins réduits de 75%"]
                    ]
                ];
            break;
            default:

            break;
        }
    }
    draw() {
        //console.log("option1= "+this.hasOptionSpec1);
        if (this.optionSpec1IsOnCoolDown) {
            //console.log(this.towerId+" est en cd : "+towers[this.towerId].optionSpec1IsOnCoolDown);
            if (this.optionSpec1CooldownDuration > 0) {
                //console.log(this.optionSpec1CooldownDuration);
                this.optionSpec1CooldownDuration--;
            }
            else {
                this.optionSpec1IsOnCoolDown = false;
                //console.log(this.towerId+" n'est plus en cd : "+towers[this.towerId].optionSpec1IsOnCoolDown);
            }
        }
        if (this.optionSpec2IsOnCoolDown) {
            if (this.optionSpec2CooldownDuration == 0) {
                this.optionSpec2IsOnCoolDown = false;
            }
            else {
                this.optionSpec2CooldownDuration--;
                //console.log(this.optionSpec2CooldownDuration);
            }
        }
        let currentWave = waveSettings - 1;
        if (currentWave < 0) {
            currentWave = 0;
        }
        //console.log("this.towertype= "+this.towerType+" ;waveSettings= "+currentWave);
        if (currentWave == this.towerType) {
            this.color = 120;
        }
        else {
            this.color = this.baseColor;
        }
        if (this.isSelected) {  //affiche le rayon de la tour si elle est sélectionnée
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, 2 * Math.PI);
            ctx.closePath();
            ctx.fillStyle = "hsla(" + this.color + ", 50%, 50%, 0.15)";
            ctx.fill();
            ctx.lineWidth = 2;
            ctx.strokeStyle = "hsla(" + this.color + ", 100%, 50%, 0.85)";
            ctx.stroke();
        }
        ctx.lineWidth = 1; // dessine la tour
        ctx.fillStyle = "hsla(" + this.color + ", 50%, 50%, 0.75)";
        ctx.beginPath();    //point central
        ctx.arc(this.x, this.y, this.radius / 64, 0, Math.PI * 2);
        ctx.closePath();
        ctx.fill();
        for (let i = 0; i < towersMaxLvl; i++) {    // indicateurs de niveau
            if (i < this.level) {
                ctx.fillStyle = "hsla("+this.color+", 100%, 50%, 1)";
            }
            else {
                ctx.fillStyle = "hsla("+this.color+", 100%, 50%, .2)";
            }
            //ctx.fillStyle = "hsl("+36 * i+", 100%, 50%)";
            //console.log("X Y = "+x+ " "+y);
            //ctx.fillRect(x, y, 10, 10);
            
            if (this.hasOptionSpec1) {  // dessine l'effet de spec1
                let x = this.x + cellSize / 5 * Math.cos(i*36*Math.PI/180) ;
                let y = this.y + cellSize / 5 * Math.sin(i*36*Math.PI/180) ;
               //console.log("draw tower spec 1");
                if (this.optionSpec1IsOnCoolDown) {
                    ctx.strokeStyle = "hsla("+this.color+", 100%, 50%, .15)";
                }
                else {
                    ctx.strokeStyle = "hsla("+this.color+", 100%, 50%, .5)";
                }
                ctx.lineWidth = 3;
                ctx.beginPath();
                ctx.moveTo(this.x, this.y);
                ctx.lineTo(x, y);
                ctx.closePath();
                ctx.stroke();
                ctx.lineWidth = 1;
            }
            let x = this.x + cellSize / 3.5 * Math.cos(i*36*Math.PI/180) ;
            let y = this.y + cellSize / 3.5 * Math.sin(i*36*Math.PI/180) ;
            ctx.beginPath();
            ctx.arc(x, y, 2, 0, Math.PI * 2);
            ctx.closePath();
            ctx.fill();
        }
        if (this.hasOptionSpec2) {  // dessine l'effect de spec2
            //console.log("draw tower spec 2");
            let linesCoord = [
                [
                this.x - cellSize / 2 + 2, this.y - 8,
                this.x - cellSize / 2 + 2, this.y - cellSize / 2 + 2,
                this.x - 8, this.y - cellSize / 2 + 2
                ],
                [
                this.x - cellSize / 2 + 2, this.y + 8,
                this.x - cellSize / 2 + 2, this.y + cellSize / 2 - 2,
                this.x - 8, this.y + cellSize / 2 - 2
                ],
                [
                this.x + cellSize / 2 - 2, this.y - 8,
                this.x + cellSize / 2 - 2, this.y - cellSize / 2 + 2,
                this.x + 8, this.y - cellSize / 2 + 2
                ],
                [
                this.x + cellSize / 2 - 2, this.y + 8,
                this.x + cellSize / 2 - 2, this.y + cellSize / 2 - 2,
                this.x + 8, this.y + cellSize / 2 - 2
                ],
            ];
            for (let i = 0; i < linesCoord.length; i++) {
                //console.log("draw tower spec 2 sur "+i);
                ctx.lineWidth = 2;
                if (this.optionSpec2IsOnCoolDown) {
                    ctx.fillStyle = "hsla("+this.baseColor+", 100%, 25%, .25)";
                }
                else {
                    ctx.fillStyle = "hsla("+this.baseColor+", 100%, 50%, .85)";
                }
                ctx.beginPath();
                ctx.moveTo(linesCoord[i][0], linesCoord[i][1]);
                ctx.lineTo(linesCoord[i][2], linesCoord[i][3]);
                ctx.lineTo(linesCoord[i][4], linesCoord[i][5]);
                ctx.closePath();
                ctx.fill();
                ctx.lineWidth = 3;
                ctx.strokeStyle = "hsl("+this.baseColor+", 100%, 50%)";
                ctx.stroke();
            }
            ctx.lineWidth = 1;
        }
        /* ctx.fillStyle = "hsla(" + this.color + ", 50%, 50%, 0.75)";
        ctx.fill(); */
    }
    upgrade(option) {
        let optionCost = optionsCost[option][1];
        //console.log(optionsCost);
        //console.log("option= "+option);
        //console.log("optionCost= "+optionCost);
        //console.log("this.optionLevelUpCost= "+this.optionLevelUpCost);
        score -= optionCost;
        if (animationIsOn) {
            updateWarningBuffer();
        }
        //score -= this.optionLevelUpCost;
        scoreBox.textContent = score.toLocaleString("en-US");
        bufferScore = score;
        bufferScoreBox.textContent = bufferScore.toLocaleString("en-US");
        if (optionCost > 0) {
            document.documentElement.style.setProperty("--scoreUpdateColor", "rgb(200, 25, 25)");
            scoreBox.textContent = score.toLocaleString("en-US");
            scoreUpdateBoxUpdate("-", optionCost);
        }
        document.documentElement.style.setProperty("--scoreUpdateColor", "rgb(25, 200, 25)");
/*         else {
            document.documentElement.style.setProperty("--scoreUpdateColor", "rgb(200, 25, 25)");
            //scoreUpdateBoxUpdate("level up tower ", this.towerId);
        } */
        //console.log("test= "+optionCost);
        switch(option) {
            case 0:
                scoreUpdateBoxUpdate(staticTranslations[gameLanguage][toTranslate.length + 15] + " ", this.towerId);//here5
                this.radius *= 1 + this.level / 100;
                this.radius = Math.floor(this.radius);
                this.damage++;
                //this.value += 10 * towersCost[this.towerType] * this.level;
                this.effectiveCost += optionCost;
                towersScore += optionCost;
                towersScoreBox.textContent = towersScore.toLocaleString("en-US");
                this.checkOptionsCost();                
                this.updateOptions();
                if (playerHoversOptionSpec1) {
                    updateTooltip(towers[this.towerId].effects[gameLanguage][0][1]);
                }
            break;
            case 1:
                scoreUpdateBoxUpdate(staticTranslations[gameLanguage][toTranslate.length + 16] + " ", this.towerId);
                switch(this.towerType) {
                    case 0:
                        this.speedMultiplier = this.effects[0][0][2];
                        this.slowDuration = this.effects[0][0][3];
                    break;
                    case 1:
                        this.burnMultiplier = 1;
                        this.speedMultiplier = this.effects[0][0][2];
                        this.slowDuration = this.effects[0][0][3];
                    break;
                    case 2:
                        this.burnMultiplier = 3;
                    break;
                    case 3://here
                        this.speedMultiplier = this.effects[0][0][2];
                        this.slowDuration = this.effects[0][0][3];
                    break;
                    case 4:

                    break;
                    default:
                    break;
                }
                //this.value += 50 * towersCost[this.towerType] * 2;
                this.effectiveCost += optionCost;
                towersScore += optionCost;
                towersScoreBox.textContent = towersScore.toLocaleString("en-US");
                this.checkOptionsCost();
            break;
            case 2:
                scoreUpdateBoxUpdate("unleash tower ", this.towerId);
                this.damageMultiplier = 2;
                this.healMultiplier = .25
/*                 switch(this.towerType) {
                    case 0:
                    break;
                    
                } */
                //this.value += 100 * towersCost[this.towerType] * 3;
                this.effectiveCost += optionCost;
                towersScore += optionCost;
                towersScoreBox.textContent = towersScore.toLocaleString("en-US");
                this.checkOptionsCost();
            break;
            default:
            break;
        }
        if (this.isSelected) {
            this.updateOptions();
        }
/*         console.log("appel de checkScore()"); //recursion
        checkScore();
        console.log("appel de checkOptionsCost()");
        this.checkOptionsCost(); */
    }
    checkOptionsCost() {
        //console.log("checkOptionsCost tower "+this.towerId);
        //console.log("COST 1= "+ 10 * towersCost[this.towerType] * this.level);
        //console.log("REDUCTION 2= "+this.killsCount * (this.towerType + 1) * 100);
        
        if (this.level < towersMaxLvl) {
            this.optionLevelUpCost = 10 * towersCost[this.towerType] * this.level - this.killsCount * (this.towerType + 1) * 100;
            optionsCost[0][1] = this.optionLevelUpCost;
            if (this.optionLevelUpCost <= 0) {
                this.optionLevelUpCost = 0;
                optionsCost[0][1] = this.optionLevelUpCost;
                this.value += 10 * towersCost[this.towerType] * this.level;
                this.level++;
                this.upgrade(0);
                this.optionLevelUpCost = 10 * towersCost[this.towerType] * this.level;
            }
        }
        if (!this.hasOptionSpec1) {
            this.optionSpec1Cost = 50 * towersCost[this.towerType] * 2 - this.killsCount * this.level * (this.towerType + 1) * 20;  
            optionsCost[1][1] = this.optionSpec1Cost;
            if (this.optionSpec1Cost <= 0) {
                this.optionSpec1Cost = 0;
                optionsCost[1][1] = this.optionSpec1Cost;
                this.hasOptionSpec1 = true;
                this.upgrade(1);
                this.value += 50 * towersCost[this.towerType] * 2;
            }
        }
        if (!this.hasOptionSpec2) {
            this.optionSpec2Cost = 100 * towersCost[this.towerType] * 3 - this.killsCount * this.level * (this.towerType + 1) * 30;
            optionsCost[2][1] = this.optionSpec2Cost;
            if (this.optionSpec2Cost <= 0) {
                this.optionSpec2Cost = 0;
                optionsCost[2][1] = this.optionSpec2Cost;
                this.hasOptionSpec2 = true;
                this.upgrade(2);
                this.value += 100 * towersCost[this.towerType] * 2;
            }
        }
        //if (this.isSelected) {
        //    levelUpCost.textContent = this.optionLevelUpCost.toLocaleString("en-US");
        //    optionSpec1.style.background = this.effects[0][5] + " center center";
        //    optionSpec1.style.backgroundSize = "125%";
        //}
/*         if (!this.hasOptionSpec1) {
            optionSpec1Cost.textContent = this.optionSpec1Cost.toLocaleString("en-US");
        }
        if (!this.hasOptionSpec2) {
            optionSpec2Cost.textContent = this.optionSpec2Cost.toLocaleString("en-US");
        } */
        //console.log(optionsCost[1][1]);
        //console.log(this.optionSpec1Cost);
        //console.log(this);
        if (this.isSelected) {
            //levelUpCost.textContent = this.optionLevelUpCost.toLocaleString("en-US");
            //console.log("IMAGE=" + this.effects[0]);
            optionSpec1.style.backgroundImage = this.effects[0][0][5];
            optionSpec1.style.backgroundSize = "contain";
            optionSpec2.style.backgroundImage = this.effects[0][1][2];
            optionSpec2.style.backgroundSize = "contain";
            for (let i = 0; i < optionsCost.length; i++) {  //actualise l'affichage du coût des upgrades
                switch(i) {
                    case 0:
                        if (this.level < towersMaxLvl) {
                            if (this.optionLevelUpCost < score) {
                                //console.log("c'est moins "+this.level+" "+towersMaxLvl);
                                optionsCost[i][0].classList.remove("option-locked-with-hover");
                                optionsCost[i][0].classList.add("option-available");
                                //levelUpCost.textContent = this.optionLevelUpCost.toLocaleString("en-US");
                                //this.updateOptions();    // A AJOUTER POUR APERCU DU NIVEAU SUIVANT
                                //optionLevelUp.style.background = "rgb(25, 200, 25)";
                                //optionLevelUp.style.boxShadow = "0 0 2px rgb(25, 200, 25), 0 0 8px rgb(25, 200, 25)";
                            }
                            else {
                                optionsCost[i][0].classList.remove("option-available");
                                optionsCost[i][0].classList.add("option-locked-with-hover");
                                //optionLevelUp.style.background = "rgb(200, 25, 25)";
                                //optionLevelUp.style.boxShadow = "0 0 2px rgb(200, 25, 25), 0 0 8px rgb(200, 25, 25)";
                            }
                            levelUpCost.textContent = this.optionLevelUpCost.toLocaleString("en-US");
                        }
                        else {
                            //console.log("c'est égal");
                            optionsCost[i][0].classList.remove("option-available");
                            optionsCost[i][0].classList.add("option-locked-with-hover");
                            levelUpCost.textContent = "max";
                            //optionLevelUp.style.background = "rgb(200, 25, 25)";
                            //optionLevelUp.style.boxShadow = "0 0 2px rgb(200, 25, 25), 0 0 8px rgb(200, 25, 25)";
                        }
                    break;
                    case 1:
                        //console.log("SPEC "+this.hasOptionSpec1+" "+this.optionSpec1Cost);
                        if (!this.hasOptionSpec1) {
                            optionSpec1Cost.textContent = this.optionSpec1Cost.toLocaleString("en-US");
                            optionsCost[i][0].classList.remove("option-active");
                            if (this.optionSpec1Cost < score) {
                                optionsCost[i][0].classList.remove("option-locked-with-hover");
                                optionsCost[i][0].classList.add("option-available");
                                this.updateOptions();
                            }
                            else {
                                optionsCost[i][0].classList.remove("option-available");
                                optionsCost[i][0].classList.add("option-locked-with-hover");
                            }
                            optionSpec1Cost.textContent = this.optionSpec1Cost.toLocaleString("en-US");
                        }
                        else {
                            optionSpec1Cost.textContent = "active";
                            optionsCost[i][0].classList.remove("option-locked-with-hover");
                            optionsCost[i][0].classList.remove("option-available");
                            optionsCost[i][0].classList.add("option-active");
                        }
                    break;
                    case 2:
                        if (this.isSelected) {
                            if (!this.hasOptionSpec2) {
                                optionSpec2Cost.textContent = this.optionSpec2Cost.toLocaleString("en-US");
                                optionsCost[i][0].classList.remove("option-active");
                                if (this.optionSpec2Cost < score) {
                                    optionsCost[i][0].classList.remove("option-locked-with-hover");
                                    optionsCost[i][0].classList.add("option-available");
                                    this.updateOptions();
                                }
                                else {
                                    optionsCost[i][0].classList.remove("option-available");
                                    optionsCost[i][0].classList.add("option-locked-with-hover");
                                }
                                optionSpec2Cost.textContent = this.optionSpec2Cost.toLocaleString("en-US");
                            }
                            else {
                                optionSpec2Cost.textContent = "active";
                                optionsCost[i][0].classList.remove("option-locked-with-hover");
                                optionsCost[i][0].classList.remove("option-available");
                                optionsCost[i][0].classList.add("option-active");
                            }
                        }
                    break;
                }
            }
        }
    }
    getTarget() {
        mobsAlive = 0;
        //console.log("MA "+this.hasTarget);
        if (this.hasTarget == false) {
            for (let i = 0; i < mobs.length; i++) {
                //onsole.log("ID MOB"+mobs[i].id+" HP "+mobs[i].hp+" X "+mobs[i].x+" path X0 "+paths[pathSeed][0][0]);
                if (mobs[i].x != paths[pathSeed][0][0] || mobs[i].y != paths[pathSeed][0][1]) {
                //console.log("DIFF");
                }
                //console.log("path X"+paths[pathSeed][0][0]+" ;mob X "+ mobs[i].x +" ;path Y "+ paths[pathSeed][0][1]+" ;mob Y "+mobs[i].y);
                if (mobs[i].hp > 0) {
                    //console.log("mob id= "+mobs[i].id);
                    //console.log("mob hp= "+mobs[i].hp);
                    mobsAlive++;
                }
                if (
                    this.hasTarget == false
                    &&
                    mobs[i].hp > 0
                    &&
                    (mobs[i].x != paths[pathSeed][0][0] || mobs[i].y != paths[pathSeed][0][1])
                    ) {
                    let x = mobs[i].x * cellSize;
                    let y = mobs[i].y * cellSize;
                    //let id = mobs[i].id;
                    let gapX = this.x - x;
                    let gapY = this.y - y;
                    this.targetDistance = Math.sqrt(gapX * gapX + gapY * gapY);
                    //console.log(this.targetDistance);
                    if (this.targetDistance <= this.radius) {
                        this.hasTarget = true;
                        this.target = mobs[i];
                    //console.log("TARGET "+this.target.id);
                    }
                }                
            }
            if (animationIsOn) {
                mobsLeft.textContent = mobsAlive;
            }
            //console.log("mobs alive= "+mobsAlive);
            if (mobsAlive == 0) {
                setTimeout(() => {
                    mobs.splice(0, mobs.length);
                }, 100);
            }
            //console.log("AA"+this.hasTarget);
        }
        else {
            let x = this.target.x * cellSize;
            let y = this.target.y * cellSize;
            let id = this.target.id;
            let gapX = this.x - x;
            let gapY = this.y - y;
            //console.log(this.target);
            //console.log("x= "+x+" ;y= "+y+" ;id= "+id+" ;gapX= "+gapX+" ;gapY="+gapY);
            this.targetDistance = Math.sqrt(gapX * gapX + gapY * gapY);
            //console.log("targetDistance= " + this.targetDistance);
            if (this.targetDistance <= this.radius && this.target.hp > 0) {
                this.hasTarget = true;
                this.shot();
                //console.log(totalFrames+" SHOT ON TARGET "+this.target);
            }
            else {
                this.target.color = this.target.baseColor;
                this.hasTarget = false;
            }
            //console.log("BB"+this.hasTarget);
        }
    }
    shot() {
        ctx.shadowBlur = 0;
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius / 128, 0, Math.PI * 2);
        ctx.closePath();
        ctx.fillStyle = "hsla(" + this.color + ", 100%, 50%, 1)";
        ctx.fill();
        //let laserWidth = (.8 + (this.baseDamage - 1)) / 2 + (2 / 2 * (this.level / 5));
        let laserWidth = (1 + (this.baseDamage - 1)) / 2 + (this.level / 5);
        //ctx.lineWidth = this.damage - this.level / 4;
        //console.log("lineWidth= "+test);
        ctx.lineWidth = laserWidth;
        ctx.moveTo(this.x, this.y);
        ctx.lineTo(this.target.x * cellSize, this.target.y * cellSize);
        ctx.shadowColor = "hsl(" + (this.color) + ", 100%, 50%)";
        ctx.shadowBlur = 2;
        ctx.strokeStyle = "hsl(" + (this.color) + ", 100%, 50%)";
        ctx.stroke();
        ctx.shadowBlur = 0;
        ctx.lineWidth = 1;

        //this.target.color = 0;

        let waveType = waveSettings - 1;
        if (waveType < 0) {
            waveType = 0;
        }
        if (this.target != undefined && this.target.hp > 0) {
            //console.log(totalFrames+"HP pre & now= "+mobs[this.target.id].previousHp+" "+mobs[this.target.id].hp);
            //console.log("this.towerType= "+this.towerType+" ;waveSettings= "+waveType);
            if (this.towerType == waveType && this.target.id != undefined) {    //le tir va heal
                //console.log("appel de shotHEAL() "+this.target.id);
                mobs[this.target.id].hp += this.damage / 2 * this.healMultiplier;
                this.healingDone += this.damage / 2 * this.healMultiplier;
                if (mobs[this.target.id].hp > mobs[this.target.id].maxHp * 2) {
                    this.healingDone -= mobs[this.target.id].hp - mobs[this.target.id].maxHp * 2;
                }
                if (this.isSelected) {
                    selectedTowerHealing.textContent = Math.floor(this.healingDone).toLocaleString("en-US");
                }
                //this.target.color = 120;
            }
            else if (this.target.id != undefined) {     //le tir va deal
                //console.log("appel de shot() "+this.target.id);
                mobs[this.target.id].hp -= this.damage * this.damageMultiplier;
                //console.log("HP="+mobs[this.target.id].hp);
                this.damageDone += this.damage * this.damageMultiplier;
                if (mobs[this.target.id].hp < 0) {
                    this.damageDone += mobs[this.target.id].hp;
                }
                if (this.isSelected) {
                    selectedTowerDamage.textContent = Math.floor(this.damageDone).toLocaleString("en-US");
                }
            }
            if (mobs[this.target.id].previousHp > mobs[this.target.id].hp) { //le mob a perdu des pv
                mobs[this.target.id].color = 0;
            }
            else if (mobs[this.target.id].previousHp < mobs[this.target.id].hp) { //le mob a gagné des pv
                mobs[this.target.id].color = 120;
            }
            else {
                mobs[this.target.id].color = mobs[this.target.id].baseColor; //les pv du mob n'ont pas changé
            }
        }
        //console.log(this.target.hp);
        //console.log(this.targetDistance + ">"+ this.radius);
        if (this.target.hp >= this.target.maxHp * 2) {
            this.target.hp = -1;
            waveMobsCount--;
            //console.log(totalFrames+"moins "+this.target.hp);
            waveMobsKilled++;
            mobsHealed++;
            mobsHealedBox.textContent = mobsHealed.toLocaleString("en-US");
            score -= this.target.maxHp * 2;
            updateWarningBuffer();
            bufferScore = score;
            bufferScoreBox.textContent = bufferScore.toLocaleString("en-US");
            document.documentElement.style.setProperty("--scoreUpdateColor", "rgb(200, 25, 25)");
            scoreUpdateBoxUpdate("-", this.target.maxHp * 2);
            scoreBox.textContent = score.toLocaleString("en-US");
            totalScore -= this.target.maxHp * 2;
            if (totalScore < 0) {
                totalScore = 0;
            }
            totalScoreBox.textContent = totalScore.toLocaleString("en-US");
            lastWaveScore -= this.target.maxHp * 2;
            /* if (lastWaveScore < 0) { //peut être négatif
                lastWaveScore = 0;
            } */
            lastWaveScoreBox.textContent = lastWaveScore.toLocaleString("en-US");
            this.healsCount ++;
            //console.log("appel de checkOptionsCost()");
            this.checkOptionsCost();
            checkScore();
            if (this.isSelected) {
                //console.log("appel de checkScore()");
                //console.log("appel de displayDatas() de "+this.towerId);
                displayDatas(this.towerId, false);
            }
        }
        else if (this.target.hp <= 0) {
            //console.log(totalFrames+"plus "+this.target.hp);
            waveMobsKilled++;
            mobsKilled++;
            mobsKilledBox.textContent = mobsKilled.toLocaleString("en-US");
            this.target.hp = -1;
            waveMobsCount--;
            score += this.target.maxHp;
            updateWarningBuffer();
            bufferScore = score;
            bufferScoreBox.textContent = bufferScore.toLocaleString("en-US");
            document.documentElement.style.setProperty("--scoreUpdateColor", "rgb(25, 200, 25)");
            scoreUpdateBoxUpdate("+", this.target.maxHp);
            scoreBox.textContent = score.toLocaleString("en-US");
            totalScore += this.target.maxHp;
            totalScoreBox.textContent = totalScore.toLocaleString("en-US");
            lastWaveScore += this.target.maxHp;
            lastWaveScoreBox.textContent = lastWaveScore.toLocaleString("en-US");

            this.killsCount ++;

            if (this.killsCount === 1) {
                let divSummary = document.createElement("div");
                divSummary.classList.add("tower-kills-summary");
                divSummary.setAttribute("id", "towerSum" + this.towerId);

                let towerImg = document.createElement("div");
                towerImg.classList.add("tower-kills-img");
                towerImg.style.backgroundImage = 'url(./image/tower' + this.towerType + '.png)';
                divSummary.appendChild(towerImg);

                let towerKillsCount = document.createElement("div");
                towerKillsCount.classList.add("tower-kills-count");
                towerKillsCount.setAttribute("id", this.towerId);
                towerKillsCount.textContent = 1;
                divSummary.appendChild(towerKillsCount);

                towersSummary.appendChild(divSummary);                
            }
            else {
                let summaryKillsCount = document.getElementById(this.towerId);
                summaryKillsCount.textContent = this.killsCount;                
            }

            //console.log("appel de checkOptionsCost()");
            this.checkOptionsCost();
            checkScore();
            if (this.isSelected) {
                //console.log("appel de checkScore()");
                //console.log("appel de displayDatas() de "+this.towerId);
                displayDatas(this.towerId, false);
            }
            this.hasTarget = false;
            //this.target.color = this.target.baseColor;
        }
        if (this.hasOptionSpec1 && !this.optionSpec1IsOnCoolDown) {  //spec1
            //console.log("avant le proc spec 1 ; towerId= "+this.towerId);
            let shotCooldown;  //parfois, message d'erreur qui dit que la variable n'est jamais lue alors qu'elle est lue dans le switch
            let waveType;
            switch(this.towerType) {
                case 0: //ice tower
                    shotCooldown = new Date() - shotTime;
                    //console.log("shotcooldown= "+shotCooldown/1000+"s");
                    shotTime = new Date();
                    //console.log("proc cold shot tower "+this.towerId);
                    //this.target.speedMultiplier = this.target.speed * this.speedMultiplier;
                    //console.log("speedMultiplier= "+this.speedMultiplier);
                    if (!this.target.isFrozenSlowed) {
                        this.target.isFrozenSlowed = true;
                        this.target.speed *= this.speedMultiplier; //modif 14 juillet
                        this.target.frozenSlowDuration = this.effects[0][0][3];
                        this.target.frozenSpeedMultiplier = this.speedMultiplier;
                    }
                break;
                case 1: //water tower
                    shotCooldown = new Date() - shotTime;
                    shotTime = new Date();
                    waveType = waveSettings - 1;
                    if (waveType < 0) {
                        waveType = 0;
                    }
                    //console.log("AAA "+waveType);
                    if (!this.target.isFlooded) {
                        this.target.isFlooded = true;
                        switch(waveType) {
                            case 0:
                            case 1:
                                //console.log("BBB slow flood "+waveType);
                                this.target.speed *= this.speedMultiplier;
                                this.target.floodSlowDuration = this.effects[0][0][3];
                                this.target.floodSpeedMultiplier = this.speedMultiplier;
                            break;
                            case 2:
                            case 3:
                                //console.log("CCC burn flood "+waveType);
                                //this.target.color = "white";
                                this.target.floodBurnOrigin = this.towerId;
                                this.target.floodBurnDuration = this.effects[0][0][3];
                                this.floodBurnTickInterval = 15;
                                this.target.floodBurnTickInterval = this.floodBurnTickInterval;
                                this.target.floodBurnNextTickInterval = this.target.floodBurnTickInterval;
                                this.target.floodBurnTicksLeft = this.effects[0][0][3] / this.floodBurnTickInterval;
                                this.target.floodBurnTickDamage = this.target.hp / 100 * this.level * this.burnMultiplier / this.target.floodBurnTicksLeft;  // formule alternative : dégats basés sur les pv actuels du mob
                                //this.target.floodBurnTickDamage = this.damage * 10 * this.burnMultiplier / this.target.floodBurnTicksLeft;//here
                            break;
                            case 4:
                            break;
                        }
/*                         this.target.burnOrigin = this.towerId;
                        this.target.isBurning = true;
                        this.target.burnDuration = this.effects[0][3];
                        this.burnTickInterval = 15;
                        this.target.burnTickInterval = this.burnTickInterval;
                        this.target.burnNextTickInterval = this.target.burnTickInterval;
                        this.target.burnTicksLeft = this.effects[0][3] / this.burnTickInterval;
                        this.target.burnTickDamage = this.damage * 10 * this.burnMultiplier / this.target.burnTicksLeft;
                        //console.log("ticksLeft= "+this.target.burnTicksLeft+" ;dmg= "+this.target.burnTickDamage); */
                    }
                break;
                case 2: //fire tower
                    waveType = waveSettings - 1;
                    if (waveType < 0) {
                        waveType = 0;
                    }
                    shotCooldown = new Date() - shotTime;
                    shotTime = new Date();
                    //console.log("proc pyromania sur tower "+this.towerId);
                    if (!this.target.isBurning && waveType != 2) {
                        this.target.burnOrigin = this.towerId;
                        this.target.isBurning = true;
                        this.target.burnDuration = this.effects[0][0][3];
                        this.burnTickInterval = 15;
                        this.target.burnTickInterval = this.burnTickInterval;
                        this.target.burnNextTickInterval = this.target.burnTickInterval;
                        this.target.burnTicksLeft = this.effects[0][0][3] / this.burnTickInterval;
                        this.target.burnTickDamage = this.target.hp / 100 * this.level * this.burnMultiplier / this.target.burnTicksLeft;  // formule alternative : dégats basés sur les pv actuels du mob
                        //this.target.burnTickDamage = this.damage * 10 * this.burnMultiplier / this.target.burnTicksLeft; // ancienne formule : degats basés sur les dégats de la tour
                        //console.log("ticksLeft= "+this.target.burnTicksLeft+" ;dmg= "+this.target.burnTickDamage);
                    }
                break;
                case 3: //electric tower
                    shotCooldown = new Date() - shotTime;
                    //console.log("shotcooldown= "+shotCooldown/1000+"s");
                    shotTime = new Date();
                    //console.log("proc cold shot tower "+this.towerId);
                    //this.target.speedMultiplier = this.target.speed * this.speedMultiplier;
                    //console.log("speedMultiplier= "+this.speedMultiplier);
                    if (!this.target.isShocked) {
                        this.target.isShocked = true;
                        this.target.speedMultiplier = this.speedMultiplier;
                        this.target.speed *= this.speedMultiplier;
                        this.target.shockDuration = this.effects[0][0][3];  // 30 frames
                    }
                break;
                case 4: //dark tower
                    waveType = waveSettings - 1;
                    if (waveType < 0) {
                        waveType = 0;
                    }
                    //console.log(waveType+" et "+this.towerType);
                    if (this.towerType != waveType) {
                        score += this.damage;
                        updateWarningBuffer();
                        bufferScore = score;
                        bufferScoreBox.textContent = bufferScore.toLocaleString("en-US");
                        if (score < towersCost[towersCost.length]) {    //on vérifie le score uniquement s'il est inférieur au prix de la tour la plus chère
                            checkScore();
                        }
                        scoreBox.textContent = score.toLocaleString("en-US");
                        lastWaveScore += this.damage;
                        lastWaveScoreBox.textContent = lastWaveScore.toLocaleString("en-US");
                        totalScore += this.damage;
                        totalScoreBox.textContent = totalScore.toLocaleString("en-US");
                    }
                break;
                default:
                break;
            }
            this.optionSpec1IsOnCoolDown = true;
            this.optionSpec1CooldownDuration = this.effects[0][0][4];
        }
    }
}

const mobs = [];
class Mob {
    constructor(x, y, color, speed, hp, id) {
        this.x = x,
        this.y = y,
        this.baseColor = color,
        this.color = this.baseColor,
        this.direction = "",
        this.baseSpeed = speed,
        this.speedMultiplier = 1,
        this.speed = this.baseSpeed * this.speedMultiplier,
        this.hp = hp * ((waveNumber + 1) / 2) * (waveNumber / 5),
        this.previousHp = this.hp,
        this.maxHp = this.hp,        
        this.size = (8 / this.maxHp * this.hp) / 600 * gridSizes,
        this.radius = this.size + 1,
        this.id = id,
        this.pathSegment = 0,
        this.hasSpawned = false,
        //this.isSlowed = false,
        //this.slowDuration = 0,
        this.isFrozenSlowed = false,
        this.frozenSlowDuration = 0,
        this.frozenSpeedMultiplier = 0,
        this.isBurning = false,
        this.burnOrigin = false;
        this.burnTickDamage = 0,
        this.burnDuration = 0,
        this.burnTickInterval = 0,
        this.burnNextTickInterval = 0,
        this.burnTicksLeft = 0,
        this.isFlooded = false,
        this.floodSpeedMultiplier = 0,
        this.floodSlowDuration = 0,
        this.floodBurnOrigin = false;
        this.floodBurnTickDamage = 0,
        this.floodBurnDuration = 0,
        this.floodBurnTickInterval = 0,
        this.floodBurnNextTickInterval = 0,
        this.floodBurnTicksLeft = 0,
        this.isShocked = false,
        this.shockDuration = 0
    }
    draw() {
        this.previousHp = this.hp;
        //console.log(this.radius);
        //console.log("mob draw()");
        //console.log(this.x+ " " + this.y);
       // this.radius = 
        //let size = (this.hp / 100 / waveNumber) + waveNumber / 10;
        //console.log("HP prev + now ="+this.previousHp+" "+this.hp+" "+this.baseColor);

        //console.log("color = "+this.color);
        this.size = (8 / this.maxHp * this.hp) / 600 * gridSizes;
        this.radius = this.size + 1;
        //console.log("mob radius= "+this.radius*2);
        //console.log("cellSize= "+cellSize);
        ctx.lineWidth = 4;
        ctx.shadowColor = "hsl(" + this.color + ", 100%, 50%)";
        ctx.shadowBlur = 10;
        ctx.fillStyle = "hsl(" + this.color + ", 100%, 50%)";
        ctx.beginPath();
        ctx.arc(this.x * cellSize, this.y * cellSize, this.size, 0, Math.PI * 2);
        ctx.closePath();
       // ctx.fillStyle = "hsl(" + this.color + ", 100%, 50%)";
        ctx.fill();
        ctx.beginPath();
        ctx.arc(this.x * cellSize, this.y * cellSize, this.radius * 2, 0, Math.PI * 2);
        ctx.closePath();
        ctx.strokeStyle = "hsl(" + this.color + ", 100%, 50%)";
        ctx.stroke();
        ctx.shadowBlur = 0;
        ctx.lineWidth = 1;
        //console.log("this "+this.x+" "+this.y);
    }
    update() {
        //console.log("this.y= " + this.y);
        if (
            (
                this.x <= paths[pathSeed][this.pathSegment][0] + .1
                &&
                this.x >= paths[pathSeed][this.pathSegment][0] - .1
            )
            &&
            (
                this.y <= paths[pathSeed][this.pathSegment][1] + .1
                &&
                this.y >= paths[pathSeed][this.pathSegment][1] - .1
            )
            ) {
            //console.log("checkpoint at "+ this.x + " ; "+this.y);
            //console.log("checkpoint floor at "+ Math.round(this.x) + " ; "+Math.round(this.y));
            //console.log("pour "+paths[pathSeed][this.pathSegment][0]+" et "+paths[pathSeed][this.pathSegment][1]);
            this.x = paths[pathSeed][this.pathSegment][0];
            this.y = paths[pathSeed][this.pathSegment][1];
            
            /* if (this.pathSegment == 0) {
                this.y = paths[pathSeed][this.pathSegment][1] + this.radius * 2;
            } */

            if (this.pathSegment < paths[pathSeed].length - 1) {
                this.pathSegment++;
                //console.log("inc");
                //console.log("segment= "+this.pathSegment);
            }
            else {
                //console.log(this.id+" ID !!");
                //mobs.splice(0, mobs.length);
                //console.log("end");
                loopers++;
                loopersBox.textContent = loopers.toLocaleString("en-US") + " / " + maxLoopers;
                this.pathSegment = 0;
                this.x = paths[pathSeed][this.pathSegment][0];
                this.y = paths[pathSeed][this.pathSegment][1];
                score -= this.maxHp * 2;
                bufferScore = score;
                bufferScoreBox.textContent = bufferScore.toLocaleString("en-US");
                document.documentElement.style.setProperty("--scoreUpdateColor", "rgb(200, 25, 25)");
                scoreUpdateBoxUpdate("-", this.maxHp * 2);
                scoreBox.textContent = score.toLocaleString("en-US");
                totalScore -= this.maxHp * 2;
                if (totalScore < 0) {
                    totalScore = 0;
                }
                updateWarningBuffer();
                totalScoreBox.textContent = totalScore.toLocaleString("en-US");
                lastWaveScore -= this.maxHp * 2;
                //if (lastWaveScore < 0) {
                //    lastWaveScore = 0;
                //}
                lastWaveScoreBox.textContent = lastWaveScore.toLocaleString("en-US");
                //console.log("appel de checkScore()");
                checkScore();
            }
            //console.log("segment= "+this.pathSegment);
            //console.log("checkpoint apres "+this.direction);
        }
        
        //console.log(mobs);

        //APPLICATION DES EFFETS

        if (this.isFrozenSlowed) {
            //console.log("SLOWMOB duration= "+this.slowDuration);
            if (this.frozenSlowDuration == 0) {
                this.speed /= this.frozenSpeedMultiplier;
                this.isFrozenSlowed = false;
                //console.log("fin de slow");
            }   
            //console.log("speed réduit de "+this.speedMultiplier);
            else {
                this.frozenSlowDuration--;
            }
        }
        if (this.isFlooded) {//here            
            let currentWave = waveSettings - 1;
            if (currentWave < 0) {
                currentWave = 0;
            }
            switch(currentWave) {
                case 0:
                case 1:
                    if (this.floodSlowDuration == 0) {
                        //this.speed = this.baseSpeed;
                        this.speed /= this.floodSpeedMultiplier;
                        this.isFlooded = false;
                    }
                    else {
                        this.floodSlowDuration--;
                    }
                break;
                case 2:
                case 3:
                    if (this.floodBurnDuration == 0) {
                        this.isFlooded = false;
                    }
                    else {
                        if (this.floodBurnNextTickInterval == 0) {
                            //console.log("proc tick flood "+this.floodBurnTickDamage+" dmg");
                            this.hp -= this.floodBurnTickDamage;
                            if (towers[this.floodBurnOrigin]) {
                                if (this.hp > 0) {
                                    towers[this.floodBurnOrigin].damageDone += this.floodBurnTickDamage;
                                }
                                else {
                                    towers[this.floodBurnOrigin].damageDone += this.floodBurnTickDamage + this.hp;
                                }
                            }
                            this.floodBurnNextTickInterval = this.floodBurnTickInterval;
                        }
                        else {
                            this.floodBurnNextTickInterval--;
                        }
                        this.floodBurnDuration--;
                        //console.log("duree burn= "+this.burnDuration+" ;tick= "+this.burnTickDamage);
                    }
                break;
                default:
                break;
            }
        }
        if (this.isBurning) {
            if (this.burnDuration == 0) {
                this.isBurning = false;
            }
            else {
                if (this.burnNextTickInterval == 0) {
                    //console.log("proc tick pyro "+this.burnTickDamage+" dmg");
                    this.hp -= this.burnTickDamage;
                    if (towers[this.burnOrigin]) {
                        if (this.hp > 0) {
                            towers[this.burnOrigin].damageDone += this.burnTickDamage;
                        }
                        else {                        
                            towers[this.burnOrigin].damageDone += this.burnTickDamage + this.hp;
                        }
                    }
                    this.burnNextTickInterval = this.burnTickInterval;
                }
                else {
                    this.burnNextTickInterval--;
                }
                this.burnDuration--;
                //console.log("duree burn= "+this.burnDuration+" ;tick= "+this.burnTickDamage);
            }
        }
        if (this.isShocked) {
            if (this.shockDuration == 0) {
                this.speed /= this.speedMultiplier;
                this.isShocked = false;
                //console.log("fin de slow");
            }   
            //console.log("speed réduit de "+this.speedMultiplier);
            else {
                this.shockDuration--;
            }
        }
        // déplacement du mob
        if (this.pathSegment < paths[pathSeed].length) {
        if ((this.y == paths[pathSeed][this.pathSegment][1]) && this.x != paths[pathSeed][this.pathSegment][0]) {
            if (this.x < paths[pathSeed][this.pathSegment][0]) {
                //console.log("cas1");
                this.direction = "right";
                this.x += this.speed / 1000;
            }
            else if (this.x > paths[pathSeed][this.pathSegment][0]) {
                //console.log("cas2");
                this.direction = "left";
                this.x -= this.speed / 1000;
            }
        }
        if (this.x == paths[pathSeed][this.pathSegment][0] && this.y != paths[pathSeed][this.pathSegment][1]) {
            if (this.y < paths[pathSeed][this.pathSegment][1]) {
                //console.log("cas3");
                this.direction = "bottom";
                this.y += this.speed / 1000;
            }
            if (this.y > paths[pathSeed][this.pathSegment][1]) {
                //console.log("cas4");
                this.direction = "top";
                /* if (this.pathSegment == 0) {
                    this.y = paths[pathSeed][this.pathSegment][1] - this.radius * 2;
                } */
                this.y -= this.speed / 1000;
            }
        }
    }
    }
}

const types = [
    //vert et rouge sont réservés pour les effets
    180, //cyan => ice
    210, //blue => water
    25, //orange => fire
    60, //yellow => electric
    285 //purple => dark
];
const wavesSettings = [ //speed, color
    [40, types[0]],
    [60, types[1]],
    [60, types[2]],
    [125, types[3]],
    [85, types[4]],
];

const mobsBaseHp = 100; // valeur divisé par 10 pour la première vague; modifier pour dev, régler sur 100 pour partie normale
let waveNumber = 0;
let waveSettings = 1; // première vague (dans types[] 1 = bleu)
let nextWaveSettings = 2;
const launchButton = document.getElementById("launchButton");
const launchText = document.getElementById("launch");
const mobsHp = document.getElementById("mobsHp");
const mobsSpeed = document.getElementById("mobsSpeed");
const mobsType = document.getElementById("mobsType");
const mobsLeftNext = document.getElementById("mobsLeftNext");
var spawnDelay = 0;
let startTimeStamp;
let spawnSequence = false;
let spawnX;
let spawnY;
let waveSpeed;
const maxMobs = 15;
let waveMobsKilled = 0;
let lastWaveScore = 0;
let animationIsOn = false;

function reload() {
        // ctxGrid.clearRect(0, 0, canvas.width, canvas.height);
        if (endGameScreen) {
            clearTimeout(endGameScreen);
            endGameScreen = false;
        }
        canvas.style.boxShadow = "0 0 10px hsla(180, 100%, 50%, .5)";
        gridColor = "cyan";
        for (let i = 0; i < cellulesArray.length; i++) {
            cellulesArray[i].hasTower = false;
            cellulesArray[i].isLocked = false;
            //cellulesArray[i].draw();
        }
        //path.draw();
        //updateGrid();
        ctxGrid.strokeRect(0, 0, canvas.width, canvas.height);
        towers.splice(0, towers.length);
        mobs.splice(0, mobs.length);
        safeScore = 0;
        safeScoreBox.textContent = "";
        towersScore = 0;
        towersScoreBox.textContent = 0;
        bufferScore = startScore;
        bufferScoreBox.textContent = bufferScore.toLocaleString("en-US");
        totalScore = startScore;
        totalScoreBox.textContent = totalScore.toLocaleString("en-US");
        lastWaveScoreBox.textContent = 0;
        let scoreUpdateBox = document.getElementById("scoreUpdate");
        scoreUpdateBox.classList.add("fade");
        score = startScore;
        scoreBox.textContent = score.toLocaleString("en-US");
        spawnSequence = false;
        spawningMobId = 0;
        waveNumber = 0;
        waveSettings = 1;
        waveMobsKilled = 0;
        nextWaveSettings = 2;
        towersCounter = [0, 0, 0, 0, 0];
        for (let i = 0; i < towersCounterBox.length; i++) {
            towersCounterBox[i].textContent = 0;
        }
        userHasPickedTower = false;
        selectedTower = null;
        towerId = 0;
        totalMobs = 0;
        totalMobsBox.textContent = 0;
        mobsKilled = 0;
        mobsKilledBox.textContent = 0;
        mobsHealed = 0;
        mobsHealedBox.textContent = 0;
        loopers = 0;
        loopersBox.textContent = 0;
        mobsHp.textContent = "";
        mobsSpeed.textContent = "";
        mobsType.style.background = "transparent";
        document.documentElement.style.setProperty("--currentWaveColor", "transparent");
        //mobsType.style.boxShadow = "none";
        mobsLeft.textContent = "";
        mobsHpNext.textContent = mobsBaseHp * (((1) + 1) / 2) * ((1) / 5).toLocaleString("en-US");
        mobsSpeedNext.textContent = wavesSettings[1][0]; // types[1] = bleu
        mobsTypeNext.style.background = "hsl(" + types[1] + " , 100%, 50%)";
        document.documentElement.style.setProperty("--nextWaveColor", "hsla(" + types[1] + " , 100%, 50%, .5)");
       // mobsTypeNext.style.boxShadow = "0 0 10px hsl(" + types[1] + " , 100%, 50%)";
        mobsLeftNext.textContent = maxMobs;
        launchText.textContent = staticTranslations[gameLanguage][toTranslate.length + 5];
        defeatWarningBar.style.width = 0;
        gameIsOver = false;
        animationIsOn = false;
        updateGrid();
        drawContext();
        checkScore();
        clearDatas();
        //console.log(cellulesArray);
}
let defeatWarningBar = document.getElementById("defeatWarningBar");
let safeScore = 0;
let safeScoreBox = document.getElementById("safeScore");
let waveMobsCount = maxMobs;
let currentWaveHp = 0;
function waveInit() {
    if (gameIsOver) {
        reload();
    }
    else {
        //console.log(cellulesArray);
        //console.log(towers);
        //console.log(mobs);
        lastWaveScore = 0;
        lastWaveScoreBox.textContent = 0;
        animationIsOn = true;
        if (waveSettings >= wavesSettings.length) {
            waveSettings = 0;
        }
        document.documentElement.style.setProperty("--currentWaveColor", "hsla("+types[waveSettings]+", 100%, 50%, .5");
        //console.log(waveSettings);
        waveSpeed = wavesSettings[waveSettings][0];
        mobsSpeed.textContent = waveSpeed;
        let waveColor = wavesSettings[waveSettings][1];
        waveSettings++;
        mobsType.style.background = "hsl(" + waveColor + " , 100%, 50%)";
        spawnSequence = true;
        waveNumber++;
        textWaveId.textContent = staticTranslations[gameLanguage][26] + " #" + waveNumber;
        launchButton.classList.remove("text-shadow-animation");
        launchButton.classList.add("button-locked");
        launchText.textContent = staticTranslations[gameLanguage][toTranslate.length + 19] + " " + waveNumber;
        startTimeStamp = new Date();        
        mobsLeft.textContent = maxMobs;
        spawnX = paths[pathSeed][0][0];
        spawnY = paths[pathSeed][0][1];
        //console.log(spawnX+" "+spawnY);    
        //console.log("direction =" + path.direction);
        //console.log("radius =" + this.radius);
        /* let size = 8 / 600 * gridSizes;
        let radius = size + 1;
        switch(path.direction) {
            case "top":
                spawnY += radius / 2;
            break;
            default:

            break;
        } */
        for (let i = 0; i < maxMobs; i++) {        
            let mob = new Mob(spawnX, spawnY, waveColor, waveSpeed, mobsBaseHp, i);
            mobs.push(mob);
        }
        waveMobsCount = mobs.length;
        currentWaveHp = mobs[0].hp.toLocaleString("en-US");
        mobsHp.textContent = currentWaveHp;
        
        updateWarningBuffer();
        updateGrid();
        // HERE2    
        //window.removeEventListener("mousemove", hueGrid);
        //hueGridIsOn = false;
        //updateGrid();
        animate(0);
        mobsHpNext.textContent = (mobsBaseHp * (((waveNumber +1 ) + 1) / 2) * ((waveNumber + 1) / 5)).toLocaleString("en-US");
        waveSpeed = wavesSettings[nextWaveSettings][0];
        mobsSpeedNext.textContent = waveSpeed;
        waveColor = wavesSettings[nextWaveSettings][1];
        document.documentElement.style.setProperty("--nextWaveColor", "hsla("+waveColor+", 100%, 50%, .5");
        mobsTypeNext.style.background = "hsl(" + waveColor + " , 100%, 50%)";
        mobsLeftNext.textContent = maxMobs;
        nextWaveSettings++;
        if (nextWaveSettings >= wavesSettings.length) {
            nextWaveSettings = 0;
        }
    }
}
function updateWarningBuffer() {
    safeScore = currentWaveHp * 2 * mobs.length;
    //safeScoreBox.textContent = safeScore;
    let currentScore = score;
    if (currentScore == 0) {
        currentScore = 1;
    }
    let buffer = 100 / safeScore * currentScore;
    if (buffer > 100) {
        buffer = 100;
    }
    else if (buffer < 0) {
        buffer = 0;
    }
    let defeatWarningBarBackground = 100 / 120 * buffer;
    if (score < safeScore) {
        defeatWarningBar.style.background = "hsla("+defeatWarningBarBackground+", 100%, 50%, .85)";
        defeatWarningBar.style.width = 100 - buffer + "%";
    }
}
function resetGame() {
    reload();
}
/* let hueGridTimer = 0;
let hueGridColor = 0;
function hueGrid(e) {
    console.log("hueGrid()");
    if (hueGridTimer == 0) {
        let x = e.x;
        let y = e.y;
        //hueGridColor = Math.floor(x + y);
        console.log(window.innerWidth);
        hueGridColor = Math.floor(360 / window.innerWidth * x);
        console.log(hueGridTimer+"hueGrid().color= "+hueGridColor);
        updateGrid();
    }    
    hueGridTimer++;
    if (hueGridTimer >= 50) {
        hueGridTimer = 0;
    }
} */

//window.addEventListener("mousemove", hueGrid);

//let logFrame = 0;
let totalFrames = 0;

//control of fps
let lastTime = 0;
const fps = 80;
const nextFrame = 1000/fps;
let timer = 0;
let currentFrame = 0;
let lastSpawnFrame = 0;
let spawningMobId = 0
const creditsMultiplierBox = document.getElementById("creditsMultiplier");
let creditsMultiplier = 5;  //valeur de base !modifiable!
let userHasReset = false;

function animate(timeStamp) {
    //console.log(selectedTower);
    const deltaTime = timeStamp - lastTime;
    lastTime = timeStamp;

    //console.log(deltaTime);
    //console.log(timer + " ; " + nextFrame);

    if (timer > nextFrame) {
        
        begin = Date.now();
        currentFrame++;
        //console.log("frame "+currentFrame);
        // waveSpeed = wavesSettings[waveSettings][0];
        if (spawnSequence == true && spawningMobId <= maxMobs - 1) {
            //let spawnInterval = 1000 + (10 * waveSpeed * 2);
            //console.log(30 + 20 / 125 * waveSpeed);
            let spawnInterval = 20 + 10 / 125 * waveSpeed;
            if (currentFrame - lastSpawnFrame > spawnInterval) {
                mobs[spawningMobId].hasSpawned = true;
                //console.log("spawning");
                spawningMobId++;
                totalMobs++;
                totalMobsBox.textContent = totalMobs.toLocaleString("en-US");
                lastSpawnFrame = currentFrame;
                if (spawningMobId == maxMobs) {
                    //console.log("fin du spawn");
                    spawnSequence = false;
                    spawningMobId = 0;
                }
            } 
        }
        
        /* totalFrames++;
        if (logFrame == 1000) {  // affiche un console.log() toutes les 1000 frames
            //console.log(mobs)
            logFrame = 0;
        }
        else {
            logFrame++;
        } */
        //console.log(cellulesArray);
    
        if (spawnDelay > 0) {
            spawnDelay--;
        }
        
        timer = 0;

        drawContext();

    }
    else {
        timer += deltaTime;
    }
    if (mobs.length == 0 && !spawnSequence && !gameIsOver && !userHasReset) {
        //console.log("wave end");
        //cancelAnimationFrame(animation);
        waveTime = new Date() - startTimeStamp;
        //console.log("cancel après "+totalFrames+" frames et "+waveTime/1000+"s");
        totalFrames = 0;
        for (let i = 0; i < towers.length; i++) {
            if (towers[i]) {
                towers[i].optionSpec1IsOnCoolDown = false;
                towers[i].optionSpec2IsOnCoolDown = false;
            }
        }
        drawContext();
        //hueGridIsOn = true;
        //window.addEventListener("mousemove", hueGrid);
        setTimeout(() => {
            document.documentElement.style.setProperty("--scoreUpdateColor", "rgb(25, 200, 25)");

            let scoreUpdate = document.getElementById("scoreUpdate");
            scoreUpdate.remove();
            let scoreUpdateDiv = document.createElement("div");
            scoreUpdateDiv.setAttribute("id", "scoreUpdate");
            let scoreUpdateContainer = document.getElementById("scoreUpdateContainer");
            scoreUpdateContainer.appendChild(scoreUpdateDiv);
            let scoreUpdateBox = document.getElementById("scoreUpdate");
            scoreUpdateBox.textContent = "credits multiplier +" + creditsMultiplier + "%";
            let waveProgressBar = document.createElement("div");
            waveProgressBar.setAttribute("id", "waveProgressBar");
            waveProgressBar.classList.add("loading");
            scoreUpdateBox.appendChild(waveProgressBar);

/*             document.getElementById("scoreUpdate").remove();
            let scoreUpdateBox = document.createElement("div");
            scoreUpdateBox.setAttribute("id", "scoreUpdate");
            scoreUpdateBox.textContent = "credits multiplier +"+creditsMultiplier+"%";
            let waveProgressBar = document.createElement("div");
            waveProgressBar.setAttribute("id", "waveProgressBar");
            waveProgressBar.classList.add("loading");
            scoreUpdateBox.appendChild(waveProgressBar); */
        }, 250);

        launchText.textContent = staticTranslations[gameLanguage][toTranslate.length + 2];

        setTimeout(() => {
            waveMobsKilled = 0;
            bonus = Math.floor(score * creditsMultiplier / 100);
            score += bonus;
            scoreBox.textContent = score.toLocaleString("en-US");
            bufferScore = score;
            bufferScoreBox.textContent = bufferScore.toLocaleString("en-US");
            totalScore += bonus;
            totalScoreBox.textContent = totalScore.toLocaleString("en-US");
            launchButton.classList.remove("button-locked");
            launchButton.classList.add("text-shadow-animation");
            launchText.textContent = staticTranslations[gameLanguage][toTranslate.length + 5];
            document.documentElement.style.setProperty("--scoreUpdateColor", "rgb(25, 200, 25)");
            scoreUpdateBoxUpdate("+", bonus);
            /* scoreUpdateBox.classList.remove("fade");
            scoreUpdateBox.classList.add("fade");
            scoreUpdateBox.textContent = "+" + bonus; */
            mobs.splice(0, mobs.length);
        }, 2000);
        animationIsOn = false;
    }
    else if (!gameIsOver && !userHasReset) {
        //console.log("ts= "+timeStamp+" ;delta= "+deltaTime+" ;timer= "+timer);
        requestAnimationFrame(animate);
    }
}
let hueGridIsOn = false; 
function updateGrid() {
    //console.log("appel de updateGrid()");
    //console.log(ctxGrid.lineWidth+" "+ctxGrid.shadowBlur);
    //ctxGrid.lineWidth = gridLineWidth;
    //ctxGrid.shadowBlur = gridShadowBlur;
    //console.log("après= "+ctxGrid.lineWidth+" "+ctxGrid.shadowBlur);
    //ctxGrid.clearRect(0, 0, canvas.width, canvas.height);
    for (let i = 0; i < cellulesArray.length; i++) {
        if (cellulesArray[i].hasTower) {
            //let color = types[cellulesArray[i].towerType];
            //console.log(cellulesArray[i]);
            ctxGrid.strokeStyle = "hsl("+types[cellulesArray[i].towerType]+", 100%, 50%)";
        }
        else {
            if (!gameIsOver) {
                //gridColor = "cyan";
                let color = waveSettings - 1;
                if (color < 0) {
                    color = 0;
                }
                gridColor = "hsl("+types[color]+", 100%, 50%)";
            }
            /* else if (hueGridIsOn) {
                gridColor = gridColor = "hsl("+hueGridColor+", 100%, 50%)";
            } */
            else {
                let color = waveSettings - 1;
                if (color < 0) {
                    color = 0;
                }
                gridColor = "hsl("+types[color]+", 100%, 50%)";
            }
            ctxGrid.shadowBlur = gridShadowBlur;
            ctxGrid.lineWidth = gridLineWidth;
        }
        cellulesArray[i].draw();
    }
    ctxGrid.strokeStyle = gridColor;
    //ctxGrid.lineWidth = 5;
    ctxGrid.strokeRect(0, 0, canvas.width, canvas.height);
    ctxGrid.lineWidth = 1;
    ctxGrid.shadowBlur = 0;
    if (userHasPickedALevel || userPreviewsALevel) {
        path.draw();
    }
}

function drawContext() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    /* let cellule;
    for (let i = 0; i < cellulesArray.length; i++) {
        cellule = cellulesArray[i];
        //cellule.draw();
    } */
    //path.draw();
    towers.forEach(tower => tower.draw());
    towers.forEach(tower => tower.getTarget());
    /* for (let k = 0; k < towers.length; k++) {
        if (towers[k]) {
            towers[k].draw();
            towers[k].getTarget();
        }
        //towers[k].draw();
        //towers[k].getTarget();
    }    */ 
    //mobs.forEach(mob => mob.draw());
    //mobs.forEach(mob => mob.update());
    if (mobs.length > 0) {
        for (let j = 0; j < mobs.length; j++) {
            if (mobs[j].hp > 0 && mobs[j].hasSpawned == true) {
                mobs[j].draw();
                mobs[j].update();
            }
        }
    }
}

// vérifie que les canvas sont des carrés
function resize(width, height, context) {
    context.width = width;
    context.height = height;
    if (context.width < context.height) {
        context.height = context.width;
        cellSize = context.height / gridSize;
    }
    else if (context.width > context.height) {
        context.width = context.height;
        cellSize = context.width / gridSize;
    }
    else {
        cellSize = context.width / gridSize;
    }
}



// ***
// paths[x] contient les coordonnées d'un chemin [x, y] sur la grille
// ensuite utilisé par Path.draw() pour dessiner le chemin et verrouiller
// les cellules adjacentes au chemin pour y interdire la pose de tour
// ***
const levelsName = [
    "border chicanes",
    "winding descent",
    "original pattern",
    "square islands",
    "dev zone",
    "grid edges"
];
const levelsDescription = [
    "test",
    "test",
    "test",
    "test",
    "test"
]
const levelsGridSize = [
    16,
    16,
    16,
    18,
    16,
    18
];
const paths = [
    [   //border chicanes
        [0, 2],
        [3, 2],
        [3, 5],
        [2, 5],
        [2, 8],
        [3, 8],
        [3, 11],
        [2, 11],
        [2, 14],
        [6, 14],
        [6, 2],
        [10, 2],
        [10, 14],
        [14, 14],
        [14, 11],
        [13, 11],
        [13, 8],
        [14, 8],
        [14, 5],
        [13, 5],
        [13, 2],
        [16, 2]

    ],
    [   //winding descent
        [0, 2],
        [14, 2],
        [14, 5],
        [2, 5],
        [2, 8],
        [14, 8],
        [14, 11],
        [2, 11],
        [2, 14],
        [16, 14]
    ],
    [   //original pattern
        [0, 2],
        [5, 2],
        [5, 7],
        [2, 7],
        [2, 14],
        [14, 14],
        [14, 7],
        [11, 7],
        [11, 2],
        [16, 2]
    ],
    [   //square islands
        [11, 10],
        [16, 10],
        [16, 16],
        [10, 16],
        [10, 2],
        [16, 2],
        [16, 8],
        [2, 8],
        [2, 2],
        [8, 2],
        [8, 16],
        [2, 16],
        [2, 10],
        [7, 10]
    ],
    [   //dev zone
        [2, 16],
        [2, 0]
    ],
    [   //boundaries
        [0, 1],
        [17, 1],
        [17, 17],
        [1, 17],
        [1, 3],
        [15, 3]
    ]
];

let pathSeed = 0;   //here a modif pour editer un niveau
let gridSize = levelsGridSize[pathSeed];

class Path {
    constructor(pathSeed) {
        this.pathSeed = pathSeed,
        this.path = paths[pathSeed],
        this.direction = "",
        this.previousDirection = ""
    }
    draw() {
        //console.log("path.draw() ctxGrid.lineWidth= "+ctxGrid.lineWidth+" ;shadowBlur= "+ctxGrid.shadowBlur);
        //console.log("path draw() "+this.path[0][0]);
        // début du tracé du chemin
        ctxGrid.beginPath();
        ctxGrid.lineWidth = 1;
        ctxGrid.shadowBlur = 0;
        for (let i = 0; i < this.path.length; i++) {         
            if (i == 0) {  
                ctxGrid.moveTo(cellSize * this.path[i][0], cellSize * this.path[i][1]);
                ctxGrid.fillStyle = pathColor;
                //ctxGrid.lineWidth = 1;
                //ctxGrid.shadowBlur = 0;
                ctxGrid.strokeStyle = pathWayColor;
            }            
            else {
                this.previousDirection = this.direction;
                ctxGrid.lineTo(cellSize * this.path[i][0], cellSize * this.path[i][1]);
                let previousX = this.path[i - 1][0];
                let previousY = this.path[i - 1][1];
                let currentX = this.path[i][0];
                let currentY = this.path[i][1];
                //console.log("b "+currentX+" "+previousX);
                //console.log("c "+currentY+" "+previousY);
                // on détermine la direction du segment
                if (currentX == previousX) {
                    var gap = currentY - previousY;
                    if (currentY > previousY) {
                        this.direction = "bottom";
                    }
                    else {
                        this.direction = "top";
                    }
                }
                if (currentY == previousY) {
                    var gap = currentX - previousX;
                    if (currentX > previousX) {
                        this.direction = "right";
                    }
                    else {
                        this.direction = "left";
                    }
                }
                //console.log("direction segment= "+this.direction);
                if (gap < 0) {
                    gap = gap * -1;
                }
                //console.log(gap);
                if (this.direction != this.previousDirection) {
                    ctxGrid.lineWidth = 1;
                    ctxGrid.strokeStyle = pathWayColor;
                    ctxGrid.fillStyle = pathWayColor;
                    let hslColor = types[waveSettings - 1];
                    if (hslColor < 0) {
                        hslColor = 0;
                    }
                    ctxGrid.fillStyle = "hsl("+hslColor+", 100%, 50%)";
                    // gestion des coins
                    switch (this.direction) {
                        case "top":
                            if (this.previousDirection == "right") {
                                //ctxGrid.fillStyle = pathWayColor;
                                let cellId = gridSize * this.path[i - 1][1] + this.path[i - 1][0];
                                cellulesArray[cellId].isLocked = true;
                                ctxGrid.fillRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize, cellSize, cellSize);
                                ctxGrid.strokeRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize, cellSize, cellSize);
                            }
                            else if (i > 1) {
                                let cellId = gridSize * this.path[i - 1][1] + (this.path[i - 1][0] - 1);
                                cellulesArray[cellId].isLocked = true;
                                ctxGrid.fillRect(this.path[i - 1][0] * cellSize - cellSize, this.path[i - 1][1] * cellSize, cellSize, cellSize);
                                ctxGrid.strokeRect(this.path[i - 1][0] * cellSize - cellSize, this.path[i - 1][1] * cellSize, cellSize, cellSize);
                            }
                        break;
                        case "right":
                            if (this.previousDirection == "top") {
                                let cellId = gridSize * (this.path[i - 1][1] - 1) + (this.path[i - 1][0] - 1);
                                cellulesArray[cellId].isLocked = true;
                                cellulesArray[cellId + gridSize].isLocked = true;
                                ctxGrid.fillRect(this.path[i - 1][0] * cellSize - cellSize, this.path[i - 1][1] * cellSize - cellSize, cellSize, cellSize);
                                ctxGrid.strokeRect(this.path[i - 1][0] * cellSize - cellSize, this.path[i - 1][1] * cellSize - cellSize, cellSize, cellSize);
                            }
                            else if (i > 1) {
                                let cellId = gridSize * this.path[i - 1][1] + (this.path[i - 1][0] - 1);
                                cellulesArray[cellId].isLocked = true;
                                ctxGrid.fillRect(this.path[i - 1][0] * cellSize - cellSize, this.path[i - 1][1] * cellSize, cellSize, cellSize);
                                ctxGrid.strokeRect(this.path[i - 1][0] * cellSize - cellSize, this.path[i - 1][1] * cellSize, cellSize, cellSize);
                            }
                        break;
                        case "bottom":
                            if (this.previousDirection == "right") {
                                let cellId = gridSize * (this.path[i - 1][1] - 1) + this.path[i - 1][0];
                                cellulesArray[cellId].isLocked = true;
                                ctxGrid.fillRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize - cellSize, cellSize, cellSize);
                                ctxGrid.strokeRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize - cellSize, cellSize, cellSize);
                            }
                            else if (i > 1) {
                                let cellId = gridSize * (this.path[i - 1][1] - 1) + (this.path[i - 1][0] - 1);
                                cellulesArray[cellId].isLocked = true;
                                cellulesArray[cellId + 1].isLocked = true;
                                ctxGrid.fillRect(this.path[i - 1][0] * cellSize - cellSize, this.path[i - 1][1] * cellSize - cellSize, cellSize, cellSize);
                                ctxGrid.strokeRect(this.path[i - 1][0] * cellSize - cellSize, this.path[i - 1][1] * cellSize - cellSize, cellSize, cellSize);
                            }
                        break;
                        case "left":
                            if (this.previousDirection == "top") {
                                let cellId = gridSize * (this.path[i - 1][1] - 1) + this.path[i - 1][0];
                                cellulesArray[cellId].isLocked = true;
                                ctxGrid.fillRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize - cellSize, cellSize, cellSize);
                                ctxGrid.strokeRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize - cellSize, cellSize, cellSize);
                            }
                            else if (i > 1) {
                                let cellId = gridSize * this.path[i - 1][1] + this.path[i - 1][0];
                                cellulesArray[cellId].isLocked = true;
                                ctxGrid.fillRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize, cellSize, cellSize);
                                ctxGrid.strokeRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize, cellSize, cellSize);
                            }
                        break;
                        default:
                        break;
                    }                    
                }    
                //console.log(i+" "+this.direction+" "+gapX+" "+gapY);
                for (let a = 0; a < gap; a++) { //génération du départ
                    if (i == 1 && a == 0) {
                        ctxGrid.fillStyle = pathStartColor;
                        if (this.direction == "top") {
                            let gradient = ctxGrid.createLinearGradient(
                            this.path[i - 1][0] * cellSize - cellSize,
                            this.path[i - 1][1] * cellSize,
                            this.path[i - 1][0] * cellSize - cellSize,
                            this.path[i - 1][1] * cellSize - cellSize
                            );
                            gradient.addColorStop(0, "hsl(120, 100%, 50%)");
                            gradient.addColorStop(1, "hsl(0, 0%, 0%)");
                            ctxGrid.fillStyle = gradient;
                        }
                        else if (this.direction == "right") {
                            let gradient = ctxGrid.createLinearGradient(
                            this.path[i - 1][0] * cellSize,
                            this.path[i - 1][1] * cellSize - ((a + 1) * cellSize),
                            this.path[i - 1][0] * cellSize + cellSize,
                            this.path[i - 1][1] * cellSize - ((a + 1) * cellSize)
                            );
                            gradient.addColorStop(0, "hsl(120, 100%, 50%)");
                            gradient.addColorStop(1, "hsl(0, 0%, 0%)")
                            ctxGrid.fillStyle = gradient;
                            //ctxGrid.fillRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize - ((a + 1) * cellSize), this.path[i - 1][0] * cellSize + cellSize, this.path[i - 1][1] * cellSize - ((a + 1) * cellSize));
                        }
                        else if (this.direction == "bottom") {
                            //console.log("path "+this.path[i - 1][0]+" "+this.path[i - 1][1]);
                            let gradient = ctxGrid.createLinearGradient(
                            this.path[i - 1][0] * cellSize - cellSize,
                            this.path[i - 1][1] * cellSize,
                            this.path[i - 1][0] * cellSize - cellSize,
                            this.path[i - 1][1] * cellSize + cellSize
                            );
                            gradient.addColorStop(0, "hsl(120, 100%, 50%)");
                            gradient.addColorStop(1, "hsl(0, 0%, 0%)");
                            ctxGrid.fillStyle = gradient;
                        }
                        else if (this.direction == "left") {
                            let gradient = ctxGrid.createLinearGradient(
                            this.path[i - 1][0] * cellSize,
                            this.path[i - 1][1] * cellSize - ((a + 1) * cellSize),
                            this.path[i - 1][0] * cellSize - cellSize,
                            this.path[i - 1][1] * cellSize - ((a + 1) * cellSize)
                            );
                            gradient.addColorStop(0, "hsl(120, 100%, 50%)");
                            gradient.addColorStop(1, "hsl(0, 0%, 0%)")
                            ctxGrid.fillStyle = gradient;
                            //ctxGrid.fillRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize - ((a + 1) * cellSize), this.path[i - 1][0] * cellSize + cellSize, this.path[i - 1][1] * cellSize - ((a + 1) * cellSize));
                        }
                    }
                    else if (i == this.path.length - 1 && a == gap - 1) {   //génération de l'arrivée
                        ctxGrid.fillStyle = pathFinishColor;
                        //console.log("FIN previousDir= "+this.previousDirection+" this= "+this.direction);
                        if (this.direction == "top") {
                            let gradient = ctxGrid.createLinearGradient(
                            this.path[i][0] * cellSize,
                            this.path[i][1] * cellSize + cellSize,
                            this.path[i][0] * cellSize,
                            this.path[i][1] * cellSize
                            );
                            gradient.addColorStop(0, "hsl(0, 0%, 0%)");
                            gradient.addColorStop(1, "hsl(0, 100%, 50%)");
                            ctxGrid.fillStyle = gradient;
                        }
                        else if (this.direction == "right") {
                            let gradient = ctxGrid.createLinearGradient(
                            this.path[i][0] * cellSize - cellSize,
                            this.path[i][1] * cellSize,
                            this.path[i][0] * cellSize,
                            this.path[i][1] * cellSize
                            );
                            gradient.addColorStop(0, "hsl(0, 0%, 0%)");
                            gradient.addColorStop(1, "hsl(0, 100%, 50%)");
                            ctxGrid.fillStyle = gradient;
                            //console.log(gradient);
                            //console.log(this.path[i - 1][0] * cellSize - cellSize);
                        }
                        else if (this.direction == "bottom") {
                            //console.log(i+" "+this.direction);
                            //console.log("path 2 "+this.path[i - 1][0]+" "+this.path[i - 1][1]);
                            let gradient = ctxGrid.createLinearGradient(
                            this.path[i][0] * cellSize,
                            this.path[i][1] * cellSize - cellSize,
                            this.path[i][0] * cellSize,
                            this.path[i][1] * cellSize
                            );
                            gradient.addColorStop(0, "hsl(0, 0%, 0%)");
                            gradient.addColorStop(1, "hsl(0, 100%, 50%)");
                            ctxGrid.fillStyle = gradient;
                        }
                        else if (this.direction == "left") {
                            let gradient = ctxGrid.createLinearGradient(
                            this.path[i][0] * cellSize + cellSize,
                            this.path[i][1] * cellSize,
                            this.path[i][0] * cellSize,
                            this.path[i][1] * cellSize
                            );
                            gradient.addColorStop(0, "hsl(0, 0%, 0%)");
                            gradient.addColorStop(1, "hsl(0, 100%, 50%)");
                            ctxGrid.fillStyle = gradient;
                            //console.log(gradient);
                            //console.log(this.path[i - 1][0] * cellSize - cellSize);
                        }
                    }
                    else {  //génération du chemin
                        ctxGrid.fillStyle = pathWayColor;
                    }
                    if (this.direction == "top") {
                        let cellId = gridSize * (this.path[i - 1][1] - a - 1) + this.path[i - 1][0];
                        //console.log("cellId= "+cellId);
                        cellulesArray[cellId].isLocked = true;
                        cellulesArray[cellId - 1].isLocked = true;
                        cellId = gridSize * (this.path[i - 1][1] - a) + (this.path[i - 1][0] - 1);
                        ctxGrid.fillRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize - ((a + 1) * cellSize), cellSize, cellSize);
                        ctxGrid.fillRect(this.path[i - 1][0] * cellSize - cellSize, this.path[i - 1][1] * cellSize - ((a + 1) * cellSize), cellSize, cellSize);
                        ctxGrid.strokeRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize - ((a + 1) * cellSize), cellSize, cellSize);
                        ctxGrid.strokeRect(this.path[i - 1][0] * cellSize - cellSize, this.path[i - 1][1] * cellSize - ((a + 1) * cellSize), cellSize, cellSize);
                    }
                    if (this.direction == "right") {
                        let cellId = gridSize * this.path[i - 1][1] + (this.path[i - 1][0] + a);
                        //console.log("AAA cellId= "+cellId);
                        cellulesArray[cellId].isLocked = true;
                        cellulesArray[cellId - gridSize].isLocked = true;
                        cellId = gridSize * (this.path[i - 1][1] - 1) + (this.path[i - 1][0] + a);
                        ctxGrid.fillRect(this.path[i - 1][0] * cellSize + (a * cellSize), this.path[i - 1][1] * cellSize, cellSize, cellSize);
                        ctxGrid.fillRect(this.path[i - 1][0] * cellSize + (a * cellSize), this.path[i - 1][1] * cellSize - cellSize, cellSize, cellSize);
                        ctxGrid.strokeRect(this.path[i - 1][0] * cellSize + (a * cellSize), this.path[i - 1][1] * cellSize, cellSize, cellSize);
                        ctxGrid.strokeRect(this.path[i - 1][0] * cellSize + (a * cellSize), this.path[i - 1][1] * cellSize - cellSize, cellSize, cellSize);
                    }
                    if (this.direction == "bottom") {
                        let cellId = gridSize * (this.path[i - 1][1] + a) + this.path[i - 1][0];
                        cellulesArray[cellId].isLocked = true;
                        cellulesArray[cellId - 1].isLocked = true;
                        cellId = gridSize * (this.path[i - 1][1] + a) + (this.path[i - 1][0] - 1);
                        ctxGrid.fillRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize + (a * cellSize), cellSize, cellSize);
                        ctxGrid.fillRect(this.path[i - 1][0] * cellSize - cellSize, this.path[i - 1][1] * cellSize + (a * cellSize), cellSize, cellSize);
                        ctxGrid.strokeRect(this.path[i - 1][0] * cellSize, this.path[i - 1][1] * cellSize + (a * cellSize), cellSize, cellSize);
                        ctxGrid.strokeRect(this.path[i - 1][0] * cellSize - cellSize, this.path[i - 1][1] * cellSize + (a * cellSize), cellSize, cellSize);
                    }
                    if (this.direction == "left") {
                        let cellId = gridSize * this.path[i - 1][1] + (this.path[i - 1][0] - a);
                        cellulesArray[cellId].isLocked = true;
                        cellulesArray[cellId - gridSize].isLocked = true;
                        cellId = gridSize * (this.path[i - 1][1] - 1) + (this.path[i - 1][0] - (a + 1));
                        ctxGrid.fillRect(this.path[i - 1][0] * cellSize - ((a + 1) * cellSize), this.path[i - 1][1] * cellSize, cellSize, cellSize);
                        ctxGrid.fillRect(this.path[i - 1][0] * cellSize - ((a + 1) * cellSize), this.path[i - 1][1] * cellSize - cellSize, cellSize, cellSize);
                        ctxGrid.strokeRect(this.path[i - 1][0] * cellSize - ((a + 1) * cellSize), this.path[i - 1][1] * cellSize, cellSize, cellSize);
                        ctxGrid.strokeRect(this.path[i - 1][0] * cellSize - ((a + 1) * cellSize), this.path[i - 1][1] * cellSize - cellSize, cellSize, cellSize);
                    }
                }
               // ctxGrid.fillRect(0, this.path[i][1] * cellSize, cellSize, cellSize);
               // ctxGrid.fillRect(0, this.path[i][1] * cellSize - cellSize, cellSize, cellSize);
            }
        }
        //console.log(canvas.width / 2);
        //const gradient = ctxGrid.createRadialGradient(canvas.width / 2, canvas.width / 2, canvas.width / 3, canvas.width / 2, canvas.width / 2, canvas.width / 1.75);
        //gradient.addColorStop(0, "hsl(0, 50%, 25%)");
        //gradient.addColorStop(1, "hsl(120, 50%, 25%)");
        //const gradient = ctxGrid.createLinearGradient(0, 0, canvas.width, 0);
        //gradient.addColorStop(0, "hsl(120, 100%, 50%)");
        //gradient.addColorStop(0.5, "hsl(180, 0%, 0%)");
        //gradient.addColorStop(1, "hsl(0, 100%, 50%)");
        //ctxGrid.strokeStyle = pathWayColor;
        // appliquer gradient au chemin
        //ctxGrid.strokeStyle = gradient;  // couleur du chemin central : gradient
        // ou appliquer pathWayColor
        //ctxGrid.strokeStyle = pathWayColor;
        ctxGrid.strokeStyle = pathWayColor; // couleur du chemin central : black
        //ctxGrid.shadowColor = gridColor;  // shadowColor du chemin central
        //ctxGrid.shadowBlur = 0;  // shadowBlur du chemin central
        ctxGrid.lineWidth = cellSize * 1.7; // largeur du chemin central
        ctxGrid.stroke();
        ctxGrid.lineWidth = 1;
        ctxGrid.strokeStyle = gridColor;
        ctxGrid.closePath();
    }
}

//let path = new Path(pathSeed);
//console.log(path);
//console.log(paths[0]);
//path.draw();
//updateGrid();

function initGrid(cellSize) {
    //console.log("cellSize= "+cellSize);
    //console.log("initGrid()");
    //console.log(ctxGrid.lineWidth+" "+ctxGrid.shadowBlur);
    let id = 0;
    ctxGrid.strokeStyle = gridColor;
    ctxGrid.lineWidth = 3;
    for (let x = 0; x < canvas.width / cellSize; x++) {
        for (let y = 0; y < canvas.height / cellSize; y++) {
            let cellule = new Cellule(y * cellSize, x * cellSize, cellSize, id);
            cellulesArray.push(cellule);
            //cellule.draw();
            id++;
        }
        //console.log("cellules: "+id);
        //console.log(cellulesArray);
        // on ajoute 1 pixel aux carrés en bordure
        ctxGrid.strokeRect(0, 0, canvas.width, canvas.height);
        //ctxGrid.lineWidth = 1;
    }
    //ctxGrid.lineWidth = 1;
    //ctxGrid.shadowBlur = 32;
    updateGrid();
}

const levelsPickContainer = document.getElementById("levelsPickContainer");
const mapsList = document.getElementById("mapsList");

function generateLevelThumbnail() {
    let levelsNumber = levelsName.length;
    for (let i = 0; i < levelsNumber; i++) {
        let levelPickDiv = document.createElement("div");
        levelPickDiv.classList.add("level-pick");
        //levelPickDiv.setAttribute("id", "level" + id);
        let levelPickName = document.createElement("h1");
        levelPickName.classList.add("level-pick-name");
        levelPickName.textContent = levelsName[i];
        levelPickName.setAttribute("onclick", "previewLevel(" + i + ")");
        levelPickName.setAttribute("id", "map" + i);

        //let levelPickDescription = document.createElement("p");
        //levelPickName.classList.add("level-pick-desc");
        //levelPickDescription.textContent = levelsDescription[i];
        
/*         let levelPickPreview = document.createElement("div");
        levelPickPreview.classList.add("level-pick-preview");
        levelPickPreview.textContent = "preview";
        levelPickPreview.setAttribute("onclick", "previewLevel(" + i + ")");

        let levelPickSelect = document.createElement("div");
        levelPickSelect.classList.add("level-pick-select");
        levelPickSelect.textContent = "select";
        levelPickSelect.setAttribute("onclick", "pickLevel(" + i + ")"); */


        levelPickDiv.appendChild(levelPickName);
        //levelPickDiv.appendChild(levelPickDescription);
/*         levelPickDiv.appendChild(levelPickPreview);
        levelPickDiv.appendChild(levelPickSelect); */
        mapsList.appendChild(levelPickDiv);
    }
}
//const cancelButton = document.getElementById("cancelButton");
let confirmReset = false;

function reset() {
    if (!confirmReset) {
        //cancelButton.style.display = "flex";
        quitButton.textContent = quitButton.textContent = staticTranslations[gameLanguage][toTranslate.length];
        confirmReset = true;
        confirmButton.classList.remove("locked-button");
        confirmButton.classList.add("unlocked-button");
        confirmButton.textContent = staticTranslations[gameLanguage][toTranslate.length + 1];
        confirmButton.setAttribute("onclick", "cancelReset()");
    }
    else {
        //console.log("reset");
        displayPreviewedLevel(-1);
        quitButton.classList.remove("unlocked-button");
        quitButton.classList.add("locked-button");
        quitButton.textContent = staticTranslations[gameLanguage][toTranslate.length + 18];
        confirmButton.classList.remove("unlocked-button");
        confirmButton.classList.add("locked-button");
        confirmButton.textContent = staticTranslations[gameLanguage][toTranslate.length + 17];
        confirmButton.setAttribute("onclick", "pickLevel()");
        previewMapName.textContent = staticTranslations[gameLanguage][45];
        let child = towersSummary.lastElementChild;
        while (child) {
            towersSummary.removeChild(child);
            child = towersSummary.lastElementChild;
        }
        if (gameIsOver) {
            scoreUpdate.classList.add("fade");
            canvas.style.boxShadow = "0 0 10px hsla(180, 100%, 50%, .5)";
        }
        else {
            launchText.textContent = "";
            launchButton.classList.add("button-locked");
        }
        reload();
        userHasReset = true;
        score = startScore;
        lastWaveScoreBox.textContent = 0;
        //cancelButton.style.display = "none";
        confirmReset = false;
        gameIsOver = false;
        selectedTower = false;
        if (spawnSequence) {
            spawnSequence = false;
        }
        userPreviewsALevel = false;
        userHasPickedALevel = false;
        topPlayersTitle.textContent = staticTranslations[gameLanguage][37];
        cellulesArray.splice(0, cellulesArray.length);
        towers.splice(0, towers.length);
        mobs.splice(0, mobs.length);
        waveSettings = 1;
        initGrid(cellSize);
        drawContext();
        hideInterface();
    }
}

function cancelReset() {
    //cancelButton.style.display = "none";
    confirmButton.classList.remove("unlocked-button");
    confirmButton.classList.add("locked-button");
    confirmButton.textContent = quitButton.textContent = staticTranslations[gameLanguage][toTranslate.length + 17];
    confirmButton.setAttribute("onclick", "pickLevel()");
    quitButton.textContent = quitButton.textContent = staticTranslations[gameLanguage][toTranslate.length + 18];
    confirmReset = false;
}
generateLevelThumbnail();

let userPreviewsALevel = false;
const previewMapName = document.getElementById("textPreviewMapName");

function displayPreviewedLevel(id) {
    let maps = document.querySelectorAll("h1.level-pick-name");
    let previewedMap;
    for (let i = 0; i < maps.length; i++) {
        previewedMap = maps[i];
        if (i != id) {
            previewedMap.classList.remove("map-name-glow");
            previewedMap.classList.add("map-name-default");
        }
        else {
            previewedMap.classList.remove("map-name-default");
            previewedMap.classList.add("map-name-glow");
        }
    }
}

function previewLevel(id) {
    userPreviewsALevel = true;
    displayPreviewedLevel(id);
    //previewedMap.classList.add("map-name-glow");
    previewMapName.textContent = levelsName[id];
    confirmButton.classList.remove("locked-button");
    confirmButton.classList.add("unlocked-button");
    //console.log("debut de previewLevel()");
    cellulesArray.splice(0, cellulesArray.length);
    towers.splice(0, towers.length);
    mobs.splice(0, mobs.length);
    //console.log(cellulesArray);
    gridSize = levelsGridSize[id];
    //console.log("gridSize= "+gridSize);
    // on recalcule la valeur de cellSize
    resize(canvas.width - gridBorderSize, canvas.height - gridBorderSize, canvas);
    resize(grid.width - gridBorderSize, grid.height - gridBorderSize, grid);
    
    //console.log("cellSize= "+cellSize);
    pathSeed = id;
    path = new Path(pathSeed);
    //console.log(cellulesArray);
    initGrid(cellSize);
    //path.draw();
    //ctx.clearRect(this.x, this.y, this.cellSize, this.cellSize);
    //updateGrid();
    //console.log(cellulesArray);
    //console.log(towers);
    //console.log(mobs);
    //console.log(path);
    //console.log("AAAPreviewLevel");
    let child = playersList.lastElementChild;
    while (child) {
        playersList.removeChild(child);
        child = playersList.lastElementChild;
    }
    topPlayersTitle.textContent = levelsName[id] + " - " + staticTranslations[gameLanguage][37];
    let line;
    let playerName;
    let playerScore;
    let playerWave;
    if (topScores[id]) {
        for (let i = 0; i < topScores[id].length; i++) {
                if (i < 20) {
                line = document.createElement("div");
                line.classList.add("player-top-score");
                playerRank = document.createElement("p");
                playerRank.textContent = i + 1;
                line.appendChild(playerRank);
                playerName = document.createElement("p");
                playerName.textContent = topScores[id][i][0];
                line.appendChild(playerName);
                playerScore = document.createElement("p");
                playerScore.textContent = parseInt(topScores[id][i][1]).toLocaleString("en-US");
                line.appendChild(playerScore);
                playerWave = document.createElement("p");
                playerWave.textContent = topScores[id][i][2];
                line.appendChild(playerWave);
                playersList.appendChild(line);
            }
        }
    }
}
//let mapId;
let topScores = [];
let topMapScores = [];
let i = 0;
<?php
include('function/db_con.php');
include('function/get_scores.php');
while ($line = $result->fetch_assoc()) { ?> //pour chaque ligne
    if (<?php echo "'" . $line['map'] . "'" ?> != i) { //on change à chaque map
        if (i != -1) { //fin des scores de la map, ajout du tableau
            topScores.push(topMapScores);
        }
        while (<?php echo "'" . $line['map'] . "'" ?> > i + 1) { //si aucun score pour une map, on ajoute un tableau vide
            topMapScores = [];
            topScores.push(topMapScores);
            i++;
        }
        i++;
        topMapScores = []; //initialisation du tableau des scores d'une map
    }
    playerScoreArray = [];
    //playerScoreArray.push(<?php echo "'" . $line['map'] . "'" ?>);
    playerScoreArray.push(<?php echo "'" . $line['name'] . "'" ?>);
    playerScoreArray.push(<?php echo "'" . $line['score'] . "'" ?>);
    playerScoreArray.push(<?php echo "'" . $line['wave'] . "'" ?>);
    topMapScores.push(playerScoreArray);
<?php
}
?>
topScores.push(topMapScores); //ajout du dernier tableau
//console.log("topScores=");
//console.log(topScores);

let userHasPickedALevel = false; //passer sur true pour édition de niveau
function pickLevel(id) {
    id = pathSeed;
    //previewLevel(id);
    userHasReset = false;
    userPreviewsALevel = false;
    //console.log("score= "+score);
    quitButton.classList.remove("locked-button");
    quitButton.classList.add("unlocked-button");
    confirmButton.classList.remove("unlocked-button");
    confirmButton.classList.add("locked-button");
    //let child = playersList.lastElementChild;
    //while (child) {
    //    playersList.removeChild(child);
    //    child = playersList.lastElementChild;
    //}
    //mapId = id;
    //console.log("mapId= "+mapId);
    //console.log("debut de pickLevel("+id+")");
    //score = startScore;
    scoreBox.textContent = score.toLocaleString("en-US");
    checkScore();
    gameIsOver = false;
    waveSettings = 1;
    nextWaveSettings = 2;
    waveNumber = 0;
    towerId = 0;
    waveMobsKilled = 0;
    spawningMobId = 0;
    mobsLeft.textContent = maxMobs;
    userHasPickedALevel = true;
    updateGrid();
    //topPlayersTitle.textContent = levelsName[id] + " - " + staticTranslations[gameLanguage][25];
    //let results = [];
    //let i = 0;
    /* let line;
    let playerName;
    let playerScore;
    let playerWave;
    if (topScores[id]) {
        for (let i = 0; i < topScores[id].length; i++) {
                if (i < 20) {
                line = document.createElement("div");
                line.classList.add("player-top-score");
                playerRank = document.createElement("p");
                playerRank.textContent = i + 1;
                line.appendChild(playerRank);
                playerName = document.createElement("p");
                playerName.textContent = topScores[id][i][0];
                line.appendChild(playerName);
                playerScore = document.createElement("p");
                playerScore.textContent = parseInt(topScores[id][i][1]).toLocaleString("en-US");
                line.appendChild(playerScore);
                playerWave = document.createElement("p");
                playerWave.textContent = topScores[id][i][2];
                line.appendChild(playerWave);
                playersList.appendChild(line);
            }
        }
    } */
    showInterface();
}
function closeSubmit() {
    gameSummary.classList.remove("fade-in");
    gameSummary.classList.add("fade");
    playerNameBox.classList.remove("active");
    playerNameBox.classList.add("inactive");
}
const userGuide = document.getElementById("userGuide");
function displayUserGuide() {
    userGuide.style.opacity = 1;
    userGuide.style.pointerEvents = "all";
}
function closeUserGuide() {
    userGuide.style.opacity = 0;
    userGuide.style.pointerEvents = "none";
}
//console.log(canvas.height+" "+canvas.width);
//resize(canvas.width - gridBorderSize, canvas.height - gridBorderSize, canvas);
//resize(grid.width - gridBorderSize, grid.height - gridBorderSize, grid);
//initGrid(cellSize);
//initGrid(cellSize);
//console.log(cellSize);


// gestion des éléments html

const startScore = 100; //changer pour mode dev ; doit être = 100 pour partie "normale"
let score = startScore;
let totalScore = score;
let bufferScore = score;
let towersScore = 0;
const totalScoreBox = document.getElementById("totalScore");
totalScoreBox.textContent = totalScore.toLocaleString("en-US");
const bufferScoreBox = document.getElementById("bufferScore");
const towersScoreBox = document.getElementById("towersScore");
const lastWaveScoreBox = document.getElementById("lastWaveScore");
const scoreBox = document.getElementById("score");
const scoreUpdateBox = document.getElementById("scoreUpdate");
scoreBox.textContent = score.toLocaleString("en-US");
bufferScoreBox.textContent = score.toLocaleString("en-US");
const towerTypesBox = document.getElementById("towerTypesBox");
const waveDatasBox = document.querySelectorAll("div.wave-data");
const levelDatasBox = document.getElementById("levelDatas");
const levelName = document.getElementById("levelName");
const playersList = document.getElementById("playersList");
const topPlayersTitle = document.getElementById("textTopPlayersTitle");
const textTowersInventory = document.getElementById("textTowersInventory");
function hideInterface() {
    for (let i = 0; i < waveDatasBox.length; i++) {
        let nodes = waveDatasBox[i].childNodes;
        //console.log(nodes);
        for (let j = 0; j < nodes.length; j++) {
            //console.log("node "+j+" ");
            //console.log(nodes[j]);
            if (nodes[j].className == "title" || nodes[j].className == "row-x2") {
                nodes[j].style.opacity = 0;
            }
        }
    }
    scoreBox.style.opacity = 0;
    towerTypesBox.style.opacity = 0;
    //playersList.style.opacity = 0;
    launchButton.classList.add("button-locked");
    launchText.textContent = "";
    levelsPickContainer.style.opacity = 1;
    levelsPickContainer.style.pointerEvents = "all";
    levelDatasBox.style.opacity = 0;
    levelDatasBox.style.pointerEvents = "none";
    textTowersInventory.style.opacity = 0;
}
hideInterface();
function showInterface() {
    for (let i = 0; i < waveDatasBox.length; i++) {
        let nodes = waveDatasBox[i].childNodes;
        //console.log(nodes);
        for (let j = 0; j < nodes.length; j++) {
            //console.log("node "+j+" ");
            //console.log(nodes[j]);
            if (nodes[j].className == "title" || nodes[j].className == "row-x2") {
                nodes[j].style.opacity = 1;
            }
        }
    }
    scoreBox.style.opacity = 1;
    towerTypesBox.style.opacity = 1;
    //playersList.style.opacity = 1;
    //console.log("toTranslate.length= " + toTranslate.length);
    launchText.textContent = staticTranslations[gameLanguage][toTranslate.length + 5];
    levelsPickContainer.style.opacity = 0;
    launchButton.classList.remove("button-locked");
    levelsPickContainer.style.pointerEvents = "none";
    levelDatasBox.style.opacity = 1;
    levelDatasBox.style.pointerEvents = "all";
    levelName.textContent = levelsName[pathSeed];    
    textTowersInventory.style.opacity = 1;
}


const towersName = [
    ["ice",
    "water",
    "fire",
    "lightning",
    "dark"],
    ["de glace",
    "d'eau",
    "de feu",
    "de foudre",
    "sombre"]
];
const towersCost = [
    100,
    200,
    500,
    1000,
    2000
];
const towersDamage = [
    1,
    2,
    3,
    4,
    5
];
/* const towersRadius = [
    100,
    200,
    500,
    1000,
    2000
]; */
const playerNamePlaceholder = [
    ["enter your name"],
    ["entrez votre nom"]
];
let gameIsOver = false;
const gameSummary = document.getElementById("gameSummary");
const mapId = document.getElementById("mapId");
const mapName = document.getElementById("mapName");
const playerNameBox = document.getElementById("playerName");
const playerScore = document.getElementById("playerScore");
const displayPlayerScore = document.getElementById("displayPlayerScore");
const lastWave = document.getElementById("lastWave");
let endGameScreen = false;
function checkScore() {
    //console.log("debut de checkScore()");
    if (score < 0 || loopers >= maxLoopers) {  // affichage de l'écran de fin de partie
        gameIsOver = true;
        launchText.textContent = staticTranslations[gameLanguage][toTranslate.length + 3];
        mapName.textContent = levelsName[pathSeed];
        mapId.value = pathSeed;
        playerNameBox.placeholder = playerNamePlaceholder[gameLanguage];
        playerScore.value = totalScore;
        displayPlayerScore.textContent = totalScore.toLocaleString("en-US");
        lastWave.value = waveNumber;
        lastWave.textContent = waveNumber;
        if (totalScore > startScore) {
            gameSummary.classList.add("fade-in");
            playerNameBox.classList.remove("inactive");
            playerNameBox.classList.add("active");
        }
        setTimeout(() => {
            let scoreUpdateBox = document.getElementById("scoreUpdate");
            scoreUpdateBox.style.color = "#fff";
            scoreUpdateBox.textContent = "game over";
            let waveProgressBar = document.createElement("div");
            waveProgressBar.setAttribute("id", "waveProgressBar");
            document.documentElement.style.setProperty("--currentWaveColor", "hsla(0, 100%, 50%, .5)");
            waveProgressBar.classList.add("loading-2s");
            scoreUpdateBox.appendChild(waveProgressBar);
        }, 10);
        
        ctxGrid.clearRect(0, 0, canvas.width, canvas.height);        
        ctxGrid.shadowBlur = 32;
        ctxGrid.lineWidth = 3;
        gridColor = "red";
        ctxGrid.fillStyle = gridColor;
        canvas.style.boxShadow = "0 0 10px hsla(0, 100%, 50%, .5)";
        ctxGrid.strokeRect(0, 0, canvas.width, canvas.height);

        //ctxGrid.shadowBlur = 32;
        //ctxGrid.lineWidth = 2;
        updateGrid();
        //path.draw();
        endGameScreen = setTimeout(() => {
            launchText.style.letterSpacing = ".2em";
            launchText.textContent = staticTranslations[gameLanguage][toTranslate.length + 4];
            launchButton.classList.remove("button-locked");
            launchButton.classList.add("text-shadow-animation");
        }, 2000);
    }
    else {
        //console.log("score= "+score);
        if (selectedTower) {
            //console.log("appel de checkOptionsCost()");
            selectedTower.checkOptionsCost();
        }
        else if (userHasPickedTower == true && towersCost[pickedTowerType] > score) {   //plus assez de crédits pour la tour picked
            window.removeEventListener("mousemove", positionTower);
            if (waveNumber > 0) {
                guideline.textContent = guildelineTranslations[gameLanguage][3];
            }
            else {
                guideline.textContent = guildelineTranslations[gameLanguage][5];
            }
            let towerDiv = document.getElementById("towerImage");
            towerDiv.remove();        
            clearDatas();
            userHasPickedTower = false;        
            let box = document.getElementById("pick"+pickedTowerType);
            //box.classList.remove("available");
            //box.classList.add("locked");
            box.style.background = "rgba(200, 25, 25, .75)";
            box.style.boxShadow = "0 0 15px rgba(200, 25, 25, .75)";
        }
        for (let i = 0; i < types.length; i++) {
            let box = document.getElementById("pick"+i);
            if (score < towersCost[i]) {
                //console.log("non pour tour id "+i);
                //box.classList.remove("available");
                //box.classList.add("locked");
                box.style.background = "rgba(200, 25, 25, .75)";
                box.style.boxShadow = "0 0 15px rgba(200, 25, 25, .75)";
            }
            else {
                //box.classList.remove("locked");
                //box.classList.add("available");
                if (userHasPickedTower == true && pickedTowerType == i) {
                    box.style.background = "hsla(" + types[i] + ", 100%, 50%, .75)";
                    box.style.boxShadow = "hsla(" + types[i] + ", 100%, 50%, .75)";
                }
                else {
                    box.style.background = "rgba(25, 200, 25, .75)";
                    box.style.boxShadow = "0 0 15px rgba(25, 200, 25, .75)";
                }
            }
        }
    }
}
//checkScore();

function clearDatas() {
    selectedItemName.style.opacity = 0;
    selectedItemDatas.style.opacity = 0;
    selectedItemId.style.opacity = 0;
    selectedItemStats.style.opacity = 0;
    selectedItemDesc.style.opacity = 1;
    //selectedItemDesc.style.pointerEvents = "all";
    selectedItemOptions.style.opacity = 0;
    selectedItemOptions.style.pointerEvents = "none";
    hideTooltip();
}
function displayDatas(itemId, isNew) {
    //console.log(isNew);
    selectedItemName.style.opacity = 1;
    selectedItemDatas.style.opacity = 1;
    if (isNew){
        switch(gameLanguage) {
            case 0:
                itemName.textContent = towersName[gameLanguage][itemId] + " tower";
            break;
            case 1:
                itemName.textContent = "tour " + towersName[gameLanguage][itemId];
            break;
            default:
            break;
        }
        itemCost.textContent = towersCost[itemId];
        itemCost.style.opacity = 1;
        selectedItemLevel.textContent = "1";
        selectedItemDamage.textContent = towersDamage[itemId];
        selectedItemRadius.textContent = (75 + (10 * itemId)).toFixed();
        selectedItemHeal.textContent = towersDamage[itemId] / 2;
    }
    else if (towers[itemId]) {
        selectedItemDesc.style.opacity = 0;
        selectedItemId.style.opacity = 1;
        selectedItemId.textContent = staticTranslations[gameLanguage][toTranslate.length + 6] + itemId; //here1
        selectedItemStats.style.opacity = 1;
        selectedTowerKills.textContent = towers[itemId].killsCount.toLocaleString("en-US");
        selectedTowerDamage.textContent = Math.floor(towers[itemId].damageDone).toLocaleString("en-US");
        selectedTowerHeals.textContent = towers[itemId].healsCount.toLocaleString("en-US");
        selectedTowerHealing.textContent = Math.floor(towers[itemId].healingDone).toLocaleString("en-US");
        selectedTowerValue.textContent = towers[itemId].value.toLocaleString("en-US");
        selectedTowerEffectiveCost.textContent = towers[itemId].effectiveCost.toLocaleString("en-US");
        //itemName.textContent = towersName[gameLanguage][towers[itemId].towerType] + staticTranslations[gameLanguage][50] + selectedTower.towerId;
        switch(gameLanguage) {
            case 0:
                itemName.textContent = towersName[gameLanguage][towers[itemId].towerType] + " tower #" + selectedTower.towerId;;
            break;
            case 1:
                itemName.textContent = "tour " + towersName[gameLanguage][towers[itemId].towerType] + " #" + selectedTower.towerId;;
            break;
            default:
            break;
        }
        itemCost.style.opacity = 0;
        if (towers[itemId].level < towersMaxLvl) {
            selectedItemLevel.textContent = towers[itemId].level;
        }
        else {
            selectedItemLevel.textContent = "max";
        }
        selectedItemDamage.textContent = towers[itemId].damage * towers[itemId].damageMultiplier;
        selectedItemRadius.textContent = towers[itemId].radius.toFixed();
        selectedItemHeal.textContent = towers[itemId].damage / 2 * towers[itemId].healMultiplier;
        selectedItemOptions.style.opacity = 1;
        selectedItemOptions.style.pointerEvents = "all";
/*         if (selectedTower) {
            console.log("appel de checkOptionsCost()");
            selectedTower.checkOptionsCost();
        } */
    }
}

function scoreUpdateBoxUpdate(sign, value) {
    //console.log("appel de scoreUpdateBoxUpdate");
    let scoreUpdate = document.getElementById("scoreUpdate");
    scoreUpdate.remove();
    let scoreUpdateDiv = document.createElement("div");
    scoreUpdateDiv.setAttribute("id", "scoreUpdate");
    let scoreUpdateContainer = document.getElementById("scoreUpdateContainer");
    scoreUpdateContainer.appendChild(scoreUpdateDiv);
    let scoreUpdateBox = document.getElementById("scoreUpdate");
    scoreUpdateBox.textContent = sign + value.toLocaleString("en-US");
    let waveProgressBar = document.createElement("div");
    waveProgressBar.setAttribute("id", "waveProgressBar");
    scoreUpdateBox.appendChild(waveProgressBar);
    
    let waveProgressBarWidth = 100 / maxMobs * waveMobsKilled + "%";
    //console.log("waveProgressBarWidth= "+waveProgressBarWidth);
    waveProgressBar.style.width = waveProgressBarWidth;
    let color = waveSettings - 1;
    if (color < 0) {
        color = 0;
    }
    //console.log("waveNumber= "+waveNumber);
    if (waveNumber > 0) {
        document.documentElement.style.setProperty("--currentWaveColor", "hsla("+types[color]+", 100%, 50%, .5)");
    }
    //document.documentElement.style.setProperty("--currentWaveColor", "hsla("+types[color]+", 100%, 50%, .5");
    if (waveMobsKilled <= maxMobs && score >= 0) {
        scoreUpdateBox.classList.add("fade");
    }
}
// affichage des données de la première vague
mobsHpNext.textContent = mobsBaseHp * (((1) + 1) / 2) * ((1) / 5).toLocaleString("en-US");
mobsSpeedNext.textContent = wavesSettings[1][0]; // types[1] = bleu
mobsTypeNext.style.background = "hsl(" + types[1] + " , 100%, 50%)";
mobsLeftNext.textContent = maxMobs;

const towersMaxLvl = 10;
// redimensionne le canvas pour la version responsive
/* window.addEventListener("resize", function() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    resize(canvas.width - gridBorderSize, canvas.height - gridBorderSize);
    path.draw();
}); */

// ajustement du curseur si le canvas est en position center / center:
//const cx = (window.innerWidth - canvas.width) / 2;
//const cy = (window.innerHeight - canvas.height) / 2;
// si le canvas est en position absolute:
const cx = 0;
const cy = 0;

/* let optionsCost = [
    [optionLevelUp, 0],
    [optionSpec1, 0],
    [optionSpec2, 0],
]; */

const selectedItemOptionsDisplay = document.getElementById("textSelectedItemOptionsDisplay");
const tooltip = document.getElementById("tooltip");
const tooltipEffect = document.getElementById("tooltipEffect");
const tooltipCooldown = document.getElementById("tooltipCooldown");
/* let tooltips= [
    ["Tooltip du type 0 spec1 "+optionsCost[0][1], "Tooltip du type 0 spec2"], // type 0; [spec1, spec2]
    ["Tooltip du type 1 spec1 "+optionsCost[1][1], "Tooltip du type 1 spec2"],
    ["Tooltip du type 2 spec1", "Tooltip du type 2 spec2"],
    ["Tooltip du type 3 spec1", "Tooltip du type 3 spec2"],
    ["Tooltip du type 4 spec1", "Tooltip du type 4 spec2"]
];
let specs = [
    ["Nom Spec 1 Type 0", "Nom Spec 2 Type 0"],
    ["Nom Spec 1 Type 1", "Nom Spec 2 Type 1"],
    ["Nom Spec 1 Type 2", "Nom Spec 2 Type 2"],
    ["Nom Spec 1 Type 3", "Nom Spec 2 Type 3"],
    ["Nom Spec 1 Type 4", "Nom Spec 2 Type 4"],
]; */
function positionTooltip(e) {
    tooltip.style.left = e.x + 20 + "px";
    tooltip.style.top = e.y + 20 + scrollY + "px";
    tooltip.style.opacity = 1;
    //tooltip.style.pointerEvents = "all";
}
function hideTooltip() {
    tooltip.style.opacity = 0;
    //tooltip.style.pointerEvents = "none";
}
function updateTooltip(msg) {
    //console.log("updateTooltip msg= " + msg);
    tooltipEffect.textContent = msg;
}
let playerHoversOptionSpec1 = false;
function hoverOptions(e) {
    //console.log("hoverOptions "+e.target.id);
    let target = e.target.id;
    switch(target) {
        case "optionLevelUp":
            selectedItemOptionsDisplay.textContent = staticTranslations[gameLanguage][toTranslate.length + 10];
            tooltipEffect.textContent = staticTranslations[gameLanguage][toTranslate.length + 11];
            tooltipCooldown.textContent = "";
            positionTooltip(e);
            break;
        case "optionSpec1":
            //selectedItemOptionsDisplay.textContent = effects[selectedTower.towerType][0];
            //tooltip.textContent = effects[selectedTower.towerType][1];
            playerHoversOptionSpec1 = true;
            selectedItemOptionsDisplay.textContent = towers[selectedTower.towerId].effects[gameLanguage][0][0];
            tooltipEffect.textContent = towers[selectedTower.towerId].effects[gameLanguage][0][1];
            if (towers[selectedTower.towerId].effects[0][0][4] / 30 < 2) {
                singOrPlur = "";
            }
            else {
                singOrPlur = "s";
            }
            if (selectedTower.towerType != 4) {
                tooltipCooldown.textContent = "\r\n" + staticTranslations[gameLanguage][toTranslate.length + 8] + " : " + towers[selectedTower.towerId].effects[0][0][4] / 30 + " " + staticTranslations[gameLanguage][toTranslate.length + 9] + singOrPlur;//here2
            }
            positionTooltip(e);
            break;
        case "optionSpec2":
            selectedItemOptionsDisplay.textContent = towers[selectedTower.towerId].effects[gameLanguage][1][0];
            tooltipEffect.textContent = towers[selectedTower.towerId].effects[gameLanguage][1][1];
            if (towers[selectedTower.towerId].effects[0][0][4] / 30  < 2) {
                singOrPlur = "";
            }
            else {
                singOrPlur = "s";
            }
            tooltipCooldown.textContent = "";
            positionTooltip(e);
            break;
        case "optionDestroy":
            selectedItemOptionsDisplay.textContent = staticTranslations[gameLanguage][toTranslate.length + 12];
            tooltipEffect.textContent = staticTranslations[gameLanguage][toTranslate.length + 13];
            tooltipCooldown.textContent = staticTranslations[gameLanguage][toTranslate.length + 14];
            positionTooltip(e);
            break;
        default:
            playerHoversOptionSpec1 = false;
            selectedItemOptionsDisplay.textContent = staticTranslations[gameLanguage][25];
            hideTooltip();
            break;
    }
}

let textColor = "hsl("+ 180 + ", 100%, 50%)";
let optionLockCooldown = [];
function optionIsLocked(option) {
    //console.log(option.id);
    let optionLockCooldownId = 0;
    switch(option.id) {
        case "levelUpCost":
            optionLockCooldownId = 0;
        break;
        case "spec1Cost":
            optionLockCooldownId = 1;
        break;
        case "spec2Cost":
            optionLockCooldownId = 2;
        break;
    }
    if (optionLockCooldown[optionLockCooldownId]) {
        clearTimeout(optionLockCooldown[optionLockCooldownId]);
        optionLockCooldown[optionLockCooldownId] = false;
    }
    option.classList.add("option-locked-alert");
    optionLockCooldown[optionLockCooldownId] = setTimeout(() => {
        option.classList.remove("option-locked-alert");
    }, 1000);
}

let optionActiveCooldown = [];
function optionIsActive(option) {
    //console.log(option.id);
    let optionActiveCooldown = 0;
    switch(option.id) {
        case "levelUpCost":
            optionActiveCooldown = 0;
        break;
        case "spec1Cost":
            optionActiveCooldown = 1;
        break;
        case "spec2Cost":
            optionActiveCooldown = 2;
        break;
    }
    if (optionLockCooldown[optionActiveCooldown]) {
        clearTimeout(optionLockCooldown[optionActiveCooldown]);
        optionLockCooldown[optionActiveCooldown] = false;
    }
    option.classList.add("option-active-alert");
    optionLockCooldown[optionActiveCooldown] = setTimeout(() => {
        option.classList.remove("option-active-alert");
    }, 1000);
}


resize(canvas.width - gridBorderSize, canvas.height - gridBorderSize, canvas);
resize(grid.width - gridBorderSize, grid.height - gridBorderSize, grid);
initGrid(cellSize);
checkScore();

function changeUiColor(color) {
    let newColor;
    if (color < types.length) {
        newColor = types[color];
    }
    else {
        newColor = 120; //vert
    }
    document.documentElement.style.setProperty("--gridColor", "hsl("+ newColor +" ,100%, 50%)");
    document.documentElement.style.setProperty("--gridColorA0-1", "hsla("+ newColor +" ,100%, 50%, .1)");
}
function changeTextColor(color) {
    let newColor;
    if (color < types.length) {
        newColor = types[color];
    }
    else {
        newColor = 120; //vert
    }
    textColor = "hsl("+ newColor + ", 100%, 50%)";
    document.documentElement.style.setProperty("--textColor", "hsl("+ newColor +" ,100%, 50%)");
}
const languageInfo = document.getElementById("languageInfo");
function changeGameLanguage(id) {
    gameLanguage = id;
    //console.log("languageId= "+id);
    updateLanguage();
    if (mobs.length > 0 && !gameIsOver) {
        launchText.textContent = staticTranslations[gameLanguage][toTranslate.length + 19] + " " + waveNumber;
    }
    else if (gameIsOver) {
        launchText.textContent = staticTranslations[gameLanguage][toTranslate.length + 4];
    }
    else if (userHasPickedALevel) {
        launchText.textContent = staticTranslations[gameLanguage][toTranslate.length + 5];    //here0
    }
    else {
        launchText.textContent = "";
    }
    switch(id) {
        case 0: 
            languageInfo.textContent = "en";
        break;
        case 1: 
            languageInfo.textContent = "fr";
        break;
        default:
        break;
    }
}

window.addEventListener("click", function(e) {
    let target = e.target.id;
    mouse.x = e.x - cx;
    mouse.y = e.y - cy;
    //console.log(mouse.x+" "+mouse.y);
    let elementX = e.offsetX - cx;
    let elementY = e.offsetY - cy;
    //console.log(elementX+" "+elementY);
    //console.log("SUBSTR= "+e.target.id);
    //console.log("SUBSTR= "+e.target.className.substr(0, 11));
    //console.log("SUBSTR= "+e.target.id.substr(0, 5));
    //console.log("SUBSTR= "+e.target.id.substr(0, 6));
    if (!userHasPickedALevel) {
        guideline.textContent = guildelineTranslations[gameLanguage][0];
    }
    else if (!selectedTower && !userHasPickedTower && target.substr(0, 5) != "tower") {
        if (waveNumber > 0)
            guideline.textContent = guildelineTranslations[gameLanguage][3];
        else
            guideline.textContent = guildelineTranslations[gameLanguage][1];
    }
    if (target == "canvas" && elementX >= 0 && elementX <= canvas.width && elementY >= 0 && elementY <= canvas.height && !gameIsOver) {
        let cellX = Math.floor(elementX / cellSize);
        let cellY = Math.floor(elementY / cellSize);
        let cellId;
        cellId = gridSize * cellY + cellX;
        //console.log("coord:" +cellX+" "+cellY);
       //console.log("cellId= "+cellId);
        cellulesArray[cellId].onClick();
    }
    else {
        if (selectedTower) {
            if (
                e.target.className != "tower-kills-summary"
                &&
                e.target.id.substr(0, 5) != "tower"
                &&
                e.target.id != "launch"
                &&
                e.target.id.substr(0, 6) != "option"
                &&
                e.target.type != "checkbox"
            )
            {
                selectedTower.isSelected = false;
                selectedTower = false;
                window.removeEventListener("mousemove", hoverOptions);
                clearDatas();
                if (!animationIsOn) {
                    drawContext();
                }
            }
            else if (e.target.id.substr(0, 6) == "option") {
                //console.log("option* "+e.target.id+" sur tour "+selectedTower.towerId);
                //console.log("type= "+selectedTower.towerType+" ;level= "+selectedTower.level);
                let towerId = selectedTower.towerId;
                let option = e.target.id;
                switch(option) {
                    case "optionLevelUp":
                        //console.log(selectedTower.optionLevelUpCost+" et score= "+score);
                        if (selectedTower.level == towersMaxLvl) {
                            optionIsActive(levelUpCost);
                        }
                        else if (selectedTower.optionLevelUpCost > score) {
                            optionIsLocked(levelUpCost);
                        }
                        else if (selectedTower.level < towersMaxLvl) {
                            //towersScore += 10 * towersCost[selectedTower.towerType] * selectedTower.level;
                            //towersScoreBox.textContent = towersScore;
                            selectedTower.value += 10 * towersCost[selectedTower.towerType] * selectedTower.level;
                            selectedTower.level++;
                            //selectedTower.checkOptionsCost();
                            //score -= selectedTower.optionLevelUpCost;
                            selectedTower.upgrade(0);
                            displayDatas(selectedTower.towerId, false);
                            if (!animationIsOn) {
                                drawContext();
                            }
                        }
                    break;
                    case "optionSpec1":
                        if (selectedTower.hasOptionSpec1) {
                            optionIsActive(optionSpec1Cost);
                        }
                        else if (selectedTower.optionSpec1Cost > score) {
                            optionIsLocked(optionSpec1Cost);
                        }
                        else if (!selectedTower.hasOptionSpec1) {
                            //console.log("ajout spec1 sur ");
                            //console.log(selectedTower);
                            selectedTower.hasOptionSpec1 = true;
                            //selectedTower.checkOptionsCost();
                            //score -= selectedTower.optionSpec1Cost;
                            //towersScore += 50 * towersCost[selectedTower.towerType] * 2;
                            //towersScoreBox.textContent = towersScore;
                            selectedTower.value += 50 * towersCost[selectedTower.towerType] * 2;
                            selectedTower.upgrade(1);
                            //selectedTower.updateOptions();
                            //updateTooltip(towers[selectedTower.towerId].effects[gameLanguage][0][1]);
                            displayDatas(selectedTower.towerId, false);
                            if (!animationIsOn) {
                                drawContext();
                            }
                        }
                    break;
                    case "optionSpec2":
                        if (selectedTower.hasOptionSpec2) {
                            optionIsActive(optionSpec2Cost);
                        }
                        else if (selectedTower.optionSpec2Cost > score) {
                            optionIsLocked(optionSpec2Cost);
                        }
                        else if (!selectedTower.hasOptionSpec2) {
                            selectedTower.hasOptionSpec2 = true;
                            //selectedTower.checkOptionsCost();
                            //score -= selectedTower.optionSpec2Cost;
                            //towersScore += 100 * towersCost[selectedTower.towerType] * 3;
                            //towersScoreBox.textContent = towersScore;
                            selectedTower.value += 100 * towersCost[selectedTower.towerType] * 3;
                            selectedTower.upgrade(2);
                            displayDatas(selectedTower.towerId, false);
                            if (!animationIsOn) {
                                drawContext();
                            }
                        }
                    break;
                    default:
                    break;
                }
                //let towerType = selectedTower.towerType;
                //let level = selectedTower.level;
            }
        }
        else if (
            userHasPickedTower
            &&
            e.target.id.substr(0, 5) != "tower"
            &&
            e.target.id != "launch"
            &&
            e.target.id.substr(0, 6) != "option"
            &&
            e.target.type != "checkbox"
            ) {
            //console.log("AAA");
            userHasPickedTower = false;
            window.removeEventListener("mousemove", positionTower);
            guideline.textContent = guildelineTranslations[gameLanguage][3];
            let towerDiv = document.getElementById("towerImage");
            towerDiv.remove();
            clearDatas();
            //console.log("appel de checkScore()");
            checkScore();
            if (!animationIsOn) {
                drawContext();
            }
        }
        if (e.target.className === "tower-kills-summary") {
            if (selectedTower) {
                selectedTower.isSelected = false;
                selectedTower = false;
            }
            selectedTower = towers[e.target.id.substr(-1)];
            selectedTower.isSelected = true;
            selectedTower.updateOptions();
            selectedTower.checkOptionsCost();
            clearDatas();
            displayDatas(e.target.id.substr(-1), false);
            if (!animationIsOn) {
                drawContext();
            }
        }
    }
});

let scrollY = null;
window.addEventListener("scroll", () => {
    //console.log(e);
    //console.log(window.scrollY);
    scrollY = window.scrollY;
    //console.log("scrollY= "+scrollY);
    if (userHasPickedTower) {
        let towerDiv = document.getElementById("towerImage");
        towerDiv.style.top = mouse.y - towerImageRadius + scrollY + "px";
    }
});

function adjustGameSize() {
    let newSize = 0;
    //console.log("window.innerHeight= "+window.innerHeight);
    if (window.innerHeight < canvas.height * 1.5) {
        if (window.innerHeight < 600) {
            newSize = 600;
        }
        else {
            newSize = window.innerHeight;
        }
        //console.log("adjust to "+ (newSize / 1.5 - 30));
        gridSizes = (newSize / 1.5 - 30);
        canvas.width = gridSizes;
        canvas.height = gridSizes;
        grid.width = gridSizes;
        grid.height = gridSizes;
        gridSize = levelsGridSize[pathSeed];
        document.documentElement.style.setProperty("--gridSize", gridSizes + "px");
        document.body.style.setProperty("font-size", ".8em");
        confirmReset = true;
        reset();
        resize(canvas.width - gridBorderSize, canvas.height - gridBorderSize, canvas);
        resize(grid.width - gridBorderSize, grid.height - gridBorderSize, grid);
        initGrid(cellSize);
        updateGrid();
        changeGameLanguage(gameLanguage);
    }
}
adjustGameSize();

quitButton.classList.remove("unlocked-button");
quitButton.classList.add("locked-button");

/* window.addEventListener("resize", () => {
    if (window.innerHeight < canvas.height * 1.5) {
        gridSizes = 500;
        canvas.width = gridSizes;
        canvas.height = gridSizes;
        grid.width = gridSizes;
        grid.height = gridSizes;
        gridSize = levelsGridSize[pathSeed];
        document.documentElement.style.setProperty("--gridSize", gridSizes + "px");
        document.body.style.setProperty("font-size", ".8em");
        resize(canvas.width - gridBorderSize, canvas.height - gridBorderSize, canvas);
        resize(grid.width - gridBorderSize, grid.height - gridBorderSize, grid);
        //initGrid(cellSize);
        updateGrid();
        drawContext();
    }
    else {
        gridSizes = 600;
        canvas.width = gridSizes;
        canvas.height = gridSizes;
        grid.width = gridSizes;
        grid.height = gridSizes;
        gridSize = levelsGridSize[pathSeed];
        document.documentElement.style.setProperty("--gridSize", gridSizes + "px");
        document.body.style.setProperty("font-size", "1em");
        resize(canvas.width - gridBorderSize, canvas.height - gridBorderSize, canvas);
        resize(grid.width - gridBorderSize, grid.height - gridBorderSize, grid);
        //initGrid(cellSize);
        updateGrid();
        drawContext();
    }
    //if (userHasPickedTower) {
    //    let towerDiv = document.getElementById("towerImage");
    //    towerDiv.style.top = mouse.y - towerImageRadius + scrollY + "px";
    //}
}); */
//console.log("total cells= "+cellulesArray.length);
</script>