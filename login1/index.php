<html>
<body>
<form action="index.php" method="post">
<input type="submit" name="submit" value="submit" />
</form>
<?php
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
    {
        disprecords();
    }
	function disprecords(){
define("USERNAME", "manishbattu@dev.com");
define("PASSWORD", "manomani@2169");
define("SECURITY_TOKEN", "oqwAHteZvrpluSMW2LsRiDps");
require_once ('soapclient/SforcePartnerClient.php');

$mySforceConnection = new SforcePartnerClient();
$mySforceConnection->createConnection("PartnerWSDL.xml");
$mySforceConnection->login(USERNAME, PASSWORD.SECURITY_TOKEN);
echo "The time is " . date("h:i:sa");
echo "date".date('d')."&nbsp;&nbsp;month".date('m')."&nbsp;&nbsp;today".date('Ymd')."&nbsp;&nbsp;day".date('l');
echo "<br>Hour".date('g')."&nbsp;&nbsp;Minutes".date('i')."&nbsp;&nbsp;Seconds".date('s');

if($mySforceConnection !=NULL)
{
echo 'Connected successfully to '.USERNAME.'<br><br>';
}
else
{
echo 'Failed to Connect to'.USERNAME;
}
$query = "SELECT Id, FirstName, LastName, Phone from Contact limit 5";
$response = $mySforceConnection->query($query);

foreach ($response->records as $record)
{
$id =$record->Id;
echo '<tr>
<td>'.$record->Id.'</td>&nbsp;&nbsp;&nbsp;
<td>'.$record->fields->FirstName.'</td>&nbsp;&nbsp;&nbsp;
<td>'.$record->fields->LastName.'</td>&nbsp;&nbsp;&nbsp;
<td>'.$record->fields->Phone.'</td>&nbsp;&nbsp;&nbsp;
</tr><br>';

$query1 = "SELECT ContentDocumentId FROM ContentDocumentLink WHERE LinkedEntityId ='" .$id ."'";
$queryResult = $mySforceConnection->query($query1);
if (!empty($queryResult->records)) {
foreach($queryResult->records as $contentDocumentId) {
	$contdocId = $contentDocumentId->fields->ContentDocumentId;
	
$query2 = "SELECT Id,Title,VersionData FROM ContentVersion WHERE ContentDocumentId ='" .$contdocId ."'";
$queryResult1 = $mySforceConnection->query($query2);

if (!empty($queryResult1->records)) { // if condition to check for the records
	foreach($queryResult1->records as $attachment) {
// to print the attachment name
echo $attachment->fields->Title.'&nbsp;&nbsp;&nbsp;'.$attachment->Id.'</br></br>';
	}
}
}
}
}
	}
?>
</body>
</html>
