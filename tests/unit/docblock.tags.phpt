<?php

use \Tester\Assert;

use \Smuuf\DocBlockParser\Tag;
use \Smuuf\DocBlockParser\Tags;
use \Smuuf\DocBlockParser\TagArg;
use \Smuuf\DocBlockParser\DocBlock;

require __DIR__ . '/../bootstrap.php';

$docblock = require __DIR__ . '/../base.php';
Assert::type(DocBlock::class, $docblock);

//
// Accessing block tags.
//

$allTags = $docblock->getTags();
Assert::type(Tags::class, $allTags);
Assert::true($allTags->hasTag('tag1'));
Assert::true($allTags->hasTag('tag2.oh.my.science'));
Assert::true($allTags->hasTag('tag3.oh.my.science'));
Assert::true($allTags->hasTag('tag4.well.well.well-mega/well'));
Assert::false($allTags->hasTag('nonexistent-bogus-tag'));
Assert::false($allTags->hasTag('nonexistent bogus tag'));

//
// Tag 1 and its args.
//

$tags = $allTags->getTags('tag1');
Assert::type(Tags::class, $tags);

$tag = $tags->getFirst();
Assert::type(Tag::class, $tag);
Assert::same('tag1', $tag->getName());

//
// Get all tags from tags named "tag1".
//

$allTag1s = $tags->getAll();
Assert::type('list', $allTag1s);

//
// Test first tag from tags named "tag1".
//

Assert::type(Tag::class, $allTag1s[0]);
Assert::same('tag1', $allTag1s[0]->getName());

//
// Test non-existence of args for first tag from tags named "tag1".
//
$args = $allTag1s[0]->getArgs();
Assert::type('array', $args);
Assert::falsey($args);
Assert::false($tag->hasArg('nonexistent arg'));
// Fetching non-existent arg returns null.
Assert::null($tag->getArg('nonexistent arg'));

//
// Test second tag from tags named "tag1".
//

Assert::type(Tag::class, $allTag1s[1]);
Assert::same('tag1', $allTag1s[1]->getName());

$args = $allTag1s[1]->getArgs();
Assert::truthy($args);
$firstArg = reset($args);
Assert::same('tag1_arg', $firstArg->getName());
Assert::same('123', $firstArg->getValue());

Assert::false(isset($allTag1s[2]));

//
// Tag 2 and its args.
//

$tag = $docblock->getTags('tag2.oh.my.science')->getFirst();
Assert::type(Tag::class, $tag);
Assert::same('tag2.oh.my.science', $tag->getName());

$args = $tag->getArgs();
Assert::type('array', $args);
Assert::falsey($args);

//
// Tag 3 and its args.
//

$tag = $docblock->getTags('tag3.oh.my.science')->getFirst();
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

$tag = $docblock->getTags('tag4.well.well.well-mega/well')->getFirst();
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
