<?php
require_once '../vendor/autoload.php';
require_once 'filesList.php'; 

try {

    $db = new PDO('mysql:host='.DATABASE_HOST.';dbname=' . DATABASE_NAME, DATABASE_USER, DATABASE_PASS);

    echo 'Creating <strong>post_media</strong> table<br>';
    $db->query("CREATE TABLE IF NOT EXISTS `post_media` (
        `id` int NOT NULL AUTO_INCREMENT,
        `post_id` int NOT NULL,
        `media_content` varchar(255) DEFAULT NULL,
        `disk` varchar(255)DEFAULT NULL,
        `created_at` datetime DEFAULT NULL,
        `updated_at` datetime DEFAULT NULL,
        PRIMARY KEY (`id`)
      );");
      
      echo 'Creating <strong>unlocks</strong> table<br>';
      $db->query("CREATE TABLE IF NOT EXISTS `unlocks` (
            `id` int NOT NULL AUTO_INCREMENT,
            `tipper_id` int NOT NULL,
            `creator_id` int NOT NULL,
            `message_id` int NOT NULL,
            `amount` double(10,2) NOT NULL,
            `creator_amount` double(10,2) DEFAULT NULL,
            `admin_amount` double(10,2) DEFAULT NULL,
            `gateway` varchar(255) DEFAULT NULL,
            `payment_status` enum('Paid','Pending') NOT NULL DEFAULT 'Paid',
            `intent` varchar(255) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");

        echo 'Creating <strong>message_media</strong> table<br>';
        $db->query("CREATE TABLE IF NOT EXISTS `message_media` (
            `id` int NOT NULL AUTO_INCREMENT,
            `message_id` int NOT NULL,
            `media_content` varchar(255) DEFAULT 'Image',
            `media_type` enum('Image','Video','Audio','ZIP') DEFAULT NULL,
            `disk` varchar(255) DEFAULT NULL,
            `lock_type` enum('Free','Paid') DEFAULT 'Free',
            `lock_price` double(10,2) DEFAULT NULL,
            PRIMARY KEY (`id`)
          );");

        echo 'Altering <strong>posts</strong> table charset to utf8mb4 (emoji support)<br>';
        try {

            $db->query("ALTER TABLE posts CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

        } catch(\Exception $e) {
            echo '<strong style="color:#cc0000">Fail, your HOSTING does not support utf8mb4 - the app will work but without emojis. Contact your host and ask for mysql utf8mb4 charset support if you need emoji.</strong><br>';
        }

        echo 'Altering <strong>messages</strong> table charset to utf8mb4 (emoji support)<br>';
        try {

            $db->query("ALTER TABLE messages CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

        } catch(\Exception $e) {
            echo '<strong style="color:#cc0000">Fail, your HOSTING does not support utf8mb4 - the app will work but without emojis. Contact your host and ask for mysql utf8mb4 charset support if you need emoji.</strong><br>';
        }



} catch(\Exception $e) {
    echo 'Cannot connect to database.';
    die($e->getMessage());
}

?>

<style>
body {
    font-size: 18px;
    line-height: 30px;;
}
</style>
<?php 

use Symfony\Component\Filesystem\Filesystem;

$file = new Filesystem;
$pathToUpgradeFiles = getcwd();
$pathToActualFiles = $pathToUpgradeFiles . '/../';


foreach($filesList as $f) {
    if(empty($f)) continue;

    echo 'Replacing <strong>' . $f . '</strong><br>';

    $copyFile = $pathToUpgradeFiles . '/upgrade-files/' . $f;
    $toFile = $pathToActualFiles . $f;

    try {

        if($f == 'vendor/composer' || $f == 'vendor/doctrine' || $f == 'vendor/mercadopago') {


            // copy folders
            // $file->remove($toFile);
            $file->mirror($copyFile, $toFile);

            // don't uncomment this line
            // it is used by @crivion to genereate this very upgrader
            // $file->mirror($toFile, $copyFile);

        }else{
        
            // copy from upgrade-files/ to ../
            $file->copy($copyFile, $toFile, true);

            // don't uncomment this - it's used by @crivion
            // to generate upgrade-files
            // copy from files ../ to upgrade-files/
            // $file->copy($toFile, $copyFile, true);

        }

    }catch(\Exception $e) {
        echo $e->getMessage() . '<br>';
    }

}

?>
<hr>
<h3 style="color: #cc0000">Congratulations, you are now on v1.9 - please remove /upgrader/ folder for SECURITY REASONS</h3>
