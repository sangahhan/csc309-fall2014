function Paddle(canvas, x, img, w, h) {
	GamePiece.call(this, canvas, x - (w / 2), canvas.height - h, img, w, h);
};

Paddle.prototype = inheritFrom(GamePiece.prototype);
Paddle.prototype.constructor = Paddle;


Paddle.prototype.draw = function() {
	this.move();
	var img = new Image();
	var ctx = this.context;
	var x = this.x;
	var y = this.y;
	var w = this.width;
	var h = this.height;
	ctx.beginPath();
	img.onload = function() {
		ctx.drawImage(img, x, y, w, h);
	}
	img.src = this.imgUrl;
};

Paddle.prototype.move = function(){
	if (rightKeyPressed){
		this.x += 8;
		if (this.x + this.width > canvas.width){
			this.x = canvas.width - this.width;
		}
	} 
	if (leftKeyPressed){
		this.x -= 8;
		if (this.x < 0){
			this.x = 0;
		}	
	}
}