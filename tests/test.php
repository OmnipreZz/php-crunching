<?php

require "./index.php";




class codeTest extends \PHPUnit\Framework\TestCase {
    
    function testTopTen() {
        $result = topTen($GLOBALS['top']);
        $this->assertCount(10, $result);
    }
}



?>