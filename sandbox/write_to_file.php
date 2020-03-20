<?php


$my_string = <<<TEST
Tizag.com
\tWebmaster Tutorials
Unlock your potential!

TEST;



$file = 'people.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= "$my_string\n";
// Write the contents back to the file
file_put_contents($file, $current);

echo "done";
?>