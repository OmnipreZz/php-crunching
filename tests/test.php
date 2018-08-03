<?php

require "./index.php";


class codeTest extends \PHPUnit\Framework\TestCase {
    
    function testTopTen() {
        $this->assertCount(10, topTen());
    }
}


?>