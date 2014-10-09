var canvas;
var bricks = [];
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
	this.width = 32;
};

Paddle.prototype = inheritFrom(GamePiece.prototype);
Paddle.prototype.constructor = Paddle;

// Draw the bricks all pretty at the top
function setUpBricks() {
};

// Move the bottom paddle with mouse
function movePaddle() {
	// precondition: user still has balls available to play with
	window.onmousemove = function(event) {
		if (!playing) return;
		console.log(event);
		console.log(paddle);
		// TODO: change this so it lines up with the mouse.
		// it has to do with the canvas origin vs mousemove origin
		// too lazy to do the math. thx
		paddle.x = event.x;
	}
};

// Keep score
function addToScore() {
};

// Get rid of a ball
function dropBall() {
	if (balls) {
		// pop the first ball... or cut out part of the list... w.e.
	} else {
		playing = false;
	}
};

// Levels
function changeLevel() {
};

// Let's put all the if statements and magic up in hurr
function gamePlay(canvas) {
	if (playing) {

		var ball = balls[0];
	
		//Clear the canvas.
		canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
	
		//Draw bricks
		for(var i=0; i< bricks.length; i++) {
			var brick = bricks[i];
			brick.draw();
		}
	
		// Draw paddle
		movePaddle();
		paddle.draw();

		// Draw ball
		ball.draw();
	} else { 
		console.log("LOSER");
	}
};

window.onload = function() {
	scoreSpan = document.getElementById("score");
	scoreSpan.innerHTML = score;
	
	canvas = document.getElementById("game-board");
	
	paddle = new Paddle(canvas, 400, "full4.png");
	balls = [new Ball(canvas, 400, 400, "football2.png"),
	      new Ball(canvas, 400, 400, "football2.png"),
	      new Ball(canvas, 400, 400, "football2.png")];

	playing = true;
	setInterval("gamePlay(canvas)", 20);

	//var testBrick = new Brick(canvas, 0,0, "wall4.png");
	//testBrick.draw();
};

