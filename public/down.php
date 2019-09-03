<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('max_execution_time', '0');
set_time_limit(0);
//创建<span style="font-family: Arial, Helvetica, sans-serif;">ZipArchive对象</span>  
$zip = new ZipArchive();  

$exportPath = '../public/';
//参数1:zip保存路径，参数2：ZIPARCHIVE::CREATE没有即是创建  
if(!$zip->open("./down.zip",ZIPARCHIVE::CREATE))  
{  
    echo "创建[$exportPath.zip]失败<br/>";return;  
}  
//echo "创建[$exportPath.zip]成功<br/>";  
createZip(opendir($exportPath),$zip,$exportPath);  
$zip->close(); 



function createZip($openFile,$zipObj,$sourceAbso,$newRelat = '')  
{  
    while(($file = readdir($openFile)) != false)  
    {  
        if($file=="." || $file=="..")  
            continue;  
          
        /*源目录路径(绝对路径)*/  
        $sourceTemp = $sourceAbso.'/'.$file;  
        /*目标目录路径(相对路径)*/  
        $newTemp = $newRelat==''?$file:$newRelat.'/'.$file;  
        if(is_dir($sourceTemp))  
        {  
            //echo '创建'.$newTemp.'文件夹<br/>';  
            $zipObj->addEmptyDir($newTemp);/*这里注意：php只需传递一个文件夹名称路径即可*/  
            createZip(opendir($sourceTemp),$zipObj,$sourceTemp,$newTemp);  
        }  
        if(is_file($sourceTemp))  
        {  
            //echo '创建'.$newTemp.'文件<br/>';  
            $zipObj->addFile($sourceTemp,$newTemp);  
        }  
    }  
}  


//$files = array('../','text.txt','music.wav');
//
//$zipname = 'enter_any_name_for_the_zipped_file.zip';
//
//$zip = new ZipArchive;
//
//$zip->open($zipname, ZipArchive::CREATE);
//
//foreach ($files as $file) {
//
// $zip->addFile($file);
//
//}
//
//$zip->close();
//
//  
//
/////Then download the zipped file.
//
//header('Content-Type: application/zip');
//
//header('Content-disposition: attachment; filename='.$zipname);
//
//header('Content-Length: ' . filesize($zipname));
//
//readfile($zipname);

  

