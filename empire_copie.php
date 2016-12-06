<?php
// code by mousshk@gmail.com
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Europe/Paris");
#inclusion des fonctions
include('fonctions.php');
#inclusion des calculs sources
include('source.php');

?>
<head>
<style>
    <?php include('style.css'); ?>
</style>
<!-- cette balise permet de s'adapter au format mobile et d'avoir le bon zoom
à l'ouverture de la page -->
<meta name="viewport" content="width=device-width, maximum-scale=1"/>
<!-- Inclusion de l'icone d'onglet -->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $icon; ?>" />

<title>Empire (<?php echo $aAccount[$accountSelected];?>)</title>
</head>
<h1>Empire </h1>
<h2><?php echo $aAccount[$accountSelected].' ['.$aServeur[$aPlanete[$key][3]].']'; ?></h2>

<div class="menuHead">
<?php
# Génération du Menu
echo '	<a href="simulator.php" class="menuPadding">Simulateur</a>
		<a href="alliance.php" class="menuPadding" target="_blank">Alliance</a>';
?>
</div>

<div name ="panel" class="panelDarkHard">
	<div style="overflow-x:auto;" name="tableauRessources">
		<table>
			<tr>
				<td></td>
				<?php
				# Nom de la planète (cliquable et revois vers simulator.php avec la planete sélectionnée)
				foreach ($aPlanete as $key => $value) {
					if($aPlanete[$key][2]==$accountSelected){
						echo '<th><a href="simulator.php?planete='.$key.'">'.$aPlanete[$key][0].'</a></th>';
					}
				}
				?>
				<th>TOTAL</th>
			</tr>
			<tr>
				<td></td>
				<?php
				# Image de la planète
				foreach ($aPlanete as $key => $value) {
					if($aPlanete[$key][2]==$accountSelected){
						echo '<td><img src="https://'.$aPlanete[$key][6].'"></td>';
					}
				}
				?>
			</tr>
			
			<?php
			# Niveau de mine de chaque resource de la planète
			foreach ($aResourceTypeShort as $keyType => $valueType) {
				echo '<tr>';
				echo '<th>'.$aResourceType[$keyType].'</th>';			
				foreach ($aPlanete as $key => $value) {
					if($aPlanete[$key][2]==$accountSelected){
						echo '<td>'.wLogRead($dataPathGlobal,'levelmine'.$valueType.$key).'</td>';
					}
				}
				echo '</tr>';
			}
				?>
			</tr>
			
			<tr>
				<th>C.E.F</th>
				<?php
				# Niveau de la CEF de chaque planète
				foreach ($aPlanete as $key => $value) {
					if($aPlanete[$key][2]==$accountSelected){
						echo '<td>'.wLogRead($dataPathGlobal,'levelCEF'.$key).'</td>';
					}
				}
				?>
			</tr>
			<tr>
				<td>PRODUCTION / H</td>
			</tr>
			<tr>
			<?php
			# production H pour chaque resources de chaque planète
			foreach ($aResourceType as $keyType => $valueType) {
				echo '<tr>';
				echo '<th>'.$aResourceType[$keyType].'</th>';		
				$totalProd[$keyType]="";
				foreach ($aPlanete as $key => $value) {			
					$levelCEF = wLogRead($dataPathGlobal,'levelCEF'.$key);
					$prod_HCEF = ceil((10*$levelCEF*pow(1.1,$levelCEF))*$uniSpeedProd);
					$TempMax = $aPlanete[$key][5];
					$levelMine = wLogRead($dataPathGlobal,'levelmine'.$aResourceTypeShort[$keyType].$key);
					$prod_H[0][$key] = ceil((((30 * $levelMine) * pow(1.1,$levelMine))*$uniSpeedProd)+90);
					$prod_H[1][$key] = ceil((((20 * $levelMine) * pow(1.1,$levelMine))*$uniSpeedProd)+45);
					$prod_H[2][$key] = floor(((10 * $levelMine) * pow(1.1,$levelMine)*(1.44 - 0.004 *$TempMax))*$uniSpeedProd-$prod_HCEF);

					if($aPlanete[$key][2]==$accountSelected){
						echo '<td id="'.$keyType.'">'.numFormat($prod_H[$keyType][$key]).'</td>';
						$totalProd[$keyType]=$totalProd[$keyType]+$prod_H[$keyType][$key];
					}
				}
				
				echo '<th>'.numFormat($totalProd[$keyType]).'</th>';
				echo '</tr>';
			}
			?>
			
			<tr>
				<td>PRODUCTION / J</td>
			</tr>
			<?php
			# production J pour chaque resources de chaque planète
			foreach ($aResourceType as $keyType => $valueType) {
				$totalProdJ= array();
				echo '<tr><th>'.$valueType;
				foreach ($aPlanete as $key => $value) {
					if($aPlanete[$key][2]==$accountSelected){
						$levelCEF = wLogRead($dataPathGlobal,'levelCEF'.$key);
						$prod_HCEF = ceil((10*$levelCEF*pow(1.1,$levelCEF))*$uniSpeedProd);
						$TempMax = $aPlanete[$key][5];
						$levelMine = wLogRead($dataPathGlobal,'levelmine'.$aResourceTypeShort[$keyType].$key);
						$prod_H[0][$key] = ceil((((30 * $levelMine) * pow(1.1,$levelMine))*$uniSpeedProd)+90);
						$prod_H[1][$key] = ceil((((20 * $levelMine) * pow(1.1,$levelMine))*$uniSpeedProd)+45);
						$prod_H[2][$key] = floor(((10 * $levelMine) * pow(1.1,$levelMine)*(1.44 - 0.004 *$TempMax))*$uniSpeedProd-$prod_HCEF);

						$prod_J[$keyType] = $prod_H[$keyType][$key]*24;
						$aProdJ[$keyType][$key] = $prod_J[$keyType];

						if($prod_J[$keyType]==max($aProdJ[$keyType])){
							echo '<td class="redResult">'.numFormat($prod_J[$keyType]).'</td>';
						}
						else{
						echo '<td>'.numFormat($prod_J[$keyType]).'</td>';
						}
						$totalProdJ[$keyType]=$totalProdJ[$keyType]+$prod_J[$keyType];
					}
				}
				echo '<th>'.numFormat($totalProdJ[$keyType]).'</th>';
			}
			var_dump(max($aProdJ[1]));
			?>

		</table>

		
	</div>
</div>
<div class="footer">
	@Mousshk - 2016
</div>
