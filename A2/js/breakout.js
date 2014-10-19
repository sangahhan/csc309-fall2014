var PADDLE_I = "#795548";
var BALL_I = "#f06292";
var BRICK_BKG = [
	"#fbc02d", "#fbc02d",  //yellow
	"#056f00", "#056f00", //green
	"#e65100", "#e65100",  //orange
	"#c41411", "#c41411" //red
];
var BRICK_BKG_S = [
	"#fff176", "#fff176",   //yellow
	"#2baf2b", "#2baf2b", //green
	"#fb8c00", "#fb8c00",  //orange
	"#f36c60", "#f36c60" //red
];

var BRICK_SCORES = [1,1,3,3,5,5,7,7];
var BRICK_COLS = 14;
var BRICK_ROWS = BRICK_SCORES.length;
var LEVEL_SCORE = 0;
for (var i = 0; i < BRICK_ROWS; i++) {
	LEVEL_SCORE += BRICK_SCORES[i] * BRICK_COLS;
}
var BRICK_W = 800/BRICK_COLS;
var BRICK_H = 25;
var PADDLE_W = 150;
var PADDLE_H = 20;
var BALL_R = 10;

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
var currPaddleSpeed = 8;

var xdirection = -4;
var ydirection = -8;
var numHits = 0;
var speedIncreaseOrangeRow = false;
var speedIncreaseRedRow = false;

// Taken from: http://stackoverflow.com/questions/7533473/javascript-inheritance-when-constructor-has-arguments
// To be used for multi-arg inheritance
function inheritFrom(type) {
	function F() {}; // Dummy constructor
	F.prototype = type; 
	return new F(); 
};

/*
 * Any piece from the game that will appear on the canvas.
 */
function GamePiece(canvas, x, y, bkg, width, height) {
	this.context = canvas.getContext("2d");
	this.x = x;
	this.y = y;
	this.width = width;
	this.height = height;
	this.bkg = bkg;
};

/*
 * Place a GamePiece on its appropriate canvas.
 */
GamePiece.prototype.draw = function() {
	var ctx = this.context;
	ctx.beginPath();
	ctx.fillStyle = this.bkg;
	ctx.fillRect(this.x, this.y, this.width, this.height);
};

/*
 * The game ball -- takes canvas, x & y coordinates, a background colour and radius
 */
function Ball(canvas, x, y, bkg, rad) {
	GamePiece.call(this, canvas, x, y, bkg, rad * 2, rad * 2);
	this.radius = rad;
};

Ball.prototype = inheritFrom(GamePiece.prototype);
Ball.prototype.constructor = Ball;

/* 
 * Draw a ball as a circle on its canvas.
 */
Ball.prototype.draw = function () {
	var ctx = this.context;
	ctx.beginPath();
	ctx.fillStyle = this.bkg;
	ctx.arc(this.x, this.y, this.radius, 0, 2 * Math.PI, false);
	ctx.fill();
	this.move();
};

/*
 * Change a ball's x & y coordinates based on its current position.
 */
Ball.prototype.move = function () {
	this.x += xdirection;
	if (this.x - this.width/2 <= 0 || (this.x >= canvas.width - this.width/2)){
		if (this.x - this.width/2 <= 0){
			this.x = this.width/2;
		} else {
			this.x = canvas.width - this.width/2;
		}
		xdirection = xdirection * -1;
	}
	this.y += ydirection;
	if (this.y -  this.width/2 <= 0 || (this.y > canvas.height )){
		if (this.y - this.width/2 <= 0){
			if (!smallPaddle){
				shrinkPaddle();
			}
			this.y = this.width/2;
		} else {
			this.y = canvas.height;
		}	
		ydirection = ydirection * -1;
	}
};

/*
 * A brick for the game -- takes canvas, x & y coordinates, background colour,
 * border colour width height, and score value (how many points hitting this 
 * brick will get you).
 */
function Brick(canvas, x, y, bkg, stroke, w, h, s) {
	GamePiece.call(this, canvas, x, y, bkg, w, h);
	this.score = s;
	this.stroke = stroke;
};

Brick.prototype = inheritFrom(GamePiece.prototype);
Brick.prototype.constructor = Brick;

/* 
 * Draw a brick as a normal gamepiece and then add a border.
 */
Brick.prototype.draw = function(){	
	GamePiece.prototype.draw.call(this);
	var ctx = this.context;
	ctx.lineWidth  = 1;
	ctx.strokeStyle = this.stroke;
	ctx.strokeRect(this.x, this.y, this.width, this.height);
};

