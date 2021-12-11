<?php

use \Tester\Assert;

use \Smuuf\DocBlockParser\Tag;
use \Smuuf\DocBlockParser\Tags;
use \Smuuf\DocBlockParser\TagArg;
use \Smuuf\DocBlockParser\Parser;

require __DIR__ . '/../bootstrap.php';

$text =<<<TEXT
Lorem ipsum dolor sit amet.

Consectetuer adipiscing elit. Nulla quis diam. In rutrum. Maecenas libero. Nemo
enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.

@tag1
@tag1(second_tag_1_arg: 123)
@tag1(third_tag_1_arg: 456)
@tag2.abc(arg1: yes, arg2 = no, arg3-without-value, arg4=maybe)

Text can be present even after @tags.

@another_tag(oh: yes!)
TEXT;

$parsed = Parser::parse($text);
var_dump($parsed->getText());

Assert::true($parsed->hasTitle());
Assert::same('Lorem ipsum dolor sit amet.', $parsed->getTitle());
Assert::match(
	'#Consectetuer adipiscing elit. Nulla quis diam.*#',
	$parsed->getBody()
);

$allTags = $parsed->getTags();

Assert::type(Tags::class, $allTags);
Assert::true($allTags->hasTag('tag1'));
Assert::true($allTags->hasTag('tag2.abc'));
Assert::false($allTags->hasTag('tag999'));

$tags = $allTags->getTags('tag2.abc');
Assert::type(Tags::class, $tags);
$tag = $tags->getFirst();
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
