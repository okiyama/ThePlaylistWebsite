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
	$cmd = "youtube-dl -i --extract-audio --audio-format mp3 --output \"/var/www/html/mp3/%(title)s.%(ext)s\" " . escapeshellarg($_POST["url"]);
	echo "<br />Downloading video now, maybe this will get a progress bar later";
	echo "<br />Command: " . $cmd;
	shell_exec($cmd);
	echo "<br />Finished downloading, updating list of streamable files.";
	shell_exec("python /var/www/html/vip/genRoster.py");
	echo "<br />All done!";
}
?>

</body>
</html>
