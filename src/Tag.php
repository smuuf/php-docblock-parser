<?php

declare(strict_types=1);

namespace Smuuf\DocBlockParser;

class Tag {

	use \Smuuf\StrictObject;

	/**
	 * Tag name.
	 */
	private string $name;

	/**
	 * Tag arguments.
	 *
	 * @var array<string, TagArg>
	 */
	private array $args;

	/** @param array<string, TagArg> $args */
	public function __construct(string $name, array $args = []) {
		$this->name = $name;
		$this->args = $args;
	}

	/**
	 * Get name of tag.
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * Get list of all args.
	 *
	 * @return array<string, TagArg> */
	public function getArgs(): array {
		return $this->args;
	}

	/**
	 * Return `true` if arg specified by `name` is present.
	 */
	public function hasArg(string $name): bool {
		return isset($this->args[$name]);
	}

	/**
	 * Return arg specified by `name` or null if such tag is not present.
	 */
	public function getArg(string $name): ?TagArg {
		return $this->args[$name] ?? null;
	}

}
