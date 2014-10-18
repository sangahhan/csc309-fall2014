var BRICK_W = 57; 
var BRICK_H = 25;
var PADDLE_W = 150;
var PADDLE_H = 20;
var BALL_R = 10;

var PADDLE_I = "gray";
var BALL_I = "#F433FF";
var BRICK_I = ["yellow", "yellow", "green", "green", "orange", "orange", "red", "red"];

var BRICK_ROWS = 8;
var BRICK_COLS = 14;
var BRICK_SCORES = [1,1,3,3,5,5,7,7];

var canvas;
var interval;
var bricks; 
var balls = [];
var paddle;
var score = 0;
var playing = false;

var rightKeyPressed = false; 
var leftKeyPressed = false;
var smallPaddle = false;

var xdirection = -4;
var ydirection = -8;
var numHits = 0;
var speedIncreaseOrangeRow = false;
var speedIncreaseRedRow = false;

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

