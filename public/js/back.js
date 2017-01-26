/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(1);


/***/ },
/* 1 */
/***/ function(module, exports) {

	var canvasDots = function() {
	    var canvas = document.querySelector('canvas'),
	        ctx = canvas.getContext('2d'),
	        colorDot = '#444343',
	        color = '#a0a0a0';
	    canvas.width = window.innerWidth;
	    canvas.height = window.innerHeight;
	    canvas.style.display = 'block';
	    ctx.fillStyle = colorDot;
	    ctx.lineWidth = .1;
	    ctx.strokeStyle = color;
	
	    var mousePosition = {
	        x: 30 * canvas.width / 100,
	        y: 30 * canvas.height / 100
	    };
	
	    var dots = {
	        nb: 600,
	        distance: 60,
	        d_radius: 150,
	        array: []
	    };
	
	    function Dot(){
	        this.x = Math.random() * canvas.width;
	        this.y = Math.random() * canvas.height;
	
	        this.vx = -.5 + Math.random();
	        this.vy = -.5 + Math.random();
	
	        this.radius = Math.random();
	    }
	
	    Dot.prototype = {
	        create: function(){
	            ctx.beginPath();
	            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
	            ctx.fill();
	        },
	
	
	        animate: function(){
	            for(i = 0; i < dots.nb; i++){
	
	                var dot = dots.array[i];
	
	                if(dot.y < 0 || dot.y > canvas.height){
	                    dot.vx = dot.vx;
	                    dot.vy = - dot.vy;
	                }
	                else if(dot.x < 0 || dot.x > canvas.width){
	                    dot.vx = - dot.vx;
	                    dot.vy = dot.vy;
	                }
	                dot.x += dot.vx;
	                dot.y += dot.vy;
	            }
	        },
	
	        line: function(){
	            for(i = 0; i < dots.nb; i++){
	                for(j = 0; j < dots.nb; j++){
	                    i_dot = dots.array[i];
	                    j_dot = dots.array[j];
	
	                    if((i_dot.x - j_dot.x) < dots.distance && (i_dot.y - j_dot.y) < dots.distance && (i_dot.x - j_dot.x) > - dots.distance && (i_dot.y - j_dot.y) > - dots.distance){
	                        if((i_dot.x - mousePosition.x) < dots.d_radius && (i_dot.y - mousePosition.y) < dots.d_radius && (i_dot.x - mousePosition.x) > - dots.d_radius && (i_dot.y - mousePosition.y) > - dots.d_radius){
	                            ctx.beginPath();
	                            ctx.moveTo(i_dot.x, i_dot.y);
	                            ctx.lineTo(j_dot.x, j_dot.y);
	                            ctx.stroke();
	                            ctx.closePath();
	                        }
	                    }
	                }
	            }
	        }
	    };
	
	    function createDots(){
	        ctx.clearRect(0, 0, canvas.width, canvas.height);
	        for(i = 0; i < dots.nb; i++){
	            dots.array.push(new Dot());
	            dot = dots.array[i];
	
	            dot.create();
	        }
	
	        dot.line();
	        dot.animate();
	    }
	
	    window.onmousemove = function(parameter) {
	        mousePosition.x = parameter.pageX;
	        mousePosition.y = parameter.pageY;
	    }
	
	    mousePosition.x = window.innerWidth / 2;
	    mousePosition.y = window.innerHeight / 2;
	
	    setInterval(createDots, 1000/30);
	};
	
	window.onload = function() {
	    canvasDots();
	};

/***/ }
/******/ ]);
//# sourceMappingURL=back.js.map