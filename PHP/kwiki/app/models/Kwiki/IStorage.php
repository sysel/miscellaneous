<?php
namespace Kwiki;

interface IStorage
{
	const LATEST_VERSION = NULL;

	function load($pageName, $version = self::LATEST_VERSION);
	function store(IPage $page);
	function getHistory($pageName);
}
