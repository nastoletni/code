<?php
declare(strict_types=1);

namespace Nastoletni\Code\Domain;

interface PasteRepository
{
    public function getById(Paste\Id $id): Paste;
}