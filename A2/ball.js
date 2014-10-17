function Ball(canvas, x, y, bkg, diameter) {
	GamePiece.call(this, canvas, x, y, bkg, diameter, diameter);
};

Ball.prototype = inheritFrom(GamePiece.prototype);
Ball.prototype.constructor = Ball;
var xdirection = -4;
var ydirection = -8;
Ball.prototype.draw = function () {
	var ctx = this.context;
	ctx.beginPath();
	ctx.fillStyle = this.bkg;
	ctx.arc(this.x, this.y, this.width / 2, 0, 2 * Math.PI, false);
	ctx.fill();

	this.move();
	
};
Ball.prototype.move = function () {

	this.x += xdirection;
	
	if (this.x <= 0 || (this.x > canvas.width - BALL_D)){
		if (this.x <= 0){
			this.x = 0;
		} else {
			this.x = canvas.width - BALL_D;
		}
		xdirection = xdirection * -1;
	}

	this.y += ydirection;
	if (this.y <= 0 || (this.y > (canvas.height - PADDLE_H - BALL_D))){
		if (this.y <= 0){
			this.y = 0;
		} else {
			this.y = canvas.height - PADDLE_H - BALL_D;
		}	
		ydirection = ydirection * -1;
	}
}


