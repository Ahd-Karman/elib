<?php

declare(strict_types=1);

namespace Dotenv\Parser;

use Dotenv\Exception\InvalidFileException;
use Dotenv\Util\Regex;
use GrahamCampbell\ResultType\Result;
use GrahamCampbell\ResultType\Success;

require_once 'C:\xampp\htdocs\CodingAcademyTraining\elib\vendor\vlucas\phpdotenv\src\Parser\ParserInterface.php';
final class Parser implements ParserInterface
{
    /**
     * Parse content into an entry array.
     *
     * @param string $content
     *
     * @throws \Dotenv\Exception\InvalidFileException
     *
     * @return \Dotenv\Parser\Entry[]
     */
    public function parse(string $content)
    {
        require_once 'C:\xampp\htdocs\CodingAcademyTraining\elib\vendor\vlucas\phpdotenv\src\Util\Regex.php';
        require_once 'C:\xampp\htdocs\CodingAcademyTraining\elib\vendor\vlucas\phpdotenv\src\Parser\Lines.php';
        require_once 'C:\xampp\htdocs\CodingAcademyTraining\elib\vendor\vlucas\phpdotenv\src\Parser\EntryParser.php';

        return Regex::split("/(\r\n|\n|\r)/", $content)->mapError(static function () {
            return 'Could not split into separate lines.';
        })->flatMap(static function (array $lines) {
            return self::process(Lines::process($lines));
        })->mapError(static function (string $error) {
            throw new InvalidFileException(\sprintf('Failed to parse dotenv file. %s', $error));
        })->success()->get();
    }

    /**
     * Convert the raw entries into proper entries.
     *
     * @param string[] $entries
     *
     * @return \GrahamCampbell\ResultType\Result<\Dotenv\Parser\Entry[],string>
     */
    private static function process(array $entries)
    {
        /** @var \GrahamCampbell\ResultType\Result<\Dotenv\Parser\Entry[],string> */
        return \array_reduce($entries, static function (Result $result, string $raw) {
            return $result->flatMap(static function (array $entries) use ($raw) {
                return EntryParser::parse($raw)->map(static function (Entry $entry) use ($entries) {
                    return \array_merge($entries, [$entry]);
                });
            });
        }, Success::create([]));
    }
}
