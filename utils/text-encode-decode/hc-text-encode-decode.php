<?php

/**
 * \fn bghea_EncodeString( $stringToEncode)
 * \brief Encodes given string into hex values of each character code
 * \return encoded string on success, NULL on failure
 */
function bghea_EncodeString( $stringToEncode) {
	if( !is_string( $stringToEncode) ) {
		return NULL;
	}
	
	$stringToEncode = trim( $stringToEncode);
	
	$tmpSplitStringToEncode = str_split( $stringToEncode);
	if( FALSE === $tmpSplitStringToEncode) {
		return NULL;
	}

	$encodedString = "";
	foreach( $tmpSplitStringToEncode as $charToEncode) {
		$encodedString = $encodedString . "0x" . dechex( ord( $charToEncode));
	}
	
	return $encodedString;
}

?>