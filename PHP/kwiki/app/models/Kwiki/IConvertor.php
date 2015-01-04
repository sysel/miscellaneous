<?php
namespace Kwiki;

interface IConvertor
{
	function compile($text);
	function decompile($html);
}
