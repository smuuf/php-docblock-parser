# PHP Docblock Text Parser

Simple tool to parse PHP docblock text with ability to also read tags and their arguments in form:

```
/**
 * Some text.
 *
 * @whatever-tags(with-arguments: yes, or-even=these)
 */
```

... or you can parse text directly even without the block comment wrapping:

```
Some text.

@whatever-tags(with-arguments: yes, or-even=these)
```

## Results of parsing

- `DocBlock`
  - Comment text _(title + body)_
  - Comment title
  - Comment body
  - `Tag` objects
    - Tag name
    - `TagArg` objects
      - Tag argument name
      - Tag argument Value
## Example usage

``````php
<?php

$text =<<<TEXT
Lorem ipsum dolor sit amet.

Consectetuer adipiscing elit. Nulla quis diam. In rutrum. Maecenas libero. Nemo
enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.

@tag1
@tag2.abc(arg1: yes, arg2 = no, arg3-without-value, arg4=maybe)
TEXT;

$docBlock = \Smuuf\DocBlockParser\Parser::parse($text);

//
// Title, body, text.
//

$docBlock->hasTitle(); // true
$docBlock->getTitle(); // "Lorem ipsum dolor sit amet."
$docBlock->getBody(); // "Consectetuer adipiscing elit. Nulla quis diam ..."
$docBlock->getText(); // "Lorem ipsum dolor sit amet. Consectetuer ..."

//
// Tags.
//

$docBlock->getTags(); // A dict array of [tag_name => Tag object].
$docBlock->hasTag('tag1'); // true
$docBlock->hasTag('tag2.abc'); // true
$docBlock->hasTag('tag999'); // false

//
// Single tag.
//

$tag = $docBlock->getTag('tag2.abc'); // Instance of Tag object.
$tag->getArgs(); // A dict array of [tag_arg_name => TagArg object]

//
// Tag args.
//

$tag->hasArg('arg1'); // true
$tag->hasArg('arg2'); // true
$tag->hasArg('arg999'); // false

$tagArg = $tag->getArg('arg2'); // Instance of TagArg object.
$tagArg->getName(); // "arg2"
$tagArg->getValue(); // "no"

$tagArg = $tag->getArg('arg3-without-value'); // Instance of TagArg object.
$tagArg->getName(); // "arg3-without-value"
$tagArg->getValue(); // null
``````
