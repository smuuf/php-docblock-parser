<?php

declare(strict_types=1);

use \Smuuf\DocBlockParser\Parser;

require __DIR__ . '/../vendor/autoload.php';

$text = <<<X
/**
 * This is title. Yay!
 *
 * This is a quite long sentence. And maybe a sentence more, because we want
 * to try parsing texts in long paragraphs.
 *
 *
 *
 * Multiple empty lines will be reduced to a single empty line, right?
 * And what is this? Another sentence? Oh snap!
 *
 * ```js
 * maybe_some_block_of_code = true;
 * andSomeExpressionWithoutSemicolon = true
 * return 'this is fine.'
 * ```
 *
 * ```python
 * c = 1
 * b = c
 * if not b:
 *   logging.info("yes")
 *   # let's have two empty lines here...
 *
 *
 *   # ... and they will be unified into one.
 *   print(b)
 * ```
 *
 * @tag1
 * @tag2.oh.my.science
 * @tag3.oh.my.science(something is lurking here and it looks like some kind
 * 	of argument that spilled over to next line)
 * @tag4.well.well.well-mega/well(  arg1,  arg2:    123   456  ,  arg3=abc,
 * 	arg4 =   xyz damn)
 *
 * And here is some more text? What the hell.
 */
X;

return Parser::parse($text);
