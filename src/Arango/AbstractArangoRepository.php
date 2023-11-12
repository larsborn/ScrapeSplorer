<?php

declare(strict_types=1);

namespace App\Arango;

use App\InputHelper;
use ArangoDBClient\Collection;
use ArangoDBClient\CollectionHandler;
use ArangoDBClient\Document;
use ArangoDBClient\DocumentHandler;
use ArangoDBClient\Statement;

/**
 * @template T
 */
abstract class AbstractArangoRepository
{
    private ArangoDatabase $arangoDatabase;
    private Collection $collectionId;
    private CollectionHandler $collectionHandler;
    private DocumentHandler $documentHandler;

    public function __construct(ArangoDatabase $arangoDatabase)
    {
        $this->arangoDatabase = $arangoDatabase;
        $this->collectionHandler = new CollectionHandler($arangoDatabase->getConnection());
        $this->collectionId = $this->collectionHandler->get(new Collection($this->getCollectionName()));
        $this->documentHandler = new DocumentHandler($arangoDatabase->getConnection());
    }

    public function getDocumentHandler(): DocumentHandler
    {
        return $this->documentHandler;
    }


    abstract protected function getCollectionName(): string;

    /**
     * @return T
     */
    abstract protected function constructEntity(Document $document): object;

    /**
     * @return ?T
     */
    public function get(string $key): ?object
    {
        return $this->constructEntity($this->documentHandler->get($this->getCollectionName(), $key));
    }

    /**
     * @param string[] $ids
     * @return T[]
     */
    public function findByIds(array $ids): array
    {
        return $this->aql(
            sprintf('FOR row in %s FILTER row._id IN @ids RETURN row', $this->getCollectionName()),
            ['ids' => $ids]
        );
    }

    /**
     * @return T[]
     */
    public function findAll(): array
    {
        return array_map(
            fn (Document $document) => $this->constructEntity(InputHelper::type($document, Document::class)),
            $this->collectionHandler->all($this->collectionId)->getAll()
        );
    }

    public function aql(string $query, array $bindVars = []): array
    {
        return array_map(
            fn (Document $document) => $this->constructEntity($document),
            $this->rawAql($query, $bindVars)
        );
    }

    public function rawAql(string $query, array $bindVars = []): array
    {
        $statement = new Statement(
            $this->arangoDatabase->getConnection(),
            [
                "query" => $query,
                "count" => true,
                "batchSize" => 100,
                "sanitize" => true,
                "bindVars" => $bindVars,
            ]
        );

        $ret = [];
        foreach ($statement->execute() as $_id => $document) {
            $ret[] = $document;
        }

        return $ret;
    }

    public function countAll(): int
    {
        return $this->rawAql(sprintf('RETURN LENGTH(%s)', $this->getCollectionName()), [])[0];
    }

    /**
     * @return T[]
     */
    public function pagination(int $limit, int $offset): array
    {
        return $this->aql(
            sprintf('FOR doc in %s LIMIT @offset, @limit RETURN doc', $this->getCollectionName()),
            ['offset' => $offset, 'limit' => $limit],
        );
    }

    public function countBy(string $filter, array $params): int
    {
        $collectionName = $this->getCollectionName();

        return $this->rawAql(
            <<<AQL
FOR doc in $collectionName
    $filter
    COLLECT WITH COUNT INTO cnt
    RETURN cnt
AQL
            ,
            $params,
        )[0];
    }
}
