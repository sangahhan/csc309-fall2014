var canvas;
var interval;
var bricks = [[][][]]; // [row][col] ... like in Towers of Hanoi
var balls = [];
var paddle;
var score = 0;
var playing = false;
var dx = 2;
var dy = 4;

// Taken from: http://stackoverflow.com/questions/7533473/javascript-inheritance-when-constructor-has-arguments
function inheritFrom(type) {
	function F() {}; // Dummy constructor
	F.prototype = type; 
	return new F(); 
}

function GamePiece(canvas, x, y, img) {
	this.context = canvas.getContext("2d");
	this.x = x;
	this.y = y;
	this.imgUrl = img;
};

GamePiece.prototype.draw = function() {
	var img = new Image();
	var ctx = this.context;
	var x = this.x;
	var y = this.y;
	ctx.beginPath();
	img.onload = function() {
		ctx.drawImage(img, x, y);
	};
	img.src = this.imgUrl;
};

