<?php
// code by mousshk@gmail.com
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Europe/Paris");
#inclusion des fonctions
include('fonctions.php');
#inclusion des calculs sources
include('source.php');

//echo $_GET['planete'];
echo '<pre>';
var_dump($aAccount);
echo '</pre>';
?>
<head>

<!-- Le meta magique pour les appareils mobiles :)-->
<meta name="viewport" content="width=device-width, maximum-scale=1"/>

<!-- Inclusion de l'icone d'onglet -->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $icon; ?>" />
<!-- Inclusion de la CSS -->
<link rel="stylesheet" type="text/css" href="style.css">
<!-- Inclusion des .js -->
<script type="text/javascript" src="jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="actions.js"></script>

<!-- style pour cacher/afficher les div -->
<style type="text/css">
<?php 
foreach ($aMenu as $key => $value) {
	echo '#'.$aMenu[$key][0].'{
    	display:none;
	}';
	echo'
	#'.$aMenu[$key][0].':target {
    display:block;
	}';
}
?>
</style>
<title>Ogame Simulateur (<?php echo $planeteName.' '.$planeteCoordonate; ?>)</title>
</head>

<body>
<div class="wrapper">
		<header>
		    <a class="to_nav" href="#primary_nav">Menu</a>
		</header>

		<h1> Ogame Simulateur </h1>
		<!-- Menu -->
		

			<nav id="primary_nav" class="menuHead">
			    <ul>
			        <?php
					# Génération du Menu
					echo '<li><a href="empire.php">Empire</a></li>';
					foreach ($aMenu as $key => $value) {
						echo ' <li><a href="#'.$aMenu[$key][0].'" class="menuPadding"> '.$aMenu[$key][1].'</a></li>';
					}
					?>
			    </ul>
			</nav><!--end mobil_nav-->

		<!-- Informations / sélection du compte -->
		<div id="account" class="center">
			<form action="simulator.php" method="post">
				<select name="account">
					<?php
					foreach ($aAccount as $key => $value) {
						foreach ($aAccount[$key] as $subkey => $subvalue){
							if($subvalue==$accountSelected){
								echo '<option selected id="'.$key.'" value="'.$subvalue.'">'.$subvalue.' ['.$key.']</option>' ;
							}
							else{
								echo '<option id="'.$key.'" value="'.$subvalue.'">'.$subvalue.' ['.$key.']</option>' ;
							}
						}
					}
					?>
				</select>
				<input type="submit" value="OK">
			</form>
		</div>

		<!-- Informations / sélection planète -->
		<div id="planete" class="center" style="background-image:url(<?php echo $planeteBg; ?>); background-repeat: no-repeat;background-position: top">
			<div name="planeteInfo" class="panelDarkHard">	
				<h3> <?php echo $planeteName.' '.$planeteCoordonate; ?> </h3>
				<div class="planeteImage">
					<img src="https://<?php echo $planeteImage; ?>">
				</div>
				<form action="simulator.php" method="post">
					<select name="planete">
						<option value="" selected>Choisir une planète</option>
						<?php
						foreach ($aPlanete as $key => $value) {
							if($aPlanete[$key][2]==$accountSelected){
								if($aPlanete[$key][0]==$planeteName){
									echo '<option value="'.$key.'" selected>'.$aPlanete[$key][0].' '.$aPlanete[$key][1].'</option>';
								}
								else{
									echo '<option value="'.$key.'">'.$aPlanete[$key][0].' '.$aPlanete[$key][1].'</option>' ;
								}
							}
						}
						?>
					</select>
					<input type="submit" name="ok" value="GO">
				</form>
			</div>
		</div>


		<div name ="panel" class="panelDarkHard">
			<!-- Tableau de configuration planète -->
			<div style="overflow-x:auto;" name="tableauRessources">
				<div class="center intro">
					Le tableau ci dessous vous permet de connaître votre production journalière pour chaque ressource<br>
					En fonction de ça, il vous suggerera le nombre de PT et GT nécessaires pour ghoster votre PJ.
				</div>
				<form action="simulator.php" method="post">
					<table>
						<tr class="celTitle">
							<td></td>
							<?php
							foreach ($aResourceType as $key => $value) {
								echo '<th>'.$value.'</th>';
							}
							?>
							<th>C.E.F</th>
							<th>Total</th>
							<th>PT</th>
							<th>GT</th>

						</tr>
						<tr>
							<td data-label="celTitle" class="celTitle">Niveau Mine</td>
							<?php
							foreach ($aResourceTypeShort as $key => $value) {
								echo '<td data-label="">';
								echo '<select name="level'.$value.$planeteKey.'">';
									foreach ($mineLevels as $keyLevel => $valueLevel) {
										if($keyLevel == $level_mine[$key]){
											echo '<option value="'.$keyLevel.'" selected> '.$level_mine[$key].'</option>';
										}
										else{
											echo '<option value="'.$keyLevel.'"> '.$valueLevel.'</option>';	
										}					
									}
								echo '</select>';
								echo '</td>';		
								
							}
							?>
							<td>
								<select name="levelCEF<?php echo $planeteKey?>" >
									<?php
									foreach ($mineLevels as $keyLevel => $valueLevel) {
										if($keyLevel == $level_CEF){
											echo '<option value="'.$keyLevel.'" selected> '.$level_CEF.'</option>';
										}
										else{
											echo '<option value="'.$keyLevel.'"> '.$valueLevel.'</option>';	
										}	
									}
									?>
								</select>
							</td>
						</tr>
						<tr class="alt">
							<td class="celTitle">Prod./H</td>
							<?php
							foreach ($aResourceTypeShort as $key => $value) {
								echo '<td><input name="prodH'.$value.'" type="hidden" value="'.$prod_H_[$key].'">
								'.numFormat($prod_H_[$key]).'</td>' ;
							}
							?>
							<td class="redResult">-<?php echo numFormat($prod_H_CEF) ?></td>
							<td><?php echo numFormat($totalProdH) ?></td>
						</tr>
						<tr class="infoStandard">
							<td class="celTitle">Prod./J</td>
							<?php
							foreach ($aResourceTypeShort as $key => $value) {
								echo '<td>'.numFormat($prodJ[$key]).'</td>' ;
							}
							?>
							<td>-<?php echo numFormat($prod_H_CEF*24) ?></td>
							<td><?php echo numFormat($totalProdJ); ?></td>
							<td><?php echo numFormat($recoPT); ?></td>
							<td><?php echo numFormat($recoGT); ?></td>

						</tr>
						<tr>
							<td class="celTitle">Stock actuel</td>
							<?php
							foreach ($aResourceTypeShort as $key => $value) {
								echo '<td><input type="text" name="stock'.$value.'" value="'.$currenStock[$key].'" size="10"</td>';
								
							}
							?>
							<td></td>
							<td><?php echo numFormat($totalCurrentStock) ?></td>
							<td><?php echo numFormat($PTneed); ?></td>
							<td><?php echo numFormat($GTneed); ?></td>

						</tr>
					</table>
					<div class="infoSmall center">
						<p>	*La "Prod./ H" et le "stock actuel" du tableau ci-dessus servent de référence à la plupart des outils.
							Pensez donc à bien remplir ce tableau avec vos valeurs personnelles.<br>
							La production de Deutérium affichée prend en compte la consommation de la C.E.F</p>
					</div>
					<div class="center ">
						<input type="submit" name="ok" value="METTRE A JOUR">
					</div>
				</form>
			</div>

			<!-- Calcul du stock futur -->
			<div style="overflow-x:auto;" id="<?php echo $aMenu[0][0]; ?>" name="<?php echo $aMenu[0][0]; ?>" class="panelDark">
				<div id="<?php echo $aMenu[0][0]; ?>Title" class="headPanelTitle">
					<h2>Calculer le futur stock dans un temps défini</h2>
				</div>
				<form action="#<?php echo $aMenu[0][0]; ?>" method="post">
					<table>
						<tr class="celTitle">
							<td></td>
							<?php
							foreach ($aResourceType as $key => $value) {
								echo '<th>'.$value.'</th>';
							}
							?>
						</tr>
						<tr>
							<td class="celTitle">Stock actuel</td>
							<?php
							foreach ($aResourceTypeShort as $key => $value) {
								echo '<td><input type="text" disabled name="stock'.$value.'" value="'.$currenStock[$key].'" size="10"</td>';
							}
							?>

						</tr>
						<tr class="infoStandard">
							<td class="celTitle">Futur stock</br>
							<?php if(isset($_POST['nbHour'])){
								$timeConstruct=mktime(date('H')+$_POST['nbHour']); 
								echo '<div class="infoStandard">(à '.date(("H:i:s"), $timeConstruct).')</div>';}
								//echo '(h+'.$_POST['nbHour'].')';}?>
							</td>
							<?php
							foreach ($aResourceTypeShort as $key => $value) {
								if($futurStock[$key]>0){
									echo '<td class="greenResult">'.numFormat($futurStock[$key]).'</td>' ;
								}
								else{
									echo '<td>'.numFormat($futurStock[$key]).'</td>' ;
								}
							}
							?>

						</tr>
					</table>
					<div class="infoSmall center">
						*Pour que le calcul fonctionne, pensez à bien remplir la Prod./H dans le tableau de haut.
					</div>
					
					<div class="center ">
						<label>Nb d'heure(s)</label>
						<select name="nbHour">
						<option value="" selected></option>
							<?php
							for($i=1;$i<=24;$i++){
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
						</select>
						<input type="submit" name="ok" value="CALCULER">
					</div>
				</form>

			</div>

			<!-- Calcul du temps nécessaire -->
			<div style="overflow-x:auto;" id="<?php echo $aMenu[1][0]; ?>" name="<?php echo $aMenu[1][0]; ?>" class="panelDark">
				<div id="<?php echo $aMenu[1][0]; ?>Title" class="headPanelTitle">
					<h2>Calculer le temps nécessaire pour obtenir le nb de ressources</h2>
				</div>
				<div class="center ">
					<form action="#<?php echo $aMenu[1][0]; ?>" method="post">
					<!--<input type="text" name="prodH">-->
					<label>Prod. heure</label>
					<select name="prodH">
						<option value="" selected></option>
						<?php
						foreach ($aResourceTypeShort as $key => $value) {
							echo '<option value="'.$prod_H_[$key].'">'.numFormat($prod_H_[$key]).' ['.$aResourceType[$key].']</option>' ;
						}
						?>
					</select>
					<label>Stock</label>
					<select name="stock">
						<option value="" selected></option>
						<?php
						foreach ($aResourceTypeShort as $key => $value) {
							echo '<option value="'.$currenStock[$key].'">'.numFormat($currenStock[$key]).' ['.$aResourceType[$key].']</option>' ;
						}
						?>
					</select>
					<label>Besoin</label><input type="text" name="need" size="10">
					<input type="submit" name="ok" value="CALCULER">
					</form>		
				</div>
				<div class="infoSmall center">
					*Pour que le calcul fonctionne, pensez à bien remplir la Prod./H dans le tableau de haut.
				</div>

				<?php
				#Affichage Resultat
				if ($heure > 0 || $minute >0 || $seconde >0){
					?>
					<div name="timeResult" class="result">
						<?php
						echo 'Temps nécessaire : <div class="resultFocus">';
						if($heure <1){
							if($minute <1){
								echo $seconde.'</div>';
							}
							else{
								echo $minute.' '.$seconde.'</div>';
							}
						}
						else{
							echo $heure.' '.$minute.' '.$seconde.'</div>'; 
						}
						?>
					</div>
					<?php
					//On ajoute les H M S à la date
					$time=mktime(date('H')+$heure,date('i')+$minute,date('s')+$seconde) ; 
					?>
					<div name="timeResultunder" class="childResult">
						<?php
						echo 'Disponible à '.date(("H:i:s (d/m/Y)"), $time); 
						echo '<br>';
						?>
					</div>
					<?php
				}
				?>
			</div>

			<!-- Calcul du nb de SATELLITES -->
			<div style="overflow-x:auto;" id="<?php echo $aMenu[2][0]; ?>" name="<?php echo $aMenu[2][0]; ?>" class="panelDark">
				<div id="<?php echo $aMenu[2][0]; ?>Title" class="headPanelTitle">
					<h2>Calculer le nb de satellites nécessaires pour une valeur d'énergie souhaitée</h2>
				</div>
				<div class="center intro">
					<p>Entrez la valeur d'énergie que vous souhaitez obtenir, puis la valeur de production énergétique de vos satellites.<br>
					Vous obtiendrez le nombre supérieur de satellites nécessaires, l'énergie en surplus et les côuts totaux de Cristal et Deutérium</p>
					<?php echo 'Production sur '.$planeteName.' : <font class="greenResult">+'.$satProd.'</font>'; ?>
						<form action="#<?php echo $aMenu[2][0]; ?>" method="post">
						<label>Energie souhaitée</label><input type="text" name="energy" size="10">
						<input type="submit" name="ok" value="CALCULER">
						</form>
					</div>
				<div name="satNeedResult" class="result">
					<?php
					if ($satNeed >0){
						echo 'Nombre de satellites à construire </br>
						<div class="resultFocus">'.$satNeed.'</div>';
					}
					?>
					<div name="satNeedUResultChild" class="childResult">
						<?php
						if ($satNeed >0){
							echo 'Vous produirez ainsi '.$prodSatFinale.' énergie pour '.$energy.' souhaitée (<font class="greenResult">+'.$prodExced.'</font>)<br>';
							echo '[Coût total : <font class="boldResult">'.numFormat($totalCristalCost).'</font> Cristal et <font class="boldResult">'.numFormat($totalDeutCost).'</font> Deutérium]';
						}
						?>
					</div>
				</div>	
			</div>

			
			<!-- DEFENSE -->
			<div style="overflow-x:auto;" id="<?php echo $aMenu[3][0]; ?>" name="<?php echo $aMenu[3][0]; ?>" class="panelDark">
				<div id="<?php echo $aMenu[3][0]; ?>Title" class="headPanelTitle">
					<h2>Calculer le nb de défenses constructibles en fonction du stock disponible</h2>
				</div>
				<div class="center">
					<form action="#<?php echo $aMenu[3][0]; ?>" method="post">
						<table>
							<tr class="celTitle">
								<td></td>
								<?php
								foreach ($aResourceType as $key => $value) {
									echo '<th>'.$value.'</th>';
								}
								?>
							</tr>
							<tr>
								<td class="celTitle">Stock actuel</td>
								<?php
								foreach ($aResourceTypeShort as $key => $value) {
									echo '<td><input type="text" disabled name="stock'.$value.'" value="'.$currenStock[$key].'" size="10"</td>';
								}
								?>
							</tr>
						</table>
						<select name="typeDefense">
							<option value="" disabled selected>Type de défense</option>
								<?php
								foreach ($aDefense as $key => $value) {
									echo '<option value="'.$key.'">'.$aDefense[$key][0].'</option>';
								}
								?>
						</select>
						<input type="submit" name="ok" value="CALCULER">
					</form>
				</div>
				<div name="<?php echo $aMenu[3][0]; ?>Result" class="result">
					<?php
					if(isset($_POST['typeDefense'])){
						echo 'Vous pouvez construire :';
						if($min>0){
							echo '<font class="resultFocus greenResult">'.$min.'</font> '.$aDefense[$_POST['typeDefense']][0]; 
						}
						else{
							echo '<font class="resultFocus redResult">'.$min.'</font> '.$aDefense[$_POST['typeDefense']][0]; 
						}
						
						echo '<div name="'.$aMenu[3][0].'ResultChild" class="childResult">';
						echo 'DETAIL : <br>';
						foreach ($aResourceType as $key => $value) {
							if(isset($nbWith[$key])){
								if($nbWith[$key]==0){
									$diff = $currenStock[$key]-$aDefense[$typeDefense][$key+1];
									echo 'Pas assez de '.$value.' (<font class="redResult">'.numFormat($diff).'</font>)<br>';
								}
								else{
									echo '<font class="greenResult">'.$nbWith[$key].'</font> possible(s) avec '.$value.'<br>'; 
								}
							}
						}
						echo '</div>';
					}
					?>	
				</div>
			</div>

			<!-- VAISSEAU -->
			<div style="overflow-x:auto;" id="<?php echo $aMenu[4][0]; ?>" name="<?php echo $aMenu[4][0]; ?>" class="panelDark">
				<div id="<?php echo $aMenu[4][0]; ?>Title" class="headPanelTitle">
					<h2>Calculer le nb de vaisseaux constructibles en fonction du stock disponible</h2>
				</div>
				<div class="center">
					<form action="#<?php echo $aMenu[4][0]; ?>" method="post">
						<table>
							<tr class="celTitle">
								<td></td>
								<?php
								foreach ($aResourceType as $key => $value) {
									echo '<th>'.$value.'</th>';
								}
								?>
							</tr>
							<tr>
								<td class="celTitle">Stock actuel</td>
								<?php
								foreach ($aResourceTypeShort as $key => $value) {
									echo '<td><input type="text" disabled name="stock'.$value.'" value="'.$currenStock[$key].'" size="10"</td>';
								}
								?>
							</tr>
						</table>
						<select name="typeVaisseau">
							<option value="" disabled selected>Type de vaisseau</option>
								<?php
								foreach ($aVaisseau as $key => $value) {
									echo '<option value="'.$key.'">'.$aVaisseau[$key][0].'</option>';
								}
								?>
							</select>
						<input type="submit" name="ok" value="CALCULER">
					</form>
				</div>
				<div name="<?php echo $aMenu[4][0]; ?>Result" class="result">
					<?php
					if(isset($_POST['typeVaisseau'])){
						echo 'Vous pouvez construire :';
						if($minVaisseau>0){
							echo '<font class="resultFocus greenResult">'.$minVaisseau.'</font> '.$aVaisseau[$_POST['typeVaisseau']][0]; 
						}
						else{
							echo '<font class="resultFocus redResult">'.$minVaisseau.'</font> '.$aVaisseau[$_POST['typeVaisseau']][0]; 
						}
						
						echo '<div name="'.$aMenu[4][0].'ResultChild" class="childResult">';
						echo 'DETAIL : <br>';
						foreach ($aResourceType as $key => $value) {
							if(isset($nbVaisseauWith[$key])){
								if($nbVaisseauWith[$key]==0){
									$diff = $currenStock[$key]-$aVaisseau[$typeVaisseau][$key+1];
									echo 'Pas assez de '.$value.' (<font class="redResult">'.numFormat($diff).'</font>)<br>';
								}
								else{
									echo '<font class="greenResult">'.$nbVaisseauWith[$key].'</font> possible(s) avec '.$value.'<br>'; 
								}
							}

						}
						if($minVaisseau >0){
							echo 'Restant : ';				
							foreach ($aResourceType as $key => $value) {
								if($nbVaisseauWith[$key]>0){
									echo '['.$value.' : '.numFormat($stockRemaining[$key]).'] ';
								}
							}
						}
						echo '</div>';
					}
						?>			
				</div>
			</div>

			
			<!-- HEURE DE FIN -->
			<div style="overflow-x:auto;" id="<?php echo $aMenu[5][0]; ?>" name="<?php echo $aMenu[5][0]; ?>" class="panelDark">
				<div id="<?php echo $aMenu[5][0]; ?>Title" class="headPanelTitle">
					<h2>Calculer l'heure de fin d'une production</h2>
				</div>
				<div class="center intro">
					<p>Permet de connaître à quelle finira une construction, en fonction de son temps et à compter de l'heure actuelle.<br>
					Utile, par exemple, pour savoir à quelle heure exactement mettre un "rappel".</p>
				</div>
				<div class="center ">
					<form action="#<?php echo $aMenu[5][0]; ?>" method="post">
					<label>Temps de construction</label>
						<select name="heure">
						<option value="" selected></option>
							<?php
							for($i=1;$i<=24;$i++){
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
						</select>H
						<select name="min">
						<option value="" selected></option>
							<?php
							for($i=1;$i<=60;$i++){
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
						</select>min
						<select name="sec">
						<option value="" selected></option>
							<?php
							for($i=1;$i<=60;$i++){
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
							?>
						</select>sec
					<input type="submit" name="ok" value="CALCULER">
					</form>

				</div>
				<div name="<?php echo $aMenu[5][0]; ?>Result" class="result">
				<?php
					if (isset($_POST['heure']) ||isset($_POST['min']) ||isset($_POST['sec'])){
						$timeConstruct=mktime(date('H')+$_POST['heure'],date('i')+$_POST['min'],date('s')+$_POST['sec']) ;
						echo '<font class="resultFocus">'.date(("H:i:s"), $timeConstruct).'</font>';		
					?>		
						<div name="<?php echo $aMenu[5][0]; ?>Child" class="childResult">
						<?php
							echo date(("(d/m/Y)"), $timeConstruct);
						?>
						</div>
						<?php
					}
				?>
				</div>
			</div>

			<!-- Calcul du nb de TRANSPORTEURS -->
			<div style="overflow-x:auto;" id="<?php echo $aMenu[6][0]; ?>" name="<?php echo $aMenu[6][0]; ?>" class="panelDark">
				<div id="<?php echo $aMenu[6][0]; ?>Title" class="headPanelTitle">
					<h2>Calculer le nb de PT nécessaires pour transporter un nb de resources donné</h2>
				</div>
				<div class="center intro">
						<form action="#<?php echo $aMenu[6][0]; ?>" method="post">
						<select name="typeTransport">
							<option value="1"><?php echo $aVaisseau[1][0]; ?></option>
							<option value="2"><?php echo $aVaisseau[2][0]; ?></option>
						</select>
						<label>Total des resources à transporter </label><input type="text" name="resourceToFret" size="10">
						<input type="submit" name="ok" value="CALCULER">
						</form>
					</div>
				<div name="satNeedResult" class="result">
					<?php
					if ($needPT >0){
						echo 'Nombre de <font class="greenResult">';
						if($typeTransport == 1){
							echo 'Petits Transporteurs';
						}
						if($typeTransport == 2){
							echo 'Grands Transporteurs';
						}
						echo '</font> nécessaires </br>';
						echo '<div class="resultFocus">'.$needPT.'</div>';
						echo '<div class="childResult">Excédant : '.numFormat($excedant).'</div>';
					}
					?>
				</div>	
			</div>


		</div>

		<div class="footer">
			@Mousshk - 2016
		</div>
	</div>
</body>


