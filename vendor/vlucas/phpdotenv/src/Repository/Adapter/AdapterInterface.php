<?php

declare(strict_types=1);

namespace Dotenv\Repository\Adapter;

require_once 'C:\xampp\htdocs\CodingAcademyTraining\elib\vendor\vlucas\phpdotenv\src\Repository\Adapter\ReaderInterface.php';
require_once 'C:\xampp\htdocs\CodingAcademyTraining\elib\vendor\vlucas\phpdotenv\src\Repository\Adapter\WriterInterface.php';

interface AdapterInterface extends ReaderInterface, WriterInterface
{
    /**
     * Create a new instance of the adapter, if it is available.
     *
     * @return \PhpOption\Option<\Dotenv\Repository\Adapter\AdapterInterface>
     */
    public static function create();
}
