
<?php

#inclusion des calculs sources

//https://s144-fr.ogame.gameforge.com/api/playerData.xml?id=100178
//https://s144-fr.ogame.gameforge.com/api/players.xml

### Calculs et params ###

# Initialisation des variabes du compteur #
$icon = "icon.ico";
$dataPathGlobal = "";
$prodH = $_POST['prodH'];
$stock = $_POST['stock'];
$need = $_POST['need'];
$energy = $_POST['energy'];


$aResourceType  = array('METAL','CRISTAL','DEUT');
$aResourceTypeShort = array('m','c','d');


## nom du joueur, en cas de plusieurs comptes ##
$aAccount = array(
	0=>array('Eanae','144',90,45),
	1 =>array('Emphurio','144',90,45),
	2 =>array('Emphurio','140',150,75),
	);


## Enregistrement du COMPTE ##
if (isset($_POST['account'.$planeteKey])){
	//On s'assure qu'il existe, sinon on le créé
	wLogRead($dataPathGlobal,'account');
	// On efface les valeurs de chaque resources dans le fichier correspondant
	wCountErase($dataPathGlobal,'account');
	// On ajoute les nouvelles valeurs
	wCountAdd($dataPathGlobal,'account',$_POST['account']);
}
# COMPTE selectionné #
$accountSelected = wLogRead($dataPathGlobal,'account');


## Nombre de Niveaux des mines ##
$i = 1;
while ($i <= 31){
    $mineLevels[] = $i-1;
    $i++;
}

$urlImgBg = 'https://s144-fr.ogame.gameforge.com/headerCache/station/';

## Tableau des données du compte (planète, coordonées, url de l'image) ##

# saisissez ici les informations de vos planètes
$aPlanete = array(
	0 => array('EnunE','[4:28:9]',0,$aAccount[0][1],'3','32','gf1.geo.gfsrv.net/cdnfa/bcb9c1fd9e0fe970c82ea66f7a3400.png',$urlImgBg.'normal.jpg','227','28',$aAccount[0][2],$aAccount[2][3]),
	1 => array('GalaG','[1:416:4]',1,$aAccount[1][1],'3','64','gf2.geo.gfsrv.net/cdn49/3d25e752f36cfed704bbfba4d78870.png',$urlImgBg.'ice.jpg','188','34',$aAccount[1][2],$aAccount[1][3]),
	3 => array('OqobO','[7:35:9]',0,$aAccount[0][1],'3','34','gf3.geo.gfsrv.net/cdnbe/1757e1263534f3fdd03caac5b2a7cf.png',$urlImgBg.'water.jpg','243','29',$aAccount[0][2],$aAccount[2][3]),
	4 => array('AiriA','[7:34:9]',1,$aAccount[1][1],'3','44','gf1.geo.gfsrv.net/cdn6b/a39518223ab20be9536510771a46d3.png',$urlImgBg.'jungle.jpg','229','30',$aAccount[1][2],$aAccount[1][3]),
	5 => array('UquqU','[7:35:10]',0,$aAccount[0][1],'3','10','gf1.geo.gfsrv.net/cdnf0/24b34c7443f3b64e74bd08a3aa609c.png',$urlImgBg.'ice.jpg','205','25',$aAccount[0][2],$aAccount[2][3]),
	6 => array('AqqA','[7:34:10]',0,$aAccount[0][1],'3','29','gf3.geo.gfsrv.net/cdnbe/1757e1263534f3fdd03caac5b2a7cf.png',$urlImgBg.'jungle.jpg','215','28',$aAccount[0][2],$aAccount[2][3]),
	7 => array('IqibI','[7:35:13]',0,$aAccount[0][1],'3','-50','gf2.geo.gfsrv.net/cdna1/1c65896e5dfbf7b1267f7d0fdbd32f.png',$urlImgBg.'gas_14_21.jpg','163','15',$aAccount[0][2],$aAccount[2][3]),
	8 => array('IabaI','[4:483:9]',1,$aAccount[1][1],'3','46','gf1.geo.gfsrv.net/cdn08/0cc75bf5cf156fc585372cf41a7508.png',$urlImgBg.'water.jpg','231','34',$aAccount[1][2],$aAccount[1][3]),
	9 => array('Aibia','[4:483:13]',1,$aAccount[1][1],'3','-43','gf1.geo.gfsrv.net/cdnc4/e4be5926248e1e5402de26bfeb6965.png',$urlImgBg.'gas_14.jpg','169','16',$aAccount[1][2],$aAccount[1][3]),
	2 => array('LagaL','[1:416:9]',1,$aAccount[1][1],'3','36','gf1.geo.gfsrv.net/cdn69/9ad60afcc1cffcb6870d31053f9eaf.png',$urlImgBg.'jungle_14.jpg','216','29',$aAccount[1][2],$aAccount[1][3]),
	10 => array('YqY','[7:120:9]',0,$aAccount[0][1],'3','47','gf3.geo.gfsrv.net/cdn5f/9d6624c2c613cc59c18a39fc6f5ae6.png',$urlImgBg.'jungle_14_21.jpg','210','31',$aAccount[0][2],$aAccount[2][3]),
	11 => array('PM','[1:344:6]',2,$aAccount[2][1],'5','51','gf3.geo.gfsrv.net/cdn5f/9d6624c2c613cc59c18a39fc6f5ae6.png',$urlImgBg.'jungle_14_21.jpg','210','31',$aAccount[2][2],$aAccount[2][3]),
	);
