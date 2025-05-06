<?php

namespace BatAPI\DataSources;

use BatAPI\Env;
use BatAPI\Interfaces\DataSource;
use PDO;
use function BatAPI\Utils\dd;

class MySQL extends DataSource
{
    private ?string $database = null;
    private ?string $username = null;
    private ?string $password = null;
    private ?string $host = null;
    private ?int $port = 3306;
    private string $table;
    private array $select = ['*'];
    private array $wheres = [];
    private array $group = [];
    private array $order = [];
    private ?int $limit = null;
    private PDO $pdo;


    public function __construct(?string $host = null, ?string $port = null, ?string $database = null, ?string $username = null, ?string $password = null)
    {
        $this->host = $host ?? Env::get('DB_HOST');
        $this->port = $port ?? Env::get('DB_PORT');
        $this->database = $database ?? Env::get('DB_DATABASE');
        $this->username = $username ?? Env::get('DB_USERNAME');
        $this->password = $password ?? Env::get('DB_PASSWORD');

        $this->pdo = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->database}", $this->username, $this->password);
    }

    public function table(string $table): MySQL
    {
        $this->table = $table;
        return $this;
    }

    public function select(array $columns): MySQL
    {
        $this->select = $columns;
        return $this;
    }

    public function where(array $wheres): MySQL
    {
        foreach($wheres as $where) {
            $joiner = empty($this->wheres) ? ' WHERE ' : ' AND ';
            $this->wheres[] = ['query' => "{$joiner} {$where[0]} {$where[1]} ?", 'value' => $where[2]];
        }

        return $this;
    }

    public function group(array $bys): MySQL
    {
        $joiner = empty($this->group) ? 'GROUP BY ' : ', ';
        foreach($bys as $by) {
            $this->group[] = "{$joiner} {$by}";
        }

        return $this;
    }

    public function order(array $bys): MySQL
    {
        $joiner = empty($this->order) ? 'ORDER BY ' : ', ';
        foreach($bys as $by) {
            $by[1] = $by[1] ?? 'ASC';
            $this->order[] = "{$joiner} {$by[0]} {$by[1]}";
        }

        return $this;
    }

    public function limit(int $limit): MySQL
    {
        $this->limit = $limit;

        return $this;
    }

    public function read(): array
    {
        $query = $this->constructQuery();

        $statement = $this->pdo->prepare($query);
        $statement->execute(array_column($this->wheres, 'value'));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function debugQuery(): void
    {
        dd($this->constructQuery());
    }


    private function constructQuery(): string
    {
        $columns = implode(",", $this->select);

        $query = "SELECT {$columns} FROM {$this->table} ";

        foreach($this->wheres as $where) {
            $query .= $where['query'];
        }

        if (!empty($this->group)) {
            $query .= " " . implode(",", $this->group);
        }

        if (!empty($this->order)) {
            $query .= " ". implode(",", $this->order);
        }

        if ($this->limit) {
            $query .= " LIMIT {$this->limit}";
        }

        return $query;
    }
}