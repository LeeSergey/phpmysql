<?php

namespace App\Config;

use App\Config\Exception\ConfigDirectoryNotFoundException;
use App\FS\FS;

class Config
{

    public function parse(string $dirname)
    {
        $dirname = APP_DIR . '/' . $dirname;
        if (!file_exists($dirname) || !is_dir($dirname)){
            throw new ConfigDirectoryNotFoundException($dirname);
        }

        $fs = new FS();
        $fileList = $fs->scanDir($dirname);

        $defaultConfigs = [];
        $appConfigs = [];
        
        foreach ($fileList as $fileConfig){
            if (strpos($fileConfig, 'conf.d') !== false){
                $config = $this->parseConfigPath($fileConfig, $dirname . '/conf.d/');
                $namePath = $config['namePath'];
                $src = [$namePath => $config['src']];

                if (strpos($namePath,'/') !== false){
                    $namePath = explode('/', $namePath);

                    $src = [];
                    $currentSrcItem = &$src;
                    foreach ($namePath as $key=>$pathItem){
                        if ($key == count($namePath)-1){
                            $currentSrcItem[$pathItem] = $config['src'];
                            break;
                        }
                        $currentSrcItem[$pathItem]=[];
                        $currentSrcItem = &$currentSrcItem[$pathItem];
                    }

                    unset($currentSrcItem);

                }

                $defaultConfigs = array_merge_recursive($defaultConfigs, $src);
                continue;
            }
            $config = $this->parseConfigPath($fileConfig, $dirname . '/');
            $appConfigs = array_merge_recursive($appConfigs, $config['src']);
        }

        $config = array_replace_recursive($defaultConfigs, $appConfigs);

    }

    private function parseConfigPath(string $configFilePath, string $replacedPart = '')
    {
        if (!file_exists($configFilePath)){
            throw new ConfigDirectoryNotFoundException($configFilePath);
        }

        $data = [];
        $data['src'] = include $configFilePath;
        $namePath = str_replace($replacedPart, '' , $configFilePath);
        $data['pathInfo'] = str_replace('.php','',$namePath);

        return $data;
    }

}