# $aPlanete = array(array(NomPlanete,Coordonnées,nomJoueur,Serveur,Vitesse Prod,TempMax,urlImage,nbCase,prodSatellite,baseMetal, baseCristal))
# pour récupérer l'url de l'image d'une planète, faites un clic droit sur la planète puis "inspecter l'élément"
# ce tableau regroupe en un seul endroit tous les comptes que vous pouvez avoir. Renseignez donc bien le serveur, la vitesse éventuel du serveur ainsi que votre nom de joueur sur le serveur


## Serveurs ##
$aServeur = array('144' => 'Rhéa');

# Elements du MENU #
$aMenu = array(
	0 => array('stockFuture','Futur stock'),
	1 => array('timeNeed','Temps nécessaire'),
	2 => array('satelliteNeed','Nb Satellites'),
	3 => array('defensePossible','Nb Défense'),
	4 => array('vaisseauPossible','Nb vaisseau'),
	5 => array('endTime','Heure de fin'),
	6 => array('needPT','Nb Transporteur')
	);

# Type de DEFENSES #
$aDefense = array(
	0 => array('Lance(s) Missiles','2000','0','0'),
	1 => array('Artillerie laser légère','1500','500','0'),
	2 => array('Artillerie laser lourde','6000','2000','0'),
	3 => array('Canon(s) de Gauss','20000','15000','2000'),
	4 => array('Artillerie à ions','2000','6000','0'),
	5 => array('Lanceur(s) de plasma','50000','50000','30000'),
	6 => array('Missile(s) Interception','8000','0','2000'),
	7 => array('Missile(s) interplanétaire(s)','12000','2500','10000')
	);

# Type de VAISSEAUX #
$aVaisseau = array(
	0 => array('Sonde(s) espionnage(s)','0','1000','0'),
	1 => array('Petit(s) Transporteur(s)','2000','2000','0'),
	2 => array('Grand(s) Transporteur(s)','6000','6000','0'),
	3 => array('Recycleur(s)','10000','6000','2000'),
	4 => array('Vaisseau(x) de colonisation','10000','20000','10000'),
	5 => array('Chasseur(s) léger(s)','3000','1000','0'),
	6 => array('Chasseur(s) lourd(s)','6000','4000','0'),
	7 => array('Croiseurs','20000','7000','2000'),
	8 => array('Vaisseau de bataille','45000','15000','0'),
	9 => array('Traqueur(s)','30000','40000','15000'),
	10 => array('Bombardier(s)','50000','25000','15000'),
	11 => array('Destructeur(s)','60000','50000','15000'),
	12 => array('Etoile(s) de la mort','5000000','4000000','1000000')
	);


