<?php

use \Smuuf\DocBlockParser\DocBlock;

use \Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$docblock = require __DIR__ . '/../base.php';
Assert::type(DocBlock::class, $docblock);

//
// Text.
//

$text =<<<X
This is title. Yay!

This is a quite long sentence. And maybe a sentence more, because we want
to try parsing texts in long paragraphs.

Multiple empty lines will be reduced to a single empty line, right?
And what is this? Another sentence? Oh snap!

```js
maybe_some_block_of_code = true;
andSomeExpressionWithoutSemicolon = true
return 'this is fine.'
```

```python
c = 1
b = c
if not b:
  logging.info("yes")
  # let's have two empty lines here...

  # ... and they will be unified into one.
  print(b)
```

And here is some more text? What the hell.
X;

Assert::same($text, $docblock->getText());

//
// Title.
//

Assert::same('This is title. Yay!', $docblock->getTitle());

//
// Body.
//

$body =<<<X
This is a quite long sentence. And maybe a sentence more, because we want
to try parsing texts in long paragraphs.

Multiple empty lines will be reduced to a single empty line, right?
And what is this? Another sentence? Oh snap!

```js
maybe_some_block_of_code = true;
andSomeExpressionWithoutSemicolon = true
return 'this is fine.'
```

```python
c = 1
b = c
if not b:
  logging.info("yes")
  # let's have two empty lines here...

  # ... and they will be unified into one.
  print(b)
```

And here is some more text? What the hell.
X;

Assert::same($body, $docblock->getBody());
