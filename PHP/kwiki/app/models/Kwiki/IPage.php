<?php
namespace Kwiki;

interface IPage
{
	function getName();
	function getContent();

	function unpack($data);
	function pack();
}
