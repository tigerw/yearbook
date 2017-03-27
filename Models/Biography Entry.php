<?php
class BiographyEntry
{
	private static function ReconstructKeys($Array, $Prefix)
	{
		$MatchingElements = array_filter(
			$Array,
			function ($Key) use ($Prefix)
			{
				return (substr($Key, 0, strlen($Prefix)) === $Prefix);
			},
			ARRAY_FILTER_USE_KEY
		);
		
		return array_combine(
			array_map(
				function ($Key) use ($Prefix)
				{
					return substr($Key, strlen($Prefix), strlen($Key));
				},
				array_keys($MatchingElements)
			),
			array_values($MatchingElements)
		);
	}
	
	public function __construct($Record)
	{
		$this->EntryId = $Record['EntryId'];
		$this->Content = $Record['Content'] ?? '';
		$this->Signature = $Record['Signature'] ?? '';
		
		$this->Author = new Student(self::ReconstructKeys($Record, 'Author'));
		$this->Target = new Student(self::ReconstructKeys($Record, 'Target'));
	}

	public $EntryId;
	public $Content;
	public $Signature;
	
	public $Target;
	public $Author;
}