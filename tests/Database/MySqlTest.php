<?php

namespace RestExample\Tests\Database;

class MySqlTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function insert() {
    $data = [
      'foo' => 'bar',
      'baz' => 1,
    ];

    $pdoStatementMock = $this->getMockBuilder(\PDOStatement::class)->getMock();
    $pdoStatementMock->expects($this->once())
            ->method('execute')
            ->with($this->equalTo(['bar', 1]))
            ->willReturn(true);

    $pdoMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->getMock();
    $pdoMock->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('INSERT INTO test_resources (foo,baz) VALUES (?,?)'))
            ->willReturn($pdoStatementMock);
    $pdoMock->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(1);

    $connection = new \RestExample\Database\MySql($pdoMock);
    $this->assertEquals(1, $connection->insert('test', $data));
  }

  /**
   * @test
   * @expectedException \RestExample\Database\Exception\InsertQueryFail
   */
  public function insertFail() {
    $pdoStatementMock = $this->getMockBuilder(\PDOStatement::class)->getMock();
    $pdoStatementMock->expects($this->once())
            ->method('execute')
            ->willReturn(false);

    $pdoMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->getMock();
    $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($pdoStatementMock);

    $connection = new \RestExample\Database\MySql($pdoMock);
    $connection->insert('test', []);
  }

  /**
   * @test
   */
  public function update() {
    $data = [
      'foo' => 'bar',
      'baz' => 1,
    ];
    $identifier = 1;

    $pdoStatementMock = $this->getMockBuilder(\PDOStatement::class)->getMock();
    $pdoStatementMock->expects($this->once())
            ->method('execute')
            ->with($this->equalTo(['bar', 1, $identifier]))
            ->willReturn(true);

    $pdoMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->getMock();
    $pdoMock->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('UPDATE test_resources SET foo=?,baz=? WHERE id_test=?'))
            ->willReturn($pdoStatementMock);

    $connection = new \RestExample\Database\MySql($pdoMock);
    $connection->update('test', $identifier, $data);
  }

  /**
   * @test
   * @expectedException \RestExample\Database\Exception\UpdateQueryFail
   */
  public function updateFail() {
    $pdoStatementMock = $this->getMockBuilder(\PDOStatement::class)->getMock();
    $pdoStatementMock->expects($this->once())
            ->method('execute')
            ->willReturn(false);

    $pdoMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->getMock();
    $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($pdoStatementMock);

    $connection = new \RestExample\Database\MySql($pdoMock);
    $connection->update('test', 1, []);
  }

  /**
   * @test
   */
  public function find() {
    $data = [
      'foo' => 'bar',
      'baz' => 1,
    ];
    $identifier = 1;

    $pdoStatementMock = $this->getMockBuilder(\PDOStatement::class)->getMock();
    $pdoStatementMock->expects($this->once())
            ->method('execute')
            ->with($this->equalTo([$identifier]))
            ->willReturn(true);
    $pdoStatementMock->expects($this->once())
            ->method('fetch')
            ->willReturn($data);

    $pdoMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->getMock();
    $pdoMock->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('SELECT * FROM test_resources WHERE id_test=?'))
            ->willReturn($pdoStatementMock);

    $connection = new \RestExample\Database\MySql($pdoMock);
    $this->assertEquals($data, $connection->find('test', $identifier));
  }

  /**
   * @test
   * @expectedException \RestExample\Database\Exception\FindQueryFail
   */
  public function findFail() {
    $pdoStatementMock = $this->getMockBuilder(\PDOStatement::class)->getMock();
    $pdoStatementMock->expects($this->once())
            ->method('execute')
            ->willReturn(false);

    $pdoMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->getMock();
    $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($pdoStatementMock);

    $connection = new \RestExample\Database\MySql($pdoMock);
    $connection->find('test', 1, []);
  }

  /**
   * @test
   */
  public function delete() {
    $identifier = 1;

    $pdoStatementMock = $this->getMockBuilder(\PDOStatement::class)->getMock();
    $pdoStatementMock->expects($this->once())
            ->method('execute')
            ->with($this->equalTo([$identifier]))
            ->willReturn(true);

    $pdoMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->getMock();
    $pdoMock->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('DELETE FROM test_resources WHERE id_test=?'))
            ->willReturn($pdoStatementMock);

    $connection = new \RestExample\Database\MySql($pdoMock);
    $connection->delete('test', $identifier);
  }

  /**
   * @test
   * @expectedException \RestExample\Database\Exception\DeleteQueryFail
   */
  public function deleteFail() {
    $pdoStatementMock = $this->getMockBuilder(\PDOStatement::class)->getMock();
    $pdoStatementMock->expects($this->once())
            ->method('execute')
            ->willReturn(false);

    $pdoMock = $this->getMockBuilder(\PDO::class)->disableOriginalConstructor()->getMock();
    $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($pdoStatementMock);

    $connection = new \RestExample\Database\MySql($pdoMock);
    $connection->delete('test', 1);
  }

}