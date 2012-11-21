<?php
	$dbconn = pg_connect("host=ec2-107-22-160-237.compute-1.amazonaws.com port=5432 dbname=d5jqkfl3vd7uqq user=ntkmmzngrxkljj password=GYxw1rdh5zBDmEcTJ23ccay_41 sslmode=require options='--client_encoding=UTF8'") or die('Could not connect: ' . pg_last_error());

$query = 'SELECT * FROM votes';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

/*$yesVotesLine = pg_fetch_array($result, null, PGSQL_ASSOC);
$yesVotes = (int) $yesVotesLine['votes'];
var_dump($yesVotesLine);


$noVotesLine = pg_fetch_array($result, null, PGSQL_ASSOC);
$noVotes = (int) $noVotesLine['votes'];*/

$lastKey = '';
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    foreach ($line as $key => $col_value) {
		if($lastKey == "no") {
			$noVotes = (int) $col_value;
		}
		if($lastKey == "yes") {
			$yesVotes = (int) $col_value;
		}
		$lastKey = $col_value;
    }
}

if(isset($_POST['vote'])) {
if($_POST['vote'] == "yes") {
$newYesVotes = $yesVotes + 1;
$query = 'UPDATE votes SET votes = '.$newYesVotes .' WHERE name = \'yes\'';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}
if($_POST['vote'] == "no") {
$newNoVotes = $noVotes + 1;
$query = 'UPDATE votes SET votes = '.$newNoVotes .' WHERE name = \'no\'';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}
}


// Free resultset
pg_free_result($result);

// Closing connection
pg_close($dbconn);
?>

<form name="input" action="index.php" method="post">
<input type="hidden" name="vote" value="yes">
<input type="submit"  value="YES">
</form>
<b>YES votes: <?php echo $yesVotes?></b>

<form name="input" action="index.php" method="post">
<input type="hidden" name="vote" value="no">
<input type="submit" value="NO">
</form>
<b>NO votes: <?php echo $noVotes?></b>
