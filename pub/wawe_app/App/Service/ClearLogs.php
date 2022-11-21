<?php

namespace App\Service;

class ClearLogs
{
    public static function clear()
    {
        $mark = ROOT_DIR.'/logs/.keep';
        if(!file_exists($mark)) {
            file_put_contents($mark, time());
        }
        $timeKeep = file_get_contents($mark);
        $diffKeep = time() - $timeKeep;
        if($diffKeep > 86400) {
            $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(ROOT_DIR.'/logs'));
            foreach ($rii as $file) {
                if ($file->isDir()){
                    continue;
                }
                $pathToFile = $file->getPathname();
                $createdFile = filemtime($pathToFile);
                $diff = time() - $createdFile;
                $secondDays = LOG_CLEAR_DAY * 86400;
                if($diff > $secondDays) {
                    unlink($file);
                }
            }
            unlink($mark);
        }
    }
}