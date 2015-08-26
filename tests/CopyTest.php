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

        function test_setNumberCopies()
        {
            //Arrange
            $number_copies = 5;
            $available = 0;
            $book_id = 1;
            $test_copy = new Copy($number_copies, $available, $book_id);

            $number_copies2 = 6;

            //Act
            $test_copy->setNumberCopies($number_copies2);
            $result = $test_copy->getNumberCopies();

            //Assert
            $this->assertEquals($number_copies2, $result);
        }

        function test_getNumberCopies()
        {
            //Arrange
            $number_copies = 5;
            $available = 0;
            $book_id = 1;
            $test_copy = new Copy($number_copies, $available, $book_id);

            //Act
            $result = $test_copy->getNumberCopies();

            //Assert
            $this->assertEquals($number_copies, $result);
        }

        function test_setBookId()
        {
            //Arrange
            $number_copies = 5;
            $available = 0;
            $book_id = 1;
            $test_copy = new Copy($number_copies, $available, $book_id);

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
            $number_copies = 5;
            $available = 0;
            $book_id = 1;
            $test_copy = new Copy($number_copies, $available, $book_id);

            //Act
            $result = $test_copy->getBookId();

            //Assert
            $this->assertEquals($book_id, $result);
        }

        function test_setAvailable()
        {
            //Arrange
            $number_copies = 5;
            $available = 0;
            $book_id = 1;
            $test_copy = new Copy($number_copies, $available, $book_id);

            $available2 = 1;

            //Act
            $test_copy->setAvailable($available2);
            $result = $test_copy->getAvailable();

            //Assert
            $this->assertEquals($available2, $result);
        }

        function test_getAvailable()
        {
            //Arrange
            $number_copies = 5;
            $available = 0;
            $book_id = 4;
            $test_copy = new Copy($number_copies, $available, $book_id);

            //Act
            $result = $test_copy->getAvailable();

            //Assert
            $this->assertEquals($available, $result);
        }

        function test_getId()
        {
            //Arrange
            $number_copies = 5;
            $available = 0;
            $book_id = 4;
            $id = 888;
            $test_copy = new Copy($number_copies, $available, $book_id, $id);

            //Act
            $result = $test_copy->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $number_copies = 5;
            $available = 0;
            $book_id = 4;
            $test_copy = new Copy($number_copies, $available, $book_id);
            $test_copy->save();

            //Act
            $result = Copy::getAll();

            //Assert
            $this->assertEquals([$test_copy], $result);
        }

        function test_getAll()
        {
            //Arrange
            $number_copies = 5;
            $available = 0;
            $book_id = 4;
            $test_copy = new Copy($number_copies, $available, $book_id);
            $test_copy->save();

            $number_copies2 = 6;
            $available2 = 11;
            $book_id2 = 5;
            $test_copy2 = new Copy($number_copies2, $available2, $book_id2);
            $test_copy2->save();

            //Act
            $result = Copy::getAll();

            //Assert
            $this->assertEquals([$test_copy, $test_copy2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $number_copies = 5;
            $available = 0;
            $book_id = 4;
            $test_copy = new Copy($number_copies, $available, $book_id);
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
            $number_copies = 5;
            $available = 0;
            $book_id = 4;
            $test_copy = new Copy($number_copies, $available, $book_id);
            $test_copy->save();

            $number_copies2 = 6;
            $available2 = 11;
            $book_id2 = 5;
            $test_copy2 = new Copy($number_copies2, $available2, $book_id2);
            $test_copy2->save();

            //Act
            $result = Copy::find($test_copy->getId());

            //Assert
            $this->assertEquals($test_copy, $result);
        }

        function test_update()
        {
            //Arrange
            $number_copies = 5;
            $available = 0;
            $book_id = 4;
            $test_copy = new Copy($number_copies, $available, $book_id);
            $test_copy->save();

            $number_copies2 = 6;
            $available2 = 11;
            $test_copy->update($number_copies2, $available2);

            //Act
            $id = $test_copy->getId();
            $test_copy2 = new Copy($number_copies2, $available2, $book_id, $id);
            $result = Copy::find($id);

            //Assert
            $this->assertEquals($test_copy2, $result);
        }

        function test_delete()
        {
            //Arrange
            $number_copies = 5;
            $available = 0;
            $book_id = 4;
            $test_copy = new Copy($number_copies, $available, $book_id);
            $test_copy->save();

            $number_copies2 = 6;
            $available2 = 11;
            $book_id2 = 5;
            $test_copy2 = new Copy($number_copies2, $available2, $book_id2);
            $test_copy2->save();

            //Act
            $test_copy->delete();
            $result = Copy::getAll();

            //Assert
            $this->assertEquals([$test_copy2], $result);
        }
    }
?>
