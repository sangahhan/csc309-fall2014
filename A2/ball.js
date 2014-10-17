function Ball(canvas, x, y, bkg, rad) {
	GamePiece.call(this, canvas, x, y, bkg, rad * 2, rad * 2);
	this.radius = rad;
};

Ball.prototype = inheritFrom(GamePiece.prototype);
Ball.prototype.constructor = Ball;
var xdirection = -4;
var ydirection = -8;
Ball.prototype.draw = function () {
var ctx = this.context;
	ctx.beginPath();
	ctx.fillStyle = this.bkg;
	ctx.arc(this.x, this.y, this.radius, 0, 2 * Math.PI, false);
	ctx.fill();

	this.move();
	
};

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
			this.y = this.width/2;
		} else {
			this.y = canvas.height;
		}	
		ydirection = ydirection * -1;
	}
};


