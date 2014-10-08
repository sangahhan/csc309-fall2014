var canvas;
var bricks = [];
var ball;
var paddle;
var score = 0;

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
	img.onload = function() {
		ctx.drawImage(img, x, y);
	};
	img.src = this.imgUrl;
};

function Ball(canvas, x, y, img) {
	GamePiece.call(this, canvas, x, y, img);
};

Ball.prototype = inheritFrom(GamePiece.prototype);
Ball.prototype.constructor = Ball;

function Brick(canvas, x, y, img) {
	GamePiece.call(this, canvas, x, y, img);
	this.broken = false;
};

Brick.prototype = inheritFrom(GamePiece.prototype);
Brick.prototype.constructor = Brick;

function Paddle(canvas, x, img) {
	GamePiece.call(this, canvas, x, canvas.clientHeight - 30, img);
	this.moving = false;
};

Paddle.prototype = inheritFrom(GamePiece.prototype);
Paddle.prototype.constructor = Paddle;

function setUpBackground(canvas, imgUrl) {
	var context = canvas.getContext("2d");
	var img = new Image();
	img.onload = function(){
		for (var w = 0; w < canvas.width; w += img.width) {
			for (var h = 0; h < canvas.height; h  += img.height) {
				context.drawImage(img, w, h);
			}
		}
	};
	img.src = imgUrl;
};

// Draw the bricks all pretty at the top
function setUpBricks() {
};

// Begin animations and breaking of bricks!
function startGame() {
};

// Keep score
function addToScore() {
};

// Levels
function changeLevel() {
};

window.onload = function() {
	scoreSpan = document.getElementById("score");
	scoreSpan.innerHTML = score;
	
	canvas = document.getElementById("game-board");
	setUpBackground(canvas, "bkg.jpg"); 
	
	ball = new Ball(canvas, 50, 50, "football2.png");
	ball.draw();
	paddle = new Paddle(canvas, 400, "full4.png");
	paddle.draw();
	
	var testBrick = new Brick(canvas, 200, 200, "wall4.png");
	testBrick.draw();
};

