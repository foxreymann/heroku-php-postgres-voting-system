<?php
	$dbconn = pg_connect("host=ec2-107-22-160-237.compute-1.amazonaws.com port=5432 dbname=d5jqkfl3vd7uqq user=ntkmmzngrxkljj password=GYxw1rdh5zBDmEcTJ23ccay_41 sslmode=require options='--client_encoding=UTF8'") or die('Could not connect: ' . pg_last_error());

$query = 'SELECT * FROM votes';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

/*$yesVotesLine = pg_fetch_array($result, null, PGSQL_ASSOC);
$yesVotes = (int) $yesVotesLine['votes'];
var_dump($yesVotesLine);


$noVotesLine = pg_fetch_array($result, null, PGSQL_ASSOC);
$noVotes = (int) $noVotesLine['votes'];*/

while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    foreach ($line as $key => $col_value) {
        var_dump($col_value);
        var_dump($key);
    }
}


/*if(isset($_POST['vote'])) {
$newYesVotes = $yesVotes + 1;
$query = 'UPDATE votes SET votes = '.$yesVotes .' WHERE name = \'yes\'';
var_dump($query);
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

}
*/


// Free resultset
pg_free_result($result);

// Closing connection
pg_close($dbconn);
?>

<form name="input" action="index.php" method="post">
<input type="hidden" name="vote" value="yes">
<input type="submit" name="vote" value="YES">
</form>
<b>YES votes: <?php echo $yesVotes?></b>

<form name="input" action="index.php" method="post">
<input type="hidden" name="vote" value="no">
<input type="submit" value="NO">
</form>
<b>NO votes: <?php echo $noVotes?></b>