## SELECTION d'une PLANETE ##
	if (isset($_POST['planete'])){
		//On s'assure qu'il existe, sinon on le créé
		wLogRead($dataPathGlobal,'planete');
		// On efface les valeurs de chaque resources dans le fichier correspondant
		wCountErase($dataPathGlobal,'planete');
		// On ajoute les nouvelles valeurs
		wCountAdd($dataPathGlobal,'planete',$_POST['planete']);
	}
	#Si envoyé depuis EMPIRE en GET ->
	elseif(isset($_GET['planete'])){
		//On s'assure qu'il existe, sinon on le créé
		wLogRead($dataPathGlobal,'planete');
		// On efface les valeurs de chaque resources dans le fichier correspondant
		wCountErase($dataPathGlobal,'planete');
		// On ajoute les nouvelles valeurs
		wCountAdd($dataPathGlobal,'planete',$_GET['planete']);
	}

	if (isset($_POST['account'])){
		//On s'assure qu'il existe, sinon on le créé
		wLogRead($dataPathGlobal,'planete');
		// On efface les valeurs de chaque resources dans le fichier correspondant
		wCountErase($dataPathGlobal,'planete');
	}

## Initialisation des divers infos liées à la planète sélectionnée ##
	$planeteKey = wLogRead($dataPathGlobal,'planete');

	$planeteName = $aPlanete[$planeteKey][0];
	$planeteCoordonate = $aPlanete[$planeteKey][1];
	$planetePlayer = $aPlanete[$planeteKey][2];
	$planeteUniName = $aPlanete[$planeteKey][3];
	$uniSpeedProd = $aPlanete[$planeteKey][4];
	$planeteTempMax = $aPlanete[$planeteKey][5];
	$planeteImage = $aPlanete[$planeteKey][6];
	$planeteBg = $aPlanete[$planeteKey][7];
	$planeteNbCase = $aPlanete[$planeteKey][8];
	$satProd = $aPlanete[$planeteKey][9];
	$baseMetal=$aPlanete[$planeteKey][10];
	$baseCristal=$aPlanete[$planeteKey][11];


## STOCK ##
	#Enregistrement des valeurs de stock soumises #
	foreach ($aResourceTypeShort as $key => $value) {
		if (isset($_POST['stock'.$value])){
			//On s'assure qu'il existe, sinon on le créé
			wLogRead($dataPathGlobal,'stock'.$value);
			// On efface les valeurs de chaque resources dans le fichier correspondant
			wCountErase($dataPathGlobal,'stock'.$value);
			// On ajoute les nouvelles valeurs
			wCountAdd($dataPathGlobal,'stock'.$value,$_POST['stock'.$value]);
		}
	}

	# stock actuel
	$currenStock = array();
	foreach ($aResourceTypeShort as $key => $value) {
		$currenStock[$key] = wLogRead($dataPathGlobal,'stock'.$value);
	}

	# On calcule le stock actuel TOTAL
	$totalCurrentStock = 0;
	foreach ($aResourceTypeShort as $key => $value) {
		$totalCurrentStock = $totalCurrentStock+$currenStock[$key];
	}


## CALCUL du nb de DEFENSE possible avec chaque ressource ##
	$typeDefense = $_POST['typeDefense'];
	$nbWith = array();
	foreach ($aResourceTypeShort as $key => $value) {
		if($aDefense[$typeDefense][$key+1]==0){
			continue;
		}
		else{
			// on arondi à l'inférieur avec floor()
			$nbWith[$key] = floor($currenStock[$key]/$aDefense[$typeDefense][$key+1]);
		}
	}
	if(isset($_POST['typeDefense'])){
		$min = min($nbWith);
	}


