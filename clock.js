/**
 * Setup and start an analog clock using a canvas
 * @param canvas The canvas to use
 * @param clockWidth The width of the clock (radius*2)
 */
	setupAnalogClock(document.getElementById("analogClock"), 300);
function setupAnalogClock(canvas, clockWidth) {
//		var canvas = document.getElementById("analogClock");
	var ctx = canvas.getContext("2d");
	var centerX = canvas.width / 2;
	var centerY = canvas.height / 2;

	function tick() {
		var date = new Date();
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		drawStatic();

		var hours = date.getHours();
		ctx.strokeStyle = "white";
		ctx.lineWidth = 5;
		drawHand(clockWidth/4, hours * 30);

		var minutes = date.getMinutes();
		ctx.strokeStyle = "white";
		ctx.lineWidth = 5;
		drawHand((clockWidth/2)-30, minutes * 6);

		var seconds = date.getSeconds();
		ctx.strokeStyle = "white";
		ctx.lineWidth = 1;
		drawHand(clockWidth/2, seconds * 6);


		function drawStatic() {
			ctx.beginPath();
			ctx.arc(centerX, centerY, clockWidth/2, 0, 2 * Math.PI, false);
			ctx.strokeStyle = "white";
			ctx.lineWidth = 5;
			ctx.stroke();
			ctx.closePath();

			ctx.beginPath();
			ctx.arc(centerX, centerY, 3, 0, 2 * Math.PI, false);
			ctx.fillStyle = "white";
			ctx.fill();
			ctx.closePath();

			drawNumbers();

			function drawNumbers() {
				var i = 12;
				ctx.strokeStyle = "white";
				while(i > 0) {
          ctx.lineWidth = 2;
					ctx.save();
					ctx.beginPath();
					ctx.translate(centerX, centerY);
					var angle = (i * 30) * Math.PI/180;
					ctx.rotate(angle);
					ctx.translate(0, -clockWidth/2);

					// Drawing numbers doesn't look so good because of the origin of the text
//					ctx.save();
//					ctx.translate(0, -10);
//					ctx.rotate(-angle);
//					ctx.fillText(i, -3, 0);
//					ctx.restore();
					ctx.moveTo(0, 0);
					ctx.lineTo(0, 20);
					ctx.stroke();
					ctx.closePath();
					ctx.restore();
					i --;
				}
			}
		}

		function drawHand(length, angle) {
			ctx.save();
			ctx.beginPath();
			ctx.translate(centerX, centerY);
			ctx.rotate(-180 * Math.PI/180); // Correct for top left origin
			ctx.rotate(angle * Math.PI/180);
			ctx.moveTo(0, 0);
			ctx.lineTo(0, length);
			ctx.stroke();
			ctx.closePath();
			ctx.restore();
		}
	}

	tick();
	window.setInterval(tick, 1000);
}