function Paddle(canvas, x, img, w, h) {
	GamePiece.call(this, canvas, x, canvas.height - h, img, w, h);
	this.speed = currPaddleSpeed;
};

Paddle.prototype = inheritFrom(GamePiece.prototype);
Paddle.prototype.constructor = Paddle;

/*
 * Move the paddle if right/left arrow has been pressed.
 */
Paddle.prototype.move = function(){
	if (rightKeyPressed){
		this.x += this.speed;
		if (this.x + this.width > canvas.width) 
			this.x = canvas.width - this.width;
	} 
	if (leftKeyPressed){
		this.x -= this.speed;
		if (this.x < 0) this.x = 0;
	}
};

Paddle.prototype.draw = function() {
	this.move();
	GamePiece.prototype.draw.call(this);
};

Paddle.prototype.shrinkSize = function(){
	this.width = this.width/2;
};

/*
 * Draw all bricks in the given list of bricks.
 */
function drawBricks(bricks) {
	for (var i = 0; i < bricks.length; i++) {
		if (bricks[i]) bricks[i].draw();
	}
};

/* 
 * Generate a new list of bricks with the specified number of rows and columns.
 */
function newBricks(rows, cols) {
	var bricks = [];
	var current_x = 0;
	var current_y = 0;
	for (var i = BRICK_ROWS; i > 0; i--) {
		for (var j = 0; j < cols; j++) {
			bricks.push(new Brick(canvas, current_x, current_y, 
						BRICK_BKG[i-1], 
						BRICK_BKG_S[i-1], 
						BRICK_W, BRICK_H, 
						BRICK_SCORES[i-1]));
			current_x += BRICK_W;
		}
		current_y += BRICK_H;
		current_x = 0;
	}
	return bricks;
};

/*
 * Generate a new list of <num> balls
 */
function newBalls(num) {
	var balls = [];
	var x = (canvas.width / 2);
	var y = canvas.height - PADDLE_H - BALL_R;
	for (var i = 0; i < num; i++) {
		balls.push(new Ball(canvas, x, y, BALL_I, BALL_R));
	}
	return balls;
};

/* 
 * Return true if the current ball hits a brick, false otherwise. 
 * Precondition: a ball exists in the global list of balls
 */
function testHitBricks() {
	if (!bricks.length) return false; 
	var row = Math.floor(balls[0].y/BRICK_H);
	var col = Math.floor(balls[0].x/BRICK_W);
	var index = col + (row * BRICK_COLS)
	if (balls[0].y < BRICK_ROWS * BRICK_H && row >= 0 && col >= 0 && bricks[index]) {
		ydirection *= -1;
		score += bricks[index].score;
		bricks[index] = 0;
	
		// Increase ball speed if we've reached a certain number of hits
		numHits += 1;
		if (numHits == 4 || numHits == 12){
			increaseBallSpeed();
		}
		
		if ((row == 2 || row == 3) && (!speedIncreaseOrangeRow)){
			speedIncreaseOrangeRow = true;
			increaseBallSpeed();
		}
		if ((row == 0 || row == 1) && (!speedIncreaseRedRow)){
			speedIncreaseRedRow = true;
			increaseBallSpeed();
		}
		return true;
	}            
	return false;
};

/*
 * Return true if the current ball hits the paddle, false otherwise. 
 */
function testHitPaddle() {
	if (!balls.length) return false;	
	var x_min = paddle.x;
	var x_max = paddle.x + paddle.width;
	var y = paddle.y;
	var ball_bottom = balls[0].y + balls[0].radius;
	return ydirection > 0 && balls[0].x >= x_min && balls[0].x <= x_max && ball_bottom >= y;
};

/*
 * Toggle being able to move the paddle if left/right arrow keys are pressed. 
 * Stop / start the game if the enter key is pressed.
 */
function movePaddle(evt) {
	if (evt.keyCode == 39) rightKeyPressed = true;
	else if (evt.keyCode == 37) leftKeyPressed = true;
	else if (evt.keyCode == 13) {
		if (balls.length) {
			if (playing) gameStop();
			else { 
				gameStart();
				ballsSpan.html("Balls left: " + balls.length);
			}
		} else {
			resetBoard();
			score = 0;
			balls = newBalls(3);
			ballsSpan.html("Press ENTER to start/pause the game.");
			scoreSpan.html("Score: " + score);
		}
	}
	else return;
};

