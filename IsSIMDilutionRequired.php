<!doctype html public "-//w3c//dtd html 3.2//en">

<html>

<head>
<title>Is SIM Dilution Required</title>
<link rel="stylesheet" type="text/css" href="chrome.css" />


<SCRIPT language=JavaScript>

function reload(form)
{
var val=DDTID.value;
var val2=SAMPLE.value; 
var val3=FRACTION.value;
var val4=CASNUMBER.value; 
self.location='IsSIMDilutionRequired.php?DDTID=' + val + '&SAMPLE=' + val2 + '&FRACTION=' + val3 + '&CASNUMBER=' + val4;
}

function reloadDDSAMP(form)
{
var val=DDTID.value;
var val2=ASAMPS.options[ASAMPS.options.selectedIndex].value; 
var val3=FRACTION.value;
var val4=CASNUMBER.value; 
self.location='IsSIMDilutionRequired.php?DDTID=' + val + '&SAMPLE=' + val2 + '&FRACTION=' + val3 + '&CASNUMBER=' + val4;
}



</script>

</head>

<body background="Background.jpg" bgproperties="fixed">

<?php
include("menu.inc");
//error_reporting(0);

$db="(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=cscsrvchn6app12)(PORT=1521)))(CONNECT_DATA=(SERVICE_NAME=prod1.cscfed.root.ad)))";

        $conn = oci_connect("bcrabtree", "!EXESKeith01", $db);
        if ($conn === False) {
                echo "Failed to connect to oracle server\n";
                $e = oci_error();
                echo $e['message']."\n";
                }
        else {
               // $s = oci_server_version ($conn);
               // echo "Server version: $s\n";


               // 

$DDT = $_GET['DDTID'];
$SAMP = $_GET['SAMPLE'];
$FRACT = $_GET['FRACTION'];
$CAS = $_GET['CASNUMBER'];

$SQL="
select DISTINCT H.LABDATAPACKAGENAME AS FRACT,
				A.CLIENTANALYSISID AS SAMPLE,
		    	CASE WHEN upper(SPM.QCType) = 'FIELD_SAMPLE' THEN 'FS'
					 WHEN upper(SPM.QCType) = 'PT_SAMPLE' THEN 'PTS'
					 WHEN upper(SPM.QCType) = 'FIELD_BLANK' THEN 'FB'
					 WHEN upper(SPM.QCType) = 'METHOD_BLANK' THEN 'MB'
					 WHEN upper(SPM.QCType) = 'INSTRUMENT_BLANK' THEN 'IB'
					 WHEN upper(SPM.QCType) = 'STORAGE_BLANK' THEN 'SB'
					 WHEN upper(SPM.QCType) = 'METHOD_INSTRUMENT_BLANK' THEN 'MIB'
					 WHEN upper(SPM.QCType) = 'MATRIX_SPIKE' THEN 'MS'
					 WHEN upper(SPM.QCType) = 'MATRIX_SPIKE_DUPLICATE' THEN 'MSD'
					 WHEN upper(SPM.QCType) = 'LABORATORY_CONTROL_SAMPLE' THEN 'LCS'
	   			END AS QCTYPE,
				SPM.MATRIXID,
	   			CASE WHEN upper(ANA.AnalyteType) = 'TARGET' THEN 'T'
					 WHEN upper(ANA.AnalyteType) = 'SURROGATE' THEN 'S'
					 WHEN upper(ANA.AnalyteType) = 'SPIKE' THEN 'SP'
					 WHEN upper(ANA.AnalyteType) = 'INTERNAL_STANDARD' THEN 'IS'
	   			END AS ANALYTETYPE,
				ANA.ANALYTENAME,
				ANA.CASREGISTRYNUMBER AS CAS,
				ANA.CALCRESULT AS RESULT,
				ANA.LABQUALIFIERS AS Q,
				OS.LABDATAPACKAGENAME AS OS_FRACT,
				OS.CLIENTANALYSISID AS OS_Sample,
				OS.CASREGISTRYNUMBER AS OS_CAS,
				OS.CALCRESULT AS OS_Result,
				OS.LABQUALIFIERS AS OS_Q

from EXES.ELECTRONICDATADELIVERABLE E
	 JOIN (EXES.DATADELIVERABLETRACKING D
	 JOIN (EXES.HEADER H
	 JOIN (EXES.SamplePlusMethod SPM
	 JOIN (EXES.ANALYSIS A
	 JOIN (EXES.Analyte ANA
	 JOIN EXES.TESTRESULT TR
	 		ON ANA.DATADELIVERABLETRACKINGID=TR.DATADELIVERABLETRACKINGID)
	 		ON A.DATADELIVERABLETRACKINGID=ANA.DATADELIVERABLETRACKINGID)
	 		ON SPM.DATADELIVERABLETRACKINGID=A.DATADELIVERABLETRACKINGID)
	 		ON H.DATADELIVERABLETRACKINGID=SPM.DATADELIVERABLETRACKINGID)
	 		ON D.DATADELIVERABLETRACKINGID=H.DATADELIVERABLETRACKINGID)
	 		ON E.DATADELIVERABLETRACKINGID=D.DATADELIVERABLETRACKINGID,
	(select OSH.LABDATAPACKAGENAME, OSA.CLIENTANALYSISID, OSANA.CASREGISTRYNUMBER, OSANA.CALCRESULT, OSANA.LABQUALIFIERS
     FROM EXES.ELECTRONICDATADELIVERABLE OSE
	 JOIN (EXES.DATADELIVERABLETRACKING OSD
	 JOIN (EXES.HEADER OSH
	 JOIN (EXES.SamplePlusMethod OSSPM
	 JOIN (EXES.ANALYSIS OSA
	 JOIN EXES.Analyte OSANA
	 		ON OSA.DATADELIVERABLETRACKINGID=OSANA.DATADELIVERABLETRACKINGID)
	 		ON OSSPM.DATADELIVERABLETRACKINGID=OSA.DATADELIVERABLETRACKINGID)
	 		ON OSH.DATADELIVERABLETRACKINGID=OSSPM.DATADELIVERABLETRACKINGID)
	 		ON OSD.DATADELIVERABLETRACKINGID=OSH.DATADELIVERABLETRACKINGID)
	 		ON OSE.DATADELIVERABLETRACKINGID=OSD.DATADELIVERABLETRACKINGID

     WHERE OSE.ELECTRONICDATADELIVERABLEID = OSH.ELECTRONICDATADELIVERABLEID
	 AND OSH.HEADERID = OSSPM.HEADERID
	 AND OSSPM.SAMPLEPLUSMETHODID = OSA.SAMPLEPLUSMETHODID
	 AND OSA.ANALYSISID = OSANA.ANALYSISID
	 AND upper(OSSPM.QCType) NOT IN ('MATRIX_SPIKE','MATRIX_SPIKE_DUPLICATE')
	 AND OSD.DATADELIVERABLETRACKINGID = '$DDT'
	 AND upper(OSE.FRACTION) IN ('BNA','VOA_LOW_MED','VOA_TRACE')) OS

WHERE E.ELECTRONICDATADELIVERABLEID = H.ELECTRONICDATADELIVERABLEID
AND H.HEADERID = SPM.HEADERID
AND SPM.SAMPLEPLUSMETHODID = A.SAMPLEPLUSMETHODID
AND A.ANALYSISID = ANA.ANALYSISID
AND D.DATADELIVERABLETRACKINGID = '$DDT'
AND SUBSTR(A.CLIENTANALYSISID,1,5) = SUBSTR(OS.CLIENTANALYSISID,1,5)
AND ANA.CASREGISTRYNUMBER=OS.CASREGISTRYNUMBER
AND TR.CLIENTSAMPLEID=A.CLIENTANALYSISID
AND TR.CLIENTANALYTEID=ANA.CLIENTANALYTEID
AND TR.DEFECTID IN (20404,20405,20406)
AND UPPER(A.CLIENTANALYSISID) LIKE upper('%$SAMP%')
AND upper(E.FRACTION) IN ('BNA_SIM','VOA_SIM')
AND ANA.CLIENTANALYTEID Like '%$CAS%'
AND upper(ANA.ANALYTETYPE) in ('TARGET')
order by A.CLIENTANALYSISID, ANALYTETYPE, ANA.CASREGISTRYNUMBER desc
";

$QRY = oci_parse($conn, $SQL);
oci_execute($QRY);


$SQLSAMP="SELECT ClientSampleID FROM EXES.SamplePlusMethod WHERE DataDeliverableTrackingID = '$DDT'";

$QRYSAMP = oci_parse($conn, $SQLSAMP);
oci_execute($QRYSAMP);

?>



<?php

if(isset($DDT) AND strlen($DDT) > 0)
{


		echo "<select name='ASAMPS' onchange=\"reloadDDSAMP(this.form)\">";
		while($noticia2 = oci_fetch_array($QRYSAMP))
		{ 
		if($noticia2[ClientSampleID]==$SAMP)
		{
		echo "<option value='$noticia2[0]'>$noticia2[0]</option>";
		$which = 1; 
		}
		else
		{
		echo "<option selected value='$noticia2[0]'>$noticia2[0]</option>";;
		$which = 2;
		}
		
		}
		echo "</select>$which<br/>";
		

}






echo "<b>Enter DDTID </b>";
echo "<INPUT TYPE = \"Text\" VALUE =\"$DDT\" NAME = \"DDTID\"></br>";
echo "<b>Enter Fraction </b>";
echo "<INPUT TYPE = \"Text\" VALUE =\"$FRACT\" NAME = \"FRACTION\"></br>";
echo "<b>Enter Sample Number </b>";
echo "<INPUT TYPE = \"Text\" VALUE =\"$SAMP\" NAME = \"SAMPLE\"></br>";
echo "<b>Enter CAS Number </b>";
echo "<INPUT TYPE = \"Text\" VALUE =\"$CAS\" NAME = \"CASNUMBER\"></br>";
echo "<INPUT TYPE = \"image\" Name = \"Submit\" src = \"Enter_Words.png\" onclick=\"reload(this.form)\">";


echo "<table border='1' cellspacing='.5' align='center'>";
echo "<tr bgcolor=#D3D3D3><th>FRACT</th><th>Sample</th><th>QCType</th><th>MATRIX</th><th>AT</th><th>AN</th><th>CAS</th><th>Result</th><th>Q</th><th>OS_Fract</th><th>OS_Sample</th><th>OS_CAS</th><th>OS_Result</th><th>OS_Q</th></tr>";
$i = 1;

// Query the table
while ($row = oci_fetch_array($QRY, OCI_ASSOC+OCI_RETURN_NULLS)) 
{

	
	$i = $i+1;
	if ($i % 2)
	{
		$bgcolor = "#d4e5f6";
	}
	else
	{
		$bgcolor = "#F5F5F5";
	}


	$OSRESULT = $row[OS_RESULT];
	$OSQ = $row[OS_Q];
	$OSQU = strpos($OSQ,"U");
	$OSQJ = strpos($OSQ,"J");
	$RESULT = $row[RESULT];
	$Q = $row[Q];
	
		if ($OSQU !== false)
			{
				$flagcolor = "#f32828";
			}
		else
			{
				if ($OSQJ !== false)
					{
						$flagcolor = "#f32828";
					}
				else
					{
						$flagcolor = "#dfb038";
					}
			}


	echo "<tr bgcolor=".$bgcolor.">";

	$b = 0;
	
	foreach ($row as $item)
	{
		$b = $b+1;
		$COLUMN = oci_field_name($QRY, $b);
		if ($COLUMN=="RESULT")
			{

				echo "<td onMouseOver=\"this.bgColor = '#FF7F50'\" onMouseOut =\"this.bgColor = '".$bgcolor."'\" onclick=\"window.open('PeakConcentration.php?DDTID=".$DDT."&FRACTION=".$row[FRACTION]."&SAMPLE=".$row[SAMPLE]."&CASNUMBER=".$row[CAS]."','plain','width=1200,height=300,left=10,top=163,location=yes, menubar=no,status=no,toolbar=no,scrollbars=no,resizable=yes')\">".($item!==null?htmlentities($item):"&nbsp;")."</td>";
			}
			
		else
			{
				if ($COLUMN=="CAS")
					{
						echo "<td bgColor='".$flagcolor."''>".($item!==null?htmlentities($item):"&nbsp;")."</td>";
					}
				else
					{
						echo "<td bgColor='".$bgcolor."''>".($item!==null?htmlentities($item):"&nbsp;")."</td>";						
					}
			}


	}
	echo "</tr>".PHP_EOL;
}






echo "</table>";

}

echo "</body>";

oci_close ($conn);



echo "</html>";


?>

 

