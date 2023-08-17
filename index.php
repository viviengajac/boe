<?php
    session_start();
    //if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    //    header("location: /index.php");
    //}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance of Elements</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="game-container">
<!--         <div id="tooltip">
            <p id="tooltipEffect"></p>
        </div> -->
        <div class="side-panel">
            <span></span>
            <span></span>
            <span></span>
            <div class="corner-panel" id="scoreUpdateContainer">
                <div class="corner-gradient-background"></div>
                <div class="row-1-1">
                    <div class="title">
                        <h1 id="textGameData">score data</h1>
                    </div>
                </div>
                <div class="column-x2">
                    <div class="row-1-1">
                        <p id="textTowersScore">tours</p>
                        <p>:</p>
                        <p id="towersScore">0</p>
                    </div>
                    <div class="row-1-1">
                        <p id="textBuffer">buffer</p>
                        <p>:</p>
                        <p id="bufferScore">0</p>
                    </div>
                    <div class="row-1-1">
                        <p id="textTotalScore">total</p>
                        <p>:</p>
                        <p id="totalScore">0</p>
                    </div>
                    <div class="row-1-1">
                        <p id="textLastWaveScore">last wave score</p>
                        <p>:</p>
                        <p id="lastWaveScore">0</p>
                    </div>
                    <!-- <div class="row-1-1">
                        <p id="textCreditsMultiplier">credits multiplier</p>
                        <p>:</p>
                        <p id="creditsMultiplier">5%</p>
                    </div> -->
                </div>
                <div id="scoreUpdate">
                    <div id="waveProgressBar"></div>
                </div>
            </div>

            <div class="side-data">                
                <span></span>
                <span></span>
                <div class="vertical-gradient-background"></div>
                <div class="score">
                    <h1 id="textCredits">credits :</h1>
                    <div id="score"></div>
                </div>


                <div class="tower-types" id="towerTypesBox">
                    <h1 id="textNewTower">new tower</h1>
                    <div class="towers-pick">

                        <div class="column">
                            <p style="opacity: 0"></p>
                            <div class="tower-container" style="height: 31px; opacity: 0; pointer-events: none">
                                <div class="tower" style="opacity: 0"></div>
                            </div>
                            <p id="textTowersCosts">cost :</p>
                            <p id="textTowersCounter">nb</p>
                        </div>
                        
                        <div class="column">
                            <p id="textTower0Name">ice</p>
                            <div class="tower-container" id="pick0" onclick="pickTower(0)">
                                <div class="tower" id="tower0"></div>
                            </div>
                            <p>100</p>
                            <p id="towerCount0">0</p>
                        </div>

                        <div class="column">
                            <p id="textTower1Name">water</p>
                            <div class="tower-container" id="pick1" onclick="pickTower(1)">
                                <div class="tower" id="tower1"></div>
                            </div>
                            <p>200</p>
                            <p id="towerCount1">0</p>
                        </div>

                        <div class="column">
                            <p id="textTower2Name">fire</p>
                            <div class="tower-container" id="pick2" onclick="pickTower(2)">
                                <div class="tower" id="tower2"></div>
                            </div>
                            <p>500</p>
                            <p id="towerCount2">0</p>
                        </div>

                        <div class="column">
                            <p id="textTower3Name">lightning</p>
                            <div class="tower-container" id="pick3" onclick="pickTower(3)">
                                <div class="tower" id="tower3"></div>
                            </div>
                            <p>1,000</p>
                            <p id="towerCount3">0</p>
                        </div>
                        
                        <div class="column">
                            <p id="textTower4Name">dark</p>
                            <div class="tower-container" id="pick4" onclick="pickTower(4)">
                                <div class="tower" id="tower4"></div>
                            </div>
                            <p>2,000</p>
                            <p id="towerCount4">0</p>
                        </div>

                    </div>
                </div>
                
                <div class="panel-selected-item">
                    <span></span>
                    <div class="selected-item-desc" id="selected-item-desc">
                        <h1 class="text-shadow-animation" id="textGuideline">select a map</h1>
                    </div>
                    <div class="row-1-1-1" id="selected-item-name">
                        <h1 id="itemName"></h1>
                        <h1 id="itemCost"></h1>
                    </div>
                    <div class="column-x2 selected-item-data" id="selected-item-data">
                        <div class="row-1-1">
                            <p id="textLevel">level</p>
                            <p>:</p>
                            <p id="selected-item-level"></p>
                        </div>
                        <div class="row-1-1">
                            <p id="textRadius">radius</p>
                            <p>:</p>
                            <p id="selected-item-radius"></p>
                        </div>
                        <div class="row-1-1">
                            <p id="textDamage">damage</p>
                            <p>:</p>
                            <p id="selected-item-damage"></p>
                        </div>
                        <div class="row-1-1">
                            <p id="textHealing">healing</p>
                            <p>:</p>
                            <p id="selected-item-heal"></p>
                        </div>
                    </div>

                    <div class="title">
                        <p id="selectedTowerId"></p>
                    </div>
                        
                        <div class="column-x3 selected-item-data" id="selected-item-stats">
                            <div class="row-1-1">
                                <p id="textKills">kills</p>
                                <p>:</p>
                                <p id="selectedTowerKills"></p>
                            </div>
                            <div class="row-1-1">
                                <p id="textDamage2">damage</p>
                                <p>:</p>
                                <p id="selectedTowerDamage"></p>
                            </div>
                            <div class="row-1-1">
                                <p id="textHeal">heals</p>
                                <p>:</p>
                                <p id="selectedTowerHeals"></p>
                            </div>
                            <div class="row-1-1">
                                <p id="textHealing2">healing</p>
                                <p>:</p>
                                <p id="selectedTowerHealing"></p>
                            </div>
                            <div class="row-1-1">
                                <p id="textValue">value</p>
                                <p>:</p>
                                <p id="selectedTowerValue"></p>
                            </div>
                            <div class="row-1-1">
                                <p id="textEffectiveCost">effective cost</p>
                                <p>:</p>
                                <p id="selectedTowerEffectiveCost"></p>
                            </div>
                        </div>

                    <div class="row-1--2"></div>

                    <div class="column-x3" id="selectedItemOptions">
                        <div class="row-x1">
                            <div class="selected-item-option-display">
                                <p id="textSelectedItemOptionsDisplay">hover an upgrade</p>
                            </div>
                        </div>
                        <div class="row-x1">
                            <div class="selected-item-option" id="optionLevelUp"></div>
                            <div class="selected-item-option" id="optionSpec1"></div>
                            <div class="selected-item-option" id="optionSpec2"></div>
                            <div class="selected-item-option" id="optionDestroy" onclick="destroyTower()"></div>
                        </div>
                        <div class="row-x1" id="optionsCost">
                            <p id="levelUpCost"></p>
                            <p id="spec1Cost"></p>
                            <p id="spec2Cost"></p>
                            <p></p>
                        </div>
                    </div>
                    
                </div>

                <!-- <div class="tower-container" id="pick0" onclick="pickTower(0)">
                    <div class="tower" id="tower0"></div>
                    <p>Ice Tower</p>
                    <p>Damage: 1</p>
                    <div class="tower-cost">100</div>
                </div>
                <div class="tower-container" id="pick1"  onclick="pickTower(1)">
                    <div class="tower" id="tower1"></div>
                    <p>Water Tower</p>
                    <p>Damage: 2</p>
                    <div class="tower-cost">200</div>
                </div>
                <div class="tower-container" id="pick2"  onclick="pickTower(2)">
                    <div class="tower" id="tower2"></div>
                    <p>Fire Tower</p>
                    <p>Damage: 3</p>
                    <div class="tower-cost">500</div>
                </div>
                <div class="tower-container" id="pick3"  onclick="pickTower(3)">
                    <div class="tower" id="tower3"></div>
                    <p>Electric Tower</p>
                    <p>Damage: 4</p>
                <div class="tower-cost">1 000</div>
                </div>
                <div class="tower-container" id="pick4"  onclick="pickTower(4)">
                    <div class="tower" id="tower4"></div>
                    <p>Dark Tower</p>
                    <p>Damage: 5</p>
                    <div class="tower-cost">2 000</div>
                </div> -->
            </div>
           <!--  <div class="user-data">
    
            </div> -->

           

            <div class="corner-panel">
                <div class="corner-gradient-background"></div>
                <!-- <div class="row-1-1">
                    <div class="display-user-guide" onclick="displayUserGuide()">
                        <p>Guide utilisateur</p>
                    </div>
                </div> -->
                <div class="game-version">
                    <div class="row">
                        <div class="title">
                            <h1>balance of elements</h1>
                        </div>
                    </div>
                    <div class="row-1-1">
                        <div class="display-user-guide" onclick="displayUserGuide()">
                            <p>Guide utilisateur</p>
                        </div>
                        <p id="gameVersion">version : 0.2.081723</p>
                    </div>
                </div>
            </div>

        </div>



        
        <div class="canvas-container">
            <div class="panel">
                <span></span>
                <div class="wave-data">
                    <span></span>
                    <span></span>
                    <div class="horizontal-gradient-background"></div>
                    <div class="title">
                        <h1 id="textWaveId">current wave</h1>
                    </div>
                    <div class="row-x2">
                        <p id="textHp1">hp</p>
                        <p id="textSpeed1">speed</p>
                        <div id="mobsHp"></div>
                        <div id="mobsSpeed"></div>
                    </div>
                    <div class="row-x2">
                        <p id="textElement1">element</p>
                        <p id="textLeft1">left</p>
                        <div class="mobsType">
                            <div id="mobsType"></div>
                        </div>
                        <div id="mobsLeft"></div>
                    </div>

                </div>
                <div class="panel-top-center">
                    <div class="top-square">
                        <div class="centered-gradient-background"></div>
                        <!-- <div class="ui-color-settings">
                            <div class="title">
                                <h1 id="textSettings">settings</h1>
                            </div>
                            <div class="row-1-1">
                                <div class="label" for="uiColorPick" id="textInterfaceColor">interface color</div>
                                <div class="select" name="uiColorPick" id="uiColorPick">
                                    <input id="colorPickInput" type="checkbox">
                                    <div id="colorPickBefore"></div>
                                    <div class="options-list" id="changeUiColor">
                                        <div class="option" onclick="changeUiColor(0)"></div>
                                        <div class="option" onclick="changeUiColor(1)"></div>
                                        <div class="option" onclick="changeUiColor(2)"></div>
                                        <div class="option" onclick="changeUiColor(3)"></div>
                                        <div class="option" onclick="changeUiColor(4)"></div>
                                        <div class="option" onclick="changeUiColor(5)"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row-1-1">
                                <div class="label" for="txtColorPick" id="textTxtColor">text color</div>
                                <div class="select" name="txtColorPick" id="txtColorPick">
                                    <input id="colorPickInput" type="checkbox">
                                    <div id="colorPickBefore"></div>
                                    <div class="options-list">
                                        <div class="option" onclick="changeTextColor(0)"></div>
                                        <div class="option" onclick="changeTextColor(1)"></div>
                                        <div class="option" onclick="changeTextColor(2)"></div>
                                        <div class="option" onclick="changeTextColor(3)"></div>
                                        <div class="option" onclick="changeTextColor(4)"></div>
                                        <div class="option" onclick="changeTextColor(5)"></div>
                                    </div>
                                </div>
                            </div>

                        </div> -->
                        
                        <div class="defeat-warning">
                            <p id="textDefeatWarning">safe zone</p>
                            <p id="safeScore"></p>
                            <div id="defeatWarningBar">
                                <!-- <div id="defeatWarningCursor"></div> -->
                            </div>
                        </div>

                    </div>
                    <button class="text-shadow-animation" id="launchButton" onclick="waveInit()">
                        <h2 id="launch">launch</h2>
                    </button>
                </div>

                <div class="wave-data">
                    <span></span>
                    <span></span>
                    <div class="horizontal-gradient-background"></div>
                    <div class="title">
                        <h1 id="textNextWave">next wave</h1>
                    </div>
                    <div class="row-x2">
                        <p id="textHp2">hp</p>
                        <p id="textSpeed2">speed</p>
                        <div id="mobsHpNext"></div>
                        <div id="mobsSpeedNext"></div>
                    </div>
                    <div class="row-x2">
                        <p id="textElement2">element</p>
                        <p id="textLeft2">left</p>
                        <div class="mobsType">
                            <div id="mobsTypeNext"></div>
                        </div>
                        <div id="mobsLeftNext"></div>
                    </div>

                   
                </div>

            </div>
            <canvas id="canvas"></canvas>
            <canvas id="grid"></canvas>
            <div class="panel" id="topPlayers">
                <span></span>
                <span></span>
                <div class="horizontal-gradient-background"></div>
                <div class="title">
                    <h1 id="textTopPlayersTitle">top scores</h1>
                </div>
                <div class="player-top-score" id="topPlayersDesc">
                        <p>#</p>
                        <p id="textPlayerName">playername</p>
                        <p>score</p>
                        <p id="textPlayerWave">wave</p>
                    </div>
                <div class="players-list" id="playersList"></div>
            </div>
            <span></span>
        </div>

        <div class="side-panel">
            <span></span>
            <span></span>
            <span></span>
            <div class="corner-panel">
                <div class="corner-gradient-background"></div>
                <div class="row-1-1-1">
                    <div class="title">
                        <h1 id="textMobsdata">mobs data</h1>
                    </div>
                </div>
                <div class="column-x2">
                    <div class="row-1-1">
                        <p id="textTotalMobs">total mobs</p>
                        <p>:</p>
                        <p id="totalMobs">0</p>
                    </div>
                    <div class="row-1-1">
                        <p id="textMobsKilled">mobs killed</p>
                        <p>:</p>
                        <p id="mobsKilled">0</p>
                    </div>
                    <div class="row-1-1">
                        <p id="textMobsHealed">mobs healed</p>
                        <p>:</p>
                        <p id="mobsHealed">0</p>
                    </div>
                    <div class="row-1-1">
                        <p id="textLoopers">loopers</p>
                        <p>:</p>
                        <p id="loopers">0 / 20</p>
                    </div>
                </div>

            </div>

            <div class="side-data">
                <span></span>
                <span></span>
                <div class="vertical-gradient-background"></div>

                <div id="levelsPickContainer"">
                    <div class="row-1-1">
                        <span></span>
                        <div class="title">
                            <h1 id="textPreviewMapName">maps list</h1>
                        </div>
                    </div>
                    
                    <div id="mapsList"></div>
                <!--<div class="level-pick" id="level0">
                        <h1 id="levelPickName">level name</h1>
                        <p>level description blabla blabla</p>
                        <div class="level-pick-preview" id="previewLevel0" onclick="previewLevel(0)">preview</div>
                        <div class="level-pick-select" id="selectLevel0" onclick="pickLevel(0)">select</div>
                    </div>-->
                    
                </div>
                <div id="levelDatas">
                    <div class="row-1-1">
                        <span></span>
                        <div class="title">
                            <h1 id="levelName"></h1>
                        </div>
                    </div>
                    

                    <div class="towers-inventory">
                        <div class="row-1-1">
                            <div class="title">
                                <h1 id="textTowersInventory" style="opacity: 0">towers inventory</h1>
                            </div>
                        </div>
                        <div class="column-x2">

                        </div>
                    </div>

                </div>
                <div class="game-status">
                    <div id="confirmButton" class="locked-button" onclick="pickLevel()">start</div>
                    <div id="quitButton" class="locked-button" onclick="reset()">quit</div>
                    <!-- <div id="cancelButton" onclick="cancelReset()">cancel</div> -->
                </div>
            </div>
            
            <div class="corner-panel">
                <div class="corner-gradient-background"></div>
                <div class="ui-color-settings">
                            <div class="title">
                                <h1 id="textSettings">settings</h1>
                            </div>
                            <div class="row-1-1">
                                <div class="select" name="uiColorPick" id="uiColorPick">
                                    <input id="colorPickInput" type="checkbox">
                                    <div id="colorPickBefore"></div>
                                    <div class="options-list" id="changeUiColor">
                                        <div class="option" onclick="changeUiColor(0)"></div>
                                        <div class="option" onclick="changeUiColor(1)"></div>
                                        <div class="option" onclick="changeUiColor(2)"></div>
                                        <div class="option" onclick="changeUiColor(3)"></div>
                                        <div class="option" onclick="changeUiColor(4)"></div>
                                        <div class="option" onclick="changeUiColor(5)"></div>
                                    </div>
                                </div>                                
                                <div class="label" for="uiColorPick" id="textInterfaceColor">interface color</div>
                            </div>

                            <div class="row-1-1">
                                <div class="select" name="txtColorPick" id="txtColorPick">
                                    <input id="colorPickInput" type="checkbox">
                                    <div id="colorPickBefore"></div>
                                    <div class="options-list">
                                        <div class="option" onclick="changeTextColor(0)"></div>
                                        <div class="option" onclick="changeTextColor(1)"></div>
                                        <div class="option" onclick="changeTextColor(2)"></div>
                                        <div class="option" onclick="changeTextColor(3)"></div>
                                        <div class="option" onclick="changeTextColor(4)"></div>
                                        <div class="option" onclick="changeTextColor(5)"></div>
                                    </div>
                                </div>
                                <div class="label" for="txtColorPick" id="textTxtColor">text color</div>
                            </div>

                            <div class="row-1-1">
                            <div class="selectLanguage" name="languagePick" id="languagePick">
                                    <p id="languageInfo">fr</p>
                                    <input id="languagePickInput" type="checkbox">
                                    <div id="languagePickBefore"></div>
                                    <div class="options-list" id="changeGameLanguage">
                                        <div class="option" onclick="changeGameLanguage(0)">english</div>
                                        <div class="option" onclick="changeGameLanguage(1)">français</div>
                                    </div>
                                </div>
                                <div class="label" for="languagePick" id="textLanguageColor">game language</div>
                            </div>

                        </div>
            </div>

        </div>
    
        
    </div>
    <div id="tooltip">
        <p id="tooltipEffect"></p>
        <p id="tooltipCooldown"></p>
    </div>
    <div id="gameSummary">
        
        <form class="summary-container" action="function/submit_score.php" method="post">
            <div class="title">
                <h1 id="textSummary">summary</h1>
            </div>
            <p id="mapName" name="mapName"></p>
            <input type="text" id="mapId" name="mapId">
            <input type="text" id="playerName" name="playerName" maxlength="15" placeholder="enter your name" required>
            <p id="textSummaryFinalScore">final score</p>
            <input type="text" id="playerScore" name="playerScore">
            <p id="displayPlayerScore">0</p>
            <p id="textSummaryLastWave">last wave</p>
            <input type="text" id="lastWave" name="lastWave">
            <input type="submit" value="submit">
            <div id="closeSubmit" onclick="closeSubmit()"></div>
        </form>
    </div>
    <div class="loading-screen">
        <div class="game-intro">
            <p>balance</p>
            <p>of</p>
            <p>elements</p>
            <p>tower defense</p>
        </div>
    </div>
    <div id="userGuide">
        <div class="user-guide-control">
            <div id="closeUserGuide" onclick="closeUserGuide()"></div>
        </div>
        <iframe src="https://onedrive.live.com/embed?resid=2D98818649028A98%218426&amp;authkey=%21ALbAGOqX8xorBN0&amp;em=2&amp;wdPrint=0&amp;wdEmbedCode=0" frameborder="0"></iframe>
    </div>
    <!-- <script src="script.js"></script> -->
    <?php include("script.php"); ?>
</body>
</html>