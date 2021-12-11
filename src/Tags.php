<?php

declare(strict_types=1);

namespace Smuuf\DocBlockParser;

/**
 * Container for `Tag` objects.
 */
class Tags {

	use \Smuuf\StrictObject;

	/** @var array<Tag> Instances of `Tag` this `Tags` object wraps. */
	private array $tags = [];

	/**
	 * @param array<Tag> $tags
	 */
	public function __construct(array $tags = []) {
		$this->tags = $tags;
	}

	/**
	 * Returns `true` is this `Tags` object contains at least one `Tag` object
	 * representing a tag with specified name.
	 */
	public function hasTag(string $name): bool {

		foreach ($this->tags as $tag) {
			if ($tag->getName() === $name) {
				return true;
			}
		}

		return false;

	}

	/**
	 * If the `$name` is specified, this method returns a new `Tags` object
	 * containing only a subset of `Tag` objects that have the specified name.
	 *
	 * If the `$name` is not specified, this method returns this original `Tags`
	 * object.
	 */
	public function getTags(?string $name = null): Tags {

		if ($name === null) {
			return $this;
		}

		$filtered = array_filter(
			$this->tags,
			fn($tag) => $tag->getName() === $name
		);

		return new Tags($filtered);

	}

	/**
	 * Returns all `Tag` objects contained in this `Tags` object.
	 *
	 * @return array<Tag>
	 */
	public function getAll(): array {
		return $this->tags;
	}

	/**
	 * Return **the first** `Tag` object present in this `Tags` object _(which
	 * may or may not contain multiple `Tag` objects)_.
	 */
	public function getFirst(): ?Tag {

		if ($this->tags) {
			return reset($this->tags);
		}

		return null;

	}

}
