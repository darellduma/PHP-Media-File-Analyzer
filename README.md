# PHP-Media-File-Analyzer
Media file analyzer made in PHP

# How To Use
Download this repo to your server.

# What does it do?
It uploads your media files to the '/uploads/' folder and analyzes it using the 'getID3' class from the getID3 library. 

# What is the filesize limit?
Depends on your server. Just adjust the config in your 'php.ini' file.

# Does it display the whole info?
No. I selected the most basic info of the media file as default. You can display the full info of a media file by going to the index.php file and add print_r($music_file_info); anywhere on the file (at your own risk).