## CALCUL du nb de VAISSEAUX possibles avec chaque ressource ##
	$typeVaisseau = $_POST['typeVaisseau'];
	$nbVaisseauWith = array();
	foreach ($aResourceTypeShort as $key => $value) {
		if($aVaisseau[$typeVaisseau][$key+1]==0){
			continue;
		}
		else{
			// on arondi à l'inférieur avec floor()
			$nbVaisseauWith[$key] = floor($currenStock[$key]/$aVaisseau[$typeVaisseau][$key+1]);
		}
	}
	# Stock restant si on construit le nombre de vaisseaux possible
	$stockRemaining = array();
	if(isset($_POST['typeVaisseau'])){
		$minVaisseau = min($nbVaisseauWith);
		foreach ($aResourceTypeShort as $key => $value) {
			$stockRemaining[$key] = $currenStock[$key]-($aVaisseau[$typeVaisseau][$key+1]*min($nbVaisseauWith));
		}
	}


## CALCUL du nb de SATELLITE nécessaires ##
	if($energy!=""){
		$calculSat = ($energy/$satProd);
		$satNeed = ceil($calculSat);

		$prodSatFinale = $satProd*$satNeed;
		$prodExced = $prodSatFinale-$energy;

		$cristalCost = 2000;
		$deutCost = 500;

		$totalCristalCost = $cristalCost*$satNeed;
		$totalDeutCost = $deutCost*$satNeed;
	}


## Enregistrement des valeurs de Prod./H soumises ##
	foreach ($aResourceTypeShort as $key => $value) {
		if (isset($_POST['prodH'.$value.$planeteKey])){
			//On s'assure qu'il existe, sinon on le créé
			wLogRead($dataPathGlobal,'prodH'.$value.$planeteKey);
			// On efface les valeurs de chaque resources dans le fichier correspondant
			wCountErase($dataPathGlobal,'prodH'.$value.$planeteKey);
			// On ajoute les nouvelles valeurs
			wCountAdd($dataPathGlobal,'prodH'.$value.$planeteKey,$_POST['prodH'.$value.$planeteKey]);
		}
	}

## Enregistrement de la valeur lvl mines soumise ##
	foreach ($aResourceTypeShort as $key => $value) {
		if (isset($_POST['level'.$value.$planeteKey])){
			//On s'assure qu'il existe, sinon on le créé
			wLogRead($dataPathGlobal,'levelmine'.$value.$planeteKey);
			// On efface les valeurs de chaque resources dans le fichier correspondant
			wCountErase($dataPathGlobal,'levelmine'.$value.$planeteKey);
			// On ajoute les nouvelles valeurs
			wCountAdd($dataPathGlobal,'levelmine'.$value.$planeteKey,$_POST['level'.$value.$planeteKey]);
		}
	}

## Enregistrement de la valeur lvl CEF soumise ##
	if (isset($_POST['levelCEF'.$planeteKey])){
		//On s'assure qu'il existe, sinon on le créé
		wLogRead($dataPathGlobal,'levelCEF'.$planeteKey);
		// On efface les valeurs de chaque resources dans le fichier correspondant
		wCountErase($dataPathGlobal,'levelCEF'.$planeteKey);
		// On ajoute les nouvelles valeurs
		wCountAdd($dataPathGlobal,'levelCEF'.$planeteKey,$_POST['levelCEF'.$planeteKey]);
	}


## CALCUL du TEMPS nécessaire pour atteindre un stock souhaité ##
	if($prodH!="" && $stock!="" && $need!=""){
		$prodDay = $prodH*24;
		$timeNeed = (($need-$stock)/$prodH)*3600;
		$timeInteger = ceil($timeNeed);
	}

