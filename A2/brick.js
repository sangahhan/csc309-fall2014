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

