<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'Classes/connect.php';

namespace Machine;

Class Linux {
    
    public function cmd($command)
    {
        $cmd = shell_exec($command);
        return $cmd;
    }
    
    
    
    
    
    
    
    
}