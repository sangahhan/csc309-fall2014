function Brick(canvas, x, y, img) {
	GamePiece.call(this, canvas, x, y, img);
	this.broken = false;
};

Brick.prototype = inheritFrom(GamePiece.prototype);
Brick.prototype.constructor = Brick;


Brick.prototype.testHit = function () {
}
