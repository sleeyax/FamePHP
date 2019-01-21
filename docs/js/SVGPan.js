/*
 * FamePHP
 *
 * Facebook Messenger bot framework
 *
 * @copyright Copyright (c) 2018 - 2019
 * @author Sleeyax (https://github.com/sleeyax)
 * @link https://github.com/sleeyax/FamePHP
 * @license https://github.com/sleeyax/FamePHP/blob/master/LICENSE
 */

var root = document.documentElement;

var state = 'none', stateTarget, stateOrigin, stateTf;

setupHandlers(root);

/**
 * Register handlers
 */
function setupHandlers(root){
	setAttributes(root, {
		"onmouseup" : "add(evt)",
		"onmousedown" : "handleMouseDown(evt)",
		"onmousemove" : "handleMouseMove(evt)",
		"onmouseup" : "handleMouseUp(evt)",
//		"onmouseout" : "handleMouseUp(evt)" // Decomment this to stop the pan functionality when dragging out of the SVG element
	});

	if(navigator.userAgent.toLowerCase().indexOf('webkit') >= 0)
		window.addEventListener('mousewheel', handleMouseWheel, false); // Chrome/Safari
	else
		window.addEventListener('DOMMouseScroll', handleMouseWheel, false); // Others
}

/**
 * Instance an SVGPoint object with given event coordinates.
 */
function getEventPoint(evt) {
	var p = root.createSVGPoint();

	p.x = evt.clientX;
	p.y = evt.clientY;

	return p;
}

/**
 * Sets the current transform matrix of an element.
 */
function setCTM(element, matrix) {
	var s = "matrix(" + matrix.a + "," + matrix.b + "," + matrix.c + "," + matrix.d + "," + matrix.e + "," + matrix.f + ")";

	element.setAttribute("transform", s);
}

/**
 * Dumps a matrix to a string (useful for debug).
 */
function dumpMatrix(matrix) {
	var s = "[ " + matrix.a + ", " + matrix.c + ", " + matrix.e + "\n  " + matrix.b + ", " + matrix.d + ", " + matrix.f + "\n  0, 0, 1 ]";

	return s;
}

/**
 * Sets attributes of an element.
 */
function setAttributes(element, attributes){
	for (i in attributes)
		element.setAttributeNS(null, i, attributes[i]);
}

/**
 * Handle mouse move event.
 */
function handleMouseWheel(evt) {
	if(evt.preventDefault)
		evt.preventDefault();

	evt.returnValue = false;

	var svgDoc = evt.target.ownerDocument;

	var delta;

	if(evt.wheelDelta)
		delta = evt.wheelDelta / 3600; // Chrome/Safari
	else
		delta = evt.detail / -90; // Mozilla

	var z = 1 + (delta * 1.2); // Zoom factor: 0.9/1.1

	var g = svgDoc.getElementById("viewport");

	var p = getEventPoint(evt);

	p = p.matrixTransform(g.getCTM().inverse());

	// Compute new scale matrix in current mouse position
	var k = root.createSVGMatrix().translate(p.x, p.y).scale(z).translate(-p.x, -p.y);

        setCTM(g, g.getCTM().multiply(k));

	stateTf = stateTf.multiply(k.inverse());
}

/**
 * Handle mouse move event.
 */
function handleMouseMove(evt) {
	if(evt.preventDefault)
		evt.preventDefault();

	evt.returnValue = false;

	var svgDoc = evt.target.ownerDocument;

	var g = svgDoc.getElementById("viewport");

	if(state == 'pan') {
		// Pan mode
		var p = getEventPoint(evt).matrixTransform(stateTf);

		setCTM(g, stateTf.inverse().translate(p.x - stateOrigin.x, p.y - stateOrigin.y));
	} else if(state == 'move') {
		// Move mode
		var p = getEventPoint(evt).matrixTransform(g.getCTM().inverse());

		setCTM(stateTarget, root.createSVGMatrix().translate(p.x - stateOrigin.x, p.y - stateOrigin.y).multiply(g.getCTM().inverse()).multiply(stateTarget.getCTM()));

		stateOrigin = p;
	}
}

/**
 * Handle click event.
 */
function handleMouseDown(evt) {
	if(evt.preventDefault)
		evt.preventDefault();

	evt.returnValue = false;

	var svgDoc = evt.target.ownerDocument;

	var g = svgDoc.getElementById("viewport");

//	if(evt.target.tagName == "svg") {
		// Pan mode
		state = 'pan';

		stateTf = g.getCTM().inverse();

		stateOrigin = getEventPoint(evt).matrixTransform(stateTf);
//	} else {
		// Move mode
//		state = 'move';
//
//		stateTarget = evt.target;
//
//		stateTf = g.getCTM().inverse();
//
//		stateOrigin = getEventPoint(evt).matrixTransform(stateTf);
//	}
}

/**
 * Handle mouse button release event.
 */
function handleMouseUp(evt) {
	if(evt.preventDefault)
		evt.preventDefault();

	evt.returnValue = false;

	var svgDoc = evt.target.ownerDocument;

	if(state == 'pan' || state == 'move') {
		// Quit pan mode
		state = '';
	}
}

