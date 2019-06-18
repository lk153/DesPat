<?php
namespace B;

//Builder Interface
interface QueryBuilderInterface
{
    public function select(string $table, array $fields): QueryBuilderInterface;

    public function where(string $field, string $value, string $operator = '='): QueryBuilderInterface;

    public function limit(int $start, int $offset): QueryBuilderInterface;

    public function getSQL(): string;

    public function reset(): void;
}

//Concrete Builder
class MysqlQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var \stdClass
     */
    protected $query;

    public function reset(): void
    {
        $this->query = new \stdClass;
    }

    /**
     * @param string $table
     * @param array $fields
     * @return QueryBuilderInterface
     */
    public function select(string $table, array $fields): QueryBuilderInterface
    {
        $this->reset();
        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $table;
        $this->query->type = 'select';

        return $this;
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return QueryBuilderInterface
     * @throws \Exception
     */
    public function where(string $field, string $value, string $operator = '='): QueryBuilderInterface
    {
        if (!in_array($this->query->type, ['select', 'update'])) {
            throw new \Exception("WHERE can only be added to SELECT OR UPDATE");
        }
        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    /**
     * @param int $start
     * @param int $offset
     * @return QueryBuilderInterface
     * @throws \Exception
     */
    public function limit(int $start, int $offset): QueryBuilderInterface
    {
        if (!in_array($this->query->type, ['select'])) {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        $this->query->limit = " LIMIT " . $start . ", " . $offset;

        return $this;
    }

    /**
     * @return string
     */
    public function getSQL(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        $sql .= ";";

        return $sql;
    }
}

//Concrete Builder
class PostgresQueryBuilder extends MysqlQueryBuilder
{
    /**
     * @param int $start
     * @param int $offset
     * @return QueryBuilderInterface
     */
    public function limit(int $start, int $offset): QueryBuilderInterface
    {
        parent::limit($start, $offset);

        $this->query->limit = " LIMIT " . $start . " OFFSET " . $offset;

        return $this;
    }
}

//Director (optional)
class QueryManager {
    /**
     * @var QueryBuilderInterface
     */
    private $queryBuilder;

    public function setQueryBuilder(QueryBuilderInterface $queryBuilder): void
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function selectQuery()
    {
        return $this->queryBuilder->select("users", ["name", "email", "password"])
            ->where("age", 18, ">")
            ->where("age", 30, "<")
            ->limit(10, 20)
            ->getSQL();
    }
}

//test
$queryManager = new QueryManager();
$queryManager->setQueryBuilder(new MysqlQueryBuilder());
echo $queryManager->selectQuery() . "\n";

$queryManager->setQueryBuilder(new PostgresQueryBuilder());
echo $queryManager->selectQuery() . "\n";
