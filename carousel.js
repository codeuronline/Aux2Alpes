const nmspc = 'zoetrope';

const isTouchDevice = (/(iPhone|iPod|iPad|Android|playbook|silk|BlackBerry|BB10|Windows Phone|Tizen|Bada|webOS|IEMobile|Opera Mini)/).test(navigator.userAgent) || (('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0) || (navigator.maxTouchPoints));

const inputEvents = {
	start: {
		touch: 'touchstart', 
  	mouse: 'mousedown'
	},
	move: {
		touch: 'touchmove', 
   	mouse: 'mousemove'
	},
	end: {
		touch: 'touchcancel', 
  	mouse: 'mouseup'
	},
	leave: {
  	touch: 'touchend', 
		mouse: 'mouseleave'
	}
};

const getInputEvent = (evt) => inputEvents[evt][isTouchDevice ? 'touch' : 'mouse'];

const createEl = (tag, html, klass, click) => {
  let elem = document.createElement(tag);
  klass && elem.classList.add(...(Array.isArray(klass) ? klass : [klass]));
	if (html) {
		if (typeof html === "string") { 
			elem.innerHTML = html; 
		} else if (typeof html === "object") { 
			if (html.tagName) {
				elem.append(html);
			} else if (Array.isArray(html)) {
				elem.append(...html);
			}
		}
	}
  elem.addEventListener("click", click)
  return elem;
}

const createButton = (html, klass, click) => createEl('button', html, klass, click);

const defaults = {
	adaptiveHeight: true,
	arrows: true,
	autoplay: false,
	autoplaySpeed: 1000,
	dots: true,
	draggable: true,
	easing: 'cubic-bezier(0.25, 1, 0.5, 1)',
	fade: true,
	loop: true,
	pauseOnHover: true,
	scrollAmount: .25,
	slidesToScroll: 1,
	slidesToShow: 1,
	speed: 500,
	startAt: 1,
	/*responsive: [
		{ breakpoint: 900, settings: { arrows: false, dots: true, } },
		{ breakpoint: 600, settings: { arrows: true, dots: false, } }
	]*/
};

const watchOpts = [
	'adaptiveHeight', 
	'arrows', 
	'autoplay', 
	'dots', 
	'draggable', 
	'fade', 
	'loop',
	{ 'pauseOnHover': ['autoplay'] }
];

class Zoetrope {
    #clones;
    #events;
    #activeSettings
    #currentPosition;
    #track;
    #trackWrapper;
    #dotsWrapper;
    #nextArrow;
    #prevArrow;
    #dragEvents;
    #slidesToShow

	constructor(elem, opts) {
		this.elem = elem;
		this.settings = new Proxy(Object.assign(defaults, opts), {
			set: (obj, prop, value) => {
				obj[prop] = value;
        if (watchOpts.find((opt) => opt === prop || opt.hasOwnProperty(prop))) { this._setOption(prop,value); }
			},
		});
		this.#activeSettings = this.settings;
		this.#track = createEl('div', (() => (this.slides = Array.from(this.elem.children), this.slides))(),`${nmspc}-track`);
		this.#trackWrapper = createEl('div', this.#track,`${nmspc}-track-wrapper`);
		this.elem.append((() => (this.#trackWrapper = createEl('div', this.#track,`${nmspc}-track-wrapper`), this.#trackWrapper))());
		
		this.currentIndex = this.#activeSettings.startAt - 1;
    this.currentSlide = this.slides[this.currentIndex];
		this.slides[this.#activeSettings.startAt - 1].classList.add("active");
		this.previousSlide = null;
		
		//redo to this.elem resize
		window.addEventListener("resize", () => this._updateDemensions());
		this._updateDemensions();

		this.elem.classList.add(`${nmspc}`);
		
		this.#events = { 
			change: new CustomEvent(`${nmspc}.change`, { detail: this }),
		};
		
		if (this.#activeSettings.responsive) {
			this._handleResponsive();
		} else {
        this._updateOptions();
    }
	}
	

  // controls 
	goTo(i) {
    let diff = 0;
    let startPos = this.#activeSettings.fade ? {opacity: 0} : { transform: `translateX(${diff + this.#currentPosition}px)` };
    let finishedPos = this.#activeSettings.fade ? {opacity: 1} : { transform: `translateX(${-i * (this.#activeSettings.slidesToScroll/this.#activeSettings.slidesToShow) * this.slideWidth}px)` };
    let animation = [startPos, finishedPos];

    if (this.#activeSettings.fade) {
    this.currentSlide.animate(Array.from(animation).reverse(), this._basicTimingProps());
    }

		this._updateIndices(i);
		
		if (this.#activeSettings.dots) {
			this._updateDots();
		}

    (this.#activeSettings.fade ?
    this.currentSlide.animate(animation, this._basicTimingProps()) :
        this.#track.animate(animation, this._basicTimingProps('none'))
    ).finished.then(() => this._onSlideChange());
	}

	goPrev() { 
    this.goTo(this.currentIndex - 1);
    }
	
    goNext() {
    this.goTo(this.currentIndex + 1);
    }
	
    pause() {
    this.timer &&= clearInterval(this.timer);
    }
	
    play() {
		this.timer ??= setInterval(() => this.goNext(), this.#activeSettings.autoplaySpeed);
	}


  // helpers
	_normalizeIndex(i = null) {
		let index = typeof i === "number"?i:this.currentIndex;
		return index < 0 ? (this.slides.length-1) : (index >= this.slides.length ? 0 : index);
	}

    _basicTimingProps(fill = 'both', speed = null) {
		let duration = speed ? speed : this.#activeSettings.speed;
		return { duration, iterations: 1, fill, easing: this.#activeSettings.easing, };
	}	
	
	_setOption(prop,value) {
		let option = (value ? '_add' : '_remove') + (prop.substring(0,1).toUpperCase() + prop.substring(1));
		return option in this && this[option]();
	}
	
	_updateOptions() {
		watchOpts.forEach((opt) => {
			let name = typeof opt === "string" ? opt : Object.keys(opt)[0];
			let deps = typeof opt === "string" ? true : opt[name].every((dep) => this.#activeSettings[dep]);
			this._setOption(name, deps && this.#activeSettings[name]);
		});
	}


	//chchchchchanges
    _updateIndices(i = null) {
		let index = typeof i === "number"?i:this.currentIndex;
		index = index<0 ? (this.slides.length - 1) : (index>=this.slides.length ? 0 : index);
	
		this.previousSlide = this.currentSlide;
    this.currentIndex = index;
    this.currentSlide = this.slides[this.currentIndex];
		this.#currentPosition = this.currentIndex * -this.slideWidth;
    }

	_onSlideChange() {
		
		this.elem.dispatchEvent(this.#events.change);
		
		this.slides.find((slide) => slide.classList.contains("active")).classList.remove("active");
	  	this.currentSlide.classList.add("active");
		
		if (!this.#activeSettings.fade) { 
			this.#track.style.transform = `translateX(${this.#currentPosition}px)`;
		}

		if (this.#activeSettings.adaptiveHeight) { 
      		let box = this._getBoxStyle(this.currentSlide);
			this.#trackWrapper.style.height = `${box.height + box.borderY}px`;
		}

		if (this.#activeSettings.dots) {
			this._updateDots();
		}
	}
	
	_getDragEvents() {
		let dragStop = (evt) => {
			if (this.dragging && this.dragging.move) {
				let diff = this.dragging.current - this.dragging.start;
				let direction = diff < 0 ? -1 : 1;
				let force = Math.max(1, (Math.abs(this.dragging.current-this.dragging.last)/10));
				let enough = (force > 1) || (Math.abs(diff) >= (this.slideWidth * (1/this.#activeSettings.slidesToScroll) * this.#activeSettings.scrollAmount));
				let position = this.#currentPosition + (direction * (enough ? ((1/this.#activeSettings.slidesToScroll)*this.slideWidth) : 0));
        let startPos = this.#activeSettings.fade ? {opacity: 0} : { transform: `translateX(${diff + this.#currentPosition}px)` };
		    let finishedPos = this.#activeSettings.fade ? {opacity: 1} : { transform: `translateX(${position}px)` };
        let animation = [startPos, finishedPos];
				if (enough) {
					if (this.#activeSettings.fade) {
        		this.currentSlide.animate(Array.from(animation).reverse(), this._basicTimingProps());
					}

					this._updateIndices(this.currentIndex - direction);

					(this.#activeSettings.fade ? 
						this.currentSlide.animate(animation, this._basicTimingProps()) : 
							this.#track.animate(animation, this._basicTimingProps('none', 500))
					).finished.then(() => this._onSlideChange());

				} else if (!this.#activeSettings.fade) {
					this.#track.animate(animation, this._basicTimingProps('none', 500)).finished.then(() => {
						this.#track.style.transform = animation[1].transform;
					})
        }
			}
			
			this.elem.classList.remove('isDragging');
			this.dragging = null;
		};
		
		let dragStart = (evt) => {
			evt.stopPropagation();
			evt.preventDefault();
			this.elem.classList.add('isDragging');
			let X = evt.touches ? evt.touches[0].clientX : evt.offsetX;

			this.dragging = {
				start: X,
				last: X,
				current: X,
				move: true,
			};			
		};
		
		let dragMove = (evt) => {
			if (this.dragging) {
				evt.stopPropagation();
				evt.preventDefault();
				
				this.dragging.move = true;
				this.dragging.last = this.dragging.current;
				this.dragging.current = evt.touches ? evt.touches[0].clientX : evt.offsetX;
				
				if (!this.#activeSettings.loop) {
					let direction = (this.dragging.current - this.dragging.start) < 0 ? 1 : -1;
					if (direction > 0 && this.currentIndex === (this.slides.length - 1) || (direction < 0 && this.currentIndex === 0)) {
						this.dragging.move = false;
					}
				}
			
				if (!this.#activeSettings.fade && this.dragging.move) {
					this.#track.style.transform = `translateX(${this.dragging.current - this.dragging.start + this.#currentPosition}px)`;
				}
			}
			
		};
		
		return {dragStop, dragStart, dragMove};
	}
	
	_addDraggable() {
		this.#dragEvents = this._getDragEvents();
		this.#trackWrapper.addEventListener(getInputEvent('start'), this.#dragEvents.dragStart);
		this.#trackWrapper.addEventListener(getInputEvent('move'), this.#dragEvents.dragMove);
		this.#trackWrapper.addEventListener(getInputEvent('end'), this.#dragEvents.dragStop);
		this.#trackWrapper.addEventListener(getInputEvent('leave'), this.#dragEvents.dragStop);
	}
	
	_removeDraggable() {
		if (this.#dragEvents) {
			this.#trackWrapper.removeEventListener(getInputEvent('start'), this.#dragEvents.dragStart);
			this.#trackWrapper.removeEventListener(getInputEvent('move'), this.#dragEvents.dragMove);
			this.#trackWrapper.removeEventListener(getInputEvent('end'), this.#dragEvents.dragStop);
			this.#trackWrapper.removeEventListener(getInputEvent('leave'), this.#dragEvents.dragStop);
			this.#dragEvents = null;
		}
	}
	
	
  // control options
	_addDots() {
		if (!this.#dotsWrapper) {
			let buttons = this.slides.map((frame,i) => createButton(i+1, (i===0?"active":""), () => this.currentIndex !== i && this.goTo(i)));
			this.elem.append((() => (this.#dotsWrapper = createEl('nav', buttons, `${nmspc}-dots`), this.#dotsWrapper))());
		}
	}
	
	_removeDots() { 
		this.#dotsWrapper &&= this.#dotsWrapper.remove();
	}
	
	_updateDots() {
		this.#dotsWrapper.children[this.slides.indexOf(this.previousSlide)].classList.remove("active");
		this.#dotsWrapper.children[this.currentIndex].classList.add("active");
	}
	
	_addArrows() {
		if (!this.#prevArrow && !this.#nextArrow) {
			this.#prevArrow = createButton('previous', [`${nmspc}-button`,`${nmspc}-button-prev`], () => (this.currentIndex > 0 || this.#activeSettings.loop) && this.goPrev());
			this.#nextArrow = createButton('next', [`${nmspc}-button`,`${nmspc}-button-next`], () => ((this.currentIndex + 1) < this.slides.length || this.#activeSettings.loop) && this.goNext());
			this.elem.append(this.#prevArrow, this.#nextArrow);
		}
	}
	
	_removeArrows() {
		this.#prevArrow &&= this.#prevArrow.remove();
		this.#nextArrow &&= this.#nextArrow.remove();
	}
	_addAutoplay() {
		this.timer = setInterval(() => {
			this.goNext();
		}, this.#activeSettings.autoplaySpeed);
			
		document.addEventListener('visibilitychange', () => document['hidden'] ? this.pause() : this.play());
	}
	
  _removeAutoplay() {
    this.timer &&= clearInterval(this.timer);
  }
	
  _addFade() {
		this.elem.classList.add("fade");
		this.slides[0].animate([{opacity: 0}, {opacity: 1}], this._basicTimingProps());
	}

	_removeFade() { 
    this.elem.classList.remove("fade");
  }
	
  _addAdaptiveHeight() { 
    this.#trackWrapper.style.setProperty('transitionDuration', `${this.#activeSettings.speed/1000}s`);
  }
	
  _removeAdaptiveHeight() {
    this.#trackWrapper.style.removeProperty('transitionDuration');
  }
	
  _addPauseOnHover() {
    if (!this._pauseOnHover) {
      this._pauseOnHover = { "over": () => this.pause(), "out": () => this.play() };
      this.elem.addEventListener("mouseover", this._pauseOnHover.over);
      this.elem.addEventListener("mouseout", this._pauseOnHover.out);
    }
  }

  _removePauseOnHover() {
    if (this._pauseOnHover) {
      this.elem.removeEventListener("mouseover", this._pauseOnHover.over);
      this.elem.removeEventListener("mouseout", this._pauseOnHover.out);
      this._pauseOnHover = null;
    }
  }
	
	_addLoop() {
		if (!this.#clones) {
      let first = this.slides[0].cloneNode(true);
      let last = this.slides[this.slides.length-1].cloneNode(true);
      [first,last].forEach((el) => el.classList.remove("active"));
			this.#clones = { first, last };
      
			this.#clones.last.style.marginLeft = `calc(-1px * ${1/this.#activeSettings.slidesToShow} * var(--slide-width))`;
			this.#track.prepend(this.#clones.last);
			this.#track.append(this.#clones.first);
		}
	}
	
	_removeLoop() {
		if (this.#clones) {
			this.#clones.first.remove();
			this.#clones.last.remove();
			this.#clones = null;
		}
	}

  _getLargestSlide(axis = "y") {
    let sizes = this.slides.map((slide) => {
      let slideBox = this._getBoxStyle(slide);
      return axis === "y" ? (slideBox.height + slideBox.paddingY + slideBox.borderY) : (slideBox.width + slideBox.paddingX + slideBox.borderX);
    });

    let size = Math.max(...sizes);
    return { slide: this.slides[sizes.indexOf(size)], size };
  }


  // sizing
	_updateDemensions() {
    let trackBox = this._getBoxStyle(this.#trackWrapper);
    let slideBox = this._getBoxStyle(this.currentSlide);
    let height = this.#activeSettings.adaptiveHeight ? slideBox.height + slideBox.borderY : this._getLargestSlide().size;

    this.#track.width = `${this.#track.scrollWidth}px`;
    this.#trackWrapper.style.height = `${height}px`
		this.slideWidth = trackBox.width;
		this.elem.style.setProperty('--slide-width', trackBox.width);	
		this.#currentPosition = this.currentIndex * -this.slideWidth;
		this.#track.style.transform = `translateX(${this.#currentPosition}px)`;
	}

	_getBoxStyle(el) {
		let cs = getComputedStyle(el);

		let borderX = parseFloat(cs.borderLeftWidth) + parseFloat(cs.borderRightWidth);
		let borderY = parseFloat(cs.borderTopWidth) + parseFloat(cs.borderBottomWidth);

		let paddingX = parseFloat(cs.paddingLeft) + parseFloat(cs.paddingRight);
		let paddingY = parseFloat(cs.paddingTop) + parseFloat(cs.paddingBottom);

		let height = (el ? el : (this.#activeSettings.adaptiveHeight ? this.slides[0] : this.#trackWrapper)).scrollHeight;
		let width = el.clientWidth;

		return {borderX,borderY,paddingX,paddingY, height, width};
	}

  // responsive
	_handleResponsive() {
		this.settings.responsive.forEach((r,i) => {
			let mediaQuery = `(max-width:${r.breakpoint}px)` + (this.settings.responsive[i+1] ? ` and (min-width: ${this.settings.responsive[i+1].breakpoint + 1}px)` : '');
			let mq = matchMedia(mediaQuery);
			let handler = () => {
				if (mq.matches) {
					this.#activeSettings = Object.assign({}, this.settings, r.settings);
					this._updateOptions();
				}
			}

			mq.addListener(handler);
			handler();
		});
		
		//set mq for everything above largest provided breakpoint
		let mq = matchMedia(`(min-width: ${(this.settings.responsive.reduce((max, cur) => Math.max(max,cur.breakpoint), 0)) + 1}px)`);
		let handler = () => {
			if (mq.matches) { 
				this.#activeSettings = this.settings;
				this._updateOptions();
			}
		};
			
		mq.addListener(handler);
		handler();
		
		this.#slidesToShow = this.#activeSettings.slidesToShow;
		this.elem.style.setProperty("--slides-to-show", this.#slidesToShow);
	}
}

let slides = document.querySelector('#slides');
window.zoetrope = new Zoetrope(slides, {
	fade: false, 
	adpativeHeight: false, 
	responsive: [
		{
			breakpoint: 1000, 
			settings: {
				draggable: true,
				loop: true,
			}
		}]
	});

slides.addEventListener('slider.change', (evt) => {
  let obj = evt.detail;
	//console.log("Current: ", obj.currentSlide);
  //console.log("Last: ", obj.previousSlide);
	console.log(obj);
});