## Enregistrement du lvl de chaque Mine
	$levelResource = array();
	foreach ($aResourceTypeShort as $key => $value) {
		$levelResource[$key] = wLogRead($dataPathGlobal,'levelmine'.$value.$planeteKey);
	}

## LEVEL de CEF ##
	$level_CEF = wLogRead($dataPathGlobal,'levelCEF'.$planeteKey);

##On calcule la production H ##
	// Pour la CEF
	$prod_H_CEF = ceil((10*$level_CEF*pow(1.1,$level_CEF))*$uniSpeedProd);

	// pour les mine
	$prod_H_[0] = ceil((((30 * $levelResource[0]) * pow(1.1,$levelResource[0]))*$uniSpeedProd)+$baseMetal);
	$prod_H_[1] = ceil((((20 * $levelResource[1]) * pow(1.1,$levelResource[1]))*$uniSpeedProd)+$baseCristal);
	$prod_H_[2] = floor(((10 * $levelResource[2]) * pow(1.1,$levelResource[2])*(1.44 - 0.004 *$planeteTempMax))*$uniSpeedProd-$prod_H_CEF);



## LEVEL des MINES ##
	$level_mine = array();
	foreach ($aResourceTypeShort as $key => $value) {
		$level_mine[$key] = wLogRead($dataPathGlobal,'levelmine'.$value.$planeteKey);
	}


## On calcule la production H TOTALE ##
	$totalProdH = 0;
	foreach ($aResourceTypeShort as $key => $value) {
		$totalProdH = $totalProdH+$prod_H_[$key];
	}


## Production JOUR ##
	#  On calcule la production J pour chaque resources #
	$prodJ = array();
	foreach ($aResourceTypeShort as $key => $value) {
		$prodJ[$key] = $prod_H_[$key]*24;
	}
	# On calcule la production J TOTALE
	$totalProdJ = 0;
	foreach ($aResourceTypeShort as $key => $value) {
		$totalProdJ = $totalProdJ+$prodJ[$key];
	}


## TRANSPORTEURS #

# Calcul du nb de Transporteurs recommandés #
$recoPT = ceil(($totalProdJ*1.2)/5000);
$recoGT = ceil(($totalProdJ*1.2)/25000);

$PTneed = ceil(($totalCurrentStock*1.2)/5000);
$GTneed = ceil(($totalCurrentStock*1.2)/25000);


# Calcul du nombre de PT en fonction des resources #
$resourceToFret = $_POST['resourceToFret'];
$needPT = 0;
$typeTransport = 0;
if (isset($resourceToFret)){
	if($_POST['typeTransport']==1){
		$needPT = ceil(($resourceToFret)/5000);
		$typeTransport = 1;
		$excedant = ($needPT*5000) - $resourceToFret;
	}
	elseif ($_POST['typeTransport']==2) {
		$needPT = ceil(($resourceToFret)/25000);
		$typeTransport = 2;
		$excedant = ($needPT*25000) - $resourceToFret;
	}
}


# calculs stock futur #
$futurStock = array();
foreach ($aResourceTypeShort as $key => $value) {
	if(isset($_POST['nbHour'])){
		if($key==2){
			$futurStock[$key] = $currenStock[$key]+(($prod_H_[$key]-$prod_H_CEF)*$_POST['nbHour']);
		}
		else{
			$futurStock[$key] = $currenStock[$key]+($prod_H_[$key]*$_POST['nbHour']);
		}
	}
	else{
		$futurStock[$key] = 0;
	}
	
}



# Calcul de temps #
/*
* Permet de passer à la minute > quand $seconde > 60
* Puis de passer à l'heure > quand $minute > 60
*/
$temp = $timeInteger % 3600; 

#heures
$time[0] = ( $timeInteger - $temp ) / 3600 ; 
$heure = $time[0].'h';

#secondes
$time[2] = $temp % 60 ;
$seconde = $time[2].' sec';

#minute
$time[1] = ( $temp - $time[2] ) / 60;
$minute = $time[1].' min';
