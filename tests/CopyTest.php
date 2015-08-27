<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Copy.php";
    require_once "src/Book.php";
    //require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CopyTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Copy::deleteAll();
            Book::deleteAll();
            //Patron::deleteAll();
        }


        function test_setBookId()
        {
            //Arrange
            $available = true;
            $book_id = 1;
            $test_copy = new Copy($available, $book_id);

            $book_id2 = 2;

            //Act
            $test_copy->setBookId($book_id2);
            $result = $test_copy->getBookId();

            //Assert
            $this->assertEquals($book_id2, $result);
        }

        function test_getBookId()
        {
            //Arrange
            $available = true;
            $book_id = 1;
            $test_copy = new Copy($available, $book_id);

            //Act
            $result = $test_copy->getBookId();

            //Assert
            $this->assertEquals($book_id, $result);
        }

        function test_setAvailable()
        {
            //Arrange
            $available = true;
            $book_id = 1;
            $test_copy = new Copy($available, $book_id);

            $available2 = false;

            //Act
            $test_copy->setAvailable($available2);
            $result = $test_copy->getAvailable();

            //Assert
            $this->assertEquals($available2, $result);
        }

        function test_getAvailable()
        {
            //Arrange
            $available = true;
            $book_id = 4;
            $test_copy = new Copy($available, $book_id);

            //Act
            $result = $test_copy->getAvailable();

            //Assert
            $this->assertEquals($available, $result);
        }

        function test_getId()
        {
            //Arrange
            $available = true;
            $book_id = 4;
            $id = 888;
            $test_copy = new Copy($available, $book_id, $id);

            //Act
            $result = $test_copy->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $available = true;
            $book_id = 4;
            $test_copy = new Copy($available, $book_id);
            $test_copy->save();

            //Act
            $result = Copy::getAll();

            //Assert
            $this->assertEquals([$test_copy], $result);
        }

        function test_getAll()
        {
            //Arrange
            $available = true;
            $book_id = 4;
            $test_copy = new Copy($available, $book_id);
            $test_copy->save();

            $available2 = 11;
            $book_id2 = 5;
            $test_copy2 = new Copy($available2, $book_id2);
            $test_copy2->save();

            //Act
            $result = Copy::getAll();

            //Assert
            $this->assertEquals([$test_copy, $test_copy2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $available = true;
            $book_id = 4;
            $test_copy = new Copy($available, $book_id);
            $test_copy->save();

            //Act
            $test_copy->deleteAll();
            $result = Copy::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $available = true;
            $book_id = 4;
            $test_copy = new Copy($available, $book_id);
            $test_copy->save();

            $available2 = 11;
            $book_id2 = 5;
            $test_copy2 = new Copy($available2, $book_id2);
            $test_copy2->save();

            //Act
            $result = Copy::find($test_copy->getId());

            //Assert
            $this->assertEquals($test_copy, $result);
        }

        function test_updateAvailable()
        {
            //Arrange
            $available = true;
            $book_id = 4;
            $test_copy = new Copy($available, $book_id);
            $test_copy->save();

            $test_copy->updateAvailable(false);

            //Act
            //$id = $test_copy->getId();
            //$test_copy2 = new Copy($available2, $book_id, $id);
            $result = $test_copy->getAvailable();

            //Assert
            $this->assertEquals(false, $result);
        }

        function test_delete()
        {
            //Arrange
            $available = true;
            $book_id = 4;
            $test_copy = new Copy($available, $book_id);
            $test_copy->save();

            $available2 = true;
            $book_id2 = 5;
            $test_copy2 = new Copy($available2, $book_id2);
            $test_copy2->save();

            //Act
            $test_copy->delete();
            $result = Copy::getAll();

            //Assert
            $this->assertEquals([$test_copy2], $result);
        }
    }
?>
