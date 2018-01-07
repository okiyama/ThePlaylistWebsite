<html>
<body>

<a href="./vip/">Stream</a>
<a href="./mp3/">Download</a>


<form action="index.php" method="post">
Youtube URL: <input type="text" name="url"><br />
<input type="submit" value="Download to server">
</form>

<?php
if(isset($_POST["url"])) {
	echo "Downloading video now\n";
	flush_to_browser();
	#echo "<br />Command: " . $cmd;
	$cmd = "youtube-dl -i --extract-audio --audio-format mp3 --output \"/var/www/html/mp3/%(title)s.%(ext)s\" " . escapeshellarg($_POST["url"]);

	$descriptorspec = array(
	   0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
	   1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
	   2 => array("pipe", "w")    // stderr is a pipe that the child will write to
	);
	$process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());
	echo "<pre>";
	if (is_resource($process)) {
	    while ($s = fgets($pipes[1])) {
		print $s;
		flush_to_browser();
	    }
	}
	echo "</pre>";
	echo "Finished downloading, updating list of streamable files.\n";
	flush_to_browser();
	exec("python /var/www/html/vip/genRoster.py");
	echo "All done!\n";
}

function flush_to_browser() {
	echo '<div style="display:none">';
	echo str_pad('',4096)."\n";
	echo "</div>";
	flush();
}
?>

</body>
</html>
