function Brick(canvas, x, y, bkg, w, h, s) {
	GamePiece.call(this, canvas, x, y, bkg, w, h);
	this.score = s;
};

Brick.prototype = inheritFrom(GamePiece.prototype);
Brick.prototype.constructor = Brick;

Brick.prototype.draw = function(){	
	GamePiece.prototype.draw.call(this);
	var ctx = this.context;
	ctx.lineWidth  = 1;
	ctx.strokeStyle = "black";
	ctx.strokeRect(this.x, this.y, this.width, this.height);
};

Brick.prototype.testHit = function (ball) {
	var x_min = this.x;
	var x_max = x_min + this.width;
	var y_min = this.y;
	var y_max = y_min + this.height;
	// TODO: ball can only hit from bottom; make it so that it can hit from all around
	return ball.x >= x_min && ball.x <= x_max && ball.y >= y_min && ball.y <= y_max;
};
