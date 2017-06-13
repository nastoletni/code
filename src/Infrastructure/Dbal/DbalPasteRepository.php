<?php

declare(strict_types=1);

namespace Nastoletni\Code\Infrastructure\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\DBALException;
use Nastoletni\Code\Domain\Paste;
use Nastoletni\Code\Domain\PasteRepository;
use PDO;

class DbalPasteRepository implements PasteRepository
{
    /**
     * @var Connection
     */
    private $dbal;

    /**
     * @var DbalPasteMapper
     */
    private $mapper;

    /**
     * DbalPasteRepository constructor.
     *
     * @param Connection      $dbal
     * @param DbalPasteMapper $mapper
     */
    public function __construct(Connection $dbal, DbalPasteMapper $mapper)
    {
        $this->dbal = $dbal;
        $this->mapper = $mapper;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(Paste\Id $id): Paste
    {
        $qb = $this->dbal->createQueryBuilder()
            ->select('p.id', 'p.title', 'p.created_at', 'f.filename', 'f.content')
            ->from('pastes', 'p')
            ->innerJoin('p', 'files', 'f', 'f.paste_id = p.id')
            ->where('p.id = :id')
            ->setParameter(':id', $id->getBase10Id());

        $query = $this->dbal->executeQuery($qb->getSQL(), $qb->getParameters());

        if ($query->rowCount() < 1) {
            throw new Paste\NotExistsException(sprintf('Paste with id %s does not exist.', $id->getBase62Id()));
        }

        $data = $query->fetchAll();

        return $this->mapper->map($data);
    }

    /**
     * {@inheritdoc}
     *
     * @throws ConnectionException when there is something wrong with transaction.
     */
    public function save(Paste $paste): void
    {
        $this->dbal->beginTransaction();

        try {
            $this->dbal->insert('pastes', [
                'id'         => $paste->getId()->getBase10Id(),
                'title'      => $paste->getTitle(),
                'created_at' => $paste->getCreatedAt()->format('Y-m-d H:i:s'),
            ], [PDO::PARAM_INT, PDO::PARAM_STR, PDO::PARAM_STR]);
        } catch (DBALException $e) {
            /* @see https://dev.mysql.com/doc/refman/5.7/en/error-messages-server.html#error_er_dup_entry */
            if (1062 == $e->getCode()) {
                throw new Paste\AlreadyExistsException(sprintf(
                    'Paste with id %s already exists.',
                    $paste->getId()->getBase62Id()
                ));
            }

            throw $e;
        }

        // Insertion of files.
        foreach ($paste->getFiles() as $file) {
            $this->dbal->insert('files', [
                'paste_id' => $paste->getId()->getBase10Id(),
                'filename' => $file->getFilename(),
                'content'  => $file->getContent(),
            ], [PDO::PARAM_INT, PDO::PARAM_STR, PDO::PARAM_STR]);
        }

        try {
            $this->dbal->commit();
        } catch (ConnectionException $e) {
            $this->dbal->rollBack();
            throw $e;
        }
    }
}
