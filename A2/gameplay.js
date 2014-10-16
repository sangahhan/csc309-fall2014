// Draw the bricks all pretty at the top
function drawBricks(bricks) {
	for (var i = 0; i < bricks.length; i++) {
		for (var j = 0; j < bricks[i].length; j++) {
			bricks[i][j].draw();
		}
	}
};

function newBricks(rows, cols) {
	var bricks = [];
	var current_x = 0;
	var current_y = 0;
	for (var i = 0; i < rows; i++) {
		var row = [];
		for (var j = 0; j < cols; j++) {
			row.push(new Brick(canvas, current_x, current_y, BRICK_I, 60, 50));
			current_x += BRICK_W;
		}
		current_y += BRICK_H;
		current_x = 0;
		bricks.push(row);
	}
	return bricks;
};

// Move the bottom paddle with mouse
function movePaddle() {
};

// Keep score
function addToScore() {
};

// Get rid of a ball
function dropBall() {
};

// Levels
function changeLevel() {
};

// Let's put all the if statements and magic up in hurr
function gamePlay(canvas) {
	drawGamePieces();
};

function drawGamePieces(){
	var ctx = canvas.getContext("2d");
	ctx.clearRect(0,0,canvas.width, canvas.height);
	ctx.fillStyle="#FF0000";
	ctx.fillRect(0, 0, canvas.width, canvas.height);
	paddle.draw();
	drawBricks(bricks);
	balls[0].draw();
}

window.onload = function() {
	scoreSpan = document.getElementById("score");
	scoreSpan.innerHTML = score;
	
	canvas = document.getElementById("game-board");
	var ctx = canvas.getContext("2d");

	
	paddle = new Paddle(canvas, 400, PADDLE_I, PADDLE_W, PADDLE_H);
	balls = [new Ball(canvas, (canvas.width/2) - (BALL_D/2), 
		canvas.height - PADDLE_H - BALL_D, BALL_I, BALL_D, BALL_D),
	      new Ball(canvas, 400, 400, BALL_I, BALL_D, BALL_D),
	      new Ball(canvas, 400, 400, BALL_I, BALL_D, BALL_D)];
	// TODO: set up bricks
		
	playing = true;
	bricks = newBricks(4, 11);
	interval = setInterval("gamePlay(canvas)", 20);
	
};

