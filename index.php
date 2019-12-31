<style>
    table,td{
        border: solid thin black;
        border-collapse: collapse;
    }
    table{
        width: 100%;
    }
    td:first-of-type{
        width: 100px;
    }
    td{
        padding: 15px;
    }
</style>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <input type="file" name="music_file" id="music_files" />
    <input type="submit" name="submit" value="Analyze" />
</form>

<?php

if(isset($_POST['submit'])){
    $music_file = $_FILES['music_file'];
    if(!file_exists('/uploads')){
        mkdir('uploads');
    }
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($music_file["name"]);
    move_uploaded_file($music_file["tmp_name"], $target_file);
    require_once('ext\\getID3-master\\getid3\\getid3.php');
    $getID3 = new getID3;
    $music_file_info = $getID3->analyze($target_file);      

?>

<hr />

<h3>Basic Info</h3>
<table>
    <tr>
        <td>File Name</td>
        <td><?php echo $music_file_info['filename'];?></td>
    </tr>
    <tr>
        <td>File Path</td>
        <td><?php echo $music_file_info['filepath'];?></td>
    </tr>
    <tr>
        <td>File Size (b)</td>
        <td><?php echo $music_file_info['filesize'];?></td>
    </tr>
    <tr>
        <td>File Name Path</td>
        <td><?php echo $music_file_info['filenamepath'];?></td>
    </tr>
    <tr>
        <td>File Format</td>
        <td><?php echo $music_file_info['fileformat'];?></td>
    </tr>
    <tr>
        <td>Mime Type</td>
        <td><?php echo $music_file_info['mime_type'];?></td>
    </tr>
    <tr>
        <td>Playtime (Seconds)</td>
        <td><?php echo $music_file_info['playtime_seconds'];?></td>
    </tr>
    <tr>
        <td>Bitrate</td>
        <td><?php echo $music_file_info['bitrate'];?></td>
    </tr>
    <tr>
        <td>Playtime (String)</td>
        <td><?php echo $music_file_info['playtime_string'];?></td>
    </tr>
</table>

<h3>Track Info</h3>
<table>
<?php 
    $fields_to_display = ['track_number','title','band','artist','album','year','genre','composer'];
    $fields_displayed = 0;
    if($music_file_info['tags']){
        $tags = $music_file_info['tags'];
        if($tags['id3v2']){
            foreach($tags['id3v2'] as $key=>$value){
                if(in_array($key,$fields_to_display)){
                ?>
                    <tr>
                        <td><?php echo ucfirst(str_replace('_',' ',$key)); ?></td>
                        <td><?php echo $value[0]; ?></td>
                    </tr>
                <?php
                $fields_displayed++;
                }
            }
        } else if($tags['id3v1']){
            foreach($tags['id3v1'] as $key=>$value){
                if(in_array($key,$fields_to_display)){
                    ?>
                    <tr>
                        <td><?php echo ucfirst(str_replace('_',' ',$key)); ?></td>
                        <td><?php echo $value[0]; ?></td>
                    </tr>
                <?php
                $fields_displayed++;
                }
            }
        }
    }
if(!$fields_displayed){
    echo "No available info";
}
?>
</table>
<?php } ?>