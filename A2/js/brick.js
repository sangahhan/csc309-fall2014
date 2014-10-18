function Brick(canvas, x, y, bkg, stroke, w, h, s) {
	GamePiece.call(this, canvas, x, y, bkg, w, h);
	this.score = s;
	this.stroke = stroke;
};

Brick.prototype = inheritFrom(GamePiece.prototype);
Brick.prototype.constructor = Brick;

Brick.prototype.draw = function(){	
	GamePiece.prototype.draw.call(this);
	var ctx = this.context;
	ctx.lineWidth  = 1;
	ctx.strokeStyle = this.stroke;
	ctx.strokeRect(this.x, this.y, this.width, this.height);
};

