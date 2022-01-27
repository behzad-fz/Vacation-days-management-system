<?php

namespace App\DataSources;

use App\Exceptions\JsonKeyUnknownException;
use App\Facades\Config;
use App\Interfaces\DataSourceInterface;

class Sqlite implements DataSourceInterface
{
    /**
     * PDO instance
     * @var \PDO
     */
    private \PDO $pdo;

    /**
     * @var string|mixed|null
     */
    private string $path;

    /**
     * @var string
     */
    private string $entityName = '';

    public function __construct()
    {
        $this->path = Config::get('app.sqlite.path');

        $this->createConnection();
    }

    /**
     * @param string $path
     * @return $this
     */
    public function path(string $path): self
    {
        $this->path = $path;

        $this->refreshConnection();

        return $this;
    }

    /**
     * @param string $entityName
     * @return $this
     */
    public function entity(string $entityName): self
    {
        $this->entityName = $entityName;

        return $this;
    }

    /**
     * @return array
     */
    public function fetch(): array
    {
        return  $this->get();
    }

    /**
     * return an instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function createConnection(): \PDO
    {
        return $this->pdo ?? $this->pdo = new \PDO("sqlite:" . $this->path);
    }

    /**
     * Refresh the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function refreshConnection(): \PDO
    {
        return $this->pdo = new \PDO("sqlite:" . $this->path);
    }

    /**
     * @return array
     * @throws JsonKeyUnknownException
     */
    public function get(): array
    {
        if (! $this->entityName) {
            throw new JsonKeyUnknownException();
        }

        $stmt = $this->pdo->query('SELECT * FROM '. $this->entityName);

        $result = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {

            $columns = array_keys($row);

            $newRecord = [];
            foreach ($columns as $column) {
                $newRecord[$column] = $row[$column];
            }

            $result[] = $newRecord;
        }

        return $result;
    }

    /**
     * @param $table
     * @param array $columns
     */
    public function createTable($table, array $columns): void
    {
        $commands = ['CREATE TABLE IF NOT EXISTS '.$table. ' ('.$this->prepareColumnsForCreate($columns).')'];

        // execute the sql commands to create new tables
        foreach ($commands as $command) {
            $this->pdo->exec($command);
        }
    }

    /**
     * @param array $records
     * @throws JsonKeyUnknownException
     */
    public function insert(array $records): void
    {
        if (empty($records)) {
            return;
        }

        if (! $this->entityName) {
            throw new JsonKeyUnknownException();
        }

        $columns =  array_keys($records[0]);

        $sql = 'INSERT INTO '.$this->entityName.' ( '.$this->prepareColumnsForInsert($columns).') '
              .'VALUES('.$this->prepareValuesForInsert($columns).')';

        foreach ($records as $record) {
            $record = is_object($record) ? $record : (object) $record;
            $stmt = $this->pdo->prepare($sql);
            $newRecord = [];

            foreach ($columns as $column) {
                $newRecord[':'.$column] = $record->$column;
            }

            $stmt->execute($newRecord);
        }
    }

    /**
     * @param array $columns
     * @return string
     */
    private function prepareColumnsForCreate(array $columns): string
    {
        $structure = '';
        foreach ($columns as $column => $type) {
            $structure .= $column.' '.$type.',';
        }

        return rtrim($structure, ',');
    }

    /**
     * @param array $columns
     * @return string
     */
    private function prepareColumnsForInsert(array $columns): string
    {
        $structure = '';
        foreach ($columns as $column) {
            $structure .= $column.',';
        }

        return rtrim($structure, ',');
    }

    /**
     * @param array $columns
     * @return string
     */
    private function prepareValuesForInsert(array $columns): string
    {
        $structure = '';
        foreach ($columns as $column) {
            $structure .= ':'.$column.',';
        }

        return rtrim($structure, ',');
    }
}