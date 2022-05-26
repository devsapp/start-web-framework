<?php
/* 发布新包时 需执行此文件更新admin/ecshopfiles.md5  否则文件校验会有很多被修改未知等 */

define('ROOT_PATH', dirname(__FILE__) . '/');
define('ADMIN_PATH', ROOT_PATH . "admin");

@set_time_limit(0);

$md5data = array();
checkfiles('./', '\.php', 0);
checkfiles(ADMIN_PATH . '/', '\.php|\.htm|\.js|\.css|\xml');
checkfiles('api/', '\.php');
checkfiles('includes/', '\.php|\.html|\.js', 1, 'fckeditor');
checkfiles('js/', '\.js|\.css');
checkfiles('languages/', '\.php');
checkfiles('plugins/', '\.php');
checkfiles('wap/', '\.php|\.wml');
// checkfiles('mobile/', '\.php');

echo ("<pre>");
// echo count($md5data);
// print_r($md5data);
// $md5data = array_flip($md5data);
// echo(count($md5data));
$file_name = ROOT_PATH . 'admin/ecshopfiles.md5';
$fw = fopen($file_name, 'w+');
foreach ($md5data as $mKey => $mValue) {
    echo ($mValue . ' *' . $mKey . "\n");
    fwrite($fw, $mValue . ' *' . $mKey . "\n");
}



/**检查文件
 * @param  string $currentdir    //待检查目录
 * @param  string $ext           //待检查的文件类型
 * @param  int    $sub           //是否检查子目录
 * @param  string $skip          //不检查的目录或文件
 */
function checkfiles($currentdir, $ext = '', $sub = 1, $skip = '')
{
    global $md5data;

    $currentdir = ROOT_PATH . str_replace(ROOT_PATH, '', $currentdir);
    $dir = @opendir($currentdir);
    $exts = '/(' . $ext . ')$/i';
    $skips = explode(',', $skip);

    while ($entry = @readdir($dir)) {
        $file = $currentdir . $entry;

        if ($entry != '.' && $entry != '..' && $entry != '.svn' && (preg_match($exts, $entry) || ($sub && is_dir($file))) && !in_array($entry, $skips)) {
            if ($sub && is_dir($file)) {
                checkfiles($file . '/', $ext, $sub, $skip);
            } else {
                if (str_replace(ROOT_PATH, '', $file) != './md5.php') {
                    $md5data[str_replace(ROOT_PATH, '', $file)] = md5_file($file);
                }
            }
        }
    }
}