/*
 * Toggle being able to move the paddle if the left/right arrow keys are 
 * released.
 */
function stopMovingPaddle(evt) {
	if (evt.keyCode == 39) rightKeyPressed = false;
	else if (evt.keyCode == 37) leftKeyPressed = false;
	else return;
};

/*
 * Decrease paddle size.
 */
function shrinkPaddle(){
	smallPaddle = true;
	paddle.shrinkSize();
}

/*
 * Increase ball speed.
 */
function increaseBallSpeed(){
	if (xdirection > 0){
		xdirection += 2;
	} else {
		xdirection -= 2;
	}
	
	if (ydirection >0){
		ydirection += 1;
	} else  {
		ydirection -= 1;
	}
	
	// When the paddle is small, need to move faster
	if(smallPaddle)
		paddle.speed += 5;
	} else {
		paddle.speed += 3;
	}
	currPaddleSpeed = paddle.speed;
}

/* 
 * Draw bricks, paddle and current ball on the board.
 * Precondition: balls exist in the global list of balls.
 */
function drawAll() {
	canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
	drawBricks(bricks);
	balls[0].draw();
	paddle.draw();
};

/* 
 * Clear the board, reset all values and draw again.
 */
function resetBoard() {	
	numHits = 0;
	speedIncreaseOrangeRow = false;
	speedIncreaseRedRow = false;
	
	bricks = newBricks(BRICK_ROWS, BRICK_COLS);
	paddle = new Paddle(canvas, (canvas.width / 2) - (PADDLE_W/ 2), PADDLE_I, PADDLE_W, PADDLE_H);
	
	// If the game is reset to the very beginning, then reset the speed of the
	// ball and the paddle. Otherwise, only change the direction of the 
	// ball.
	smallPaddle = false;
	
	if (score < LEVEL_SCORE && numHits < 4){
		xdirection = -4;
		ydirection = -8;
		currPaddleSpeed = 8;
		paddle.speed = currPaddleSpeed;
	} else {
		if (ydirection > 0){
			ydirection *= -1;
		}
	}
	
	drawAll();
};

/*
 * Take appropriate action if player has passed a level.
 */
function levelCheck() {
	var sum; // will either be 0 or a string
	for (var i = 0; i < bricks.length; i++) { sum += bricks[i];} 	
	if (!sum) {
		if (score == LEVEL_SCORE) {
			resetBoard();
			console.log(balls);
			var x = (canvas.width / 2);
			var y = canvas.height - PADDLE_H - BALL_R;
			balls[0].x = x;
			balls[0].y = y;
			drawAll();
			gameStop();
			ballsSpan.html("LEVEL 2");
			return true;
		} else if (score == LEVEL_SCORE * 2) {
			gameStop();
			scoreSpan.html("WINNER");
			ballsSpan.html("Press ENTER to play again.");
			return true;
		}
	}
	return false;
};

/*
 * Take appropriate action if player has lost a ball.
 */
function onLose(){
	balls.shift();
	if (balls.length) {
		paddle.x = (canvas.width / 2) - (paddle.width/ 2);
		ballsSpan.html("Press ENTER to continue.");
	} else {
		scoreSpan.html("GAME OVER");
		ballsSpan.html("Press ENTER to play again.");
	}
	gameStop();
};

/* 
 * Stop animation & all movement.
 */
function gameStop() {
	playing = false;
	clearInterval(interval);
};

/*
 * Begin the animation/ movement
 */
function gameStart() {
	playing = true;
	interval = setInterval("gameRun()", 30);
};

/*
 * Start and stop the game when necessary.
 */
function gameRun() {
	if (playing) {
		if (testHitBricks()) scoreSpan.html("Score: " + score);
		if (!testHitPaddle()) {
			if (balls[0].y >= (canvas.height - paddle.height)) {
				onLose();
				/*
				 * so we don't try to draw everything if there
				 * are no balls left
				 */
				if (!balls.length) return;
			}
		} else {
			ydirection *= -1;
		}
		if (!levelCheck()) drawAll();
	}
};

$(function() {
	scoreSpan = $("#score");
	scoreSpan.html("Score: " + score);
		
	ballsSpan = $("#balls");

	canvas = $("#game-window")[0];
	balls = newBalls(3);
	resetBoard();	
	$(document).keydown(movePaddle);
	$(document).keyup(stopMovingPaddle);
	ballsSpan.html("Press ENTER to start/pause the game.");
});

