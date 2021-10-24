<?php

use \Tester\Assert;

use \Smuuf\DocBlockParser\DocBlock;
use \Smuuf\DocBlockParser\Tag;
use \Smuuf\DocBlockParser\TagArg;

require __DIR__ . '/../bootstrap.php';

$docblock = require __DIR__ . '/../base.php';
Assert::type(DocBlock::class, $docblock);

//
// Accessing block tags.
//

$tags = $docblock->getTags();
Assert::type('array', $tags);
Assert::true($docblock->hasTag('tag1'));
Assert::true($docblock->hasTag('tag2.oh.my.science'));
Assert::true($docblock->hasTag('tag3.oh.my.science'));
Assert::true($docblock->hasTag('tag4.well.well.well-mega/well'));
Assert::false($docblock->hasTag('nonexistent-bogus-tag'));
Assert::false($docblock->hasTag('nonexistent bogus tag'));

//
// Tag 1 and its args.
//

$tag = $docblock->getTag('tag1');
Assert::type(Tag::class, $tag);
Assert::same('tag1', $tag->getName());

$args = $tag->getArgs();
Assert::type('array', $args);
Assert::falsey($args);
Assert::false($tag->hasArg('nonexistent arg'));

// Fetching non-existent arg returns null.
Assert::null($tag->getArg('nonexistent arg'));

//
// Tag 2 and its args.
//

$tag = $docblock->getTag('tag2.oh.my.science');
Assert::type(Tag::class, $tag);
Assert::same('tag2.oh.my.science', $tag->getName());

$args = $tag->getArgs();
Assert::type('array', $args);
Assert::falsey($args);

//
// Tag 3 and its args.
//

$tag = $docblock->getTag('tag3.oh.my.science');
Assert::type(Tag::class, $tag);
Assert::same('tag3.oh.my.science', $tag->getName());

$args = $tag->getArgs();
Assert::type('array', $args);
Assert::truthy($args);

// Fetching non-existent arg returns null.
Assert::null($tag->getArg('nonexistent arg'));

// Fetching existing arg returns instance of TagArg.
Assert::true($tag->hasArg('something is lurking here and it looks like some kind of argument that spilled over to next line'));
$arg = $tag->getArg('something is lurking here and it looks like some kind of argument that spilled over to next line');
Assert::type(TagArg::class, $arg);
Assert::same('something is lurking here and it looks like some kind of argument that spilled over to next line', $arg->getName());
Assert::same(null, $arg->getValue());

//
// Tag 4 and its args.
//

$tag = $docblock->getTag('tag4.well.well.well-mega/well');
Assert::type(Tag::class, $tag);
Assert::same('tag4.well.well.well-mega/well', $tag->getName());

$args = $tag->getArgs();
Assert::type('array', $args);

$arg = $tag->getArg('arg1');
Assert::type(TagArg::class, $arg);
Assert::same('arg1', $arg->getName());
Assert::false($arg->hasValue());
Assert::same(null, $arg->getValue());

$arg = $tag->getArg('arg2');
Assert::type(TagArg::class, $arg);
Assert::same('arg2', $arg->getName());
Assert::true($arg->hasValue());
Assert::same('123   456', $arg->getValue());

$arg = $tag->getArg('arg3');
Assert::type(TagArg::class, $arg);
Assert::same('arg3', $arg->getName());
Assert::true($arg->hasValue());
Assert::same('abc', $arg->getValue());

$arg = $tag->getArg('arg4');
Assert::type(TagArg::class, $arg);
Assert::same('arg4', $arg->getName());
Assert::true($arg->hasValue());
Assert::same('xyz damn', $arg->getValue());
