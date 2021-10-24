<?php

use \Tester\Assert;

use \Smuuf\DocBlockParser\Tag;
use \Smuuf\DocBlockParser\TagArg;
use \Smuuf\DocBlockParser\Parser;

require __DIR__ . '/../bootstrap.php';

$text =<<<TEXT
Lorem ipsum dolor sit amet.

Consectetuer adipiscing elit. Nulla quis diam. In rutrum. Maecenas libero. Nemo
enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.

@tag1
@tag2.abc(arg1: yes, arg2 = no, arg3-without-value, arg4=maybe)
TEXT;

$parsed = Parser::parse($text);
var_dump($parsed->getText());

Assert::true($parsed->hasTitle());
Assert::same('Lorem ipsum dolor sit amet.', $parsed->getTitle());
Assert::match(
	'#Consectetuer adipiscing elit. Nulla quis diam.*#',
	$parsed->getBody()
);

Assert::type('array', $parsed->getTags());
var_dump($parsed->getTags());
Assert::true($parsed->hasTag('tag1'));
Assert::true($parsed->hasTag('tag2.abc'));
Assert::false($parsed->hasTag('tag999'));

$tag = $parsed->getTag('tag2.abc');
Assert::type(Tag::class, $tag);
Assert::type('array', $tag->getArgs());
Assert::true($tag->hasArg('arg1'));
Assert::true($tag->hasArg('arg2'));
Assert::false($tag->hasArg('arg999'));

$tagArg = $tag->getArg('arg2'); // Instance of TagArg object.
Assert::type(TagArg::class, $tagArg);
Assert::same('arg2', $tagArg->getName());
Assert::same('no', $tagArg->getValue());

$tagArg = $tag->getArg('arg3-without-value');
Assert::type(TagArg::class, $tagArg);
Assert::same('arg3-without-value', $tagArg->getName());
Assert::same(null, $tagArg->getValue());
