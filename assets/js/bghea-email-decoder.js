/**
 * \fn hideContacts_DecodeString( stringToDecode) 
 * \brief Decodes given string from hex representation to normal text
 * \param stringToDecode input string to be decoded
 * \return decoded string
 */
function hideContacts_DecodeString( stringToDecode) {
	if( null == stringToDecode) {
		return null;
	}

	/* Depending on the innerHTML formatting of an element and its content might 
	 * contain whilte spaces around it. We are getting rid of them here.
	 */
	stringToDecode = stringToDecode.trim();
	
	/* First element of split string of hex codes will always be an empty string, 
	 * so we slice the array starting from element #1.
	 */
	var splitHexCodes =  stringToDecode.split( "0x").slice(1);
	
	var decodedString = "";
	for( let charCode of splitHexCodes) {		
		var decodedChar = parseInt( charCode, 16);
		if( NaN == decodedChar) {
			return null;
		}

		decodedString += String.fromCharCode( decodedChar);
	}

	return decodedString;
}


function bghea_drawEmailAddressOnCanvas( canvasId, emailAddress) {
	var textBorderPx = 1;

	var canvasToDrawTo = document.getElementById( canvasId);

	var canvasContext = canvasToDrawTo.getContext( "2d");
	
	var parentElem = canvasToDrawTo.parentNode;

	/** Applying font parameters to the canvas to calculate the
	 * dimensions of the rectangle needed to outline the text.
	 */
	var tmpParentStyle = window.getComputedStyle( parentElem);
	var tmpFont = '';
	var tmpFontColor = window.getComputedStyle( parentElem).getPropertyValue('color');
	
	if (tmpParentStyle.font)
      tmpFont = tmpParentStyle.font;
    else {
      var fontStyle = tmpParentStyle.getPropertyValue('font-style');
      var fontVariant = tmpParentStyle.getPropertyValue('font-variant');
      var fontWeight = tmpParentStyle.getPropertyValue('font-weight');
      var fontSize = tmpParentStyle.getPropertyValue('font-size');
      var fontFamily = tmpParentStyle.getPropertyValue('font-family');

      tmpFont = (fontStyle + ' ' + fontVariant + ' ' + fontWeight + ' ' + fontSize + ' ' + fontFamily).replace(/ +/g, ' ').trim();
	}
	canvasContext.font = tmpFont;

	/** Adjusting Canvas dimensions: */
	canvasToDrawTo.width = 2 * textBorderPx + 
		canvasContext.measureText( emailAddress).width;
	
	var fontHeight = parseInt( tmpParentStyle.fontSize.replace( "px", ""), 10);
	var lineHeight = parseInt( tmpParentStyle.lineHeight, 10);


	canvasToDrawTo.height = lineHeight;
	
	/** Applying font parameters again, since canvas size
	 * modification clears the canvas.
	 * See the explanation here https://stackoverflow.com/a/4939066/6231882
	 */
	canvasContext.font = tmpFont;
	canvasContext.fillStyle = tmpFontColor;

	/** Rendering text to the canvas, adding borders around the text */
	canvasContext.fillText(
		emailAddress,
		textBorderPx, fontHeight - textBorderPx
	);
}


function bghea_onCanvasWasClicked( canvasElem) {
	var tmpDecodedEmail = hideContacts_DecodeString( canvasElem.innerHTML);

	var tmpSpanElement = document.createElement( "span");
	var spanContent = document.createTextNode( tmpDecodedEmail);
	tmpSpanElement.appendChild( spanContent);

	var parentElement = canvasElem.parentNode;
	parentElement.replaceChild( tmpSpanElement, canvasElem);
}


window.onload = function () {
	var allCanvasElements = document.getElementsByTagName( "canvas");
	
	for( let canvas of allCanvasElements) {
		var tmpCanvasID = canvas.attributes[ "id"];
		if( !tmpCanvasID) {
			continue;
		}
		
		if( tmpCanvasID.textContent.startsWith( "bghea-id_") ) {
			console.log( tmpCanvasID);
			var tmpDecodedEmailAddr = hideContacts_DecodeString( canvas.innerHTML);
			bghea_drawEmailAddressOnCanvas( tmpCanvasID.textContent, tmpDecodedEmailAddr);
		}
	}
}
