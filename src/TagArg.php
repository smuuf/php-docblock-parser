<?php

declare(strict_types=1);

namespace Smuuf\DocBlockParser;

class TagArg {

	use \Smuuf\StrictObject;

	private string $name;
	private ?string $value;

	public function __construct(string $name, ?string $value = null) {
		$this->name = $name;
		$this->value = $value;
	}

	public function getName(): string {
		return $this->name;
	}

	public function getValue(): ?string {
		return $this->value;
	}

	public function hasValue(): bool {
		return $this->value !== null;
	}

}
