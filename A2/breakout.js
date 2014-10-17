var BRICK_W = 100; 
var BRICK_H = 50;
var PADDLE_W = 150;
var PADDLE_H = 30;
var BALL_R = 25;

var PADDLE_I = "gray";
var BALL_I = "pink";
var BRICK_I = ["yellow", "green", "orange", "red"];

var BRICK_ROWS = 4;
var BRICK_COLS = 8;
var BRICK_SCORES = [1,3,5,7];

var canvas;
var interval;
var bricks; // [row][col] ... like in Towers of Hanoi
var balls = [];
var paddle;
var score = 0;
var playing = false;

var rightKeyPressed = false; 
var leftKeyPressed = false;

// Taken from: http://stackoverflow.com/questions/7533473/javascript-inheritance-when-constructor-has-arguments
function inheritFrom(type) {
	function F() {}; // Dummy constructor
	F.prototype = type; 
	return new F(); 
};

function GamePiece(canvas, x, y, bkg, width, height) {
	this.context = canvas.getContext("2d");
	this.x = x;
	this.y = y;
	this.width = width;
	this.height = height;
	this.bkg = bkg;
};

GamePiece.prototype.draw = function() {
	var ctx = this.context;
	ctx.beginPath();
	ctx.fillStyle = this.bkg;
	ctx.fillRect(this.x, this.y, this.width, this.height);
};

