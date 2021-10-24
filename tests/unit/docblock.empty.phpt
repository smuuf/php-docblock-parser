<?php

use \Tester\Assert;

use \Smuuf\DocBlockParser\Parser;

require __DIR__ . '/../bootstrap.php';

//
// Non-empty first.
//

$text = <<<X
/**
 * First line.
 *
 * Second line.
 */
X;

$docblock = Parser::parse($text);
Assert::same("First line.\n\nSecond line.", $docblock->getText());

Assert::true($docblock->hasTitle());
Assert::same('First line.', $docblock->getTitle());

Assert::true($docblock->hasBody());
Assert::same('Second line.', $docblock->getBody());

//
// Just title.
//

$text = <<<X
/**
 * First line.
 *
 *
 */
X;

$docblock = Parser::parse($text);
Assert::same("First line.", $docblock->getText());

Assert::true($docblock->hasTitle());
Assert::same("First line.", $docblock->getTitle());

Assert::false($docblock->hasBody());
Assert::null($docblock->getBody());

//
// Completely empty.
//

$text = <<<X
/**
 *
 *
 *
 */
X;

$docblock = Parser::parse($text);
Assert::same("", $docblock->getText());

Assert::false($docblock->hasTitle());
Assert::null($docblock->getTitle());

Assert::false($docblock->hasBody());
Assert::null($docblock->getBody());
