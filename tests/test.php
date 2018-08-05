<?php

require "./index.php";

// pour tester !!  taper composer test dans la console !!
class codeTest extends \PHPUnit\Framework\TestCase {
    
    function testTopTen() {
        $this->assertCount(10, topTen());
    }
}


?>

