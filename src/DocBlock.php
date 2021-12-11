<?php

declare(strict_types=1);

namespace Smuuf\DocBlockParser;

class DocBlock {

	use \Smuuf\StrictObject;

	private string $text;

	private ?string $title;
	private ?string $body;

	private Tags $tags;

	public function __construct(string $text, ?Tags $tags = null) {

		[$this->text, $this->title, $this->body] = self::processText($text);
		$this->tags = $tags ?? new Tags;

	}

	//
	// Text.
	//

	public function getText(): string {
		return $this->text;
	}

	//
	// Title.
	//

	public function getTitle(): ?string {
		return $this->title;
	}

	public function hasTitle(): bool {
		return $this->title !== null;
	}

	//
	// Body.
	//

	public function getBody(): ?string {
		return $this->body;
	}

	public function hasBody(): bool {
		return $this->body !== null;
	}

	//
	// Tags.
	//

	public function getTags(?string $name = null): Tags {
		return $this->tags->getTags($name);
	}

	public function hasTag(string $name): bool {
		return $this->tags->hasTag($name);
	}

	//
	// Helpers.
	//

	/** @return array{string, string|null, string|null} */
	private static function processText(string $text): array {

		if (trim($text) === '') {
			return ['', null, null];
		}

		if (!preg_match('#(?<title>[^\n]*)(\n(?<body>.*))?#s', $text, $m)) {
			return [$text, null, null];
		}

		$title = trim($m['title'] ?? '') ?: null;
		$body = trim($m['body'] ?? '') ?: null;

		return [$text, $title, $body];

	}

}
