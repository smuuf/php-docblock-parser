<?php

declare(strict_types=1);

namespace Smuuf\DocBlockParser;

abstract class Parser {

	use \Smuuf\StrictObject;

	public static function parse(string $text): DocBlock {

		$text = self::clean($text);

		[$tags, $text] = self::parseTags($text);
		return new DocBlock($text, $tags);

	}

	public static function clean(string $text): string {

		// Unify newlines to UNIX style.
		$text = preg_replace('#\r?\n#', "\n", $text);

		// Remove '/**  ' and '  */'
		$text = preg_replace('#(^\/\*\*\s*\n)|(\s*\*+\/$)#', '', $text);

		// Remove '*' with spaces at the line starts.
		$text = preg_replace('#^\s*\*\h?#m', '', $text);

		// 2 and more empty lines into one empty line.
		$text = preg_replace('#\n{2,}#', "\n\n", $text);

		return trim($text);

	}

	/** @return array{Tags, string} */
	public static function parseTags(string $text): array {

		$gathered = [];
		$newText = preg_replace_callback(
			'~

				# Tags must be first thing in the string or first thing after newline (horizontal whitespace in front of it is allowed).
				(^|\n)\h*@

				# Anything after "@" which is not whitespace and "(" char represents tag name.
				(?<name>(?:[^\s\(])+)

				# Anything inside "(" and ")", which can span over multiple lines, are args.
				(\((?<args>.+?)\))?+

				# And catch the newline at the end - so we can get rid of the newline when
				# erasing the tag (after processing it) from the body text.
				\n?

			~msx',
			function($m) use (&$gathered) {

				$args = [];
				if (!empty($m['args'])) {
					$args = self::parseArgs($m['args']);
				}

				$gathered[] = new Tag($m['name'], $args);

				// Replace the found tag in the original text with nothing.
				return '';

		}, $text);

		return [new Tags($gathered), (string) $newText];

	}

	/** @return array<string, TagArg> */
	public static function parseArgs(string $text): array {

		$args = [];

		// Remove any newlines in the tag argument list string.
		$oneliner = preg_replace('#\h*\n\h*#m', ' ', $text);

		foreach (explode(',', $oneliner) as $arg) {

			// Valid name-value separators are ':' and '='.
			if (!$pair = preg_split('#[:=]#', $arg, 2)) {
				continue;
			}

			// Extract name.
			$name = trim($pair[0]);
			// Extract value, if defined.
			$value = isset($pair[1]) ? trim($pair[1]) : null;

			$args[$name] = new TagArg($name, $value);

		}

		return $args;

	}

}
