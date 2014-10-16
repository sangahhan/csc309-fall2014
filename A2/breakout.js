var BRICK_W = 75; 
var BRICK_H = 40;
var PADDLE_W = 128;
var PADDLE_H = 30;
var BALL_D = 30;

var PADDLE_I = "blackbox.jpeg";
var BALL_I ="red.jpg";
var BRICK_I = ["yellow.jpg", "green.gif", "orange.png", "red.jpg"];

var BRICK_ROWS = 4;
var BRICK_COLS = 11;
var BRICK_SCORES = [1,3,5,7];

var canvas;
var interval;
var bricks; // [row][col] ... like in Towers of Hanoi
var balls = [];
var paddle;
var score = 0;
var playing = false;

// Taken from: http://stackoverflow.com/questions/7533473/javascript-inheritance-when-constructor-has-arguments
function inheritFrom(type) {
	function F() {}; // Dummy constructor
	F.prototype = type; 
	return new F(); 
}

function GamePiece(canvas, x, y, img, width, height) {
	this.context = canvas.getContext("2d");
	this.x = x;
	this.y = y;
	this.width = width;
	this.height = height;
	this.imgUrl = img;
};

GamePiece.prototype.draw = function() {
	var img = new Image();
	var ctx = this.context;
	var x = this.x;
	var y = this.y;
	var w = this.width; 
	var h = this.height;
	ctx.beginPath();
	img.onload = function() {
		ctx.drawImage(img, x, y, w, h);
	};
	img.src = this.imgUrl;
};

