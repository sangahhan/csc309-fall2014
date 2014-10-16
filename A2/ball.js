function Ball(canvas, x, y, img, w, h) {
	GamePiece.call(this, canvas, x, y ,img, w, h);
};

Ball.prototype = inheritFrom(GamePiece.prototype);
Ball.prototype.constructor = Ball;

Ball.prototype.move = function () {
	this.x += dx;
	this.y += dy;
}

