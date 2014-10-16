function Ball(canvas, x, y, img, diameter) {
	GamePiece.call(this, canvas, x, y ,img, diameter, diameter);
};

Ball.prototype = inheritFrom(GamePiece.prototype);
Ball.prototype.constructor = Ball;

Ball.prototype.move = function () {
	this.x += dx;
	this.y += dy;
}

