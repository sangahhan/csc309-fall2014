var canvas;
var bricks = [];
var ball;
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
	img.onload = function() {
		ctx.drawImage(img, 0, 0);
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

Brick.prototype = inheritFrom(GamePiece);
Brick.prototype.constructor = Brick;

function Paddle(canvas, x, img) {
	GamePiece.call(this, canvas, x, 0, img);
	this.moving = false;
};

Paddle.prototype = inheritFrom(GamePiece);
Paddle.prototype.constructor = Paddle;

window.onload = function() {
	canvas = document.getElementById("game-board");
	ball = new Ball(canvas, 50, 50, "football2.png");
	ball.draw();
};

